<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aspirasi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin: 0 0 8px; }
        .meta { margin-bottom: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px 8px; vertical-align: top; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Aspirasi</h2>
    <div class="meta">
        Generated: {{ $generatedAt }}
        @if(isset($periodStart) && isset($periodEnd))
            | Periode: {{ $periodStart->toDateString() }} s/d {{ $periodEnd->toDateString() }}
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NISN</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aspirasi as $index => $a)
                @php
                    $latestFeedback = optional($a->feedback->first())->isi_feedback;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $a->tgl_inputaspirasi }}</td>
                    <td>{{ $a->nisn }}</td>
                    <td>{{ $a->kategori->nama ?? '-' }}</td>
                    <td>{{ $a->lokasi }}</td>
                    <td>{{ $a->ket }}</td>
                    <td>{{ $a->status }}</td>
                    <td>{{ $latestFeedback ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
