<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butter Bake</title>

    {{-- DETEKSI ADMIN --}}
    @php
        $isAdmin = request()->is('admin/*');
    @endphp

    {{-- GOOGLE FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- CSS --}}
    @if($isAdmin)
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @endif

    @yield('css')
</head>

<body>

<div class="main-wrapper">

    {{-- NAVBAR USER / SIDEBAR ADMIN --}}
    @if(!$isAdmin)

        @include('components.navbar')

    @else
        @include('components.adminsidebar')
    @endif

    {{-- CONTENT --}}
    <main class="{{ $isAdmin ? 'main' : '' }}">
        @yield('content')
    </main>

    {{-- FOOTER USER --}}
    @if(!$isAdmin)
        @include('components.footer')
    @endif

</div>

</body>
</html>