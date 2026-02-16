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

        <div class="mb-3">
            <input type="text" id="searchAspirasiSiswaAlt" class="form-control" placeholder="Cari aspirasi...">
        </div>

        <div class="row g-4">
            @foreach($aspirasi as $a)
                <div class="col-md-4 aspirasi-card">
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
            const input = document.getElementById('searchAspirasiSiswaAlt');
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
</body>
</html>
