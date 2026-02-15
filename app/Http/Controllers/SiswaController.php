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
            ->orderBy('tgl_inputaspirasi', 'desc')
            ->get();

        $kategori = Kategori::all();

        // FEEDBACK KHUSUS SISWA LOGIN
        $feedbackSaya = collect();

        if (auth()->check() && auth()->user()->role === 'siswa') {
            $feedbackSaya = Feedback::where('nisn', auth()->user()->nisn)
                ->get()
                ->keyBy('id_aspirasi');
        }

        return view('siswa', compact(
            'aspirasi',
            'kategori',
            'feedbackSaya'
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
}
