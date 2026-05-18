<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user','items')
            ->latest()
            ->paginate(10);

        return view(
            'admin.orders.index',
            compact('orders')
        );
    }

    public function show(Order $order)
    {
        $order->load('user','items');

        return view(
            'admin.orders.show',
            compact('order')
        );
    }

    public function updateStatus(
    Request $request,
    Order $order
) {

    $request->validate([
        'status' => 'required'
    ]);

    $order->update([
        'status' => $request->status
    ]);

    return back()->with(
        'success',
        'Order status updated'
    );
}
public function updatePayment(Request $request, Order $order)
{
    $request->validate([
        'payment_status' => 'required|in:pending,paid,failed',
    ]);

    $order->update([
        'payment_status' => $request->payment_status
    ]);

    return back()->with('success', 'Payment status updated');
}
}