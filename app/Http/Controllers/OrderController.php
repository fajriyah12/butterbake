<?php

namespace App\Http\Controllers;

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

    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        return view('checkout.checkout', compact('cart'));
    }

    public function payment(Request $request)
    {
        $request->validate([
            'delivery_method'      => 'required|in:pickup,delivery',
            'delivery_address'     => 'required_if:delivery_method,delivery|nullable|string',
            'delivery_city'        => 'required_if:delivery_method,delivery|nullable|string',
            'delivery_postal_code' => 'required_if:delivery_method,delivery|nullable|string',
            'pickup_date'          => 'required_if:delivery_method,pickup|nullable|date',
            'notes'                => 'nullable|string|max:500',
        ]);

        session(['checkout_data' => $request->all()]);

        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        return view('payment.payment', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $cart     = Cart::where('user_id', Auth::id())->with('items.product')->first();
        $checkout = session('checkout_data');

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        DB::transaction(function () use ($cart, $checkout, $request) {
            $subtotal    = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
            $deliveryFee = ($checkout['delivery_method'] === 'delivery') ? 15000 : 0;

            $order = Order::create([
                'user_id'              => Auth::id(),
                'order_number'         => Order::generateOrderNumber(),
                'status'               => 'pending',
                'delivery_method'      => $checkout['delivery_method'],
                'delivery_address'     => $checkout['delivery_address'] ?? null,
                'delivery_city'        => $checkout['delivery_city'] ?? null,
                'delivery_postal_code' => $checkout['delivery_postal_code'] ?? null,
                'pickup_date'          => $checkout['pickup_date'] ?? null,
                'subtotal'             => $subtotal,
                'delivery_fee'         => $deliveryFee,
                'total'                => $subtotal + $deliveryFee,
                'payment_method'       => $request->payment_method,
                'payment_status'       => 'paid',
                'notes'                => $checkout['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $item->product->price,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->product->price * $item->quantity,
                ]);
            }

            $cart->items()->delete();
            session()->forget('checkout_data');
            session(['last_order_id' => $order->id]);
        });

        return redirect()->route('order.confirmation');
    }

    public function confirmation()
    {
        $orderId = session('last_order_id');
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with('items.product')->findOrFail($orderId);
        return view('pages.order-confirmation', compact('order'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('pages.my-orders', compact('orders'));
    }
}