@extends('layouts.app')

@section('css')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="admin-main">


    {{-- HERO HEADER --}}
    <div class="dash-hero">
        <h1>Welcome, Admin!</h1>
        <p>Here's what's baking in your shop today.</p>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stat-card">
            <p class="stat-label">Total Sales</p>
            <h2 class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            <span class="stat-change {{ $revenueChange >= 0 ? 'positive' : 'negative' }}">
                {{ $revenueChange >= 0 ? '+' : '' }}{{ $revenueChange }}%
            </span>
        </div>

        <div class="stat-card">
            <p class="stat-label">Total Orders</p>
            <h2 class="stat-value">{{ $totalOrders }}</h2>
            <span class="stat-unit">orders</span>
        </div>

        <div class="stat-card">
            <p class="stat-label">Active Customers</p>
            <h2 class="stat-value">{{ $totalCustomers }}</h2>
            <span class="stat-unit">users</span>
        </div>

        <div class="stat-card">
            <p class="stat-label">Avg Order Value</p>
            <h2 class="stat-value">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</h2>
        </div>

    </div>

    {{-- CHART + TOP SELLING --}}
    <div class="dash-mid-grid">

        {{-- Sales Chart --}}
        <div class="dash-card chart-card">
            <div class="dash-card-header">
                <h3>Sales Overview</h3>
                <span class="chart-badge">Last 7 days</span>
            </div>
            <div class="chart-wrap">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Top Selling --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <h3>Top Selling</h3>
            </div>
            <div class="top-selling-list">
                @forelse($topProducts as $product)
                    <div class="top-product-item">
                        <img
                            src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/60x60/f5ede3/c8925b?text=🍞' }}"
                            alt="{{ $product->name }}"
                            class="top-product-img"
                        >
                        <div class="top-product-info">
                            <h4>{{ $product->name }}</h4>
                            <p>{{ $product->total_sold }} sold this week</p>
                        </div>
                    </div>
                @empty
                    <p class="empty-text">Belum ada data penjualan.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- RECENT ORDERS --}}
    <div class="dash-card">
        <div class="dash-card-header">
            <h3>Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="see-all-link">See All Orders</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td class="order-id">#{{ strtoupper(substr($order->order_number, -6)) }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status status-{{ $order->status }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');

    const salesData = {
        labels: {!! json_encode(array_column($salesChart, 'day')) !!},
        datasets: [{
            data: {!! json_encode(array_column($salesChart, 'total')) !!},
            backgroundColor: function(context) {
                const index = context.dataIndex;
                const count = context.dataset.data.length;
                return index === count - 1 ? '#c8925b' : '#e8d5bc';
            },
            borderRadius: 8,
            borderSkipped: false,
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: salesData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { color: '#9a8880', font: { size: 12 } }
                },
                y: {
                    grid: { color: '#f0e8e1', lineWidth: 1 },
                    border: { display: false, dash: [4, 4] },
                    ticks: {
                        color: '#9a8880',
                        font: { size: 11 },
                        callback: val => 'Rp ' + (val/1000).toFixed(0) + 'k'
                    }
                }
            }
        }
    });
</script>
@endpush

@endsection