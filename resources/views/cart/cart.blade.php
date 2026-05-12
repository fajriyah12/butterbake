@extends('layouts.app')
@section('title', 'Keranjang')

@section('content')

<div class="page-header">
    <div class="container">
                <h1 class="page-header-title">Your Basket</h1>
        <p class="page-header-subtitle">{{ $cart->items->count() }} item dalam keranjang</p>
    </div>
</div>

<div class="section" style="padding-top:48px;">
    <div class="container">
        @if($cart->items->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-shopping-basket"></i></div>
                <h3 class="empty-state-title">Keranjang Anda Kosong</h3>
                <p class="empty-state-desc">Yuk mulai belanja dan temukan produk terbaik kami</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-bread-slice"></i> Mulai Belanja
                </a>
            </div>
        @else
            <div class="cart-layout">

                {{-- ============ CART ITEMS ============ --}}
                <div>
                    <div class="cart-table">
                        <div class="cart-table-header">
                            <span>Produk</span>
                            <span>Harga</span>
                            <span>Jumlah</span>
                            <span>Subtotal</span>
                            <span></span>
                        </div>

                        @foreach($cart->items as $item)
                            <div class="cart-row">

                                {{-- Produk --}}
                                <div class="cart-product">
                                    <div class="cart-product-image">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                                 alt="{{ $item->product->name }}">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1486427944299-d1955d23e34d?w=200&q=80"
                                                 alt="{{ $item->product->name }}">
                                        @endif
                                    </div>
                                    <div>
                                        <div class="cart-product-name">{{ $item->product->name }}</div>
                                        <div class="cart-product-cat">{{ $item->product->category->name }}</div>
                                    </div>
                                </div>

                                {{-- Harga satuan --}}
                                <div style="font-size:.95rem;color:var(--text-mid);">
                                    {{ $item->product->formatted_price }}
                                </div>

                                {{-- Quantity --}}
                                <form method="POST" action="{{ route('cart.update', $item) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="quantity-selector" style="display:flex;align-items:center;">
                                        <button type="button" class="qty-btn" onclick="dec(this)">−</button>
                                        <input type="number" name="quantity" class="qty-input"
                                               value="{{ $item->quantity }}" min="1" max="99"
                                               onchange="this.form.submit()">
                                        <button type="button" class="qty-btn" onclick="inc(this)">+</button>
                                    </div>
                                </form>

                                {{-- Subtotal --}}
                                <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:var(--chocolate);">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </div>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('cart.remove', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="width:36px;height:36px;border-radius:50%;background:none;border:1.5px solid var(--border);cursor:pointer;color:var(--text-light);transition:var(--transition);"
                                        onmouseover="this.style.borderColor='#e74c3c';this.style.color='#e74c3c'"
                                        onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-light)'"
                                        title="Hapus item">
                                        <i class="fas fa-times" style="font-size:.75rem;"></i>
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    </div>
                    

                    <div style="margin-top:20px;display:flex;gap:12px;">
                        <a href="{{ route('catalog.index') }}" class="btn btn-ghost">
                            <i class="fas fa-arrow-left"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>

                {{-- ============ ORDER SUMMARY ============ --}}
                <div class="cart-summary-box">
                    <h3 class="cart-summary-title">Ringkasan Pesanan</h3>

                    {{-- Daftar item --}}
                    @foreach($cart->items as $item)
                        <div class="cart-summary-row">
                            <span>{{ Str::limit($item->product->name, 22) }} ×{{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    {{-- Ongkir --}}
                    <div class="cart-summary-row">
                        <span>Ongkir</span>
                        <span style="color:var(--amber);">Dihitung saat checkout</span>
                    </div>

                    {{-- Total --}}
                    <div class="cart-summary-row total">
                        <span>Total Sementara</span>
                        <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout') }}"
                    class="btn btn-primary btn-full btn-lg"
                     style="margin-top:20px;display:inline-flex;align-items:center;justify-content:center;">Lanjut ke Checkout
                     <i class="fas fa-arrow-right"></i></a>

                    <div style="margin-top:16px;text-align:center;font-size:.8rem;color:var(--text-light);">
                        <i class="fas fa-shield-alt" style="color:var(--amber)"></i>
                        Transaksi Aman &amp; Terpercaya
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function dec(btn) {
    const input = btn.parentElement.querySelector('input');
    const val = parseInt(input.value);
    if (val > 1) {
        input.value = val - 1;
        input.form.submit();
    }
}
function inc(btn) {
    const input = btn.parentElement.querySelector('input');
    const val = parseInt(input.value);
    if (val < 99) {
        input.value = val + 1;
        input.form.submit();
    }
}
</script>
@endpush

@endsection