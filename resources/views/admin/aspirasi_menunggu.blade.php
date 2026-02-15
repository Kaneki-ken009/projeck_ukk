@extends('layouts.admin')

@section('title', 'Aspirasi Menunggu')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Aspirasi Menunggu</h2>
        <p class="text-muted mb-0">Berisi aspirasi yang baru masuk dan belum diproses.</p>
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
                    <th>Foto</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
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
                        <td>
                            @if($a->foto)
                                <img src="{{ asset('storage/'.$a->foto) }}" alt="Foto aspirasi"
                                    style="width:100px;height:100px;object-fit:cover;border-radius:4px;">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $a->ket }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#feedbackModal{{ $a->id_inputaspirasi }}">
                                Beri Feedback
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="feedbackModal{{ $a->id_inputaspirasi }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Feedback Aspirasi #{{ $a->id_inputaspirasi }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.feedback') }}">
                                    @csrf
                                    <input type="hidden" name="id_aspirasi" value="{{ $a->id_inputaspirasi }}">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status" required>
                                                <option value="menunggu" selected>Menunggu</option>
                                                <option value="proses">Proses</option>
                                                <option value="selesai">Selesai</option>
                                            </select>
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
                @empty
                    <tr>
                        <td colspan="8" class="text-muted">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
