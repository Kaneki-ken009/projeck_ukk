<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Normal attempt with hashed password
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user && $user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user && $user->role === 'kepsek') {
                return redirect()->route('kepsek.dashboard');
            }
            return redirect('/'); // balik ke halaman siswa
        }

        // Fallback: handle legacy/plain password, then upgrade to hash
        $user = User::where('username', $data['username'])->first();
        if ($user && $user->password === $data['password']) {
            $user->password = Hash::make($data['password']);
            $user->save();
            Auth::login($user);
            $request->session()->regenerate();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'kepsek') {
                return redirect()->route('kepsek.dashboard');
            }
            return redirect('/');
        }

        return back()->withErrors([
            'username' => 'Login gagal',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
