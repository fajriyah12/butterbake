<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login — Butter Bake</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<div class="login-page">

    <div class="login-card">

        <!-- LOGO -->
        <h1 class="login-logo">
            Butter Bake
        </h1>

        <!-- TITLE -->
        <h2 class="login-title">
            Welcome Back
        </h2>

        <p class="login-subtitle">
            Sign in to your bakery account to manage your orders.
        </p>

        <!-- ERROR -->
        @if($errors->any())

            <div class="login-error">
                {{ $errors->first() }}
            </div>

        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}">

            @csrf

            <!-- EMAIL -->
            <div class="login-group">

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

            <!-- PASSWORD -->
            <div class="login-group">

                <div class="password-top">

                    <label>
                        PASSWORD
                    </label>

                    <a href="#">
                        Forgot Password?
                    </a>

                </div>

                <div class="password-box">

                    <input
                        type="password"
                        name="password"
                        id="passwordField"
                        placeholder="••••••••"
                        required
                    >

                    <button type="button" onclick="togglePassword()">
                        <i id="eyeIcon" class="fas fa-eye"></i>
                    </button>

                </div>

            </div>

            <!-- BUTTON -->
            <button type="submit" class="login-btn">
                Login
            </button>

            <!-- LOGIN ADMIN -->
            <div class="admin-login-link">
                <a href="{{ route('admin.login') }}" class="admin-login-btn">
                    Login as Admin
                </a>

            </div>

        </form>

        <!-- FOOTER -->
        <div class="login-footer">

            <p>
                Don't have an account yet?
            </p>

            <a href="{{ route('signup') }}" class="create-btn">
                Create an Account
            </a>

        </div>

    </div>

</div>

<script>

function togglePassword(){

    const field = document.getElementById('passwordField');
    const icon = document.getElementById('eyeIcon');

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