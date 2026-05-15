@extends('layouts.app')
@section('title', 'Pesanan Berhasil')

@section('content')

<div style="background:#f7efe9;min-height:100vh;padding-bottom:80px;">
    <div class="container" style="padding-top:40px;">

        {{-- ── SUCCESS BADGE ── --}}
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
            <div style="width:36px;height:36px;border-radius:50%;background:#e8f5ee;border:2px solid #a8d5b8;display:flex;align-items:center;justify-content:center;color:#2e7d4f;font-size:13px;">
                <i class="fas fa-check"></i>
            </div>
            <span style="font-size:11px;font-weight:700;letter-spacing:.15em;color:#9b5a28;text-transform:uppercase;">
                ORDER PLACED SUCCESSFULLY
            </span>
        </div>

        {{-- ── HERO ROW ── --}}
        <div class="confirm-hero">
            <div>
                <h1 class="confirm-title">Thank You for<br>Your Order!</h1>
                <p class="confirm-desc">
                    We've received your order. Please complete the payment below so we can
                    begin preparing your artisanal treats.
                </p>
            </div>
            <div class="confirm-order-box">
                <div class="confirm-order-label">ORDER NUMBER</div>
                <div class="confirm-order-number">#{{ $order->order_number }}</div>
            </div>
        </div>

        {{-- ── MAIN GRID ── --}}
        <div class="confirm-layout">

            {{-- LEFT: PAYMENT DETAIL --}}
            <div class="confirm-card">

                {{-- Header: metode + total --}}
                <div class="confirm-payment-header">
                    <div>
                        <div class="confirm-label">PAYMENT METHOD</div>
                        <div class="confirm-payment-name">
                            @php
                                $method = $order->payment_method ?? '';
                                $label  = match(true) {
                                    str_contains($method, 'bca')     => 'Virtual Account BCA',
                                    str_contains($method, 'bni')     => 'Virtual Account BNI',
                                    str_contains($method, 'bri')     => 'Virtual Account BRI',
                                    str_contains($method, 'mandiri') => 'Virtual Account Mandiri',
                                    str_contains($method, 'gopay')   => 'GoPay',
                                    str_contains($method, 'ovo')     => 'OVO',
                                    str_contains($method, 'dana')    => 'DANA',
                                    str_contains($method, 'shopee')  => 'ShopeePay',
                                    default                          => ucfirst($method),
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

                {{-- VA Number / E-Wallet Number --}}
                @php
                    $isVA     = str_contains($order->payment_method ?? '', 'bank_transfer');
                    $isWallet = str_contains($order->payment_method ?? '', 'qris');

                    // Generate simulasi nomor (sesuaikan jika ada kolom payment_code)
                    $prefixMap = ['bca'=>'8837','bni'=>'8808','bri'=>'8822','mandiri'=>'8910'];
                    $prefix    = '8800';
                    foreach($prefixMap as $k=>$v){ if(str_contains($order->payment_method??'',$k)) $prefix=$v; }
                    $vaNumber  = $prefix.' '.substr($order->id*1234,0,4).' '.substr($order->id*5678,0,4).' '.substr($order->id*9012,0,4);
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
                @php
                    $emojiMap = ['gopay'=>'🟢','ovo'=>'🟣','dana'=>'🔵','shopeepay'=>'🟠'];
                    $emoji    = '💳';
                    foreach($emojiMap as $k=>$v){ if(str_contains($order->payment_method??'',$k)) $emoji=$v; }
                    $walletNum = '0812-'.substr($order->id*1357,0,4).'-'.substr($order->id*2468,0,4);
                @endphp
                <div class="confirm-va-box" style="text-align:center;">
                    <div class="confirm-va-label" style="margin-bottom:10px;">
                        Transfer ke akun {{ $label }}
                    </div>
                    <div style="font-size:48px;margin-bottom:8px;">{{ $emoji }}</div>
                    <div class="confirm-va-number" id="vaNumber">{{ $walletNum }}</div>
                    <button type="button" class="confirm-copy-btn" style="margin:12px auto 0;"
                            onclick="copyVA()">
                        <i class="fas fa-copy"></i> Copy Number
                    </button>
                </div>
                @endif

                {{-- Pickup Info dari order --}}
                <div class="confirm-pickup">
                    @if($order->pickup_date)
                    <div class="confirm-pickup-row">
                        <span><i class="fas fa-clock" style="color:#9b5a28;margin-right:8px;"></i>Waktu Pickup</span>
                        <span>{{ $order->pickup_date }}</span>
                    </div>
                    @endif
                    @if($order->delivery_address)
                    <div class="confirm-pickup-row">
                        <span><i class="fas fa-map-marker-alt" style="color:#9b5a28;margin-right:8px;"></i>Alamat</span>
                        <span>{{ $order->delivery_address }}, {{ $order->delivery_city }}</span>
                    </div>
                    @endif
                    @if($order->notes)
                    <div class="confirm-pickup-row">
                        <span><i class="fas fa-sticky-note" style="color:#9b5a28;margin-right:8px;"></i>Catatan</span>
                        <span>{{ $order->notes }}</span>
                    </div>
                    @endif
                </div>

                {{-- Back to Home --}}
                <a href="{{ route('home') }}" class="confirm-back-btn">Back to Home</a>
            </div>

            {{-- RIGHT: PAYMENT INSTRUCTIONS --}}
            <div class="confirm-card">
                <h3 class="confirm-instructions-title">
                    <i class="fas fa-question-circle" style="color:#9b5a28;"></i>
                    Payment Instructions
                </h3>

                @php
                    $m = $order->payment_method ?? '';
                    if(str_contains($m,'bca'))          $steps = ["Open your m-BCA app or log in to klikBCA and navigate to the Transfer menu.","Select BCA Virtual Account and enter the account number provided above.","Verify the transaction details, enter your PIN, and save the payment receipt."];
                    elseif(str_contains($m,'bni'))      $steps = ["Open BNI Mobile Banking and select Transfer.","Select BNI Virtual Account and enter the account number above.","Confirm the details and complete with your PIN."];
                    elseif(str_contains($m,'bri'))      $steps = ["Open BRImo or Internet Banking BRI.","Select Pembayaran → BRIVA and enter the account number.","Verify, enter your PIN, and save the receipt."];
                    elseif(str_contains($m,'mandiri'))  $steps = ["Open Livin' by Mandiri app or visit ATM Mandiri.","Select Bayar → E-commerce and enter the code.","Verify and complete the payment."];
                    elseif(str_contains($m,'gopay'))    $steps = ["Open GoPay in your Gojek app and tap Pay.","Scan the QR or enter the number shown above.","Confirm the amount with your PIN."];
                    elseif(str_contains($m,'ovo'))      $steps = ["Open OVO app and select Transfer.","Enter the OVO number and the exact amount.","Confirm the transfer and save the receipt."];
                    elseif(str_contains($m,'dana'))     $steps = ["Open DANA app and tap Kirim Uang.","Enter the DANA number and transfer the amount.","Confirm the transaction with your DANA PIN."];
                    elseif(str_contains($m,'shopee'))   $steps = ["Open Shopee app and tap ShopeePay.","Select Transfer and enter the number above.","Confirm the amount and complete the payment."];
                    else                                $steps = ["Your order has been recorded in our system.","Please prepare the exact payment amount when picking up.","Show your order number at the counter when you arrive."];
                @endphp

                <div class="confirm-steps">
                    @foreach($steps as $i => $step)
                    <div class="confirm-step">
                        <div class="confirm-step-num">{{ $i + 1 }}</div>
                        <p class="confirm-step-text">{{ $step }}</p>
                    </div>
                    @endforeach
                </div>

                {{-- Countdown 24 jam --}}
                <div class="confirm-timer-box">
                    <i class="fas fa-hourglass-half" style="color:#9b5a28;"></i>
                    <span>Selesaikan pembayaran dalam</span>
                    <span class="confirm-timer" id="countdown">23:59:00</span>
                </div>

                {{-- Order Items ringkas --}}
                <div style="margin-top:24px;padding-top:20px;border-top:1px solid #f0e6dc;">
                    <div style="font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#9b8577;margin-bottom:14px;">
                        Item Pesanan
                    </div>
                    @foreach($order->items as $item)
                    <div style="display:flex;justify-content:space-between;font-size:13px;color:#4d4036;margin-bottom:8px;">
                        <span>{{ $item->product_name }} ×{{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <div style="display:flex;justify-content:space-between;font-size:14px;font-weight:700;color:#9b5a28;margin-top:12px;padding-top:12px;border-top:1px solid #f0e6dc;">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── YOU MIGHT ALSO LOVE ── --}}
        @php
            $related = \App\Models\Product::whereNotIn('id', $order->items->pluck('product_id'))
                        ->inRandomOrder()->take(4)->get();
        @endphp
        @if($related->count())
        <div style="margin-top:56px;">
            <div style="text-align:center;font-size:26px;font-family:'Cormorant Garamond',serif;color:#2b1d13;margin-bottom:12px;">
                You might also love
            </div>
            <div style="width:100%;height:1px;background:#e8dbd0;margin-bottom:28px;"></div>
            <div class="confirm-related-grid">
                @foreach($related as $product)
                <a href="{{ route('catalog.show', $product->slug) }}" class="confirm-related-card">
                    <div class="confirm-related-img">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1486427944299-d1955d23e34d?w=300&q=80" alt="{{ $product->name }}">
                        @endif
                    </div>
                    <div style="padding:4px 0;">
                        <div class="confirm-related-name">{{ $product->name }}</div>
                        <div class="confirm-related-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Countdown 24 jam
(function(){
    const end = new Date(Date.now() + 24*60*60*1000);
    function tick(){
        const d = end - Date.now();
        if(d <= 0){ document.getElementById('countdown').textContent='00:00:00'; return; }
        const h=String(Math.floor(d/3600000)).padStart(2,'0');
        const m=String(Math.floor(d%3600000/60000)).padStart(2,'0');
        const s=String(Math.floor(d%60000/1000)).padStart(2,'0');
        document.getElementById('countdown').textContent=h+':'+m+':'+s;
    }
    tick(); setInterval(tick,1000);
})();

// Copy number
function copyVA(){
    const txt = document.getElementById('vaNumber').textContent.trim();
    navigator.clipboard.writeText(txt).then(function(){
        const btn = document.querySelector('.confirm-copy-btn');
        btn.innerHTML='<i class="fas fa-check"></i> Copied!';
        setTimeout(()=>{btn.innerHTML='<i class="fas fa-copy"></i> Copy Number';},2000);
    });
}
</script>
@endpush

@endsection