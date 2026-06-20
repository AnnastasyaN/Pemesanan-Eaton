<nav class="navbar navbar-expand-md navbar-dark navbar-custom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand brand-font" href="{{ url('/') }}">
            Admin | EatOn
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Kiri Kosong -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- Kanan -->
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <!-- Menu Admin -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('menus.index') }}">Kelola Menu</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>
