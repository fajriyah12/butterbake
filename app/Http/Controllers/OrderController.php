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

    if ($request->has('product_id')) {

        $product = Product::findOrFail($request->product_id);

        // buat cart sementara agar view payment tetap berjalan normal
        $cart = new \stdClass();

        $item = new \stdClass();
        $item->product = $product;
        $item->quantity = $request->quantity ?? 1;

        $cart->items = collect([$item]);

        return view('checkout.payment', compact('cart'));
    }

    $request->validate([
        'delivery_method' => 'required|in:pickup,delivery',
        'pickup_date'     => 'nullable|string',
        'notes'           => 'nullable|string|max:500',
    ]);

    // Simpan data checkout ke session
    session(['checkout_data' => $request->except('_token')]);

    $cart = Cart::where('user_id', Auth::id())
        ->with('items.product')
        ->first();

    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->route('cart.index')
            ->with('error', 'Keranjang Anda kosong.');
    }

    return view('checkout.payment', compact('cart'));
}

    public function placeOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ], [
            'payment_method.required' => 'Pilih salah satu metode pembayaran.',
        ]);

        $cart     = Cart::where('user_id', Auth::id())->with('items.product')->first();
        $checkout = session('checkout_data', []);

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        DB::transaction(function () use ($cart, $checkout, $request) {

            $subtotal    = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
            $tax         = $subtotal * 0.1;
            $deliveryFee = 0; 
            $total       = $subtotal + $tax;

            $order = Order::create([
                'user_id'              => Auth::id(),
                'order_number'         => Order::generateOrderNumber(),
                'status'               => 'pending',

               
                'delivery_method'      => $checkout['delivery_method']      ?? 'pickup',
                'delivery_address'     => $checkout['delivery_address']      ?? null,
                'delivery_city'        => $checkout['delivery_city']         ?? null,
                'delivery_postal_code' => $checkout['delivery_postal_code']  ?? null,


                'pickup_date'          => now(),
                'subtotal'             => $subtotal,
                'delivery_fee'         => $deliveryFee,
                'total'                => $total,

     
                'payment_method'       => $request->payment_method,
                'payment_status'       => 'unpaid',

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
            $cart->update(['total' => 0]);

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

        $order = Order::with('items')->findOrFail($orderId);

        return view('order.confirmation', compact('order'));
    }


    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('pages.my-orders', compact('orders'));
    }
}