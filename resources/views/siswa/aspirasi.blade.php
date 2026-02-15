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

        <div class="row g-4">
            @foreach($aspirasi as $a)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">

                        @if($a->foto)
                            <img src="{{ asset('storage/'.$a->foto) }}"
                                class="card-img-top"
                                style="height:200px;object-fit:cover">
                        @endif

                        <div class="card-body">
                            <span class="badge bg-primary">{{ $a->kategori->nama }}</span>
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
</body>
</html>
