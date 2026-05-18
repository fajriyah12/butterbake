<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Signup — Butter Bake</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<div class="signup-page">

    <div class="signup-card">

        <!-- LOGO -->
        <h1 class="signup-logo">
            Butter Bake
        </h1>

        <!-- TITLE -->
        <h2 class="signup-title">
            Create Account
        </h2>

        <p class="signup-subtitle">
            Begin your journey with Butter Bake today.
        </p>

        <!-- ERROR -->
        @if($errors->any())

            <div class="signup-error">

                {{ $errors->first() }}

            </div>

        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('signup') }}">

            @csrf

            <!-- FULL NAME -->
            <div class="signup-group">

                <label>
                    FULL NAME
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Masukkan Nama Anda "
                    value="{{ old('name') }}"
                    required
                >

            </div>

            <!-- EMAIL -->
            <div class="signup-group">

                <label>
                    EMAIL ADDRESS
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan Email Anda"
                    value="{{ old('email') }}"
                    required
                >

            </div>

            {{-- PHONE NUMBER --}}
            <div class="form-group">

                <label class="form-label">
                PHONE NUMBER
                </label>

                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="Masukkan Nomor Telepon"
                       value="{{ old('phone') }}"
                       required>
             </div>

            <!-- PASSWORD -->
            <div class="signup-group">

                <label>
                    PASSWORD
                </label>

                <div class="password-box">

                    <input
                        type="password"
                        name="password"
                        id="passwordField"
                        placeholder="••••••••"
                        required
                    >

                    <button type="button"
                        onclick="togglePassword('passwordField','eyeIcon1')">

                        <i id="eyeIcon1" class="fas fa-eye"></i>

                    </button>

                </div>

            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="signup-group">

                <label>
                    CONFIRM PASSWORD
                </label>

                <div class="password-box">

                    <input
                        type="password"
                        name="password_confirmation"
                        id="passwordField2"
                        placeholder="••••••••"
                        required
                    >

                    <button type="button"
                        onclick="togglePassword('passwordField2','eyeIcon2')">

                        <i id="eyeIcon2" class="fas fa-eye"></i>

                    </button>

                </div>

            </div>

            <!-- BUTTON -->
            <button type="submit" class="signup-btn">

                Create Account

            </button>

        </form>

        <!-- FOOTER -->
        <div class="signup-footer">

            <p>
                Already have an account?
            </p>

            <a href="{{ route('login') }}" class="login-link">

                Login Here

            </a>

        </div>
    
    </div>

</div>

<script>

function togglePassword(fieldId, iconId){

    const field = document.getElementById(fieldId);

    const icon = document.getElementById(iconId);

    if(field.type === 'password'){

        field.type = 'text';

        icon.classList.replace('fa-eye','fa-eye-slash');

    }else{

        field.type = 'password';

        icon.classList.replace('fa-eye-slash','fa-eye');

    }

}

</script>

</body>
</html>