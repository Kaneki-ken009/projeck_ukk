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

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
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
                            <th>Feedback Terakhir</th>
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
                                <td>{{ optional($a->feedback->first())->isi_feedback ?? '-' }}</td>
                            </tr>
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
@endsection
