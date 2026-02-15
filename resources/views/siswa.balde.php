<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aspirasi Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@include('components.navbar')

@yield('content')

@include('components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function hideAll() {
    document.querySelectorAll('.page').forEach(el => el.classList.add('d-none'));
}

function showLanding() {
    hideAll();
    document.getElementById('landing').classList.remove('d-none');
}

function showAspirasi() {
    hideAll();
    document.getElementById('aspirasi').classList.remove('d-none');
}
</script>

</body>
</html>