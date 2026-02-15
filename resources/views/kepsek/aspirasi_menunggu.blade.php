@extends('layouts.kepsek')

@section('title', 'Aspirasi Menunggu')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Aspirasi Menunggu</h2>
        <p class="text-muted mb-0">Daftar aspirasi yang baru masuk.</p>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NISN</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirasi as $a)
                    <tr>
                        <td>{{ $a->id_inputaspirasi }}</td>
                        <td>{{ $a->nisn }}</td>
                        <td>{{ $a->kategori->nama ?? '-' }}</td>
                        <td>{{ $a->lokasi }}</td>
                        <td>{{ $a->tgl_inputaspirasi }}</td>
                        <td>{{ $a->ket }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
