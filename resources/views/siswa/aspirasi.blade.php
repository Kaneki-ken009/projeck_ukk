<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>siswa - dashboard</title>
</head>
<body>
    <div class="container py-5">
        <h4 class="mb-4">Daftar Aspirasi</h4>

        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <select id="filterNisnSiswaAlt" class="form-select">
                    <option value="">Semua NISN</option>
                </select>
            </div>
            <div class="col-md-4">
                <select id="filterNamaSiswaAlt" class="form-select">
                    <option value="">Semua Nama</option>
                </select>
            </div>
            <div class="col-md-4">
                <select id="filterStatusSiswaAlt" class="form-select">
                    <option value="">Semua Status</option>
                </select>
            </div>
        </div>
        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="date" id="filterDateSiswaAlt" class="form-control">
            </div>
        </div>

        <div class="row g-4">
            @foreach($aspirasi as $a)
                <div class="col-md-4 aspirasi-card"
                    data-nisn="{{ $a->nisn }}"
                    data-nama="{{ $a->pengirim->nama ?? '' }}"
                    data-status="{{ $a->status }}"
                    data-tanggal="{{ optional($a->tgl_inputaspirasi)->format('Y-m-d') }}">
                    <div class="card shadow-sm h-100">

                        @if($a->foto)
                            <img src="{{ asset('storage/'.$a->foto) }}"
                                class="card-img-top"
                                style="height:20px;object-fit:cover">
                        @endif

                        <div class="card-body">
                            <span class="badge bg-primary">{{ $a->kategori->nama }}</span>
                            <h6 class="mt-2">
                                Pengirim: {{ $a->pengirim->nama ?? '-' }} (NISN: {{ $a->nisn }})
                            </h6>
                            <h5 class="mt-2">{{ $a->lokasi }}</h5>
                            <p>{{ $a->ket }}</p>

                            @auth
                                @if($feedbackSaya->has($a->id_inputaspirasi))
                                    <div class="alert alert-success">
                                        {{ $feedbackSaya[$a->id_inputaspirasi]->isi_feedback }}
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> 
    <script>
        (() => {
            const nisnSelect = document.getElementById('filterNisnSiswaAlt');
            const namaSelect = document.getElementById('filterNamaSiswaAlt');
            const statusSelect = document.getElementById('filterStatusSiswaAlt');
            const dateInput = document.getElementById('filterDateSiswaAlt');
            const cards = Array.from(document.querySelectorAll('.aspirasi-card'));
            if (!nisnSelect || !namaSelect || !statusSelect || !dateInput || cards.length === 0) return;

            const fillOptions = (selectEl, label, values) => {
                selectEl.innerHTML = '';
                selectEl.add(new Option(label, ''));
                values.forEach((value) => selectEl.add(new Option(value, value)));
            };

            const renderOptions = () => {
                const nisnValues = [...new Set(cards
                    .map((card) => (card.dataset.nisn || '').trim())
                    .filter((v) => v !== ''))]
                    .sort((a, b) => a.localeCompare(b, 'id'));
                const namaValues = [...new Set(cards
                    .map((card) => (card.dataset.nama || '').trim())
                    .filter((v) => v !== ''))]
                    .sort((a, b) => a.localeCompare(b, 'id'));
                const statusValues = [...new Set(cards
                    .map((card) => (card.dataset.status || '').trim())
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
                cards.forEach((card) => {
                    const nisn = (card.dataset.nisn || '').toLowerCase();
                    const nama = (card.dataset.nama || '').toLowerCase();
                    const status = (card.dataset.status || '').toLowerCase();
                    const cardDate = card.dataset.tanggal || '';
                    const matchNisn = !selectedNisn || nisn === selectedNisn;
                    const matchNama = !selectedNama || nama === selectedNama;
                    const matchStatus = !selectedStatus || status === selectedStatus;
                    const matchDate = !date || cardDate === date;
                    card.style.display = matchNisn && matchNama && matchStatus && matchDate ? '' : 'none';
                });
            };

            nisnSelect.addEventListener('change', applyFilter);
            namaSelect.addEventListener('change', applyFilter);
            statusSelect.addEventListener('change', applyFilter);
            dateInput.addEventListener('change', applyFilter);

            renderOptions();
        })();
    </script>
</body>
</html>
