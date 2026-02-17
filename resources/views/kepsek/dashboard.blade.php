@extends('layouts.kepsek')

@section('title', 'Dashboard Kepsek')

@section('content')
    <style>
        .kepsek-hero {
            background: linear-gradient(135deg, #198754 0%, #0dcaf0 100%);
            color: #fff;
            border-radius: 16px;
        }
        .kepsek-stat-card {
            border: 0;
            border-radius: 14px;
            overflow: hidden;
        }
        .kepsek-stat-top {
            height: 6px;
        }
        .kepsek-soft {
            border-radius: 14px;
            border: 1px solid #e9ecef;
            background: #fff;
        }
    </style>

    <div class="kepsek-hero p-4 p-md-5 mb-4 shadow-sm">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="mb-2 fw-bold">Beranda Kepsek</h2>
                <p class="mb-0">
                    Pantau rekap aspirasi sekolah dan progres tindak lanjut dari admin secara cepat.
                </p>
            </div>
            <div class="text-md-end">
                <div class="small opacity-75">Total Aspirasi</div>
                <div class="display-6 fw-bold mb-0">{{ $aspirasiTotal }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card kepsek-stat-card shadow-sm">
                <div class="kepsek-stat-top bg-primary"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted">Total Aspirasi</div>
                            <div class="h4 mb-0">{{ $aspirasiTotal }}</div>
                        </div>
                        <i class="bi bi-clipboard-data fs-4 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kepsek-stat-card shadow-sm">
                <div class="kepsek-stat-top bg-danger"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted">Menunggu</div>
                            <div class="h4 mb-0">{{ $aspirasiMenunggu }}</div>
                        </div>
                        <i class="bi bi-hourglass-bottom fs-4 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kepsek-stat-card shadow-sm">
                <div class="kepsek-stat-top bg-warning"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted">Proses</div>
                            <div class="h4 mb-0">{{ $aspirasiProses }}</div>
                        </div>
                        <i class="bi bi-gear fs-4 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card kepsek-stat-card shadow-sm">
                <div class="kepsek-stat-top bg-success"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted">Selesai</div>
                            <div class="h4 mb-0">{{ $aspirasiSelesai }}</div>
                        </div>
                        <i class="bi bi-patch-check fs-4 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="kepsek-soft p-4 h-100 shadow-sm">
                <h5 class="mb-2">Ringkasan Monitoring</h5>
                <p class="text-muted mb-0">
                    Gunakan menu aspirasi untuk memantau status per kategori, lalu cek menu laporan untuk evaluasi bulanan.
                </p>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="kepsek-soft p-4 h-100 shadow-sm">
                <h6 class="mb-3">Fokus Tindak Lanjut</h6>
                <div class="d-flex justify-content-between small mb-2">
                    <span class="text-muted">Menunggu</span>
                    <span class="fw-semibold">{{ $aspirasiMenunggu }}</span>
                </div>
                <div class="d-flex justify-content-between small mb-2">
                    <span class="text-muted">Dalam Proses</span>
                    <span class="fw-semibold">{{ $aspirasiProses }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Selesai</span>
                    <span class="fw-semibold text-success">{{ $aspirasiSelesai }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
