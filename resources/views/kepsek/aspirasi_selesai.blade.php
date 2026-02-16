@extends('layouts.kepsek')

@section('title', 'History Aspirasi')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">History Aspirasi (Selesai)</h2>
        <p class="text-muted mb-0">Aspirasi yang sudah selesai diproses.</p>
    </div>

    <div class="mb-3">
        <input type="text" id="searchKepsekSelesai" class="form-control" placeholder="Cari aspirasi...">
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NISN</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirasi as $a)
                    <tr class="aspirasi-row">
                        <td>{{ $a->id_inputaspirasi }}</td>
                        <td>{{ $a->nisn }}</td>
                        <td>{{ $a->kategori->nama ?? '-' }}</td>
                        <td>{{ $a->lokasi }}</td>
                        <td>{{ $a->ket }}</td>
                        <td>
                            @if($a->foto)
                                <img src="{{ asset('storage/'.$a->foto) }}" alt="Foto aspirasi"
                                    style="width:100px;height:100px;object-fit:cover;border-radius:4px;">
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        (() => {
            const input = document.getElementById('searchKepsekSelesai');
            const rows = Array.from(document.querySelectorAll('.aspirasi-row'));
            if (!input || rows.length === 0) return;

            input.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();
                rows.forEach((row) => {
                    row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
                });
            });
        })();
    </script>
@endsection
