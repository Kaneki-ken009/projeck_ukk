@extends('layouts.admin')

@section('title', 'User')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">User</h2>
        <p class="text-muted mb-0">Kelola user admin dan kepsek.</p>
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
                <h6 class="mb-0">Data User</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    Tambah User
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr>
                                <td>{{ $u->username }}</td>
                                <td>{{ $u->nama }}</td>
                                <td style="min-width: 170px;">
                                    <input type="password" class="form-control form-control-sm"
                                        value="{{ $u->password }}" readonly>
                                </td>
                                <td class="text-capitalize">{{ $u->role }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal{{ $u->id }}">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.user.destroy', $u) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.user.update', $u) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label class="form-label">Username</label>
                                                    <input type="text" class="form-control" name="username"
                                                        value="{{ $u->username }}" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Password (opsional)</label>
                                                    <input type="password" class="form-control" name="password">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="nama"
                                                        value="{{ $u->nama }}" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Role</label>
                                                    <select class="form-select js-role-select" name="role" required>
                                                        <option value="admin" @selected($u->role === 'admin')>Admin</option>
                                                        <option value="siswa" @selected($u->role === 'siswa')>Siswa</option>
                                                        <option value="kepsek" @selected($u->role === 'kepsek')>Kepsek</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">NISN</label>
                                                    <input type="text" class="form-control js-nisn-input js-nisn-user-check" name="nisn"
                                                        value="{{ $u->nisn }}" data-current-nisn="{{ $u->nisn ?? '' }}">
                                                    <div class="invalid-feedback">NISN sudah digunakan.</div>
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
                                <td colspan="5" class="text-muted">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.user.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Role</label>
                            <select class="form-select js-role-select" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="siswa">Siswa</option>
                                <option value="kepsek">Kepsek</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">NISN</label>
                            <input type="text" class="form-control js-nisn-input js-nisn-user-check" name="nisn" data-current-nisn="">
                            <div class="invalid-feedback">NISN sudah digunakan.</div>
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
        const usedUserNisn = @json($usedUserNisn);

        const normalizeNisn = (value) => (value || '').trim().toLowerCase();
        const validateUserNisnInput = (input) => {
            if (!input || input.disabled) {
                return true;
            }

            const value = normalizeNisn(input.value);
            const currentValue = normalizeNisn(input.dataset.currentNisn);
            if (!value || value === currentValue) {
                input.classList.remove('is-invalid');
                input.setCustomValidity('');
                return true;
            }

            const duplicated = usedUserNisn.some((nisn) => normalizeNisn(nisn) === value);
            if (duplicated) {
                input.classList.add('is-invalid');
                input.setCustomValidity('NISN sudah digunakan.');
                return false;
            }

            input.classList.remove('is-invalid');
            input.setCustomValidity('');
            return true;
        };

        document.querySelectorAll('.modal').forEach(function(modal) {
            const roleSelect = modal.querySelector('.js-role-select');
            const nisnInput = modal.querySelector('.js-nisn-input');
            const form = modal.querySelector('form');
            if (!roleSelect || !nisnInput) return;

            const syncNisnState = function() {
                const isSiswa = roleSelect.value === 'siswa';
                nisnInput.disabled = !isSiswa;
                nisnInput.required = isSiswa;
                if (!isSiswa) {
                    nisnInput.value = '';
                    nisnInput.classList.remove('is-invalid');
                    nisnInput.setCustomValidity('');
                }
            };

            syncNisnState();
            roleSelect.addEventListener('change', syncNisnState);
            nisnInput.addEventListener('blur', function() {
                validateUserNisnInput(nisnInput);
            });
            nisnInput.addEventListener('input', function() {
                nisnInput.classList.remove('is-invalid');
                nisnInput.setCustomValidity('');
            });
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!validateUserNisnInput(nisnInput)) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                });
            }
        });
    </script>
@endsection
