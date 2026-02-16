@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Laporan ke Kepala Sekolah</h2>
        <p class="text-muted mb-0">Ringkasan aspirasi untuk dikirim ke kepala sekolah.</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.laporan.send') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Periode Bulan</label>
                        <input type="month" class="form-control" name="bulan" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catatan ke Kepsek (opsional)</label>
                        <input type="text" class="form-control" name="note" maxlength="300"
                            placeholder="Contoh: Fokus perbaikan fasilitas toilet">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100" type="submit">Kirim Laporan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h6 class="mb-1">Download PDF</h6>
                <p class="text-muted mb-0">Unduh laporan PDF langsung tanpa mengirim ke kepala sekolah.</p>
            </div>
            <a href="{{ route('admin.laporan.pdf') }}" class="btn btn-outline-primary">
                Download PDF
            </a>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h6 class="mb-3">Riwayat Pengiriman</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Periode</th>
                            <th>Admin</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
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
                                <td>
                                    <a class="btn btn-sm btn-outline-secondary"
                                        href="{{ route('admin.laporan.download', $log->id) }}">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">Belum ada pengiriman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<div class="mb-4">
        <h2 class="mb-1">Aspirasi </h2>
        <p class="text-muted mb-0">Berisi semua data aspirasi.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <select id="filterNisnSelesai" class="form-select">
                        <option value="">Semua NISN</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="filterNamaSelesai" class="form-select">
                        <option value="">Semua Nama</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                 <input type="date" id="filterDateSelesai" class="form-control">
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirasi as $a)
                    <tr class="aspirasi-row"
                        data-nisn="{{ $a->nisn }}"
                        data-nama="{{ $a->pengirim->nama ?? '' }}"
                        data-status="{{ $a->status }}"
                        data-tanggal="{{ optional($a->tgl_inputaspirasi)->format('Y-m-d') }}">
                        <td>{{ $a->nisn }}</td>
                        <td>{{ $a->pengirim->nama ?? '-' }}</td>
                        <td>{{ $a->kategori->nama ?? '-' }}</td>
                        <td>{{ $a->lokasi }}</td>
                        <td>
                            @if($a->foto)
                                <img src="{{ asset('storage/'.$a->foto) }}" alt="Foto aspirasi"
                                    style="width:100px;height:100px;object-fit:cover;border-radius:4px;">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $a->id_inputaspirasi }}">
                                Detail
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade" id="detailModal{{ $a->id_inputaspirasi }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Aspirasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">NISN</label>
                                            <input type="text" class="form-control" value="{{ $a->nisn }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" value="{{ $a->pengirim->nama ?? '-' }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kategori</label>
                                            <input type="text" class="form-control" value="{{ $a->kategori->nama ?? '-' }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" class="form-control" value="{{ $a->lokasi }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal</label>
                                            <input type="text" class="form-control" value="{{ $a->tgl_inputaspirasi }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Status</label>
                                            <input type="text" class="form-control text-capitalize" value="{{ $a->status }}" disabled>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Keterangan</label>
                                            <textarea class="form-control" rows="3" disabled>{{ $a->ket }}</textarea>
                                        </div>
                                    </div>
                                    @if($a->feedback->isNotEmpty())
                                        <hr class="my-4">
                                        <div>
                                            <label class="form-label">Feedback Terakhir</label>
                                            <textarea class="form-control" rows="3" disabled>{{ $a->feedback->first()->isi_feedback }}</textarea>
                                            <small class="text-muted d-block mt-2">
                                                Diberikan pada {{ optional($a->feedback->first()->created_at)->format('d-m-Y H:i') ?? '-' }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
                </table>
            </div>
        </div>
    </div>