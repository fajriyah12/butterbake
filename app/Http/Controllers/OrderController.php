<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Keranjang Anda kosong.'
                );
        }

        return view(
            'checkout.checkout',
            compact('cart')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT PAGE
    |--------------------------------------------------------------------------
    */

    public function payment(Request $request)
    {

        // BUY NOW
        if ($request->has('product_id')) {

            $product = Product::findOrFail(
                $request->product_id
            );

            $cart = new \stdClass();

            $item = new \stdClass();

            $item->product = $product;

            $item->quantity =
                $request->quantity ?? 1;

            $cart->items = collect([$item]);

            return view(
                'checkout.payment',
                compact('cart')
            );
        }

        $request->validate([
            'delivery_method' => 'required|in:pickup,delivery',
            'pickup_date'     => 'nullable|string',
            'notes'           => 'nullable|string|max:500',
        ]);

        // simpan ke session
        session([
            'checkout_data' =>
                $request->except('_token')
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Keranjang Anda kosong.'
                );
        }

        return view(
            'checkout.payment',
            compact('cart')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */

    public function placeOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ], [
            'payment_method.required' =>
                'Pilih salah satu metode pembayaran.',
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->with('items.product')
            ->first();

        $checkout = session('checkout_data', []);

        if (!$cart || $cart->items->isEmpty()) {

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Keranjang kosong.'
                );
        }

        DB::transaction(function () use (
            $cart,
            $checkout,
            $request
        ) {

            $subtotal = $cart->items->sum(
                fn($i) =>
                    $i->product->price * $i->quantity
            );

            $tax = $subtotal * 0.1;

            $deliveryFee = 0;

            $total = $subtotal + $tax;

            $order = Order::create([

                'user_id'      => Auth::id(),

                'order_number' =>
                    Order::generateOrderNumber(),

                // STATUS ORDER
                'status' => 'pending',

                // DELIVERY
                'delivery_method' =>
                    $checkout['delivery_method']
                    ?? 'pickup',

                'delivery_address' =>
                    $checkout['delivery_address']
                    ?? null,

                'delivery_city' =>
                    $checkout['delivery_city']
                    ?? null,

                'delivery_postal_code' =>
                    $checkout['delivery_postal_code']
                    ?? null,

                // PICKUP
                'pickup_location' =>
                    $checkout['pickup_location']
                    ?? null,

                'pickup_date' =>
                    now(),

                // PAYMENT
                'subtotal'      => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total'         => $total,

                'payment_method' =>
                    $request->payment_method,

                // BELUM DIBAYAR
                'payment_status' =>
                    'pending',

                // NOTES
                'notes' =>
                    $checkout['notes']
                    ?? null,
            ]);

            // ORDER ITEMS
            foreach ($cart->items as $item) {

                OrderItem::create([

                    'order_id' =>
                        $order->id,

                    'product_id' =>
                        $item->product_id,

                    'product_name' =>
                        $item->product->name,

                    'price' =>
                        $item->product->price,

                    'quantity' =>
                        $item->quantity,

                    'subtotal' =>
                        $item->product->price
                        * $item->quantity,
                ]);
            }

            // CLEAR CART
            $cart->items()->delete();

            $cart->update([
                'total' => 0
            ]);

            session()->forget(
                'checkout_data'
            );

            session([
                'last_order_id' =>
                    $order->id
            ]);
        });

        return redirect()
            ->route('order.confirmation');
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER CONFIRMATION PAGE
    |--------------------------------------------------------------------------
    */

    public function confirmation()
{
    $orderId = session('last_order_id');

    if (!$orderId) {
        return redirect()->route('home');
    }

    $order = Order::with('items')->findOrFail($orderId);

    return view('order.confirmation', compact('order'));
}


    /*
    |--------------------------------------------------------------------------
    | USER CONFIRM PAYMENT
    |--------------------------------------------------------------------------
    */

    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);

        // pastikan order milik user login
        if ($order->user_id != Auth::id()) {

            abort(403);
        }

        // update status
        $order->status =
            'pending';

        $order->payment_status =
            'checking';

        $order->save();

        return redirect()
            ->back()
            ->with(
                'success',
                'Payment confirmation sent successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MY ORDERS
    |--------------------------------------------------------------------------
    */

    public function myOrders()
    {
        $orders = Order::where(
                'user_id',
                Auth::id()
            )
            ->with('items')
            ->latest()
            ->paginate(10);

        return view(
            'order.myorders',
            compact('orders')
        );
    }
    /*
|--------------------------------------------------------------------------
| ORDER DETAIL
|--------------------------------------------------------------------------
*/

public function show($id)
{
    $order = Order::with('items.product')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    return view('order.show', compact('order'));
}
}