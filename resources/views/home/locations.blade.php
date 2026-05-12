@extends('layouts.app')

@section('title', 'Locations')

@section('content')

<section class="locations-page">

    {{-- HEADER --}}
    <div class="locations-header">

        <span>VISIT OUR BAKERIES</span>

        <h1>Our Neighborhood Nook.</h1>

        <p>
            From the historic downtown cobblestones
            to the breezy suburban avenues, find
            the Artisan Crumbs closest to your morning ritual.
        </p>

    </div>

    {{-- MAIN --}}
    <div class="locations-layout">

        {{-- LEFT --}}
        <div class="location-list">

            {{-- CARD --}}
            <div class="location-card active">

                <div class="location-top">

                    <div>
                        <h3>Heritage Square</h3>
                        <span>Flagship Bakery</span>
                    </div>

                    <div class="open-badge">
                        OPEN NOW
                    </div>

                </div>

                <div class="location-info">

                    <p>📍 124 Heritage Lane, Old Town District<br>
                    San Francisco, CA 94102</p>

                    <p>🕒 Mon — Fri &nbsp;&nbsp; 6:00 — 19:00<br>
                    Sat — Sun &nbsp; 7:00 — 17:00</p>

                    <p>📞 (555) 123–4567</p>

                </div>

                <a href="#" class="location-btn">
                    Get Directions →
                </a>

            </div>

            {{-- CARD --}}
            <div class="location-card">

                <div class="location-top">

                    <div>
                        <h3>Oak & Vine</h3>
                        <span>Artisanal Workshop</span>
                    </div>

                </div>

                <div class="location-info">

                    <p>📍 892 Oak Avenue, The Highlands<br>
                    San Francisco, CA 94117</p>

                    <p>🕒 Mon — Sat &nbsp; 7:00 — 16:00<br>
                    Sunday &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Closed</p>

                    <p>📞 (555) 987–6543</p>

                </div>

                <a href="#" class="location-btn outline">
                    Get Directions →
                </a>

            </div>

            {{-- CARD --}}
            <div class="location-card">

                <div class="location-top">

                    <div>
                        <h3>Pier 14 Kiosk</h3>
                        <span>Waterfront Express</span>
                    </div>

                </div>

                <div class="location-info">

                    <p>📍 Embarcadero Waterfront, Kiosk #4<br>
                    San Francisco, CA 94105</p>

                    <p>🕒 Daily &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8:00 — 18:00</p>

                    <p>📞 (555) 246–8102</p>

                </div>

                <a href="#" class="location-btn outline">
                    Get Directions →
                </a>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="map-box">

            <img src="{{ asset('images/map-phone.png') }}" alt="Map">

        </div>

    </div>

    {{-- BOTTOM --}}
    <div class="location-bottom">

        <div class="bottom-card">

            <div class="bottom-icon">✉</div>

            <h3>Planning an Event?</h3>

            <p>
                We provide artisanal catering for gatherings
                of any size. Reach out to our events team.
            </p>

            <a href="#">
                Inquire About Catering
            </a>

        </div>

        <div class="bottom-card">

            <div class="bottom-icon">🧺</div>

            <h3>Freshness Guarantee</h3>

            <p>
                Every location receives fresh daily deliveries
                of heritage-grain loaves and pastries.
            </p>

            <a href="#">
                Our Baking Philosophy
            </a>

        </div>

    </div>

</section>

@endsection