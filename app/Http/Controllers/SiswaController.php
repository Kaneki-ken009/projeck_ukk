<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Feedback;

class SiswaController extends Controller
{
    public function index()
    {
        // SEMUA ASPIRASI (GLOBAL)
        $aspirasi = InputAspirasi::with(['kategori', 'pengirim'])
            ->orderByRaw("CASE status WHEN 'menunggu' THEN 1 WHEN 'proses' THEN 2 WHEN 'selesai' THEN 3 ELSE 4 END")
            ->orderBy('tgl_inputaspirasi', 'desc')
            ->get();

        $kategori = Kategori::all();

        // FEEDBACK KHUSUS SISWA LOGIN
        $feedbackSaya = collect();
        $aspirasiSaya = collect();
        $unreadFeedbackCount = 0;

        if (auth()->check() && auth()->user()->role === 'siswa') {
            $aspirasiSaya = InputAspirasi::with(['kategori', 'pengirim'])
                ->where('nisn', auth()->user()->nisn)
                ->orderByRaw("CASE status WHEN 'menunggu' THEN 1 WHEN 'proses' THEN 2 WHEN 'selesai' THEN 3 ELSE 4 END")
                ->orderBy('tgl_inputaspirasi', 'desc')
                ->get();

            $feedbackSaya = Feedback::where('nisn', auth()->user()->nisn)
                ->orderByDesc('created_at')
                ->get()
                ->keyBy('id_aspirasi');

            $unreadFeedbackCount = Feedback::where('nisn', auth()->user()->nisn)
                ->where('is_read', false)
                ->count();
        }

        return view('siswa', compact(
            'aspirasi',
            'aspirasiSaya',
            'kategori',
            'feedbackSaya',
            'unreadFeedbackCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'lokasi' => 'required',
            'ket' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('aspirasi', 'public');
        }

        InputAspirasi::create([
            'nisn' => auth()->user()->nisn,
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
            'foto' => $foto,
            'status' => 'menunggu',
            'tgl_inputaspirasi' => now(),
        ]);

        return back();
    }

    public function readFeedback(Request $request)
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'siswa') {
            abort(403);
        }

        $data = $request->validate([
            'id_aspirasi' => 'required|integer|exists:inputaspirasi,id_inputaspirasi',
        ]);

        Feedback::where('nisn', $user->nisn)
            ->where('id_aspirasi', $data['id_aspirasi'])
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['ok' => true]);
    }
}
