@extends('layouts.app')

@section('content')
<div class="admin-main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="inventory-header">
            <div>
                <h1>Product Inventory</h1>
                <p class="inventory-subtitle">Showing all your artisanal creations</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="new-product-btn">
                <i class="bi bi-plus-lg"></i> New Product
            </a>
        </div>
    </div>

    <!-- FILTER -->
    <form method="GET" action="{{ route('admin.products.index') }}" class="filter-form">
        <div class="filter-tabs">

            <button type="submit"
                    name="category_id"
                    value=""
                    class="{{ request('category_id') ? '' : 'active' }}">
                All
            </button>

            @foreach($categories as $category)
                <button type="submit"
                        name="category_id"
                        value="{{ $category->id }}"
                        class="{{ request('category_id') == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </button>
            @endforeach

        </div>
    </form>

    <!-- PRODUCT GRID -->
    <div class="product-grid">

        @foreach($products as $product)
        <div class="card">

            <div class="card-image">

                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/400x300" alt="No image">
                @endif

                <div class="badge-category">
                    {{ $product->category->name ?? 'No Category' }}
                </div>

                @if($product->is_featured)
                    <div class="badge-featured">Best Seller</div>
                @endif

                @if($product->stock == 0)
                    <div class="badge-soldout">SOLD OUT</div>
                @endif

            </div>

            <div class="card-body">

                <div class="card-title">
                    <h3>{{ $product->name }}</h3>
                    <div class="price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="desc">
                    {{ \Illuminate\Support\Str::limit($product->description, 70) }}
                </div>

                <div class="divider"></div>

                <div class="stock-row">
                    <div>
                        <div class="stock-label">STOCK LEVEL</div>
                        <div class="stock {{ $product->stock > 0 && $product->stock <= 15 ? 'stock-low' : '' }} {{ $product->stock == 0 ? 'stock-empty' : '' }}">
                            {{ $product->stock }} Units
                            @if($product->stock > 0 && $product->stock <= 15)
                                (Low)
                            @endif
                        </div>
                    </div>

                    <div class="actions">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="icon-action edit-btn" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-action delete-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
        @endforeach

    </div>

    <!-- PAGINATION -->
    <div class="pagination-bar">
        <span class="pagination-info">
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
        </span>
        <div class="pagination-links">
            @if($products->onFirstPage())
                <span class="page-btn disabled"><i class="bi bi-chevron-left"></i></span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="page-btn"><i class="bi bi-chevron-left"></i></a>
            @endif

            @foreach(range(1, $products->lastPage()) as $page)
                <a href="{{ $products->url($page) }}"
                   class="page-btn {{ $products->currentPage() == $page ? 'active' : '' }}">
                    {{ $page }}
                </a>
            @endforeach

            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="page-btn"><i class="bi bi-chevron-right"></i></a>
            @else
                <span class="page-btn disabled"><i class="bi bi-chevron-right"></i></span>
            @endif
        </div>
    </div>

</div>
@endsection