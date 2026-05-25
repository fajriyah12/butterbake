@extends('layouts.app')

@section('title', 'Locations')

@section('content')

<section class="locations-page">

    <div class="locations-header">
        <span>VISIT OUR BAKERY</span>

        <h1>Where to Find Us</h1>

        <p>
            Discover Butter Bake flagship store, where artisan pastries
            and warm coffee create cozy mornings on Jl. Kopi Arabica,
            bringing sweetness and comfort to every visit.
        </p>
    </div>

    <div class="locations-layout">

        {{-- LEFT --}}
        <div class="location-list">

            <div class="location-card active">

                <div class="location-top">
                    <div>
                        <h3>Butter Bake</h3>
                        <span>Flagship Bakery</span>
                    </div>

                    <div class="open-badge">
                        OPEN NOW
                    </div>
                </div>

                <div class="location-info">
                    <p>
                        📍 Jl. Kopi Arabica No.121, Kedaton <br>
                        Bandar Lampung, Lampung 35141
                    </p>

                    <p>
                        🕒 Mon — Fri 6:00 — 19:00 <br>
                        Sat — Sun 7:00 — 17:00
                    </p>

                    <p>📞 (0721) 123–4567</p>
                </div>

                <a href="#" class="location-btn">
                    Get Directions 
                </a>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="map-box">
            <img src="{{ asset('images/mapbutterbake1.png') }}" alt="Butter Bake Map">
        </div>

    </div>

    </div>

</section>

@endsection