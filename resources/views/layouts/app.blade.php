<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EatOn') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Vite (Laravel) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('scripts')

    <style>
        /* Warna Kustom */
        .warna-emas {
            color: #ee9632;
        }

        .bg-emas {
            background-color: #ee9632;
            color: #000;
        }

        /* Navbar */
        .navbar-custom {
            background-color: #000;
        }

        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: #ee9632;
        }

        .navbar-custom .nav-link:hover {
            color: #fff;
        }

        /* Tombol Reservasi */
        .btn-reservation {
            background-color: #ee9632;
            color: #000;
            border: none;
            border-radius: 20px;
            padding: 5px 15px;
        }

        .btn-reservation:hover {
            background-color: #ee9632;
            color: #000;
        }

        /* Badge Keranjang */
        .cart-badge {
            background-color: #ee9632;
            color: #000;
        }

        /* Dropdown Profil */
        .dropdown-menu {
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .dropdown-item:hover {
            background-color: #e9ecef;
            color: #000;
        }

        .brand-font {
            font-family: 'Abril Fatface', cursive;
            font-weight: 400;
            font-size: 2rem;
            letter-spacing: 1px;
            color: #ee9632;
        }
    </style>
</head>

<body>
    <div id="app">
        {{-- Header Dinamis Berdasarkan Role --}}
@if(Auth::check() && Auth::user()->role === 'admin')
    @include('layouts.header-admin')
@else
    @include('layouts.header-user')
@endif

        <main class="p-0 m-0">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
