@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">

        {{-- Hero Slider Section --}}
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/bg3.jpg') }}" class="d-block w-100 object-fit-cover" style="height: 450px;"
                        alt="Slide 1">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-4 rounded shadow">
                        <h2 class="fw-bold text-white">Yuk, Pesan di EatOn!</h2>
                        <p class="text-light">Pesan makanan favoritmu dengan mudah, cepat, dan lezat</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/bg2.jpg') }}" class="d-block w-100 object-fit-cover" style="height: 450px;"
                        alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/bg1.jpg') }}" class="d-block w-100 object-fit-cover" style="height: 450px;"
                        alt="Slide 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
            </button>
        </div>

        {{-- Content --}}
        <div class="container py-5" style="max-width: 1140px;">
            <h2 class="text-center fw-bold mb-4">Pesan Menu Favoritmu</h2>

            {{-- Kategori Filter --}}
            <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                <a href="{{ route('menu.index') }}"
                    class="btn btn-outline-secondary rounded-pill px-4 {{ request('kategori') == null ? 'active fw-bold' : '' }}">Semua</a>
                @foreach ($categories as $category)
                    <a href="{{ route('menu.index', ['kategori' => $category]) }}"
                        class="btn btn-outline-secondary rounded-pill px-4 {{ request('kategori') == $category ? 'active fw-bold' : '' }}">
                        {{ ucfirst($category) }}
                    </a>
                @endforeach
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('menu.index') }}" class="d-flex justify-content-center mb-5"
                role="search">
                <div class="input-group w-75 w-md-50 shadow-sm">
                    <input type="search" name="search" class="form-control form-control-lg rounded-start"
                        placeholder="Cari menu " value="{{ request('search') }}">
                    <button type="submit" class="btn btn-dark rounded-end px-4">Cari</button>
                </div>
            </form>

            {{-- Menu Grid --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach ($menus as $menu)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition rounded-4">
                            <div class="overflow-hidden rounded-top">
                                <img src="{{ asset('uploads/' . $menu->foto) }}" class="card-img-top transition"
                                    style="height: 180px; object-fit: cover;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $menu->nama }}</h5>
                                <p class="text-muted text-capitalize small mb-1">{{ $menu->kategori }}</p>
                                <p class="fw-bold text-success mb-3">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                @auth
                                    <form action="{{ route('cart.store') }}" method="POST" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <button type="submit" class="btn btn-dark w-100 rounded-pill py-2">
                                            <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Pesan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- No Data --}}
            @if ($menus->isEmpty())
                <div class="text-center mt-5 text-muted">
                    <p class="mb-3">Tidak ada menu yang ditemukan.</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-outline-primary">Kembali ke Semua Menu</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Optional CSS animation --}}
    <style>
        .transition {
            transition: all 0.3s ease-in-out;
        }

        .transition:hover {
            transform: scale(1.05);
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endsection
