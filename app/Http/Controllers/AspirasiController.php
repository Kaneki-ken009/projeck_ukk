<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index()
    {
        return response()->json(
            InputAspirasi::with('kategori')->orderBy('tgl_inputaspirasi', 'desc')->get()
        );
    }

    public function show(InputAspirasi $aspirasi)
    {
        return response()->json($aspirasi->load('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn' => 'required|string',
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'lokasi' => 'required|string',
            'ket' => 'required|string',
            'foto' => 'nullable|string',
            'status' => 'nullable|in:menunggu,proses,selesai',
            'tgl_inputaspirasi' => 'nullable|date',
        ]);

        $data['status'] = $data['status'] ?? 'menunggu';
        $data['tgl_inputaspirasi'] = $data['tgl_inputaspirasi'] ?? now();

        $aspirasi = InputAspirasi::create($data);

        return response()->json($aspirasi, 201);
    }

    public function update(Request $request, InputAspirasi $aspirasi)
    {
        $data = $request->validate([
            'nisn' => 'sometimes|required|string',
            'id_kategori' => 'sometimes|required|integer|exists:kategori,id_kategori',
            'lokasi' => 'sometimes|required|string',
            'ket' => 'sometimes|required|string',
            'foto' => 'nullable|string',
            'status' => 'nullable|in:menunggu,proses,selesai',
            'tgl_inputaspirasi' => 'nullable|date',
        ]);

        $aspirasi->update($data);

        return response()->json($aspirasi->fresh());
    }

    public function destroy(InputAspirasi $aspirasi)
    {
        $aspirasi->delete();

        return response()->json(['deleted' => true]);
    }
}
