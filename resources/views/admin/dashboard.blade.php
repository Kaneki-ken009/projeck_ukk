@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-4">
        <h2 class="mb-2">Beranda Admin</h2>
        <p class="text-muted mb-0">
            Kelola akun, pantau aspirasi berdasarkan status, berikan feedback, dan siapkan laporan untuk kepala sekolah.
        </p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Total Aspirasi</div>
                    <div class="h4 mb-0">{{ $aspirasiTotal }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Menunggu</div>
                    <div class="h4 mb-0">{{ $aspirasiMenunggu }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Proses</div>
                    <div class="h4 mb-0">{{ $aspirasiProses }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Selesai</div>
                    <div class="h4 mb-0">{{ $aspirasiSelesai }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-2">Ringkasan Tugas Admin</h5>
            <p class="text-muted mb-0">
                Gunakan menu di sidebar untuk melihat aspirasi berdasarkan status, mengelola user,
                dan membuat laporan untuk kepala sekolah.
            </p>
        </div>
    </div>
@endsection
