<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use App\Models\LaporanLog;

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
            'aspirasi' => InputAspirasi::with('kategori')
                ->where('status', 'menunggu')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function proses()
    {
        return view('kepsek.aspirasi_proses', [
            'aspirasi' => InputAspirasi::with('kategori')
                ->where('status', 'proses')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function selesai()
    {
        return view('kepsek.aspirasi_selesai', [
            'aspirasi' => InputAspirasi::with('kategori')
                ->where('status', 'selesai')
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get(),
        ]);
    }

    public function laporan()
    {
        return view('kepsek.laporan', [
            'logs' => LaporanLog::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
