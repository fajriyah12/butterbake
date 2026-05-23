@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

{{-- SUCCESS POPUP --}}
@if(session('success'))
<div id="successPopup" class="popup-overlay">
    <div class="popup-box">

        <div class="popup-icon">✓</div>

        <h2 class="popup-title">Berhasil!</h2>

        <p class="popup-message">
            {{ session('success') }}
        </p>

        <button onclick="closePopup()" class="popup-btn">
            OK
        </button>

    </div>
</div>
@endif

<div class="profile-page">

    <div class="profile-wrapper">

        {{-- SIDEBAR --}}
        <aside class="profile-sidebar">

            <a href="{{ route('profile.index') }}" class="profile-menu ">
                <span>Profile</span>
            </a>

            <a href="{{ route('order.myorders') }}" class="profile-menu">
                <span>Orders</span>
            </a>

            <div class="sidebar-line"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="profile-menu logout-btn">
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

                    <h4>{{ $user->phone }}</h4>

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
                    <h3>Butter Bake</h3>

                    <p>
                        Jl. Kopi Arabica No.121, Kedaton 
                        Bandar Lampung, Lampung 31141.
                    </p>

                    

                </div>


            </div>

        </div>

    </div>

</div>

{{-- POPUP SCRIPT --}}
<script>
function closePopup() {
    const popup = document.getElementById('successPopup');

    if (popup) {
        popup.style.display = 'none';
    }
}

// Auto close popup after 3 seconds
setTimeout(() => {
    closePopup();
}, 3000);
</script>

@endsection