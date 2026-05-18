@extends('layouts.app')
@section('title', 'Pesanan Berhasil')

@section('content')

<div style="background:#f7efe9;min-height:100vh;padding-bottom:80px;">
    <div class="container" style="padding-top:40px;">

        {{-- SUCCESS BADGE --}}
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
            <div style="width:36px;height:36px;border-radius:50%;background:#e8f5ee;border:2px solid #a8d5b8;display:flex;align-items:center;justify-content:center;color:#2e7d4f;font-size:13px;">
                <i class="fas fa-check"></i>
            </div>
            <span style="font-size:11px;font-weight:700;letter-spacing:.15em;color:#9b5a28;text-transform:uppercase;">
                ORDER PLACED SUCCESSFULLY
            </span>
        </div>

        {{-- HERO --}}
        <div class="confirm-hero">
            <div>
                <h1 class="confirm-title">Thank You for<br>Your Order!</h1>
                <p class="confirm-desc">
                    We've received your order. Please complete the payment using the method below.
                </p>
            </div>

            <div class="confirm-order-box">
                <div class="confirm-order-label">ORDER NUMBER</div>
                <div class="confirm-order-number">#{{ $order->order_number }}</div>
            </div>
        </div>

        {{-- MAIN GRID --}}
        <div class="confirm-layout">

            {{-- LEFT --}}
            <div class="confirm-card">

                {{-- PAYMENT HEADER --}}
                <div class="confirm-payment-header">
                    <div>
                        <div class="confirm-label">PAYMENT METHOD</div>
                        <div class="confirm-payment-name">
                            @php
                                $method = $order->payment_method ?? '';
                                $label = match(true) {
                                    str_contains($method,'bca') => 'Virtual Account BCA',
                                    str_contains($method,'bni') => 'Virtual Account BNI',
                                    str_contains($method,'bri') => 'Virtual Account BRI',
                                    str_contains($method,'mandiri') => 'Virtual Account Mandiri',
                                    str_contains($method,'gopay') => 'GoPay',
                                    str_contains($method,'ovo') => 'OVO',
                                    str_contains($method,'dana') => 'DANA',
                                    str_contains($method,'shopee') => 'ShopeePay',
                                    default => ucfirst($method),
                                };
                            @endphp
                            {{ $label }}
                        </div>
                    </div>

                    <div style="text-align:right;">
                        <div class="confirm-label">Total Amount</div>
                        <div class="confirm-total">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                {{-- STATUS BOX (FIX REPLACE POPUP BUTTON) --}}
                <div style="margin-top:20px;padding:14px 16px;background:#fff3e6;border:1px solid #f0d2b6;border-radius:12px;">
                    <div style="font-weight:700;color:#9b5a28;margin-bottom:6px;">
                        Payment Pending Verification
                    </div>
                    <div style="font-size:13px;color:#6b4a2f;">
                        Your order is waiting for admin confirmation. Please wait while we verify your payment.
                    </div>
                </div>

                {{-- VA / WALLET --}}
                @php
                    $isVA = str_contains($order->payment_method ?? '', 'bank_transfer');
                    $isWallet = str_contains($order->payment_method ?? '', 'qris');

                    $prefixMap = ['bca'=>'8837','bni'=>'8808','bri'=>'8822','mandiri'=>'8910'];
                    $prefix = '8800';
                    foreach($prefixMap as $k=>$v){
                        if(str_contains($order->payment_method??'', $k)) $prefix=$v;
                    }

                    $vaNumber = $prefix.' '.substr($order->id*1234,0,4).' '.substr($order->id*5678,0,4).' '.substr($order->id*9012,0,4);
                @endphp

                @if($isVA)
                <div class="confirm-va-box">
                    <div class="confirm-va-label">Virtual Account Number</div>
                    <div class="confirm-va-row">
                        <span class="confirm-va-number" id="vaNumber">{{ $vaNumber }}</span>
                        <button type="button" class="confirm-copy-btn" onclick="copyVA()">
                            <i class="fas fa-copy"></i> Copy Number
                        </button>
                    </div>
                </div>
                @elseif($isWallet)
                <div class="confirm-va-box" style="text-align:center;">
                    <div class="confirm-va-label">E-Wallet Number</div>
                    <div style="font-size:40px;">💳</div>
                    <div class="confirm-va-number" id="vaNumber">
                        0812-{{ substr($order->id*1357,0,4) }}-{{ substr($order->id*2468,0,4) }}
                    </div>
                    <button type="button" class="confirm-copy-btn" onclick="copyVA()">
                        <i class="fas fa-copy"></i> Copy Number
                    </button>
                </div>
                @endif

                {{-- PICKUP INFO --}}
                <div class="confirm-pickup">
                    @if($order->pickup_date)
                    <div class="confirm-pickup-row">
                        <span><i class="fas fa-clock" style="color:#9b5a28;margin-right:8px;"></i>Pickup Time</span>
                        <span>{{ $order->pickup_date }}</span>
                    </div>
                    @endif

                    @if($order->delivery_address)
                    <div class="confirm-pickup-row">
                        <span><i class="fas fa-map-marker-alt" style="color:#9b5a28;margin-right:8px;"></i>Address</span>
                        <span>{{ $order->delivery_address }}, {{ $order->delivery_city }}</span>
                    </div>
                    @endif
                </div>

                {{-- BACK BUTTON + STATUS ORDER --}}
                <div class="confirm-btn-group">
                    <a href="{{ route('home') }}" class="confirm-back-btn">
                    Back to Home
                    </a>
                    <a href="{{ route('order.show', $order->id) }}" class="confirm-status-btn">
                    <i class="fas fa-receipt"></i> Status Order
                 </a>
            </div>

            </div>

            {{-- RIGHT --}}
            <div class="confirm-card">

                <h3 class="confirm-instructions-title">
                    <i class="fas fa-question-circle" style="color:#9b5a28;"></i>
                    Payment Instructions
                </h3>

                @php
                    $m = $order->payment_method ?? '';

                    if(str_contains($m,'bca')) $steps = [
                        "Open m-BCA or KlikBCA",
                        "Go to Transfer → Virtual Account",
                        "Enter number and confirm payment"
                    ];
                    elseif(str_contains($m,'bni')) $steps = [
                        "Open BNI Mobile Banking",
                        "Select Transfer → Virtual Account",
                        "Confirm payment"
                    ];
                    elseif(str_contains($m,'bri')) $steps = [
                        "Open BRImo",
                        "Select BRIVA payment",
                        "Confirm transaction"
                    ];
                    elseif(str_contains($m,'mandiri')) $steps = [
                        "Open Livin' Mandiri",
                        "Select payment menu",
                        "Confirm transfer"
                    ];
                    else $steps = [
                        "Complete payment using selected method",
                        "Wait for admin verification",
                        "Order will be processed after confirmation"
                    ];
                @endphp

                <div class="confirm-steps">
                    @foreach($steps as $i => $step)
                    <div class="confirm-step">
                        <div class="confirm-step-num">{{ $i+1 }}</div>
                        <p class="confirm-step-text">{{ $step }}</p>
                    </div>
                    @endforeach
                </div>

                {{-- ITEMS --}}
                <div style="margin-top:24px;">
                    <div style="font-weight:700;margin-bottom:10px;">Items</div>

                    @foreach($order->items as $item)
                    <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px;">
                        <span>{{ $item->product_name }} ×{{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                    </div>
                    @endforeach

                    <div style="display:flex;justify-content:space-between;font-weight:700;margin-top:10px;">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total,0,',','.') }}</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

{{-- SCRIPT --}}
@push('scripts')
<script>
function copyVA(){
    const txt = document.getElementById('vaNumber').textContent.trim();
    navigator.clipboard.writeText(txt);

    const btn = document.querySelector('.confirm-copy-btn');
    btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
    setTimeout(() => {
        btn.innerHTML = '<i class="fas fa-copy"></i> Copy Number';
    }, 2000);
}
</script>
@endpush

@endsection