<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use App\Models\LaporanLog;
use Barryvdh\DomPDF\Facade\Pdf;

class KepsekController extends Controller
{
    public function index()
    {
        return view('kepsek.dashboard', [
            'aspirasiTotal' => InputAspirasi::count(),
            'aspirasiMenunggu' => InputAspirasi::where('status', 'menunggu')->count(),
            'aspirasiProses' => InputAspirasi::where('status', 'proses')->count(),
            'aspirasiSelesai' => InputAspirasi::where('status', 'selesai')->count(),
        ]);
    }

    public function menunggu()
    {
        return view('kepsek.aspirasi_menunggu', [
            'aspirasi' => InputAspirasi::with([
                'kategori',
                'pengirim',
                'feedback' => fn ($query) => $query->orderByDesc('created_at'),
            ])
                ->where('status', 'menunggu')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function proses()
    {
        return view('kepsek.aspirasi_proses', [
            'aspirasi' => InputAspirasi::with([
                'kategori',
                'pengirim',
                'feedback' => fn ($query) => $query->orderByDesc('created_at'),
            ])
                ->where('status', 'proses')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function selesai()
    {
        return view('kepsek.aspirasi_selesai', [
            'aspirasi' => InputAspirasi::with([
                'kategori',
                'pengirim',
                'feedback' => fn ($query) => $query->orderByDesc('created_at'),
            ])
                ->where('status', 'selesai')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function laporan()
    {
        return view('kepsek.laporan', [
            'logs' => LaporanLog::with('admin')->orderBy('created_at', 'desc')->get(),
            'aspirasi' => InputAspirasi::with([
                'kategori',
                'pengirim',
                'feedback' => fn ($query) => $query->orderByDesc('created_at'),
            ])
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function laporanPdf()
    {
        $aspirasi = InputAspirasi::with([
            'kategori',
            'feedback' => fn ($query) => $query->orderByDesc('created_at'),
        ])
            ->orderBy('tgl_inputaspirasi', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan_pdf', [
            'aspirasi' => $aspirasi,
            'generatedAt' => now(),
        ]);

        return $pdf->download('laporan-aspirasi-kepsek-' . now()->format('YmdHis') . '.pdf');
    }
}
