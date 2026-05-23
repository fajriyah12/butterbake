@extends('layouts.app')
@section('title', 'Katalog Produk')

@section('content')

<div class="page-header">
    <div class="container">
        <div class="page-header-inner">

            <h1 class="page-header-title">
                Our Heritage Collection
            </h1>

            <p class="page-header-subtitle">
                Slow-fermented breads, hand-laminated pastries,
                and heirloom cakes baked daily in our stone ovens
                using grains from local family farms.
            </p>

        </div>
    </div>
</div>

<div class="section" style="padding-top:48px;">

    <div class="container">

        <div class="catalog-layout">

            {{-- =========================
                SIDEBAR
            ========================== --}}
            <aside class="filter-sidebar">

    <form method="GET" action="{{ route('catalog.index') }}">

        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <div class="filter-title">Category</div>

        <div class="filter-option {{ !request('category') ? 'active' : '' }}">
            <input type="radio" name="category" value=""
                {{ !request('category') ? 'checked' : '' }}
                onchange="this.form.submit()">
            All Product
        </div>

        @foreach($categories as $cat)
        <div class="filter-option {{ request('category') === trim($cat->name) ? 'active' : '' }}">
            <input type="radio"
            name="category"
            value="{{ trim($cat->name) }}"
            {{ request('category') === trim($cat->name) ? 'checked' : '' }}
            onchange="this.form.submit()">

        {{ $cat->name }}

        </div>
        @endforeach

        <div class="filter-title" style="margin-top:24px;">Price Range</div>
        @foreach([
            'newest'     => 'Newest',
            'price_low'  => 'Lowest Price',
            'price_high' => 'Highest Price',
            'rating'     => 'Top Rated'
        ] as $val => $label)
            <div class="filter-option {{ request('sort','newest') === $val ? 'active' : '' }}">
                <input type="radio" name="sort" value="{{ $val }}"
                    {{ request('sort','newest') === $val ? 'checked' : '' }}
                    onchange="this.form.submit()">
                {{ $label }}
            </div>
        @endforeach

    </form>

</aside>

            {{-- =========================
                PRODUCTS
            ========================== --}}
            <div>

                @if($products->isEmpty())

                    <div class="empty-state">

                        <div class="empty-state-icon">
                        </div>

                        <h3 class="empty-state-title">
                            Product Not Found
                        </h3>

                        <p class="empty-state-desc">
                            Try changing your search filters or keywords.
                        </p>

                        <a href="{{ route('catalog.index') }}"
                           class="btn btn-primary">
                            View All
                        </a>

                    </div>

                @else

                    {{-- SUCCESS ALERT --}}
                    @if(session('success'))

                        <div id="popup-alert"
                             class="popup-alert">

                            <i class="fas fa-check-circle"></i>

                            {{ session('success') }}

                        </div>

                    @endif

                    {{-- PRODUCT GRID --}}
                    <div class="products-grid catalog-grid">

                        @foreach($products as $product)

                            <div class="product-card">

                                {{-- IMAGE --}}
                                <a href="{{ route('catalog.show', $product->slug) }}"
                                   class="product-card-image">

                                    @if($product->image)

                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}">

                                    @else

                                        <img src="https://images.unsplash.com/photo-1586444248902-2f64eddc13df?w=500&q=80"
                                             alt="{{ $product->name }}">

                                    @endif

                                    {{-- BADGE --}}
                                    @if($product->stock == 0)

                                        <span class="sold-out-overlay">
                                            SOLD OUT
                                        </span>

                                    @elseif($product->is_featured)

                                        <span class="product-card-badge">
                                            Best Seller
                                        </span>

                                    @endif

                                </a>

                                {{-- BODY --}}
                                <div class="product-card-body">

                                    <div class="product-card-category">
                                        {{ $product->category->name }}
                                    </div>

                                    <h3 class="product-card-name">
                                        {{ $product->name }}
                                    </h3>

                                    <div class="product-card-rating">
                                        {{ number_format($product->rating, 1) }}
                                        ({{ $product->review_count }})
                                    </div>

                                    {{-- PRICE --}}
                                    <div class="product-card-footer">

                                        <span class="product-price">
                                            {{ $product->formatted_price }}
                                        </span>

                                    </div>

                                    {{-- BUTTON --}}
                                    @if($product->stock > 0)

                                        <form method="POST"
                                              action="{{ route('cart.add') }}">

                                            @csrf

                                            <input type="hidden"
                                                   name="product_id"
                                                   value="{{ $product->id }}">

                                            <input type="hidden"
                                                   name="quantity"
                                                   value="1">

                                            <button type="submit"
                                                    class="btn btn-primary btn-sm add-cart-btn">

                                                ADD TO CART

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- PAGINATION --}}
                    {{ $products->links() }}

                @endif

            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alert = document.getElementById("popup-alert");

        if (alert) {
            setTimeout(() => {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";

                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 3000); // 3 detik tampil
        }
    });
</script>

@endsection