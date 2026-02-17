<nav class="navbar navbar-expand-lg navbar-dark bg-primary border-bottom">
    <div class="container">
        <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('siswa') }}">
            <img src="{{ asset('icon.ico') }}" alt="Logo" width="28" height="28" class="rounded-circle bg-white p-1">
            <span>Aspirasi</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa') }}" onclick="event.preventDefault(); showLanding();">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa') }}" onclick="event.preventDefault(); showAspirasi();">Aspirasi</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="{{ route('siswa') }}" onclick="event.preventDefault(); showHistory();">
                            <span>History</span>
                            @if(auth()->user()->role === 'siswa' && (($unreadFeedbackCount ?? 0) > 0))
                                <span class="badge text-bg-danger rounded-pill">{{ $unreadFeedbackCount }}</span>
                            @endif
                        </a>
                    </li>
                @endauth
            </ul>

            <div class="d-flex ms-lg-3">
                @guest
                    <a class="btn btn-outline-light" href="{{ route('login.form') }}">Login</a>
                @endguest

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light" type="submit">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
