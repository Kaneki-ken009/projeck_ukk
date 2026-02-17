@extends('layouts.kepsek')

@section('title', 'Laporan')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Laporan Aspirasi</h2>
        <p class="text-muted mb-0">Ringkasan aspirasi sekolah dan riwayat laporan dari admin.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h6 class="mb-1">Download Mandiri Kepsek</h6>
                <p class="text-muted mb-0">Kepsek bisa unduh laporan aspirasi langsung tanpa menunggu kiriman admin.</p>
            </div>
            <a href="{{ route('kepsek.laporan.pdf') }}" class="btn btn-outline-primary">
                Download PDF
            </a>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h6 class="mb-3">Semua Aspirasi (Terbaru)</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aspirasi as $i => $a)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ optional($a->tgl_inputaspirasi)->format('d-m-Y H:i') ?? '-' }}</td>
                                <td>{{ $a->nisn }}</td>
                                <td>{{ $a->pengirim->nama ?? '-' }}</td>
                                <td>{{ $a->kategori->nama ?? '-' }}</td>
                                <td>{{ $a->lokasi }}</td>
                                <td class="text-capitalize">{{ $a->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#detailAspirasiKepsekLaporan{{ $a->id_inputaspirasi }}">
                                        Detail
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="detailAspirasiKepsekLaporan{{ $a->id_inputaspirasi }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Aspirasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-7">
                                                    <div class="mb-2"><strong>NISN:</strong> {{ $a->nisn }}</div>
                                                    <div class="mb-2"><strong>Nama:</strong> {{ $a->pengirim->nama ?? '-' }}</div>
                                                    <div class="mb-2"><strong>Kategori:</strong> {{ $a->kategori->nama ?? '-' }}</div>
                                                    <div class="mb-2"><strong>Lokasi:</strong> {{ $a->lokasi }}</div>
                                                    <div class="mb-2"><strong>Tanggal:</strong> {{ optional($a->tgl_inputaspirasi)->format('d-m-Y H:i') ?? '-' }}</div>
                                                    <div class="mb-2"><strong>Status:</strong> <span class="text-capitalize">{{ $a->status }}</span></div>
                                                    <div class="mb-3"><strong>Keterangan:</strong><br>{{ $a->ket }}</div>
                                                    <div class="mb-0">
                                                        <strong>Feedback Terakhir:</strong><br>
                                                        {{ optional($a->feedback->first())->isi_feedback ?? '-' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    @if($a->foto)
                                                        <img src="{{ asset('storage/'.$a->foto) }}" alt="Foto aspirasi"
                                                            class="img-fluid rounded border"
                                                            style="width:100%;height:260px;object-fit:cover;">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center text-primary fw-semibold rounded border"
                                                            style="width:100%;height:260px;background:linear-gradient(135deg,#dbeafe 0%,#bfdbfe 100%);">
                                                            Tidak ada foto
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted">Belum ada data aspirasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h6 class="mb-3">Riwayat Pengiriman Laporan</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Periode</th>
                            <th>Admin</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $i => $log)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $log->created_at }}</td>
                                <td>
                                    @if($log->period_start && $log->period_end)
                                        {{ $log->period_start }} s/d {{ $log->period_end }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $log->admin?->nama ?? $log->admin_username ?? '-' }}</td>
                                <td>{{ $log->note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">Belum ada pengiriman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
