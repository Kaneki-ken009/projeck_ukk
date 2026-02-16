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
                                <td>{{ optional($log->created_at)->format('d-m-Y H:i') ?? '-' }}</td>
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
                                        href="{{ route('admin.laporan.download', $log) }}">
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
