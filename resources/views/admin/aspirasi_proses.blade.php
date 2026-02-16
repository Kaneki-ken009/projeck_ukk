@extends('layouts.admin')

@section('title', 'Aspirasi Proses')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Aspirasi Proses</h2>
        <p class="text-muted mb-0">Aspirasi yang sedang ditangani.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <select id="filterNisnProses" class="form-select">
                        <option value="">Semua NISN</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="filterNamaProses" class="form-select">
                        <option value="">Semua Nama</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <input type="date" id="filterDateProses" class="form-control">
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
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
                        <td>{{ $a->tgl_inputaspirasi }}</td>
                        <td>
                            @if($a->foto)
                                <img src="{{ asset('storage/'.$a->foto) }}" alt="Foto aspirasi"
                                    style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#feedbackModal{{ $a->id_inputaspirasi }}">
                                Beri Feedback
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $a->id_inputaspirasi }}">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="feedbackModal{{ $a->id_inputaspirasi }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Feedback Aspirasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.feedback') }}">
                                    @csrf
                                    <input type="hidden" name="id_aspirasi" value="{{ $a->id_inputaspirasi }}">
                                    <input type="hidden" name="status" value="selesai">
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">NISN</label>
                                                <input type="text" class="form-control" value="{{ $a->nisn }}" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $a->pengirim->nama ?? '-' }}" disabled>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Kategori</label>
                                                <input type="text" class="form-control" value="{{ $a->kategori->nama ?? '-' }}" disabled>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" value="{{ $a->lokasi }}" disabled>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Keterangan</label>
                                                <input type="text" class="form-control" value="{{ $a->ket }}" disabled>
                                            </div>
                                        </div>
                                        <hr class="my-4">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <input type="text" class="form-control" value="Selesai" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Isi Feedback</label>
                                            <textarea class="form-control" name="isi_feedback" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
            const nisnSelect = document.getElementById('filterNisnProses');
            const namaSelect = document.getElementById('filterNamaProses');
            const statusSelect = document.getElementById('filterStatusProses');
            const dateInput = document.getElementById('filterDateProses');
            const rows = Array.from(document.querySelectorAll('.aspirasi-row'));
            if (!nisnSelect || !namaSelect || !statusSelect || !dateInput || rows.length === 0) return;

            const fillOptions = (selectEl, label, values) => {
                selectEl.innerHTML = '';
                selectEl.add(new Option(label, ''));
                values.forEach((value) => selectEl.add(new Option(value, value)));
            };

            const renderOptions = () => {
                const nisnValues = [...new Set(rows
                    .map((row) => (row.dataset.nisn || '').trim())
                    .filter((v) => v !== ''))]
                    .sort((a, b) => a.localeCompare(b, 'id'));
                const namaValues = [...new Set(rows
                    .map((row) => (row.dataset.nama || '').trim())
                    .filter((v) => v !== ''))]
                    .sort((a, b) => a.localeCompare(b, 'id'));
                const statusValues = [...new Set(rows
                    .map((row) => (row.dataset.status || '').trim())
                    .filter((v) => v !== ''))]
                    .sort((a, b) => a.localeCompare(b, 'id'));

                fillOptions(nisnSelect, 'Semua NISN', nisnValues);
                fillOptions(namaSelect, 'Semua Nama', namaValues);
                fillOptions(statusSelect, 'Semua Status', statusValues);
            };

            const applyFilter = () => {
                const selectedNisn = nisnSelect.value.toLowerCase().trim();
                const selectedNama = namaSelect.value.toLowerCase().trim();
                const selectedStatus = statusSelect.value.toLowerCase().trim();
                const date = dateInput.value;
                rows.forEach((row) => {
                    const nisn = (row.dataset.nisn || '').toLowerCase();
                    const nama = (row.dataset.nama || '').toLowerCase();
                    const status = (row.dataset.status || '').toLowerCase();
                    const rowDate = row.dataset.tanggal || '';
                    const matchNisn = !selectedNisn || nisn === selectedNisn;
                    const matchNama = !selectedNama || nama === selectedNama;
                    const matchStatus = !selectedStatus || status === selectedStatus;
                    const matchDate = !date || rowDate === date;
                    row.style.display = matchNisn && matchNama && matchStatus && matchDate ? '' : 'none';
                });
            };

            nisnSelect.addEventListener('change', applyFilter);
            namaSelect.addEventListener('change', applyFilter);
            statusSelect.addEventListener('change', applyFilter);
            dateInput.addEventListener('change', applyFilter);

            renderOptions();
        })();
    </script>
@endsection
