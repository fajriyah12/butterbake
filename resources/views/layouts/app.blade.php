<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Butter Bake</title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('css')

</head>

<body>

    <div class="main-wrapper">

        <!-- NAVBAR -->
        @include('components.navbar')

        <!-- CONTENT -->
        <main>
            @yield('content')
        </main>

        <!-- FOOTER -->
        @include('components.footer')

    </div>

    @stack('scripts')

</body>

</html>