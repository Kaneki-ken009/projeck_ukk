@extends('layouts.kepsek')

@section('title', 'Dashboard Kepsek')

@section('content')
    <div class="mb-4">
        <h2 class="mb-2">Beranda Kepsek</h2>
        <p class="text-muted mb-0">
            Pantau rekap aspirasi sekolah. Gunakan menu untuk melihat detail per status atau laporan.
        </p>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Total Aspirasi</div>
                    <div class="h4 mb-0">{{ $aspirasiTotal }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Menunggu</div>
                    <div class="h4 mb-0">{{ $aspirasiMenunggu }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Proses</div>
                    <div class="h4 mb-0">{{ $aspirasiProses }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Selesai</div>
                    <div class="h4 mb-0">{{ $aspirasiSelesai }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
