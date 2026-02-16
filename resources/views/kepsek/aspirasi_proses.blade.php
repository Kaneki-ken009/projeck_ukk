@extends('layouts.kepsek')

@section('title', 'Aspirasi Proses')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Aspirasi Proses</h2>
        <p class="text-muted mb-0">Aspirasi yang sedang ditangani.</p>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <select id="filterNisnKepsekProses" class="form-select">
                <option value="">Semua NISN</option>
            </select>
        </div>
        <div class="col-md-4">
            <select id="filterNamaKepsekProses" class="form-select">
                <option value="">Semua Nama</option>
            </select>
        </div>
        <div class="col-md-4">
            <select id="filterStatusKepsekProses" class="form-select">
                <option value="">Semua Status</option>
            </select>
        </div>
    </div>
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="date" id="filterDateKepsekProses" class="form-control">
        </div>
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
                    <tr class="aspirasi-row"
                        data-nisn="{{ $a->nisn }}"
                        data-nama="{{ $a->pengirim->nama ?? '' }}"
                        data-status="{{ $a->status }}"
                        data-tanggal="{{ optional($a->tgl_inputaspirasi)->format('Y-m-d') }}">
                        <td>{{ $a->id_inputaspirasi }}</td>
                        <td>{{ $a->nisn }}</td>
                        <td>{{ $a->kategori->nama ?? '-' }}</td>
                        <td>{{ $a->lokasi }}</td>
                        <td>{{ $a->tgl_inputaspirasi }}</td>
                        <td>{{ $a->ket }}</td>
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
            const nisnSelect = document.getElementById('filterNisnKepsekProses');
            const namaSelect = document.getElementById('filterNamaKepsekProses');
            const statusSelect = document.getElementById('filterStatusKepsekProses');
            const dateInput = document.getElementById('filterDateKepsekProses');
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
