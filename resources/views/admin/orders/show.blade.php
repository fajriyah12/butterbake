@extends('layouts.app')

@section('content')

<div class="admin-main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="inventory-header">
            <div>
                <h1 class="order-title">
                    Order #{{ $order->order_number }}
                </h1>
                <p class="inventory-subtitle">
                    Placed on {{ $order->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            <div class="order-actions">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="status-form">
                        <select name="status" class="status-select">
                            <option value="pending"    {{ $order->status == 'pending'    ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="ready"      {{ $order->status == 'ready'      ? 'selected' : '' }}>Ready</option>
                            <option value="completed"  {{ $order->status == 'completed'  ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled"  {{ $order->status == 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="order-grid">

        <!-- LEFT -->
        <div class="left-section">

            <!-- ORDER ITEMS -->
            <div class="card-box">
                <h3 class="card-title">Order Items</h3>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         class="order-item-img"
                                         alt="{{ $item->product_name }}">
                                    <div>
                                        <h4>{{ $item->product_name }}</h4>
                                        <p>Product item</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- NOTES -->
            <div class="card-box">
                <div class="notes-header">
                    <h3 class="card-title">Kitchen Notes</h3>
                </div>
                <div class="notes-box">
                    {{ $order->notes ?? 'No notes available.' }}
                </div>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="right-section">

            <!-- CUSTOMER -->
            <div class="card-box">
                <h3 class="card-title">Customer Details</h3>
                <div class="customer-info">
                    <div class="avatar">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4>{{ $order->user->name }}</h4>
                        <p>Active Member</p>
                    </div>
                </div>
                <div class="detail-item">{{ $order->user->email }}</div>
                <div class="detail-item">{{ $order->user->phone ?? '-' }}</div>
                <div class="detail-item">Pickup Location : {{ $order->pickup_location ?? '-' }}</div>
                <div class="detail-item">
                    Pickup Time :
                    {{ $order->pickup_date
                        ? \Carbon\Carbon::parse($order->pickup_date)->format('d M Y, H:i')
                        : '-' }}
                </div>
                @if($order->delivery_address)
                <div class="detail-item">Address : {{ $order->delivery_address }}</div>
                @endif
            </div>

            <!-- PAYMENT -->
            <div class="card-box">
                <h3 class="card-title">Payment Summary</h3>

                @php
                    $tax = $order->subtotal * 0.10;
                @endphp

                <div class="payment-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="payment-row">
                    <span>Tax (10%)</span>
                    <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                </div>

                <!-- PAYMENT STATUS -->
                <div class="payment-row">
                    <span>Payment Status</span>
                    <form method="POST"
                          action="{{ route('admin.orders.updatePayment', $order) }}"
                          style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <select name="payment_status"
                                onchange="this.form.submit()"
                                class="payment-status-select
                                    @if($order->payment_status == 'paid') select-paid
                                    @elseif($order->payment_status == 'refunded') select-refunded
                                    @elseif($order->payment_status == 'unpaid') select-unpaid
                                    @else select-pending
                                    @endif">
                            <option value="unpaid"   {{ $order->payment_status == 'unpaid'   ? 'selected' : '' }}>Unpaid</option>
                            <option value="pending"  {{ $order->payment_status == 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="paid"     {{ $order->payment_status == 'paid'     ? 'selected' : '' }}>Paid</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </form>
                </div>

                <hr>

                <div class="payment-row total-row">
                    <span>Total Paid</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>

                <div class="payment-method-box">
                    <small>PAYMENT METHOD</small>
                    <h4>{{ $order->payment_method ?? 'Bank Transfer' }}</h4>
                </div>

            </div>

        </div>

    </div>

</div>


@endsection