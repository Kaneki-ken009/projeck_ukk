@extends('layouts.admin')

@section('title', 'User')

@section('content')
    <div class="mb-4">
        <h2 class="mb-1">User</h2>
        <p class="text-muted mb-0">Tambah dan lihat data user.</p>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Tambah User</h6>
                    <form method="POST" action="{{ route('admin.user.store') }}">
                        @csrf
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
                            <label class="form-label">NISN (opsional)</label>
                            <input type="text" class="form-control" name="nisn">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="siswa">Siswa</option>
                                <option value="kepsek">Kepsek</option>
                            </select>
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Data User</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $u)
                                    <tr>
                                        <td>{{ $u->username }}</td>
                                        <td>{{ $u->nama }}</td>
                                        <td>{{ $u->nisn ?? '-' }}</td>
                                        <td>{{ $u->role }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted">Belum ada user.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
