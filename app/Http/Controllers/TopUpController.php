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
            'tarifDiamond' => $this->diamondTariff(),
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
            'estimasiDiamond' => $this->diamondEstimate($order->nominal),
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

    // Tarif perkiraan Diamond Mobile Legends per nominal rupiah,
    // dari riset harga pasar (Codashop, itemku, VYGaming, Sehtzone —
    // dicek 17 Nov 2026). Estimasi dibulatkan ke bawah, pakai tanda ±.
    // Satu sumber angka: create + show membaca tabel yang sama.
    private function diamondTariff(): array
    {
        return [
            10000 => ['diamond' => 42, 'perDiamond' => 238],
            20000 => ['diamond' => 85, 'perDiamond' => 238],
            50000 => ['diamond' => 213, 'perDiamond' => 235],
            100000 => ['diamond' => 426, 'perDiamond' => 235],
            150000 => ['diamond' => 638, 'perDiamond' => 234],
            250000 => ['diamond' => 1064, 'perDiamond' => 232],
            500000 => ['diamond' => 2128, 'perDiamond' => 228],
        ];
    }

    // Estimasi Diamond ML untuk satu nominal rupiah.
    private function diamondEstimate(int $nominal): array
    {
        return $this->diamondTariff()[$nominal] ?? ['diamond' => 0, 'perDiamond' => 0];
    }
}
