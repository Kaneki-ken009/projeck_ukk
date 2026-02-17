@extends('layouts.app')

@section('content')
    <style>
        .page { }
        .card-hover {
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, .12);
        }
        .hero {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #fff;
            border-radius: 16px;
        }
        .status-menunggu {
            border-top: 4px solid #dc3545;
        }
        .status-proses {
            border-top: 4px solid #ffc107;
        }
        .status-selesai {
            border-top: 4px solid #198754;
        }
        .status-default {
            border-top: 4px solid #6c757d;
        }
        .filter-panel {
            border: 1px solid rgba(13, 110, 253, .15);
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
            border-radius: 12px;
        }
        .aspirasi-card .card-title {
            line-height: 1.3;
        }
        .aspirasi-card .card-text-ket {
            min-height: 72px;
        }
        .foto-placeholder {
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e3a8a;
            font-weight: 600;
            border-radius: 8px;
        }
    </style>

    <div class="container py-5">
        <section id="landing" class="page">
            <div class="hero p-4 p-md-5 mb-4">
                <h2 class="fw-bold mb-3">Kenapa Menggunakan Aplikasi Aspirasi?</h2>
                <p class="mb-0">
                    Aplikasi ini memudahkan siswa menyampaikan aspirasi secara cepat, aman, dan terpantau.
                    Semua masukan tercatat rapi dan bisa segera ditindaklanjuti oleh pihak sekolah.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-hover h-100">
                        <div class="card-body">
                            <h5 class="card-title">Mudah dan Cepat</h5>
                            <p class="card-text">Kirim aspirasi kapan pun tanpa ribet, langsung dari HP atau laptop.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-hover h-100">
                        <div class="card-body">
                            <h5 class="card-title">Transparan</h5>
                            <p class="card-text">Setiap aspirasi tercatat dan bisa dipantau statusnya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-hover h-100">
                        <div class="card-body">
                            <h5 class="card-title">Responsif</h5>
                            <p class="card-text">Admin memberi feedback agar siswa tahu tindak lanjutnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="aspirasi" class="page d-none">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0">Daftar Aspirasi</h4>
                @auth
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAspirasi">
                        Input Aspirasi
                    </button>
                @endauth
                @guest
                    <button class="btn btn-primary" disabled>Login untuk Input</button>
                @endguest
            </div>

            @if($aspirasi->isEmpty())
                <div class="alert alert-info">Belum ada aspirasi.</div>
            @else
                <div class="card shadow-sm filter-panel mb-4">
                    <div class="card-body p-3 p-md-4">
                        <h6 class="mb-3">Filter Aspirasi</h6>
                        <div class="row g-2 mb-3">
                            <div class="col-md-4">
                                <select id="filterNisnSiswa" class="form-select">
                                    <option value="">Semua NISN</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="filterNamaSiswa" class="form-select">
                                    <option value="">Semua Nama</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="filterStatusSiswa" class="form-select">
                                    <option value="">Semua Status</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="date" id="filterDateSiswa" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="resetFilterSiswa" class="btn btn-outline-secondary w-100">
                                    Reset Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($aspirasi as $a)
                        @php
                            $isOwner = auth()->check()
                                && auth()->user()->role === 'siswa'
                                && auth()->user()->nisn === $a->nisn;

                            $statusCardClass = match ($a->status) {
                                'menunggu' => 'status-menunggu',
                                'proses' => 'status-proses',
                                'selesai' => 'status-selesai',
                                default => 'status-default',
                            };

                            $statusBadgeClass = match ($a->status) {
                                'menunggu' => 'bg-danger',
                                'proses' => 'bg-warning text-dark',
                                'selesai' => 'bg-success',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <div class="col-md-4 aspirasi-card"
                            data-nisn="{{ $a->nisn }}"
                            data-nama="{{ $a->pengirim->nama ?? '' }}"
                            data-status="{{ $a->status }}"
                            data-tanggal="{{ optional($a->tgl_inputaspirasi)->format('Y-m-d') }}">
                            <div class="card card-hover h-100 {{ $isOwner ? $statusCardClass : '' }}">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-primary">{{ $a->kategori->nama }}</span>
                                        @if($isOwner)
                                            <span class="badge {{ $statusBadgeClass }} text-uppercase">{{ $a->status }}</span>
                                        @endif
                                    </div>
                                    <p class="text-muted mb-1 mt-2">
                                        <i class="bi bi-person-circle me-1"></i>
                                        Pengirim: {{ $a->pengirim->nama ?? '-' }} (NISN: {{ $a->nisn }})
                                    </p>
                                    <h5 class="mt-2 card-title">
                                        <i class="bi bi-geo-alt-fill me-1 text-danger"></i>{{ $a->lokasi }}
                                    </h5>
                                    @auth
                                        @if($feedbackSaya->has($a->id_inputaspirasi))
                                            <div class="alert alert-success mb-3">
                                                {{ $feedbackSaya[$a->id_inputaspirasi]->isi_feedback }}
                                            </div>
                                        @endif
                                    @endauth

                                    <button class="btn btn-sm btn-outline-primary mt-auto" data-bs-toggle="modal"
                                        data-bs-target="#detailModalSiswa{{ $a->id_inputaspirasi }}">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="detailModalSiswa{{ $a->id_inputaspirasi }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Aspirasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-7">
                                                <div class="mb-2"><strong>NISN:</strong> {{ $a->nisn }}</div>
                                                <div class="mb-2"><strong>Nama:</strong> {{ $a->pengirim->nama ?? '-' }}</div>
                                                <div class="mb-2"><strong>Kategori:</strong> {{ $a->kategori->nama ?? '-' }}</div>
                                                <div class="mb-2"><strong>Lokasi:</strong> {{ $a->lokasi }}</div>
                                                <div class="mb-2"><strong>Tanggal:</strong> {{ $a->tgl_inputaspirasi }}</div>
                                                <div class="mb-2"><strong>Status:</strong> <span class="text-capitalize">{{ $a->status }}</span></div>
                                                <div class="mb-0"><strong>Keterangan:</strong><br>{{ $a->ket }}</div>
                                            </div>
                                            <div class="col-md-5">
                                                @if($a->foto)
                                                    <img src="{{ asset('storage/'.$a->foto) }}"
                                                        class="img-fluid rounded border"
                                                        alt="Foto aspirasi"
                                                        style="width:100%;height:260px;object-fit:cover;">
                                                @else
                                                    <div class="foto-placeholder">Tidak ada foto</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <div class="modal fade" id="modalAspirasi" tabindex="-1" aria-labelledby="modalAspirasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAspirasiLabel">Input Aspirasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/siswa/aspirasi" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">NISN</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->nisn ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->nama ?? '' }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="id_kategori" required>
                                    <option value="" disabled selected>Pilih kategori</option>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id_kategori }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" rows="4" name="ket" required></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Foto (opsional)</label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        (() => {
            const nisnSelect = document.getElementById('filterNisnSiswa');
            const namaSelect = document.getElementById('filterNamaSiswa');
            const statusSelect = document.getElementById('filterStatusSiswa');
            const dateInput = document.getElementById('filterDateSiswa');
            const resetBtn = document.getElementById('resetFilterSiswa');
            const cards = Array.from(document.querySelectorAll('.aspirasi-card'));
            if (!nisnSelect || !namaSelect || !statusSelect || !dateInput || !resetBtn || cards.length === 0) return;

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
            resetBtn.addEventListener('click', () => {
                nisnSelect.value = '';
                namaSelect.value = '';
                statusSelect.value = '';
                dateInput.value = '';
                applyFilter();
            });

            renderOptions();
        })();
    </script>
@endsection
