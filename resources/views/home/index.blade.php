@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<section class="hero-section">

    <div class="hero-content">

        <span class="year-badge">
            EST. 2012
        </span>

        <h1>
            Handcrafted Daily, <br>

            <span>
                With Heritage Grain.
            </span>

        </h1>

        <p>
            Slow-fermented sourdoughs and buttery laminated pastries
            made with organic local flour. Every bite is a celebration
            of traditional techniques.
        </p>

        <div class="hero-buttons">

            <a href="/login" class="btn-primary">
                ORDER ONLINE
            </a>

            <a href="/catalog" class="btn-secondary">
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

        <h2>
            Explore Our Kitchen
        </h2>

        <div class="line"></div>

    </div>

    <!-- GRID -->
    <div class="explore-grid">

        <!-- CARD 1 -->
        <div class="explore-card cake-card">

            <img src="{{ asset('images/cakes.jpeg') }}">

            <div class="overlay">

                <h3>Cakes</h3>

                <p>
                    Celebration layers and petite gateaux.
                </p>

            </div>

        </div>

        <!-- CARD 2 -->
        <div class="explore-card pastry-card">

            <img src="{{ asset('images/patries.png') }}">

            <div class="overlay">

                <h3>Pastries</h3>

                <p>
                    Buttery, flaky, and golden perfection.
                </p>

            </div>

        </div>

        <!-- CARD 3 -->
        <div class="explore-card wide">

            <img src="{{ asset('images/bread.png') }}">

            <div class="overlay">

                <h3>Daily Breads</h3>

                <p>
                    Ancient grains and sourdough fermented for 48 hours.
                </p>

            </div>

        </div>

    </div>

</section>

<!-- FAVORITES SECTION -->
<section class="favorite-section">

    <div class="favorite-header">

        <div>

            <h2>The Morning Favorites</h2>

            <p>
                What our neighbors are loving this week.
            </p>

        </div>

        <a href="/catalog">
            SEE ALL PRODUCTS
        </a>

    </div>

    <div class="favorite-grid">

        <!-- CARD 1 -->
        <div class="favorite-card">

            <div class="favorite-image">

                <img src="{{ asset('images/croisant.png') }}">

            </div>

            <div class="favorite-content">

                <div class="favorite-top">

                    <h3>
                        Pain au Chocolat
                    </h3>

                    <span>
                        Rp 45.000
                    </span>

                </div>

                <p>
                    Double chocolate batons enveloped in
                    our signature 72-layer buttery pastry.
                </p>

                <a href="/login" class="favorite-btn">

                    🛒 ADD TO CART

                </a>

            </div>

        </div>

        <!-- CARD 2 -->
        <div class="favorite-card">

            <div class="favorite-image">

                <img src="{{ asset('images/sourdough.png') }}">

            </div>

            <div class="favorite-content">

                <div class="favorite-top">

                    <h3>
                        Heritage Sourdough
                    </h3>

                    <span>
                        Rp 80.000
                    </span>

                </div>

                <p>
                    Our 50-year-old starter creates a
                    perfectly tangy crumb and blistered crust.
                </p>

                <a href="/login" class="favorite-btn">

                    🛒 ADD TO CART

                </a>

            </div>

        </div>

        <!-- CARD 3 -->
        <div class="favorite-card">

            <div class="favorite-image">

                <img src="{{ asset('images/pie.png') }}">

                <span class="favorite-badge">
                    POPULAR
                </span>

            </div>

            <div class="favorite-content">

                <div class="favorite-top">

                    <h3>
                        Vanilla Bean Tart
                    </h3>

                    <span>
                        Rp 115.000
                    </span>

                </div>

                <p>
                    Madagascar vanilla cream in a crisp
                    shortbread crust with seasonal berries.
                </p>

                <a href="/login" class="favorite-btn">

                    🛒 ADD TO CART

                </a>

            </div>

        </div>

    </div>

</section>

<!-- PROCESS SECTION -->
<section class="process-section">

    <!-- LEFT IMAGE -->
    <div class="process-image-wrapper">

        <img src="{{ asset('images/store.png') }}" class="process-image">

        <!-- PICKUP CARD -->
        <div class="pickup-card">

            <div class="pickup-top">

                <div class="pickup-icon">
                    🕒
                </div>

                <div>

                    <h4>Pickup Hours</h4>

                    <span>Daily 7am — 2pm</span>

                </div>

            </div>

            <p>
                Fresh batches come out at 7am
                and 10:30am daily.
            </p>

        </div>

    </div>

    <!-- RIGHT CONTENT -->
    <div class="process-content">

        <h2>
            Freshness Made Simple
        </h2>

        <p class="process-description">
            We bake in small batches to ensure quality.
            Reserve your favorites online and skip the morning rush.
        </p>

        <!-- STEP -->
        <div class="step">

            <div class="step-number">
                1
            </div>

            <div class="step-content">

                <h3>Order Online</h3>

                <p>
                    Browse our daily menu and place your order by
                    4 PM the day before for guaranteed availability.
                </p>

            </div>

        </div>

        <!-- STEP -->
        <div class="step">

            <div class="step-number">
                2
            </div>

            <div class="step-content">

                <h3>Select Time</h3>

                <p>
                    Choose your preferred pickup window.
                    We'll have your bag packed and waiting for you.
                </p>

            </div>

        </div>

        <!-- STEP -->
        <div class="step">

            <div class="step-number">
                3
            </div>

            <div class="step-content">

                <h3>Quick Pickup</h3>

                <p>
                    Stop by our main counter at 42 Heritage Lane.
                    Just show your order QR code and you're good to go!
                </p>

            </div>

        </div>

        <!-- BUTTON -->
        <a href="/login" class="process-btn">

            START YOUR ORDER

        </a>

    </div>

</section>

@endsection