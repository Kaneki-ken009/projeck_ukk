<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'nama' => 'required|string',
            'nisn' => 'nullable|string',
            'role' => 'required|in:admin,siswa,kepsek',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'sometimes|required|string|unique:users,username,' . $user->getKey(),
            'password' => 'nullable|string|min:6',
            'nama' => 'sometimes|required|string',
            'nisn' => 'nullable|string',
            'role' => 'sometimes|required|in:admin,siswa,kepsek',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json($user->fresh());
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['deleted' => true]);
    }
}
