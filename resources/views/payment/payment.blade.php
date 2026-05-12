@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')

<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a><span>/</span>
            <a href="{{ route('cart.index') }}">Keranjang</a><span>/</span>
            <a href="{{ route('checkout') }}">Checkout</a><span>/</span>
            <span>Pembayaran</span>
        </div>
        <h1 class="page-header-title">Pembayaran</h1>
    </div>
</div>

<div class="section" style="padding-top:48px;">
    <div class="container">
        <form method="POST" action="{{ route('order.place') }}">
            @csrf
            <div class="checkout-layout">

                {{-- PAYMENT METHODS --}}
                <div>
                    <div class="checkout-card">
                        <h3 class="checkout-card-title">
                            <i class="fas fa-credit-card" style="color:var(--amber)"></i> Metode Pembayaran
                        </h3>

                        <div class="payment-methods">
                            {{-- Transfer Bank --}}
                            <label class="payment-method" onclick="selectPayment(this,'bank_transfer')">
                                <input type="radio" name="payment_method" value="bank_transfer" required style="display:none;">
                                <i class="fas fa-university" style="font-size:1.4rem;color:var(--amber);width:32px;"></i>
                                <div>
                                    <div class="payment-method-name">Transfer Bank</div>
                                    <div class="payment-method-desc">BCA, Mandiri, BNI, BRI</div>
                                </div>
                            </label>

                            {{-- QRIS --}}
                            <label class="payment-method" onclick="selectPayment(this,'qris')">
                                <input type="radio" name="payment_method" value="qris" style="display:none;">
                                <i class="fas fa-qrcode" style="font-size:1.4rem;color:var(--amber);width:32px;"></i>
                                <div>
                                    <div class="payment-method-name">QRIS</div>
                                    <div class="payment-method-desc">GoPay, OVO, Dana, ShopeePay</div>
                                </div>
                            </label>

                            {{-- COD --}}
                            <label class="payment-method" onclick="selectPayment(this,'cod')">
                                <input type="radio" name="payment_method" value="cod" style="display:none;">
                                <i class="fas fa-money-bill-wave" style="font-size:1.4rem;color:var(--amber);width:32px;"></i>
                                <div>
                                    <div class="payment-method-name">Bayar di Tempat</div>
                                    <div class="payment-method-desc">Bayar saat pickup atau terima barang</div>
                                </div>
                            </label>

                            {{-- Kartu Kredit --}}
                            <label class="payment-method" onclick="selectPayment(this,'credit_card')">
                                <input type="radio" name="payment_method" value="credit_card" style="display:none;">
                                <i class="fas fa-credit-card" style="font-size:1.4rem;color:var(--amber);width:32px;"></i>
                                <div>
                                    <div class="payment-method-name">Kartu Kredit / Debit</div>
                                    <div class="payment-method-desc">Visa, Mastercard, JCB</div>
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ORDER INFO --}}
                    @php $checkout = session('checkout_data'); @endphp
                    @if($checkout)
                        <div class="checkout-card">
                            <h3 class="checkout-card-title">
                                <i class="fas fa-info-circle" style="color:var(--amber)"></i> Detail Pengiriman
                            </h3>
                            <div style="font-size:.9rem;color:var(--text-mid);line-height:1.9;">
                                <div><strong style="color:var(--chocolate);">Metode:</strong>
                                    {{ $checkout['delivery_method'] === 'pickup' ? '🏪 Ambil Sendiri' : '🛵 Pengiriman' }}
                                </div>
                                @if($checkout['delivery_method'] === 'pickup' && isset($checkout['pickup_date']))
                                    <div><strong style="color:var(--chocolate);">Waktu Pickup:</strong>
                                        {{ \Carbon\Carbon::parse($checkout['pickup_date'])->locale('id')->isoFormat('dddd, D MMM Y · HH:mm') }}
                                    </div>
                                @elseif($checkout['delivery_method'] === 'delivery')
                                    <div><strong style="color:var(--chocolate);">Alamat:</strong> {{ $checkout['delivery_address'] }}, {{ $checkout['delivery_city'] }}</div>
                                @endif
                                @if(!empty($checkout['notes']))
                                    <div><strong style="color:var(--chocolate);">Catatan:</strong> {{ $checkout['notes'] }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ORDER SUMMARY --}}
                <div>
                    <div class="cart-summary-box">
                        <h3 class="cart-summary-title">Ringkasan Pesanan</h3>

                        @php
                            $subtotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
                            $delivFee = (isset($checkout['delivery_method']) && $checkout['delivery_method'] === 'delivery') ? 15000 : 0;
                        @endphp

                        @foreach($cart->items as $item)
                            <div class="cart-summary-row">
                                <span>{{ Str::limit($item->product->name, 22) }} ×{{ $item->quantity }}</span>
                                <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach

                        <div class="cart-summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        @if($delivFee > 0)
                            <div class="cart-summary-row">
                                <span>Ongkir</span>
                                <span>Rp {{ number_format($delivFee, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div class="cart-summary-row total">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($subtotal + $delivFee, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full btn-lg" style="margin-top:20px;">
                            <i class="fas fa-lock"></i> Konfirmasi Pesanan
                        </button>

                        <div style="margin-top:16px;text-align:center;font-size:.8rem;color:var(--text-light);">
                            <i class="fas fa-shield-alt" style="color:var(--amber)"></i> Transaksi terenkripsi & aman
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function selectPayment(el, val) {
    document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input[type=radio]').checked = true;
}
</script>
@endpush

@endsection