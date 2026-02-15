<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(Kategori::all());
    }

    public function show(Kategori $kategori)
    {
        return response()->json($kategori);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
        ]);

        $kategori = Kategori::create($data);

        return response()->json($kategori, 201);
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => 'required|string',
        ]);

        $kategori->update($data);

        return response()->json($kategori->fresh());
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return response()->json(['deleted' => true]);
    }
}
