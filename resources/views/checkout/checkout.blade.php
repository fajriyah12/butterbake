@extends('layouts.app')
@section('title', 'Checkout')

@section('content')

<div class="page-header">
    <div class="container">
        
        <h1 class="page-header-title">Checkout & Pickup</h1>
    </div>
</div>

<div class="section" style="padding-top:48px;">
    <div class="container">
        <form method="POST" action="{{ route('checkout.payment') }}">
            @csrf
            <div class="checkout-layout">

                {{-- LEFT --}}
                <div>
                    {{-- DELIVERY METHOD --}}
                    <div class="checkout-card">
                        <h3 class="checkout-card-title">
                            <i class="fas fa-truck" style="color:var(--amber)"></i> Metode Pengiriman
                        </h3>
                        <div class="delivery-options">
                            <label class="delivery-option" id="pickupOpt">
                                <input type="radio" name="delivery_method" value="pickup" checked onchange="toggleDelivery(this)">
                                <div class="delivery-option-icon">🏪</div>
                                <div class="delivery-option-label">Ambil Sendiri</div>
                                <div class="delivery-option-desc">Gratis · Pilih jadwal</div>
                            </label>
                            <label class="delivery-option" id="deliveryOpt">
                                <input type="radio" name="delivery_method" value="delivery" onchange="toggleDelivery(this)">
                                <div class="delivery-option-icon">🛵</div>
                                <div class="delivery-option-label">Pengiriman</div>
                                <div class="delivery-option-desc">Rp 15.000 · 1-3 jam</div>
                            </label>
                        </div>

                        {{-- Pickup Date --}}
                        <div id="pickupSection" style="margin-top:20px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Tanggal & Waktu Pickup</label>
                                <input type="datetime-local" name="pickup_date" class="form-control"
                                    min="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>

                        {{-- Delivery Address --}}
                        <div id="deliverySection" style="margin-top:20px;display:none;">
                            <div class="form-group">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="delivery_address" class="form-control" rows="3" placeholder="Jalan, Nomor, RT/RW, Kelurahan..."></textarea>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label">Kota</label>
                                    <input type="text" name="delivery_city" class="form-control" placeholder="Jakarta">
                                </div>
                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="delivery_postal_code" class="form-control" placeholder="12345">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- NOTES --}}
                    <div class="checkout-card">
                        <h3 class="checkout-card-title">
                            <i class="fas fa-sticky-note" style="color:var(--amber)"></i> Catatan Pesanan
                        </h3>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Contoh: Tolong jangan terlalu manis, atau tambahkan lilin ulang tahun"></textarea>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: ORDER SUMMARY --}}
                <div>
                    <div class="cart-summary-box">
                        <h3 class="cart-summary-title">Ringkasan Pesanan</h3>

                        @foreach($cart->items as $item)
                            <div style="display:flex;gap:12px;align-items:center;margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid var(--border);">
                                <div style="width:52px;height:52px;border-radius:var(--radius);overflow:hidden;background:var(--cream-dark);flex-shrink:0;">
                                    <img src="https://images.unsplash.com/photo-1486427944299-d1955d23e34d?w=100&q=80" alt="" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div style="flex:1;">
                                    <div style="font-size:.9rem;font-weight:500;color:var(--chocolate);">{{ Str::limit($item->product->name, 24) }}</div>
                                    <div style="font-size:.8rem;color:var(--text-light);">×{{ $item->quantity }}</div>
                                </div>
                                <div style="font-size:.9rem;font-weight:600;color:var(--chocolate);">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach

                        <div class="cart-summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="cart-summary-row" id="deliverySummary" style="display:none;">
                            <span>Ongkir</span>
                            <span>Rp 15.000</span>
                        </div>
                        <div class="cart-summary-row total">
                            <span>Total</span>
                            <span id="totalAmt">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full btn-lg" style="margin-top:20px;">
                            Lanjut ke Pembayaran <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const cartTotal = {{ $cart->total }};
function toggleDelivery(radio) {
    const isDelivery = radio.value === 'delivery';
    document.getElementById('pickupSection').style.display  = isDelivery ? 'none' : 'block';
    document.getElementById('deliverySection').style.display = isDelivery ? 'block' : 'none';
    document.getElementById('deliverySummary').style.display = isDelivery ? 'flex' : 'none';
    const t = isDelivery ? cartTotal + 15000 : cartTotal;
    document.getElementById('totalAmt').textContent = 'Rp ' + t.toLocaleString('id-ID');
    document.getElementById('pickupOpt').classList.toggle('selected', !isDelivery);
    document.getElementById('deliveryOpt').classList.toggle('selected', isDelivery);
    // Required fields
    document.querySelector('[name=pickup_date]').required = !isDelivery;
    document.querySelector('[name=delivery_address]').required = isDelivery;
    document.querySelector('[name=delivery_city]').required = isDelivery;
    document.querySelector('[name=delivery_postal_code]').required = isDelivery;
}
document.getElementById('pickupOpt').classList.add('selected');
</script>
@endpush

@endsection