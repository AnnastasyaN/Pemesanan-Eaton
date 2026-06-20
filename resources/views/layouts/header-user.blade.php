<nav class="navbar navbar-expand-md navbar-dark navbar-custom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand brand-font" href="{{ url('/') }}">
            EatOn
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Kiri Kosong -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- Kanan -->
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <!-- Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('menu.index') }}">Menu</a>
                </li>

                <!-- Keranjang -->
                @php
                    $cart = session('cart', []);
                    $cartCount = collect($cart)->sum('quantity');
                @endphp
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                        @if ($cartCount > 0)
                            <span
                                class="badge cart-badge rounded-circle position-absolute top-0 start-100 translate-middle">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>

                <!-- Autentikasi -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
