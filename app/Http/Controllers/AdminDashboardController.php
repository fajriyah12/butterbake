<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();
        $totalProducts = Product::count();

        // Revenue minggu ini vs minggu lalu (untuk % change)
        $thisWeekRevenue = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total');

        $lastWeekRevenue = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ])
            ->sum('total');

        $revenueChange = $lastWeekRevenue > 0
            ? round((($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100)
            : 0;

        // Sales chart - 7 hari terakhir
        $salesChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesChart[] = [
                'day'   => $date->format('D'),
                'total' => Order::where('status', '!=', 'cancelled')
                    ->whereDate('created_at', $date)
                    ->sum('total'),
            ];
        }

        // Top selling products (butuh tabel order_items)
        // Jika belum ada order_items, pakai dummy dulu
        $topProducts = collect([]);
        if (DB::getSchemaBuilder()->hasTable('order_items')) {
            $topProducts = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.image',
                    DB::raw('SUM(order_items.quantity) as total_sold')
                )
                ->groupBy('products.id', 'products.name', 'products.image')
                ->orderByDesc('total_sold')
                ->take(3)
                ->get();
        }

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Average order value
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'recentOrders',
            'salesChart',
            'topProducts',
            'revenueChange',
            'avgOrderValue'
        ));
    }
}