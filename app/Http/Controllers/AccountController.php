<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Halaman Akun: profil user login, listing yang ia buat,
// dan order top up miliknya.
class AccountController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        return view('akun', [
            'user' => $user,
            'listingSaya' => $user->products()->orderByDesc('id')->get(),
            'topupSaya' => $user->topUpOrders()->orderByDesc('id')->get(),
        ]);
    }
}
