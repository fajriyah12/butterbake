@extends('layouts.app')

@push('styles')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link rel="stylesheet" href="{{ asset('css/order-konfirmasi.css') }}">

@endpush

@section('content')

@php

    $status = str_replace(' ', '_', strtolower($order->status ?? 'pending'));

    /*
    |--------------------------------------------------------------------------
    | HERO CONTENT
    |--------------------------------------------------------------------------
    */

    switch($status){

        case 'pending':
            $heroTitle = 'Order Pending';
            $heroText  = 'Your order is waiting for admin confirmation.';
            $heroIcon  = '<i class="fa-regular fa-clock"></i>';
        break;

        case 'processing':
            $heroTitle = 'Order In Preparation';
            $heroText  = 'Thank you for choosing Butter Bake. Your order is being prepared with care.';
            $heroIcon  = '<i class="fa-solid fa-bread-slice"></i>';
        break;

        case 'ready_to_pickup':
            $heroTitle = 'Ready To Pickup';
            $heroText  = 'Your order is ready and waiting for pickup.';
            $heroIcon  = '<i class="fa-solid fa-check"></i>';
        break;

        case 'completed':
            $heroTitle = 'Order Completed';
            $heroText  = 'Thank you for ordering with Butter Bake.';
            $heroIcon  = '<i class="fa-solid fa-check"></i>';
        break;

        case 'cancelled':
            $heroTitle = 'Order Cancelled';
            $heroText  = 'This order has been cancelled.';
            $heroIcon  = '<i class="fa-solid fa-xmark"></i>';
        break;

        default:
            $heroTitle = 'Order Status Updated';
            $heroText  = 'Your order status has been updated.';
            $heroIcon  = '<i class="fa-solid fa-box"></i>';
        break;

    }

@endphp

<div class="bb-page">

    {{-- HERO --}}
    <div class="bb-hero">

        <div class="bb-hero-icon {{ $status }}">
            {!! $heroIcon !!}
        </div>

        <h1>{{ $heroTitle }}</h1>

        <p>{{ $heroText }}</p>

    </div>

    <div class="bb-container">

        @if(session('success'))

            <div class="success-alert">
                {{ session('success') }}
            </div>

        @endif

        @php
            $tax  = $order->subtotal * 0.10;
            $user = $order->user;
        @endphp

        <div class="bb-grid">

            {{-- LEFT --}}
            <div>

                {{-- STATUS CARD --}}
                @php

                    switch($status){

                        case 'pending':
                            $statusTitle = 'Pending';
                            $statusText  = 'Waiting for admin confirmation.';
                            $statusClass = 'status-pending';
                        break;

                        case 'processing':
                            $statusTitle = 'In Preparation';
                            $statusText  = 'Preparing your order with care.';
                            $statusClass = 'status-processing';
                        break;

                        case 'ready_to_pickup':
                            $statusTitle = 'Ready To Pickup';
                            $statusText  = 'Your order is packed and ready for pickup.';
                            $statusClass = 'status-ready';
                        break;

                        case 'completed':
                            $statusTitle = 'Completed';
                            $statusText  = 'Order completed successfully.';
                            $statusClass = 'status-completed';
                        break;

                        case 'cancelled':
                            $statusTitle = 'Cancelled';
                            $statusText  = 'This order has been cancelled.';
                            $statusClass = 'status-cancelled';
                        break;

                        default:
                            $statusTitle = 'Updated';
                            $statusText  = 'Order status updated.';
                            $statusClass = 'status-ready';
                        break;

                    }

                @endphp

                <div class="status-card {{ $statusClass }}">

                    <div class="status-left">

                        <div class="status-label">

                            @if($status == 'pending')

                                <i class="fa-regular fa-clock"></i>

                            @elseif($status == 'processing')

                                <i class="fa-solid fa-bread-slice"></i>

                            @elseif($status == 'ready_to_pickup')

                                <i class="fa-solid fa-check"></i>

                            @elseif($status == 'completed')

                                <i class="fa-solid fa-check"></i>

                            @elseif($status == 'cancelled')

                                <i class="fa-solid fa-xmark"></i>

                            @endif

                            {{ $statusTitle }}

                        </div>

                        <div class="status-quote">
                            "{{ $statusText }}"
                        </div>

                    </div>

                    <div class="status-time">

                        @if($status == 'completed')

                            <div class="status-time-number completed-icon">
                                <i class="fa-solid fa-check"></i>
                            </div>

                            <div class="status-time-label completed-text">
                                Completed
                            </div>

                        @elseif($status == 'cancelled')

                            <div class="status-time-number cancelled-icon">
                                <i class="fa-solid fa-xmark"></i>
                            </div>

                            <div class="status-time-label cancelled-text">
                                Cancelled
                            </div>

                        @elseif($status == 'ready_to_pickup')

                            <div class="status-time-number ready-icon">
                                <i class="fa-solid fa-check"></i>
                            </div>

                            <div class="status-time-label ready-text">
                                Ready
                            </div>

                        @elseif($status == 'processing')

                            <div class="status-time-number">
                                10
                            </div>

                            <div class="status-time-label">
                                Minutes Away
                            </div>

                        @else

                            <div class="status-time-number">
                                <i class="fa-regular fa-clock"></i>
                            </div>

                            <div class="status-time-label">
                                Pending
                            </div>

                        @endif

                    </div>

                </div>

                {{-- ORDER ITEMS --}}
                <div class="bb-card">

                    <div class="bb-card-title">
                        Order Summary
                    </div>

                    @foreach($order->items as $item)

                        <div class="order-item">

                            <img
                                src="{{ asset('storage/'.$item->product->image) }}"
                                class="order-item-img"
                                alt="{{ $item->product->name }}"
                            >

                            <div class="flex-1">

                                <div class="order-item-name">
                                    {{ $item->product_name }}
                                </div>

                                <div class="order-item-qty">
                                    Qty: {{ $item->quantity }}
                                </div>

                            </div>

                            <div class="order-item-price">
                                Rp {{ number_format($item->subtotal,0,',','.') }}
                            </div>

                        </div>

                    @endforeach

                    <div class="summary-totals">

                        <div class="summary-row">

                            <span>Subtotal</span>

                            <span>
                                Rp {{ number_format($order->subtotal,0,',','.') }}
                            </span>

                        </div>

                        <div class="summary-row">

                            <span>Tax (10%)</span>

                            <span>
                                Rp {{ number_format($tax,0,',','.') }}
                            </span>

                        </div>

                        <div class="summary-row summary-total">

                            <span>Total</span>

                            <span>
                                Rp {{ number_format($order->total,0,',','.') }}
                            </span>

                        </div>

                    </div>

                </div>

                {{-- NOTES --}}
                @if($order->notes)

                    <div class="bb-card">

                        <div class="bb-card-title">
                            Kitchen Notes
                        </div>

                        <p class="notes-text">
                            {{ $order->notes }}
                        </p>

                    </div>

                @endif

            </div>

            {{-- RIGHT --}}
            <div>

                {{-- ORDER NUMBER --}}
                <div class="order-number-card">

                    <div class="order-number-label">
                        Order Number
                    </div>

                    <div class="order-number-value">
                        #{{ $order->order_number }}
                    </div>

                    <div class="order-number-note">
                        Show this number at pickup.
                    </div>

                </div>

                <a href="{{ route('home') }}"
                   class="btn-primary">
                    Continue Shopping
                </a>

                {{-- PICKUP DETAILS --}}
                <div class="bb-card mt-20">

                    <div class="bb-card-title">
                        Pickup Details
                    </div>

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

                {{-- PAYMENT STATUS --}}
                <div class="bb-card mt-20">

                    <div class="bb-card-title">
                        Payment Status
                    </div>

                    @if($order->payment_status == 'paid')

                        <div class="badge-completed">
                            Paid - Your payment has been confirmed
                        </div>

                    @elseif($order->payment_status == 'pending')

                        <div class="badge-pending">
                            Pending - Waiting for admin verification
                        </div>

                    @elseif($order->payment_status == 'unpaid')

                        <div class="badge-cancelled">
                            Unpaid - Payment has not been received
                        </div>

                    @elseif($order->payment_status == 'failed')

                        <div class="badge-cancelled">
                            Failed - Please make payment again
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection