@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/order-konfirmasi.css') }}">
@endpush

@section('content')

<div class="bb-page">

    {{-- HERO --}}
    <div class="bb-hero">
        <div class="bb-hero-icon">
            <svg viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <h1>Order Confirmed!</h1>
        <p>
            Thank you for choosing Artisan Crumbs. Your order is being prepared.
        </p>
    </div>

    <div class="bb-container">

        @if(session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif

        @php
            $tax = $order->subtotal * 0.10;
            $user = $order->user;
        @endphp

        <div class="bb-grid">

            {{-- LEFT --}}
            <div>

                {{-- STATUS --}}
                <div class="status-card">
                    <div class="status-left">
                        <div class="status-label">
                            <span class="status-dot"></span> In Preparation
                        </div>
                        <div class="status-quote">
                            "Preparing your order with care."
                        </div>
                    </div>

                    <div class="status-time">
                        <div class="status-time-number">10</div>
                        <div class="status-time-label">Minutes Away</div>
                    </div>
                </div>

                {{-- ORDER ITEMS --}}
                <div class="bb-card">
                    <div class="bb-card-title">Order Summary</div>

                    @foreach($order->items as $item)
                        <div class="order-item">

                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                 class="order-item-img"
                                 alt="{{ $item->product->name }}">

                            <div class="flex-1">
                                <div class="order-item-name">
                                    {{ $item->product_name }}
                                </div>
                                <div class="order-item-qty">
                                    Qty: {{ $item->quantity }}
                                </div>
                            </div>

                            <div class="order-item-price">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach

                    <div class="summary-totals">

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Tax (10%)</span>
                            <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>

                        <div class="summary-row summary-total">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>

                    </div>
                </div>

                {{-- NOTES --}}
                @if($order->notes)
                    <div class="bb-card">
                        <div class="bb-card-title">Kitchen Notes</div>
                        <p class="notes-text">{{ $order->notes }}</p>
                    </div>
                @endif

            </div>

            {{-- RIGHT --}}
            <div>

                {{-- ORDER NUMBER --}}
                <div class="order-number-card">
                    <div class="order-number-label">Order Number</div>
                    <div class="order-number-value">#{{ $order->order_number }}</div>
                    <div class="order-number-note">
                        Show this number at pickup.
                    </div>
                </div>

                <a href="{{ route('home') }}" class="btn-primary">Continue Shopping</a>
                <a href="#" class="btn-ghost">Need Assistance?</a>

                {{-- PICKUP DETAILS --}}
                <div class="bb-card mt-20">

                    <div class="bb-card-title">Pickup Details</div>

                    <div class="detail-row">
                        <span>
                            {{ $order->pickup_date
                                ? \Carbon\Carbon::parse($order->pickup_date)->format('d M Y, H:i')
                                : '-' }}
                        </span>
                    </div>

                    <div class="detail-row">
                        <span>{{ $user?->name }}</span>
                    </div>

                    <div class="detail-row">
                        <span>{{ $user?->email }}</span>
                    </div>

                    @if($user?->phone)
                        <div class="detail-row">
                            <span>{{ $user->phone }}</span>
                        </div>
                    @endif

                    @if($order->delivery_address)
                        <div class="detail-row">
                            <span>{{ $order->delivery_address }}</span>
                        </div>
                    @endif
                </div>

                {{-- PAYMENT STATUS (BELOW PICKUP) --}}
                <div class="bb-card mt-20">

                    <div class="bb-card-title">Payment Status</div>

                    @if($order->payment_status == 'paid')

                        <div class="badge-completed" style="font-weight:600;">
                            Paid - Your payment has been confirmed
                        </div>

                    @elseif($order->payment_status == 'pending')

                        <div class="badge-pending" style="font-weight:600;">
                            Pending - Waiting for admin verification
                        </div>

                    @elseif($order->payment_status == 'failed')

                        <div class="badge-cancelled" style="font-weight:600;">
                            Failed - Please make the payment again
                        </div>

                    @else

                        <div class="badge-pending" style="font-weight:600;">
                            Pending - Waiting for admin verification
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection