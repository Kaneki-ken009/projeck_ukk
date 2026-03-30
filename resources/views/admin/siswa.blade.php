@extends('layouts.admin')

@section('title', 'Siswa')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">Siswa</h2>
        <p class="text-muted mb-0">Kelola data siswa secara terpisah dari user admin dan kepsek.</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Data Siswa</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createSiswaModal">
                    Tambah Siswa
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                            <tr>
                                <td>{{ $s->nisn }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->kelas ?? '-' }}</td>
                                <td>{{ $s->jurusan ?? '-' }}</td>
                                <td style="min-width: 170px;">
                                    @if(isset($passwordByNisn[$s->nisn]))
                                        <input type="password" class="form-control form-control-sm"
                                            value="{{ $passwordByNisn[$s->nisn] }}" readonly>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editSiswaModal{{ $s->id_siswa }}">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.siswa.destroy', $s) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editSiswaModal{{ $s->id_siswa }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Siswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.siswa.update', $s) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label class="form-label">NISN</label>
                                                    <input type="text" class="form-control js-siswa-nisn-check" name="nisn"
                                                        value="{{ $s->nisn }}" data-current-nisn="{{ $s->nisn }}" required>
                                                    <div class="invalid-feedback">NISN sudah digunakan.</div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="nama"
                                                        value="{{ $s->nama }}" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Kelas</label>
                                                    <input type="text" class="form-control" name="kelas"
                                                        value="{{ $s->kelas }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Jurusan</label>
                                                    <input type="text" class="form-control" name="jurusan"
                                                        value="{{ $s->jurusan }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button class="btn btn-primary" type="submit">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createSiswaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.siswa.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">NISN</label>
                            <input type="text" class="form-control js-siswa-nisn-check" name="nisn" data-current-nisn="" required>
                            <div class="invalid-feedback">NISN sudah digunakan.</div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" name="kelas">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Jurusan</label>
                            <input type="text" class="form-control" name="jurusan">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const usedSiswaNisn = @json($usedSiswaNisn);
        const normalizeSiswaNisn = (value) => (value || '').trim().toLowerCase();

        const validateSiswaNisnInput = (input) => {
            if (!input) {
                return true;
            }

            const value = normalizeSiswaNisn(input.value);
            const currentValue = normalizeSiswaNisn(input.dataset.currentNisn);
            if (!value || value === currentValue) {
                input.classList.remove('is-invalid');
                input.setCustomValidity('');
                return true;
            }

            const duplicated = usedSiswaNisn.some((nisn) => normalizeSiswaNisn(nisn) === value);
            if (duplicated) {
                input.classList.add('is-invalid');
                input.setCustomValidity('NISN sudah digunakan.');
                return false;
            }

            input.classList.remove('is-invalid');
            input.setCustomValidity('');
            return true;
        };

        document.querySelectorAll('.js-siswa-nisn-check').forEach((input) => {
            input.addEventListener('blur', () => {
                validateSiswaNisnInput(input);
            });

            input.addEventListener('input', () => {
                input.classList.remove('is-invalid');
                input.setCustomValidity('');
            });

            const form = input.closest('form');
            if (form) {
                form.addEventListener('submit', (event) => {
                    if (!validateSiswaNisnInput(input)) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                });
            }
        });
    </script>
@endsection
