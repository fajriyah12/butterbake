@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="edit-profile-page">

    <div class="container">

        {{-- BACK --}}
        <div class="back-profile-wrapper">
            <a href="{{ route('profile.index') }}" class="back-profile">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Profile</span>
            </a>
        </div>

        {{-- CARD --}}
        <div class="edit-profile-card">

            {{-- TITLE --}}
            <div class="edit-profile-header">

                <h1>Edit Your Profile</h1>

                <p>
                    Keep your personal details up to date for a better experience.
                </p>

            </div>

            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('profile.update') }}"
                  class="edit-profile-form">

                @csrf
                @method('PUT')

                {{-- FULL NAME --}}
                <div class="form-group">

                    <label>Full Name</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $user->name) }}">

                </div>

                {{-- EMAIL --}}
                <div class="form-group">

                    <label>Email Address</label>

                    <input type="email"
                           class="form-control"
                           value="{{ $user->email }}"
                           disabled>

                </div>

                {{-- PHONE --}}
                <div class="form-group">

                    <label>Phone Number</label>

                    <input type="text"
                           name="phone"
                           class="form-control"
                           value="{{ old('phone', $user->phone ?? '') }}">

                </div>

                {{-- PASSWORD --}}
                <div class="form-group">

                    <label>New Password</label>

                    <div class="password-wrapper">

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               placeholder="Enter new password">

                        <span class="toggle-password"
                              onclick="togglePassword('password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>

                    </div>

                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="form-group">

                    <label>Confirm Password</label>

                    <div class="password-wrapper">

                        <input type="password"
                               name="password_confirmation"
                               id="confirmPassword"
                               class="form-control"
                               placeholder="Confirm new password">

                        <span class="toggle-password"
                              onclick="togglePassword('confirmPassword', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="edit-btn-group">

                    <button type="submit" class="save-btn">
                        SAVE CHANGES
                    </button>

                    <a href="{{ route('profile.index') }}" class="cancel-btn">
                        CANCEL
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- SCRIPT --}}
<script>
    function togglePassword(inputId, element) {

        const input = document.getElementById(inputId);
        const icon = element.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

@endsection