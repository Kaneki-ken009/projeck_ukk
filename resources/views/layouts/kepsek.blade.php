<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Kepsek')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('icon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .profile-avatar-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid #dee2e6;
            padding: 0;
            overflow: hidden;
            background: #fff;
        }
        .profile-avatar-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-avatar-btn.dropdown-toggle::after {
            display: none;
        }
    </style>
</head>
<body>

<div class="d-flex" style="min-height: 100vh;">
    @include('components.kepsek.sidebar')

    <div class="flex-fill bg-light">
        <div class="d-flex justify-content-end align-items-center border-bottom bg-white px-4 py-3">
            <div class="text-center">
                <div class="dropdown">
                    <button class="profile-avatar-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Profil">
                        <img src="{{ asset('icon.ico') }}" alt="Profil">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="small text-muted mt-1">
                    {{ auth()->user()?->nama ?? auth()->user()?->username ?? 'Kepsek' }}
                </div>
            </div>
        </div>
        <div class="p-4">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
