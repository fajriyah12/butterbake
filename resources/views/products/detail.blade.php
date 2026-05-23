@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="page-header" style="padding:24px 50px 20px; border-top:1px solid #eadfd4;">
    <div class="container">
        <div class="breadcrumb">
           <a href="/catalog">Katalog</a>
           <span>/</span>
           <span>{{ $product->category->name }}</span>
           <span>/</span>
           <span>{{ $product->name }}</span>
        </div>
    </div>
</div>

{{-- DETAIL --}}
<div class="detail-page">
    <div class="container">
        <div class="product-detail-layout">

            {{-- IMAGE --}}
            <div class="product-gallery" style="position:relative;">
                <div class="product-main-image">
                    @if($product->image)
                        <img id="mainImg"
                             src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}">
                    @else
                        <img id="mainImg"
                             src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=900&q=80"
                             alt="{{ $product->name }}">
                    @endif
                </div>
            </div>

            {{-- INFO --}}
            <div class="product-info">

                {{-- TOP --}}
                <div class="product-topbar">
                    <span class="best-badge">Best Seller</span>
                    <div class="rating-area">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($product->rating))
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star" style="color:#ddd;"></i>
                                @endif
                            @endfor
                        </div>
                        <span>({{ number_format($product->rating, 1) }} / {{ $product->review_count }} Reviews)</span>
                    </div>
                </div>

                {{-- TITLE --}}
                <h1 class="product-info-title">{{ $product->name }}</h1>

                {{-- PRICE --}}
                <div class="product-detail-price">{{ $product->formatted_price }}</div>

                {{-- STOK --}}
               <div class="product-stock">
               @if($product->stock > 10)
               <span style="color:#2e7d32;">
                 In Stock ({{ $product->stock }})
                </span>
               @elseif($product->stock > 0)
                <span style="color:#e67e22;">
                Low Stock ({{ $product->stock }})
                </span>
               @else
               <span style="color:#c0392b;">
               Out of Stock
               </span>
               @endif
                </div>

                {{-- DESC --}}
                @if($product->description)
                <p class="product-description">{{ $product->description }}</p>
                @endif

                {{-- INGREDIENTS --}}
                @if($product->ingredients)
                <div style="margin-bottom:14px;">
                    <div class="buy-label" style="margin-bottom:8px;">INGREDIENTS</div>
                    <div style="display:flex; flex-wrap:wrap; gap:8px;">
                        @foreach(explode(',', $product->ingredients) as $ingredient)
                        <span class="product-tag">
                            <i class="far fa-check-circle"></i>
                            {{ trim($ingredient) }}
                        </span>
                        @endforeach
                    </div>
                </div>@endif

                {{-- BUY BOX --}}
                @if($product->stock > 0)

                    @if(session('success'))
                        <div class="success-popup" id="successPopup">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                        <script>
                            setTimeout(() => {
                                const el = document.getElementById('successPopup');
                                if(el) el.remove();
                            }, 2000);
                        </script>
                    @endif

                    <div class="buy-box">

                        {{-- ADD TO CART --}}
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="buy-top" style="display:flex; justify-content:space-between; align-items:center; gap:30px;">
                                <div>
                                    <div class="buy-label">QUANTITY</div>
                                    <div class="quantity-selector">
                                        <button type="button" class="qty-btn" onclick="changeQty(-1)">−</button>
                                        <input type="number"
                                               name="quantity"
                                               id="qtyInput"
                                               class="qty-input"
                                               value="1"
                                               min="1"
                                               max="{{ $product->stock }}"
                                               readonly>
                                        <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                                    </div>
                                </div>

                                <div class="subtotal-box">
                                    <div class="buy-label">SUB-TOTAL</div>
                                    <h3 id="subtotalText">{{ $product->formatted_price }}</h3>
                                </div>
                            </div>

                            <div class="buy-actions">
                                <button type="submit" class="btn-cart">Add to Cart</button>
                        </form>

                        {{-- BUY NOW --}}
                        <form action="{{ route('checkout') }}" method="POST">
    @csrf

    <input type="hidden" name="buy_now" value="1">

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <input type="hidden" name="quantity" id="buyQty" value="1">

    <button type="submit" class="btn-buy">
        Buy Now
    </button>
</form>
                        </div>
                    </div>

                @else
                    <div style="margin-top:16px; padding:14px 18px; background:#fff0f0; border:1px solid #f5c6c6; border-radius:10px; font-size:13px; color:#c0392b;">
                        <i class="fas fa-times-circle"></i> Stok habis, produk sedang tidak tersedia.
                    </div>
                @endif

                {{-- EXTRA --}}
                <div class="product-extra">
                    @if($product->serves)
                    <div class="extra-item">
                        <i class="fas fa-box"></i>
                        <div>
                            <h4>Serves</h4>
                            <p>{{ $product->serves }}</p>
                        </div>
                    </div>
                    @endif

                    @if($product->shelf_life)
                    <div class="extra-item">
                        <i class="far fa-clock"></i>
                        <div>
                            <h4>Shelf Life</h4>
                            <p>{{ $product->shelf_life }}</p>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- RELATED PRODUCTS --}}
        @if($related->isNotEmpty())
            <div style="margin-top:80px;">
                <div class="section-header">
                    <span class="section-label">Produk Lainnya</span>
                    <h2 class="section-title" style="font-size:2rem;">Mungkin Anda Suka</h2>
                </div>
                <div class="products-grid related-grid">
                    @foreach($related as $rel)
                        <div class="related-product-card">
                            <a href="{{ route('catalog.show', $rel->slug) }}" class="product-card-image" style="display:block;">
                                @if($rel->image)
                                    <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=500&q=80" alt="{{ $rel->name }}">
                                @endif
                            </a>
                            <div class="product-card-body">
                                <div class="product-card-category">{{ $rel->category->name }}</div>
                                <a href="{{ route('catalog.show', $rel->slug) }}">
                                    <h3 class="product-card-name">{{ $rel->name }}</h3>
                                </a>
                                <div class="product-card-footer">
                                    <span class="product-price">{{ $rel->formatted_price }}</span>
                                    <a href="{{ route('catalog.show', $rel->slug) }}" class="btn btn-outline btn-sm">Lihat</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
const basePrice = {{ $product->price }};

function changeQty(d) {
    const i = document.getElementById('qtyInput');
    const v = parseInt(i.value) + d;
    const max = parseInt(i.max);
    if (v >= 1 && v <= max) {
        i.value = v;
        document.getElementById('buyQty').value = v;

        // update subtotal
        const total = basePrice * v;
        document.getElementById('subtotalText').textContent =
            'Rp ' + total.toLocaleString('id-ID');
    }
}
</script>
@endpush

@endsection