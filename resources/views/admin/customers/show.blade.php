@extends('layouts.app')

@section('content')
<div class="admin-main">
    <!-- TOPBAR -->
    <div class="topbar" style="margin-bottom: 28px;">
        <div class="inventory-header">
            <div>
                <a href="{{ route('admin.customers.index') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> Back to Customers
                </a>
                <h1>{{ $customer->name }}</h1>
                <p class="inventory-subtitle">{{ $customer->email }} · Joined {{ $customer->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
   
    <!-- STATS -->
    <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <p class="stat-label">Total Lifetime Value</p>
            <h2 class="stat-value">Rp {{ number_format($totalSpend, 0, ',', '.') }}</h2>
        </div>
        <div class="stat-card">
            <p class="stat-label">Total Orders</p>
            <h2 class="stat-value">{{ $totalOrders }}</h2>
        </div>
        <div class="stat-card">
            <p class="stat-label">Average Order Value</p>
            <h2 class="stat-value">Rp {{ number_format($avgOrder, 0, ',', '.') }}</h2>
        </div>
        <div class="stat-card">
            <p class="stat-label">Member Since</p>
            <h2 class="stat-value" style="font-size: 20px;">
                {{ $customer->created_at->format('M d, Y') }}
            </h2>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="customer-show-grid">

        <!-- LEFT: Order History -->
        <div class="dash-card">
            <div class="dash-card-header">
                <h3>Order History</h3>
                <span class="chart-badge">{{ $totalOrders }} orders</span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="order-id">#{{ strtoupper(substr($order->order_number, -6)) }}</td>
                                <td style="color:#9a8880;">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td style="font-weight:700; color:#b46f28;">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="status status-{{ $order->status }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color:#b5a89f; padding:40px;">
                                    No orders yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
            <div class="pagination-bar" style="padding: 20px 0 0; margin-top: 0; border-top: 1px solid #f0e8e1;">
                <span class="pagination-info">
                    Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }}
                </span>
                <div class="pagination-links">
                    @if($orders->onFirstPage())
                        <span class="page-btn disabled"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="page-btn"><i class="bi bi-chevron-left"></i></a>
                    @endif

                    @foreach(range(1, $orders->lastPage()) as $page)
                        <a href="{{ $orders->url($page) }}"
                           class="page-btn {{ $orders->currentPage() == $page ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="page-btn"><i class="bi bi-chevron-right"></i></a>
                    @else
                        <span class="page-btn disabled"><i class="bi bi-chevron-right"></i></span>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- RIGHT: Customer Info -->
        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- Profile Card -->
            <div class="dash-card" style="text-align: center; padding: 32px 24px;">
                <div class="customer-avatar-lg" style="margin: 0 auto 16px;">
                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                </div>
                <h3 style="font-size: 20px; font-weight: 700; color: #2d1f14; margin-bottom: 8px;">
                    {{ $customer->name }}
                </h3>
                @if($totalOrders >= 10)
                    <span class="cust-badge gold">GOLD MEMBER</span>
                @elseif($totalOrders >= 5)
                    <span class="cust-badge silver">SILVER MEMBER</span>
                @else
                    <span class="cust-badge regular">MEMBER</span>
                @endif

                <div class="cust-info-list">
                    <div class="cust-info-item">
                        <i class="bi bi-envelope"></i>
                        <span>{{ $customer->email }}</span>
                    </div>
                    <div class="cust-info-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Status:
                            <strong style="color: {{ $totalOrders > 0 ? '#22c55e' : '#9a8880' }}">
                                {{ $totalOrders > 0 ? 'Active' : 'Inactive' }}
                            </strong>
                        </span>
                    </div>
                    <div class="cust-info-item">
                        <i class="bi bi-calendar3"></i>
                        <span>Joined {{ $customer->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            </div>

        </div>

    </div>

</div>
@endsection