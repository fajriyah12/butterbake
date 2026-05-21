@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-content">
        <span class="year-badge">EST. 1924</span>
        <h1>
            Handcrafted Daily, <br>
            <span>With Heritage Grain.</span>
        </h1>
        <p>
            Slow-fermented sourdoughs and buttery laminated pastries
            made with organic local flour. Every bite is a celebration
            of traditional techniques.
        </p>
        <div class="hero-buttons">
            <a href="{{ auth()->check() ? route('catalog.index') : route('login') }}" class="hero-btn-primary">
                ORDER ONLINE
            </a>
            <a href="{{ route('catalog.index') }}" class="hero-btn-secondary">
                VIEW CATALOG
            </a>
        </div>
    </div>
    <div class="hero-image">
        <img src="{{ asset('images/cake.jpg') }}" alt="Cake">
    </div>
</section>

<!-- EXPLORE SECTION -->
<section class="explore-section">
    <div class="section-title">
        <h2>Explore Our Kitchen</h2>
        <div class="line"></div>
    </div>
    <div class="explore-grid">
        <div class="explore-card cake-card">
            <img src="{{ asset('images/cakes.jpeg') }}">
            <div class="overlay">
                <h3>Cakes</h3>
                <p>Celebration layers and petite gateaux.</p>
            </div>
        </div>
        <div class="explore-card pastry-card">
            <img src="{{ asset('images/patries.png') }}">
            <div class="overlay">
                <h3>Pastries</h3>
                <p>Buttery, flaky, and golden perfection.</p>
            </div>
        </div>
        <div class="explore-card wide">
            <img src="{{ asset('images/bread.png') }}">
            <div class="overlay">
                <h3>Daily Breads</h3>
                <p>Ancient grains and sourdough fermented for 48 hours.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAVORITES SECTION -->
<section class="favorite-section">
    <div class="favorite-header">
        <div>
            <h2>The Morning Favorites</h2>
            <p>What our neighbors are loving this week.</p>
        </div>
        <a href="{{ route('catalog.index') }}">SEE ALL PRODUCTS</a>
    </div>

    <div class="favorite-grid">
        @foreach($morningFavorites as $product)
        <div class="favorite-card">
            <div class="favorite-image">
                {{-- Gambar dari storage jika ada, fallback ke gambar lokal sesuai kategori --}}
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    @php
                        $fallback = match(true) {
                            str_contains($product->slug, 'croissant') => asset('images/croisant.png'),
                            str_contains($product->slug, 'sourdough') => asset('images/sourdough.png'),
                            str_contains($product->slug, 'tart')
                            || str_contains($product->slug, 'chocolate') => asset('images/pie.png'),
                            str_contains($product->slug, 'cake')      => asset('images/cakes.jpeg'),
                            str_contains($product->slug, 'bread')
                            || str_contains($product->slug, 'focaccia') => asset('images/bread.png'),
                            default => asset('images/cakes.jpeg'),
                        };
                    @endphp
                    <img src="{{ $fallback }}" alt="{{ $product->name }}">
                @endif

                @if($product->is_featured)
                    <span class="favorite-badge">POPULAR</span>
                @endif
            </div>

            <div class="favorite-content">
                <div class="favorite-top">
                    <h3>{{ $product->name }}</h3>
                    <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>

                <p>{{ Str::limit($product->description, 85) }}</p>

                @auth
                    {{-- Sudah login: langsung tambah ke keranjang --}}
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="favorite-btn">
                            🛒 ADD TO CART
                        </button>
                    </form>
                @else
                    {{-- Belum login: arahkan ke login --}}
                    <a href="{{ route('login') }}" class="favorite-btn">
                        🛒 ADD TO CART
                    </a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- PROCESS SECTION -->
<section class="process-section">
    <div class="process-image-wrapper">
        <img src="{{ asset('images/store.png') }}" class="process-image">
        <div class="pickup-card">
            <div class="pickup-top">
                <div class="pickup-icon">🕒</div>
                <div>
                    <h4>Pickup Hours</h4>
                    <span>Daily 7am — 2pm</span>
                </div>
            </div>
            <p>Fresh batches come out at 7am and 10:30am daily.</p>
        </div>
    </div>

    <div class="process-content">
        <h2>Freshness Made Simple</h2>
        <p class="process-description">
            We bake in small batches to ensure quality.
            Reserve your favorites online and skip the morning rush.
        </p>
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-content">
                <h3>Order Online</h3>
                <p>Browse our daily menu and place your order by 4 PM the day before for guaranteed availability.</p>
            </div>
        </div>
        <div class="step">
            <div class="step-number">2</div>
            <div class="step-content">
                <h3>Select Time</h3>
                <p>Choose your preferred pickup window. We'll have your bag packed and waiting for you.</p>
            </div>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <div class="step-content">
                <h3>Quick Pickup</h3>
                <p>Stop by our main counter at 42 Heritage Lane. Just show your order QR code and you're good to go!</p>
            </div>
        </div>
        <a href="{{ auth()->check() ? route('catalog.index') : route('login') }}" class="process-btn">
            START YOUR ORDER
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Toast notifikasi sukses add to cart
@if(session('success'))
    (function(){
        const toast = document.createElement('div');
        toast.style.cssText = [
            'position:fixed',
            'bottom:24px',
            'right:24px',
            'background:#9b5a28',
            'color:white',
            'padding:14px 20px',
            'border-radius:12px',
            'font-size:13px',
            'font-weight:600',
            'z-index:9999',
            'box-shadow:0 8px 24px rgba(0,0,0,.15)',
            'display:flex',
            'align-items:center',
            'gap:10px',
            'max-width:320px',
            'line-height:1.4',
        ].join(';');
        toast.innerHTML = '<span style="font-size:16px;">✓</span> {{ session("success") }}';
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.transition = 'opacity .4s';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    })();
@endif
</script>
@endpush