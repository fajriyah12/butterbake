@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="page-header">
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

<div class="detail-page">
    <div class="container">
        <div class="product-detail-layout">

            {{-- IMAGE --}}
            <div class="product-gallery">
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
                                    <i class="far fa-star star-inactive"></i>
                                @endif
                            @endfor
                        </div>
                        <span>({{ number_format($product->rating, 1) }} / {{ $product->review_count }} Reviews)</span>
                    </div>
                </div>

                <h1 class="product-info-title">{{ $product->name }}</h1>

                <div class="product-detail-price">{{ $product->formatted_price }}</div>

                @if($product->description)
                <p class="product-description">{{ $product->description }}</p>
                @endif

                @if($product->ingredients)
                <div class="product-ingredients">
                    <div class="buy-label">INGREDIENTS</div>
                    <div class="ingredients-list">
                        @foreach(explode(',', $product->ingredients) as $ingredient)
                        <span class="product-tag">
                            <i class="far fa-check-circle"></i>
                            {{ trim($ingredient) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- BUY BOX --}}
                @if($product->stock <= 0 || !$product->is_active)
                    <span class="sold-out">Sold Out</span>
                    <button class="btn-disabled" disabled>Tidak tersedia</button>
                @else
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
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="buy-top">
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

                        <form action="{{ route('checkout.payment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="buyQty" value="1">
                            <button type="submit" class="btn-buy">Buy Now</button>
                        </form>
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
            <div class="related-products">
                <div class="section-header">
                    <span class="section-label">Produk Lainnya</span>
                    <h2 class="section-title">Mungkin Anda Suka</h2>
                </div>
                <div class="products-grid related-grid">
                    @foreach($related as $rel)
                        <div class="related-product-card">
                            <a href="{{ route('catalog.show', $rel->slug) }}" class="product-card-image">
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

        const total = basePrice * v;
        document.getElementById('subtotalText').textContent =
            'Rp ' + total.toLocaleString('id-ID');
    }
}
</script>
@endpush

@endsection

