@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <style>
        .admin-hero {
            background: linear-gradient(135deg, #0d6efd 0%, #198754 100%);
            color: #fff;
            border-radius: 16px;
        }
        .admin-stat-card {
            border: 0;
            border-radius: 14px;
            overflow: hidden;
        }
        .admin-stat-top {
            height: 6px;
        }
        .admin-soft {
            border-radius: 14px;
            border: 1px solid #e9ecef;
            background: #fff;
        }
    </style>

    <div class="admin-hero p-4 p-md-5 mb-4 shadow-sm">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="mb-2 fw-bold">Beranda Admin</h2>
                <p class="mb-0">
                    Kelola akun, pantau status aspirasi, berikan feedback, dan kirim laporan ke kepala sekolah.
                </p>
            </div>
            <div class="text-md-end">
                <div class="small opacity-75">Aspirasi Aktif</div>
                <div class="display-6 fw-bold mb-0">{{ $aspirasiMenunggu + $aspirasiProses }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card admin-stat-card shadow-sm">
                <div class="admin-stat-top bg-primary"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted">Total Aspirasi</div>
                            <div class="h4 mb-0">{{ $aspirasiTotal }}</div>
                        </div>
                        <i class="bi bi-collection fs-4 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card admin-stat-card shadow-sm">
                <div class="admin-stat-top bg-danger"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted">Menunggu</div>
                            <div class="h4 mb-0">{{ $aspirasiMenunggu }}</div>
                        </div>
                        <i class="bi bi-hourglass-split fs-4 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card admin-stat-card shadow-sm">
                <div class="admin-stat-top bg-warning"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted">Proses</div>
                            <div class="h4 mb-0">{{ $aspirasiProses }}</div>
                        </div>
                        <i class="bi bi-tools fs-4 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card admin-stat-card shadow-sm">
                <div class="admin-stat-top bg-success"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted">Selesai</div>
                            <div class="h4 mb-0">{{ $aspirasiSelesai }}</div>
                        </div>
                        <i class="bi bi-check-circle fs-4 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-soft p-4 h-100 shadow-sm">
                <h5 class="mb-3">Ringkasan Tugas Admin</h5>
                <p class="text-muted mb-3">
                    Gunakan menu di sidebar untuk melihat aspirasi per status, mengelola user, dan membuat laporan.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge text-bg-primary">Monitoring Aspirasi</span>
                    <span class="badge text-bg-warning">Tindak Lanjut</span>
                    <span class="badge text-bg-success">Pelaporan Bulanan</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-soft p-4 h-100 shadow-sm">
                <h6 class="mb-3">Komposisi Status</h6>
                @php
                    $total = max(1, (int) $aspirasiTotal);
                    $pMenunggu = round(($aspirasiMenunggu / $total) * 100);
                    $pProses = round(($aspirasiProses / $total) * 100);
                    $pSelesai = round(($aspirasiSelesai / $total) * 100);
                @endphp
                <div class="mb-2 small text-muted">Menunggu ({{ $pMenunggu }}%)</div>
                <div class="progress mb-3" role="progressbar" aria-label="Menunggu" aria-valuenow="{{ $pMenunggu }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-danger" style="width: {{ $pMenunggu }}%"></div>
                </div>
                <div class="mb-2 small text-muted">Proses ({{ $pProses }}%)</div>
                <div class="progress mb-3" role="progressbar" aria-label="Proses" aria-valuenow="{{ $pProses }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-warning" style="width: {{ $pProses }}%"></div>
                </div>
                <div class="mb-2 small text-muted">Selesai ({{ $pSelesai }}%)</div>
                <div class="progress" role="progressbar" aria-label="Selesai" aria-valuenow="{{ $pSelesai }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-success" style="width: {{ $pSelesai }}%"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
