<aside class="bg-dark text-white p-3" style="width: 260px; min-height: 100vh;">
    <div class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-1">
            <img src="{{ asset('icon.ico') }}" alt="Logo" width="28" height="28" class="rounded-circle bg-white p-1">
            <div class="fw-semibold">Aspirasi</div>
        </div>
        <small class="text-white-50">Kepsek Panel</small>
    </div>

    <nav class="nav flex-column gap-1">
        <a href="{{ route('kepsek.dashboard') }}" class="nav-link text-white">Dashboard</a>

        <button class="btn btn-dark text-start d-flex align-items-center justify-content-between px-2 py-2"
            data-bs-toggle="collapse" data-bs-target="#menuAspirasiKepsek" aria-expanded="false">
            <span>Aspirasi</span>
            <span class="text-white-50">▾</span>
        </button>
        <div class="collapse show" id="menuAspirasiKepsek">
            <div class="nav flex-column ms-3">
                <a class="nav-link text-white-50" href="{{ route('kepsek.aspirasi.menunggu') }}">Menunggu</a>
                <a class="nav-link text-white-50" href="{{ route('kepsek.aspirasi.proses') }}">Proses</a>
                <a class="nav-link text-white-50" href="{{ route('kepsek.aspirasi.selesai') }}">History</a>
            </div>
        </div>

        <a href="{{ route('kepsek.laporan') }}" class="nav-link text-white">Laporan</a>
    </nav>

    <div class="mt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-light w-100" type="submit">Logout</button>
        </form>
    </div>
</aside>
