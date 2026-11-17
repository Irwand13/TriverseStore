<?php

namespace App\Http\Controllers;

use App\Models\TopUpOrder;
use Illuminate\Http\Request;

// Top up game versi demo: order dicatat ke database, tidak ada
// payment gateway. Kalau user login, order terikat ke akunnya
// supaya tampil di halaman Akun.
class TopUpController extends Controller
{
    public function create()
    {
        return view('topup.create', [
            'games' => $this->gameList(),
            'nominals' => $this->nominalList(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'game' => 'required|in:' . implode(',', array_keys($this->gameList())),
            'nominal' => 'required|integer|in:' . implode(',', array_keys($this->nominalList())),
            'game_user_id' => 'required|string|max:100',
        ]);

        $order = TopUpOrder::create([
            'user_id' => auth()->id(),
            'game' => $data['game'],
            'nominal' => $data['nominal'],
            'game_user_id' => $data['game_user_id'],
            'status' => 'Menunggu',
        ]);

        return redirect()->route('topup.show', $order->id)
            ->with('sukses', 'Order top up #' . $order->id . ' dicatat (demo).');
    }

    // Ringkasan satu order. Order milik user lain tidak
    // bisa dibuka; order tamu hanya bisa dibuka saat logout.
    public function show($id)
    {
        $order = TopUpOrder::findOrFail($id);

        if ($order->user_id !== null && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('topup.show', [
            'order' => $order,
            'mataUang' => $this->gameList()[$order->game],
        ]);
    }

    // Game dan mata uangnya, sesuai katalog top up umum.
    private function gameList(): array
    {
        return [
            'Mobile Legends' => 'Diamond',
            'Free Fire' => 'Diamond',
            'Genshin Impact' => 'Genesis Crystal',
            'Roblox' => 'Robux',
            'PUBG Mobile' => 'UC',
            'Honor of Kings' => 'Token',
            'Valorant' => 'Points',
            'Call of Duty: Mobile' => 'CP',
        ];
    }

    // Nominal rupiah yang bisa dipilih di form.
    private function nominalList(): array
    {
        return [
            10000 => 'Rp 10.000',
            20000 => 'Rp 20.000',
            50000 => 'Rp 50.000',
            100000 => 'Rp 100.000',
            150000 => 'Rp 150.000',
            250000 => 'Rp 250.000',
            500000 => 'Rp 500.000',
        ];
    }
}
