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
                <div class="mb-3">
                    <input type="text" id="searchAspirasiSiswa" class="form-control"
                        placeholder="Cari aspirasi...">
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
                        <div class="col-md-4 aspirasi-card">
                            <div class="card card-hover h-100 {{ $isOwner ? $statusCardClass : '' }}">
                                @if($a->foto)
                                    <img src="{{ asset('storage/'.$a->foto) }}"
                                        class="card-img-top"
                                        style="height:200px;object-fit:cover">
                                @endif

                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary">{{ $a->kategori->nama }}</span>
                                    @if($isOwner)
                                        <span class="badge {{ $statusBadgeClass }} text-uppercase">{{ $a->status }}</span>
                                    @endif
                                </div>
                                    <p class="text-muted mb-1 mt-2">
                                        Pengirim: {{ $a->pengirim->nama ?? '-' }} (NISN: {{ $a->nisn }})
                                    </p>
                                    <h5 class="mt-2">{{ $a->lokasi }}</h5>
                                    <p>{{ $a->ket }}</p>

                                    @auth
                                        @if($feedbackSaya->has($a->id_inputaspirasi))
                                            <div class="alert alert-success mb-0">
                                                {{ $feedbackSaya[$a->id_inputaspirasi]->isi_feedback }}
                                            </div>
                                        @endif
                                    @endauth
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
            const input = document.getElementById('searchAspirasiSiswa');
            const cards = Array.from(document.querySelectorAll('.aspirasi-card'));
            if (!input || cards.length === 0) return;

            input.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();
                cards.forEach((card) => {
                    card.style.display = card.innerText.toLowerCase().includes(keyword) ? '' : 'none';
                });
            });
        })();
    </script>
@endsection
