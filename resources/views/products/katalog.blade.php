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
                Slow-fermented breads, hand-laminated pastries, and heirloom cakes baked
                daily in our stone ovens using grains from local family farms.
            </p>
                  
<div class="section" style="padding-top:48px;">
    <div class="container">
        <div class="catalog-layout">

            {{-- SIDEBAR --}}
            <aside class="filter-sidebar">
                <div class="filter-title">Categori</div>
                <form method="GET" action="{{ route('catalog.index') }}">
                    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                    <div class="filter-option {{ !request('category') ? 'active' : '' }}">
                        <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                        Semua Produk
                    </div>
                    @foreach($categories as $cat)
                        <div class="filter-option {{ request('category') === $cat->slug ? 'active' : '' }}">
                            <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} onchange="this.form.submit()">
                            {{ $cat->name }}
                        </div>
                    @endforeach
                </form>

                <div class="filter-title" style="margin-top:24px;">Price Range </div>
                <form method="GET" action="{{ route('catalog.index') }}">
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                    @foreach(['newest' => 'Terbaru', 'price_low' => 'Harga Terendah', 'price_high' => 'Harga Tertinggi', 'rating' => 'Rating Terbaik'] as $val => $label)
                        <div class="filter-option {{ request('sort', 'newest') === $val ? 'active' : '' }}">
                            <input type="radio" name="sort" value="{{ $val }}" {{ request('sort', 'newest') === $val ? 'checked' : '' }} onchange="this.form.submit()">
                            {{ $label }}
                        </div>
                    @endforeach
                </form>
            </aside>

            {{-- PRODUCTS --}}
            <div>
                @if($products->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-bread-slice"></i></div>
                        <h3 class="empty-state-title">Produk Tidak Ditemukan</h3>
                        <p class="empty-state-desc">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary">Lihat Semua</a>
                    </div>
                @else

                @if(session('success'))
                <div id="popup-alert" class="popup-alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                </div>
                @endif
                
                    <div class="products-grid catalog-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                <a href="{{ route('catalog.show', $product->slug) }}" class="product-card-image" style="display:block;">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1586444248902-2f64eddc13df?w=500&q=80" alt="{{ $product->name }}">
                                    @endif
                                    @if($product->is_featured)
                                        <span class="product-card-badge">Best Seller</span>
                                    @endif
                                </a>
                                <div class="product-card-body">
                                    <div class="product-card-category">{{ $product->category->name }}</div>
                                    <a href="{{ route('catalog.show', $product->slug) }}">
                                        <h3 class="product-card-name">{{ $product->name }}</h3>
                                    </a>
                                    <div class="product-card-rating">
                                        <span class="stars" style="font-size:.72rem;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= round($product->rating) ? '' : '-o' }}"></i>
                                            @endfor
                                        </span>
                                        {{ number_format($product->rating, 1) }} ({{ $product->review_count }})
                                    </div>
                                    <div class="product-card-footer">
                                        <span class="product-price">{{ $product->formatted_price }}</span>
                                        <form method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus">ADD TO BASKET</i>
                                            </button>
                                           
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- PAGINATION --}}
                    @if($products->hasPages())
                        <div class="pagination">
                            @if($products->onFirstPage())
                                <span class="page-link" style="opacity:.4;cursor:default;"><i class="fas fa-chevron-left"></i></span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="page-link"><i class="fas fa-chevron-left"></i></a>
                            @endif

                            @foreach($products->links()->elements[0] ?? [] as $page => $url)
                                <a href="{{ $url }}" class="page-link {{ $products->currentPage() == $page ? 'active' : '' }}">{{ $page }}</a>
                            @endforeach

                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="page-link"><i class="fas fa-chevron-right"></i></a>
                            @else
                                <span class="page-link" style="opacity:.4;cursor:default;"><i class="fas fa-chevron-right"></i></span>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
<script>
        setTimeout(() => {
            const popup = document.getElementById('popup-alert');
            if (popup) {
                popup.style.transition = '0.4s';
                popup.style.opacity = '0';
                popup.style.transform = 'translateY(-10px)';

                setTimeout(() => popup.remove(), 400);
            }
        }, 2500);
    </script>
@endsection