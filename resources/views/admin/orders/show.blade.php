@extends('layouts.app')

@section('content')

<div class="admin-main">

    <!-- HEADER -->
    <div class="inventory-header">
        <div>
            <p class="breadcrumb">Orders > Details</p>

            <h1 class="order-title">
                Order #{{ $order->order_number }}
            </h1>
        </div>

        <div class="order-actions">
            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf
                @method('PATCH')

                <div class="status-form">
                    <select name="status" class="status-select">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                            Processing
                        </option>

                        <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>
                            Ready to Pickup
                        </option>

                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>
                    </select>

                    <button type="submit" class="btn-primary">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- GRID -->
    <div class="order-grid">

        <!-- LEFT -->
        <div class="left-section">

            <!-- ORDER ITEMS -->
            <div class="card-box">

                <div class="card-header">
                    <h3 class="card-title">Order Items</h3>

                    <span class="item-badge">
                        {{ $order->items->count() }} Item
                    </span>
                </div>

                <table class="order-table">

                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>QTY</th>
                            <th>PRICE</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($order->items as $item)

                        <tr>

                            <td>
                                <div class="product-info">

                                    <img
                                        src="{{ asset('storage/' . $item->product->image) }}"
                                        class="order-item-img"
                                        alt="{{ $item->product_name }}"
                                    >

                                    <div>
                                        <h4>{{ $item->product_name }}</h4>
                                        <p>
                                            SKU :
                                            {{ $item->product->sku ?? 'BB-001' }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td>{{ $item->quantity }}</td>

                            <td>
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>

                            <td class="fw-bold">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- NOTES -->
            <div class="card-box">

                <h3 class="card-title">
                    Kitchen Notes
                </h3>

                <div class="notes-box">
                    {{ $order->notes ?? 'No notes available' }}
                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="right-section">

            <!-- CUSTOMER -->
            <div class="card-box">

                <h3 class="card-title">
                    Customer Details
                </h3>

                <div class="customer-info">

                    <div class="avatar">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>

                    <div>
                        <h4>{{ $order->user->name }}</h4>

                        <span class="member-badge">
                            ACTIVE MEMBER
                        </span>
                    </div>

                </div>

                <hr>

                <div class="detail-item">
                    <strong>Email</strong>
                    <p>{{ $order->user->email }}</p>
                </div>

                <div class="detail-item">
                    <strong>Phone</strong>
                    <p>{{ $order->user->phone ?? '-' }}</p>
                </div>

                <div class="detail-item">
                    <strong>Pickup Time</strong>

                    <p>
                        {{ $order->pickup_date
                            ? \Carbon\Carbon::parse($order->pickup_date)->format('d M Y, H:i')
                            : '-' }}
                    </p>
                </div>

            </div>

            <!-- PAYMENT -->
            <div class="card-box">

                <div class="payment-header">

                    <h3 class="card-title">
                        Payment Summary
                    </h3>

                    <form method="POST"
                        action="{{ route('admin.orders.updatePayment', $order) }}">

                        @csrf
                        @method('PATCH')

                        <select
                            name="payment_status"
                            onchange="this.form.submit()"
                            class="payment-status-select">

                            <option value="unpaid"
                                {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>
                                UNPAID
                            </option>

                            <option value="pending"
                                {{ $order->payment_status == 'pending' ? 'selected' : '' }}>
                                PENDING
                            </option>

                            <option value="paid"
                                {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                PAID
                            </option>

                            <option value="refunded"
                                {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>
                                REFUNDED
                            </option>

                        </select>

                    </form>

                </div>

                @php
                    $tax = $order->subtotal * 0.10;
                @endphp

                <div class="payment-row">
                    <span>Subtotal</span>

                    <span>
                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                    </span>
                </div>

                <div class="payment-row">
    <span>Tax (10%)</span>

    <span>
        Rp {{ number_format($tax, 0, ',', '.') }}
    </span>
</div>

<div class="payment-row">
    <span>Payment Method</span>

    <span class="payment-method">
        {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'Bank Transfer')) }}
    </span>
</div>

<hr>

                <hr>

                <div class="payment-row total-row">
                    <span>Total Paid</span>

                    <span>
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>


        </div>

    </div>

</div>

@endsection