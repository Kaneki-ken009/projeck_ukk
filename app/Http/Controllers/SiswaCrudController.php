<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaCrudController extends Controller
{
    public function index()
    {
        return response()->json(Siswa::all());
    }

    public function show(Siswa $siswa)
    {
        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn' => 'required|string|unique:siswa,nisn',
            'nama' => 'required|string',
            'kelas' => 'nullable|string',
            'jurusan' => 'nullable|string',
        ]);

        $siswa = Siswa::create($data);

        return response()->json($siswa, 201);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nisn' => 'sometimes|required|string|unique:siswa,nisn,' . $siswa->getKey() . ',id_siswa',
            'nama' => 'sometimes|required|string',
            'kelas' => 'nullable|string',
            'jurusan' => 'nullable|string',
        ]);

        $siswa->update($data);

        return response()->json($siswa->fresh());
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return response()->json(['deleted' => true]);
    }
}
