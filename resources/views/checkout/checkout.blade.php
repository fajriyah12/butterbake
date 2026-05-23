@extends('layouts.app')
@section('title', 'Checkout')

@section('content')

<div class="page-header">
    <div class="container" style="max-width:100%; margin:0; padding:0px 40px;">
        <h1 class="page-header-title">Checkout & Pickup</h1>
    </div>
</div>

<div class="section" style="padding-top:20px; padding-bottom:40px;">
    <div class="container" style="max-width:100%; margin:0; padding:0 40px;">

        @if($errors->any())
            <div style="background:#fff0f0;border:1px solid #f5c6c6;border-radius:10px;padding:14px 18px;margin-bottom:24px;font-size:13px;color:#c0392b;display:flex;align-items:center;gap:10px;">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.payment') }}">
            @csrf
            <div class="checkout-layout">

                {{-- ── LEFT ── --}}
                <div class="checkout-left">

                    {{-- CONTACT INFORMATION --}}
                    <div class="checkout-card">
                        <h3 class="checkout-card-title">
                            Contact Information
                        </h3>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label-upper">Full Name</label>
                                <input type="text" name="full_name" class="form-control"
                                    placeholder="Julian Thorne"
                                    value="{{ old('full_name', auth()->user()->name ?? '') }}">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label-upper">Phone Number</label>
                                <input type="tel" name="phone" class="form-control"
                                    placeholder="(555) 000-0000"
                                    value="{{ old('phone', auth()->user()->phone ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label-upper">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                placeholder="julian@example.com"
                                value="{{ old('email', auth()->user()->email ?? '') }}">
                        </div>
                    </div>

                    {{-- PICKUP DETAILS --}}
                    <div class="checkout-card">
                        <h3 class="checkout-card-title">
                            Pickup Details
                        </h3>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label-upper">Select Location</label>
                                <div class="select-wrapper">
                                    <select name="pickup_location" class="form-control form-select" required>
                                        @foreach([
                                            'Butter Bake, Kedaton',
                                        ] as $loc)
                                            <option value="{{ $loc }}"
                                                {{ old('pickup_location') === $loc ? 'selected' : '' }}>
                                                {{ $loc }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label-upper">Pickup Time</label>
                                <div class="select-wrapper">
                                    <select name="pickup_date" class="form-control form-select" required>
                                        @foreach([
                                            'Today, 10:00 AM',
                                            'Today, 11:00 AM',
                                            'Today, 12:00 PM',
                                            'Today, 1:00 PM',
                                            'Today, 2:00 PM',
                                            'Today, 3:00 PM',
                                            'Today, 4:00 PM',
                                            'Today, 5:00 PM',
                                            'Today, 6:00 PM',
                                            'Today, 7:00 PM',
                                            'Today, 8:00 PM',
                                            'Today, 9:00 PM',
                                        ] as $slot)
                                            <option value="{{ $slot }}"
                                                {{ old('pickup_date') === $slot ? 'selected' : '' }}>
                                                {{ $slot }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- NOTES --}}
                    <div class="checkout-card">
                        <h3 class="checkout-card-title">
                            Catatan (opsional)
                        </h3>
                        <div class="form-group" style="margin-bottom:0;">
                            <textarea name="notes" class="form-control" rows="3"
                                placeholder="Contoh: Tolong jangan terlalu manis, atau tambahkan lilin ulang tahun">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <input type="hidden" name="delivery_method" value="pickup">

                </div>

                {{-- ── RIGHT: YOUR BASKET ── --}}
                <div class="checkout-right">
                    <div class="cart-summary-box">
                        <h3 class="cart-summary-title checkout">Your Cart</h3>

                        @foreach($cart->items as $item)
                        <div class="basket-item">
                            <div class="basket-item-img">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         alt="{{ $item->product->name }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1486427944299-d1955d23e34d?w=100&q=80"
                                         alt="{{ $item->product->name }}">
                                @endif
                            </div>
                            <div class="basket-item-info">
                                <div class="basket-item-name">{{ Str::limit($item->product->name, 24) }}</div>
                                <div class="basket-item-qty">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div class="basket-item-price">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach


                        <div class="cart-summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="cart-summary-row">
                            <span>Tax (10%)</span>
                            <span>Rp {{ number_format($cart->total * 0.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="cart-summary-row total">
                            <span>Total</span>
                            <span>Rp {{ number_format($cart->total * 1.1, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full btn-lg"
                                style="margin-top:20px;display:flex;align-items:center;justify-content:center;gap:8px;">
                            Confirm Order for Pickup
                        </button>

                        <div class="basket-notify" style="display:flex;justify-content:center;align-items:center;">
                            <span>You will receive an SMS and email notification when
your order is ready for collection.</span>
                        </div>
                    
                </div>

            </div>
        </form>
    </div>
</div>

@endsection