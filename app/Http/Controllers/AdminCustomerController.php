<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminCustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'user')
            ->withCount('orders')
            ->withSum('orders', 'total')
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'user')->findOrFail($id);

        $orders = $customer->orders()->latest()->paginate(8);

        $totalSpend = $customer->orders()->sum('total');
        $totalOrders = $customer->orders()->count();
        $avgOrder = $totalOrders > 0 ? round($totalSpend / $totalOrders) : 0;

        return view('admin.customers.show', compact(
            'customer', 'orders', 'totalSpend', 'totalOrders', 'avgOrder'
        ));
    }
}