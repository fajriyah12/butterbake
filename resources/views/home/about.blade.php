@extends('layouts.app')

@section('title', 'Our Story')

@section('content')

{{-- HERO --}}
<section class="story-hero">

    <img src="{{ asset('images/stroy-hero.png') }}">

    <div class="story-overlay">

        <span>SINCE 1924</span>

        <h1>
            Tradition Baked into Every Crumb.
        </h1>

        <p>
            We believe that the best breads take time,
            patience, and a deep respect for the Earth’s
            most ancient grains.
        </p>

        <a href="/catalog" class="story-btn">
            EXPLORE OUR CATALOG
        </a>

    </div>

</section>

{{-- GRAIN --}}
<section class="grain-section">

    <div class="grain-text">

        <h2>
            The Soul of the Soil:
            Heritage Grains
        </h2>

        <p>
            We source rare, non-GMO heritage grains
            from local regenerative farms. Unlike modern wheat,
            these ancient varieties retain their nutritional
            complexity and deep, nutty flavor profile.
        </p>

        <div class="grain-tags">

            <span>Einkorn</span>

            <span>Spelt</span>

            <span>Emmer</span>

            <span>Rye</span>

        </div>

    </div>

    <div class="grain-images">

        <img src="{{ asset('images/grain1.png') }}">

        <img src="{{ asset('images/grain2.png') }}">

    </div>

</section>

{{-- PROCESS --}}
<section class="fermentation-section">

    <div class="section-center">

        <h2>The Art of Slower Fermentation</h2>

        <p>
            While the world rushed, we slowed down.
            Every loaf at Artisan Crumbs undergoes a meticulous
            36-hour cold fermentation process.
        </p>

    </div>

    <div class="ferment-grid">

        <div class="ferment-card">

            <div class="ferment-icon">☀️</div>

            <h3>01. Temperature Control</h3>

            <p>
                Precision chilling allows natural
                development and flavor.
            </p>

        </div>

        <div class="ferment-card">

            <div class="ferment-icon">🥖</div>

            <h3>02. Aeration & Fold</h3>

            <p>
                Hand folding every few hours
                creates irresistible texture.
            </p>

        </div>

        <div class="ferment-card">

            <div class="ferment-icon">🔥</div>

            <h3>03. Stone Hearth Bake</h3>

            <p>
                Fired in real stone hearth ovens,
                creating crisp crusts.
            </p>

        </div>

    </div>

</section>

{{-- MISSION --}}
<section class="mission-section">

    <img src="{{ asset('images/baker.png') }}">

    <div class="mission-content">

        <h2>
            Our Mission:
            Conscious Craft
        </h2>

        <p>
            We believe a bakery should be a pillar
            of its community. Our mission is to nourish
            both body and spirit while supporting the farmers.
        </p>

        <div class="mission-list">

            <div>☑ Zero Waste Initiative</div>

            <div>☑ Plastic-Free Delivery</div>

        </div>

    </div>

</section>

@endsection