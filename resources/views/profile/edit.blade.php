@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="edit-profile-page">

    <div class="container">

        {{-- BACK --}}
        <a href="{{ route('profile') }}" class="back-profile">
            ← BACK TO PROFILE
        </a>

        {{-- CARD --}}
        <div class="edit-profile-card">

            {{-- TITLE --}}
            <div class="edit-profile-header">

                <h1>Edit Your Profile</h1>

                <p>
                    Keep your personal details up to date for a better experience.
                </p>

            </div>

            {{-- PHOTO --}}
            <div class="profile-photo-section">

                <div class="profile-photo-wrapper">

                    <img src="{{ asset('images/profile.jpg') }}" alt="Profile">

                    <button class="photo-edit-btn">
                        <i class="fas fa-camera"></i>
                    </button>

                </div>

                <label class="change-photo-text">
                    Change Photo
                </label>

            </div>

            {{-- FORM --}}
            <form method="POST"
            action="{{ route('profile.update') }}"
            class="edit-profile-form"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

                <div class="edit-grid">

                    {{-- NAME --}}
                    <div class="form-group">

                        <label class="form-label">
                            FULL NAME
                        </label>

                        <input type="text"
                               class="form-control"
                                value="{{ $user->name }}">

                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group">

                        <label class="form-label">
                            EMAIL ADDRESS
                        </label>

                        <input type="email"
                               class="form-control"
                               value="{{ $user->email }}">

                    </div>

                    {{-- PHONE --}}
                    <div class="form-group">

                        <label class="form-label">
                            PHONE NUMBER
                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $user->phone }}">

                    </div>

                    {{-- PASSWORD --}}
                    <div class="form-group">

                        <label class="form-label">
                            PASSWORD
                        </label>

                        <div class="password-wrapper">

                            <input type="password"
                                   class="form-control"
                                   value="password123">

                            <button type="button"
                                    class="password-eye">

                                <i class="fas fa-eye"></i>

                            </button>

                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="edit-profile-actions">

                    <button type="submit"
                            class="save-btn">

                        SAVE CHANGES

                    </button>

                    <a href="{{ route('profile') }}"
                       class="cancel-btn">

                        CANCEL

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection