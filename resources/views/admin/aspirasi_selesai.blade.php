@extends('layouts.admin')

@section('title', 'History Aspirasi')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">History Aspirasi (Selesai)</h2>
        <p class="text-muted mb-0">Aspirasi yang sudah selesai diproses.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="mb-3">
                <input type="text" id="searchAspirasiSelesai" class="form-control"
                    placeholder="Cari aspirasi...">
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
                    <tr class="aspirasi-row">
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
    <script>
        (() => {
            const input = document.getElementById('searchAspirasiSelesai');
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
