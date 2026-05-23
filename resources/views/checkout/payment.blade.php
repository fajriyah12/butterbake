@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')

<div class="page-header">
    <div class="container" style="max-width:100%; margin:0; padding:0px 40px;">
        <h1 class="page-header-title">Payment</h1>
    </div>
</div>

<div class="section" style="padding-top:20px; padding-bottom:64px;">
    <div class="container" style="max-width:100%; margin:0; padding:0 40px;">

        @if($errors->any())
            <div class="pay-alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('order.place') }}" id="paymentForm">
            @csrf
            <input type="hidden" name="payment_method" id="paymentMethod">

            <div class="checkout-layout">

                {{-- LEFT --}}
                <div class="checkout-left">

                    {{-- PAYMENT METHOD --}}
                    <div class="checkout-card">
                        <h3 class="checkout-card-title">
                            Choose Payment Method
                        </h3>

                        <div class="pay-group">
                            <div class="pay-group-label">
                                Virtual Account
                            </div>

                            <div class="pay-options-grid">
                                @foreach([
                                    ['bank_transfer_bca','BCA','images/bca.jpg'],
                                    ['bank_transfer_bni','BNI','images/bni.png'],
                                    ['bank_transfer_bri','BRI','images/bri.png'],
                                    ['bank_transfer_mandiri','Mandiri','images/mandiri.jpg'],
                                ] as [$val,$label,$logo])
                                <div class="pay-option" data-value="{{ $val }}" onclick="selectPayment(this)">
                                    <div class="pay-option-inner">
                                        <div class="pay-option-icon">
                                            <img src="{{ asset($logo) }}" alt="{{ $label }}">
                                        </div>
                                        <span>{{ $label }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="payError" class="pay-inline-error" style="display:none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            Please select a payment method first.
                        </div>
                    </div>

                    {{-- PICKUP --}}
                    @php $checkout = session('checkout_data'); @endphp
                    @if($checkout)
                    <div class="checkout-card">
                        <h3 class="checkout-card-title">
                            Detail Pickup
                        </h3>

                        <div class="pickup-summary">
                            @if(!empty($checkout['full_name']))
                                <div class="pickup-summary-row">
                                    <span>Nama</span>
                                    <span>{{ $checkout['full_name'] }}</span>
                                </div>
                            @endif

                            @if(!empty($checkout['email']))
                                <div class="pickup-summary-row">
                                    <span>Email</span>
                                    <span>{{ $checkout['email'] }}</span>
                                </div>
                            @endif

                            @if(!empty($checkout['phone']))
                                <div class="pickup-summary-row">
                                    <span>Telepon</span>
                                    <span>{{ $checkout['phone'] }}</span>
                                </div>
                            @endif

                            @if(!empty($checkout['pickup_location']))
                                <div class="pickup-summary-row">
                                    <span>Lokasi</span>
                                    <span>{{ $checkout['pickup_location'] }}</span>
                                </div>
                            @endif

                            @if(!empty($checkout['pickup_date']))
                                <div class="pickup-summary-row">
                                    <span>Waktu</span>
                                    <span>{{ $checkout['pickup_date'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>

                {{-- RIGHT --}}
                <div class="checkout-right">
                    <div class="cart-summary-box">

                        <h3 class="cart-summary-title checkout">Order Summary</h3>

                        @php
                            $subtotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
                            $tax = $subtotal * 0.1;
                            $total = $subtotal + $tax;
                        @endphp

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
                                <div class="basket-item-name">
                                    {{ Str::limit($item->product->name, 24) }}
                                </div>
                                <div class="basket-item-qty">
                                    Qty: {{ $item->quantity }}
                                </div>
                            </div>
                            <div class="basket-item-price">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach

                        <div class="cart-summary-divider"></div>

                        <div class="cart-summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="cart-summary-row">
                            <span>Tax (10%)</span>
                            <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>

                        <div class="cart-summary-row total">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-full btn-lg"
                                style="margin-top:20px;display:flex;justify-content:center;gap:8px;"
                                onclick="return validatePayment()">
                            Confirm Order
                        </button>

                        <div class="basket-notify" style="display:flex; align-items:center; justify-content:center; gap:6px; text-align:center;">
                            <span>SECURE & TRUSTED TRANSACTIONS</span></div>
</div>
                </div>

            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
function selectPayment(el) {
    document.querySelectorAll('.pay-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('paymentMethod').value = el.dataset.value;
    document.getElementById('payError').style.display = 'none';
}

function validatePayment() {
    if (!document.getElementById('paymentMethod').value) {
        document.getElementById('payError').style.display = 'flex';
        return false;
    }
    return true;
}
</script>
@endpush

@endsection