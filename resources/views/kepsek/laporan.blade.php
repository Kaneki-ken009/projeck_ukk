@extends('layouts.kepsek')

@section('title', 'Laporan')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Laporan Aspirasi</h2>
        <p class="text-muted mb-0">Download laporan aspirasi terbaru.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <span class="text-muted">Kepsek mengunduh dari riwayat pengiriman admin.</span>
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
                            <th>Jenis</th>
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
                                <td>{{ $log->admin_username ?? '-' }}</td>
                                <td>{{ strtoupper($log->file_type) }}</td>
                                <td>{{ $log->note ?? '-' }}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-secondary"
                                        href="{{ route('kepsek.laporan.download', $log->id) }}">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Belum ada pengiriman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
