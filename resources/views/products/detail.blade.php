@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="page-header" style="padding:24px 50px 20px;
    border-top:1px solid #eadfd4;">
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
            <div class="product-gallery"style="position:relative;">

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

                    <span class="best-badge">
                        Best Seller
                    </span>

                    <div class="rating-area">

                        <div class="stars">

                            @for($i = 1; $i <= 5; $i++)

                                <i class="fas fa-star"></i>

                            @endfor

                        </div>

                        <span>
                            ({{ number_format($product->rating,1) }}
                            / {{ $product->review_count }} Reviews)
                        </span>

                    </div>

                </div>

                {{-- TITLE --}}
                <h1 class="product-info-title">

                    {{ $product->name }}

                </h1>

                {{-- PRICE --}}
                <div class="product-detail-price">

                    {{ $product->formatted_price }}

                </div>

                {{-- DESC --}}
                <p class="product-description">

                    {{ $product->description }}

                </p>

                {{-- TAGS --}}
                <div class="product-tags">

                    <span class="product-tag">

                        <i class="far fa-check-circle"></i>

                        Preservative Free

                    </span>

                    <span class="product-tag">

                        <i class="far fa-check-circle"></i>

                        Organic Grains

                    </span>

                </div>

 {{-- BUY BOX --}}
@if($product->stock > 0)

    @if(session('success'))
        <div class="success-popup" id="successPopup">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    <script>
    setTimeout(() => {
    document.getElementById('successPopup').remove();
    }, 2000);
    </script>

    <div class="buy-box">

       {{-- ADD TO CART --}}
<form method="POST"
      action="{{ route('cart.add') }}">

    @csrf

    <input type="hidden"
           name="product_id"
           value="{{ $product->id }}">

    <div class="buy-top"
         style="display:flex;
                justify-content:space-between;
                align-items:center;
                gap:30px;">

        <div>

            <div class="buy-label">
                QUANTITY
            </div>

            <div class="quantity-selector">

                <button type="button"
                        class="qty-btn"
                        onclick="changeQty(-1)">
                    −
                </button>

                <input type="number"
                       name="quantity"
                       id="qtyInput"
                       class="qty-input"
                       value="1"
                       min="1"
                       max="{{ $product->stock }}"
                       readonly>

                <button type="button"
                        class="qty-btn"
                        onclick="changeQty(1)">
                    +
                </button>

            </div>

        </div>

        <div class="subtotal-box">

            <div class="buy-label">
                SUB-TOTAL
            </div>

            <h3>
                {{ $product->formatted_price }}
            </h3>

        </div>

    </div>

    <div class="buy-actions">

        {{-- ADD TO CART --}}
        <button type="submit"
                class="btn-cart">

            Add to Cart

        </button>

</form>


{{-- BUY NOW --}}
<form action="{{ route('checkout.payment') }}"
      method="POST">

    @csrf

    <input type="hidden"
           name="product_id"
           value="{{ $product->id }}">

    <input type="hidden"
           name="quantity"
           id="buyQty"
           value="1">

    <button type="submit"
            class="btn-buy">

        Buy Now

    </button>

</form>

</div>

@endif
               

                {{-- EXTRA --}}
                <div class="product-extra">

                    <div class="extra-item">

                        <i class="fas fa-box"></i>

                        <div>

                            <h4>Serves</h4>

                            <p>8–10 people</p>

                        </div>

                    </div>

                    <div class="extra-item">

                        <i class="far fa-clock"></i>

                        <div>

                            <h4>Shelf Life</h4>

                            <p>3–5 days chilled</p>

                        </div>

                    </div>

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
                                <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=500&q=80" alt="{{ $rel->name }}">
                            </a>
                            <div class="product-card-body">
                                <div class="product-card-category">{{ $rel->category->name }}</div>
                                <a href="{{ route('catalog.show', $rel->slug) }}"><h3 class="product-card-name">{{ $rel->name }}</h3></a>
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

function changeQty(d) {

    const i = document.getElementById('qtyInput');

    const v = parseInt(i.value) + d;

    const max = parseInt(i.max);

    if (v >= 1 && v <= max) i.value = v;

}

</script>

@endpush

@endsection