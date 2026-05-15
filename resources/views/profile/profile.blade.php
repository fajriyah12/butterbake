@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="profile-page">

    <div class="profile-wrapper">

        {{-- SIDEBAR --}}
        <aside class="profile-sidebar">

            <a href="#" class="profile-menu active">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>

            <a href="{{ route('order.confirmation') }}"  class="profile-menu">
                <i class="fas fa-box"></i>
                <span>Orders</span>
            </a>

            <a href="#" class="profile-menu">
                <i class="fas fa-shield-alt"></i>
                <span>Security</span>
            </a>

            <div class="sidebar-line"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="profile-menu logout-btn">

                    <i class="fas fa-sign-out-alt"></i>

                    <span>Logout</span>

                </button>

            </form>

        </aside>

        {{-- CONTENT --}}
        <div class="profile-content">

            {{-- PERSONAL INFO --}}
            <div class="profile-section-title">

                <h2>Personal Information</h2>

                <a href="{{ route('profile.edit') }}">
                <i class="fas fa-pen"></i>
                Edit Details
                </a>

            </div>

            <div class="profile-card">

                <div class="info-item">

                    <span>FULL NAME</span>

                    <h4>{{ $user->name }}</h4>

                </div>

                <div class="info-item">

                    <span>EMAIL ADDRESS</span>

                    <h4>{{ $user->email }}</h4>

                </div>

                <div class="info-item">

                    <span>PHONE NUMBER</span>

                    <h4>{{ $user->phone  }}</h4>

                </div>

                <div class="info-item">

                    <span>MEMBER SINCE</span>

                    <h4>{{ $user->created_at->format('F Y') }}</h4>

                </div>

            </div>

            {{-- LOCATION --}}
            <div class="profile-section-title second-title">

                <h2>Saved Pickup Locations</h2>

            </div>

            <div class="location-wrapper">

                <div class="location-card">

                    <span class="primary-badge">
                        PRIMARY
                    </span>

                    <h3>Heritage District Bakery</h3>

                    <p>
                        124 Baker’s Lane, Old Town District.
                        Just around the corner from the clock tower.
                    </p>

                    <div class="location-actions">

                        <a href="#" class="direction-btn">
                            Directions
                        </a>

                        <a href="#" class="change-btn">
                            Change
                        </a>

                    </div>

                </div>

                <div class="add-location">

                    <i class="fas fa-map-marker-alt"></i>

                    <h4>Add New Location</h4>

                    <p>
                        Save a new bakery for faster checkout
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection