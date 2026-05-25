@extends('layouts.app')

@section('title', 'Our Story')

@section('content')

{{-- HERO --}}
<section class="story-hero">

    <img src="{{ asset('images/dailybreads.jpg') }}">

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

        <img src="{{ asset('images/gandum.jpg') }}">

        <img src="{{ asset('images/tepung.png') }}">

    </div>

</section>

{{-- PROCESS --}}
<section class="fermentation-section">

    <div class="section-center">

        <h2>The Art of Premium Butter Bake</h2>

        <p>
            While others compromise on ingredients, we elevate the craft. 
            Every pastry at Butter Bake undergoes a meticulous lamination and chilling process using 100% pure European 
            cultured butter to unlock peak richness, flaky layers, and an unforgettable melt-in-your-mouth texture.
        </p>

    </div>

    <div class="ferment-grid">

        <div class="ferment-card">

            <div class="ferment-icon">
                <i class="fa-regular fa-sun"></i>
            </div>
            <h3>01. Temperature Control</h3>

            <p>
                Precision chilling ensures our 
                premium butter stays perfectly solid within 
                the dough layers before baking.
            </p>

        </div>

        <div class="ferment-card">

            <div class="ferment-icon">
                <i class="fa-solid fa-wind"></i>
            </div>

            <h3>02. The Art of Lamination</h3>

            <p>
                Hand-folding the dough creates 
                hundreds of paper-thin layers for 
                our signature flaky texture.
            </p>

        </div>

        <div class="ferment-card">

            <div class="ferment-icon">
                <i class="fa-solid fa-box"></i>
            </div>

            <h3>03. Golden Caramelized Bake</h3>

            <p>
                High-temperature baking 
                vaporizes the butter to puff up
                the layers into a rich, golden crust.
            </p>

        </div>

    </div>

</section>

{{-- MISSION --}}
<section class="mission-section">

    <img src="{{ asset('images/ourstory.jpg') }}">

    <div class="mission-content">

        <h2>
            Our Mission:
            Crafting Excellence
        </h2>

        <p>
            We believe that great bread and pastry have the power to brighten your day. Our mission is to serve the ultimate bakery experience by combining traditional baking techniques with the rich flavor of premium butter.
        </p>
<div class="mission-list">

    <div class="mission-item">
        <h4>Freshly Baked Daily</h4>

        <p>
            We guarantee that all our breads and pastries
            are baked fresh from the oven every morning
            to deliver the perfect texture and aroma.
        </p>
    </div>

    <div class="mission-item">
        <h4>Premium Ingredients Only</h4>

        <p>
            We strictly use 100% pure butter and
            high-quality flour, ensuring no artificial
            preservatives are ever added to our products.
        </p>
    </div>

</div>
    </div>

</section>

@endsection