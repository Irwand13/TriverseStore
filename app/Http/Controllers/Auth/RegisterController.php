<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Daftar akun tanpa package auth: validasi, simpan user,
// langsung login. Password disimpan mentah di sini karena
// Model User sudah punya cast "hashed" yang meng-hash-nya.
class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('akun')
            ->with('sukses', 'Selamat datang, ' . $user->name . '! Akunmu sudah dibuat.');
    }
}
