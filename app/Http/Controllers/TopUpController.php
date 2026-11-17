<?php

namespace App\Http\Controllers;

use App\Models\TopUpOrder;
use Illuminate\Http\Request;

// Top up game versi demo: order dicatat ke database, tidak ada
// payment gateway. Kalau user login, order terikat ke akunnya
// supaya tampil di halaman Akun.
//
// Form mengikuti pola Codashop: pilih game dulu, lalu pilih paket
// mata uang game itu (mis. "85 Diamond"). Harga paket TIDAK pernah
// dipercaya dari input client — server yang lookup dari tabel
// packageList() di bawah. Game yang harga paketnya belum
// terverifikasi (Roblox, Honor of Kings, Call of Duty: Mobile)
// tetap memakai tile nominal rupiah seperti sebelumnya.
class TopUpController extends Controller
{
    public function create()
    {
        return view('topup.create', [
            'games' => $this->gameList(),
            'packages' => $this->packagesForView(),
            'nominals' => $this->nominalList(),
            'tarifDiamond' => $this->diamondTariff(),
        ]);
    }

    public function store(Request $request)
    {
        $games = $this->gameList();

        $request->validate([
            'game' => 'required|in:' . implode(',', array_keys($games)),
            'game_user_id' => 'required|string|max:100',
        ], [
            'game.required' => 'Pilih game dulu.',
            'game.in' => 'Game yang dipilih tidak tersedia.',
            'game_user_id.required' => 'ID akun game wajib diisi.',
            'game_user_id.max' => 'ID akun game maksimal 100 karakter.',
        ]);

        $game = $request->input('game');
        $packages = $this->packageList();

        if (isset($packages[$game])) {
            $data = $request->validate([
                'paket' => 'required|in:' . implode(',', array_keys($packages[$game])),
            ], [
                'paket.required' => 'Pilih paket top up dulu.',
                'paket.in' => 'Paket yang dipilih tidak tersedia untuk game ini.',
            ]);

            $paket = $packages[$game][(int) $data['paket']];
            $nominal = $paket['harga'];
            $paketLabel = number_format($paket['jumlah'], 0, ',', '.') . ' ' . $games[$game];
        } else {
            $data = $request->validate([
                'nominal' => 'required|integer|in:' . implode(',', array_keys($this->nominalList())),
            ], [
                'nominal.required' => 'Pilih nominal top up dulu.',
                'nominal.in' => 'Nominal yang dipilih tidak tersedia.',
            ]);

            $nominal = (int) $data['nominal'];
            $paketLabel = null;
        }

        $order = TopUpOrder::create([
            'user_id' => auth()->id(),
            'game' => $game,
            'paket' => $paketLabel,
            'nominal' => $nominal,
            'game_user_id' => $request->input('game_user_id'),
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

    // Paket mata uang game per game, harga rupiah. Kunci = jumlah
    // mata uang; 'bonus' = rincian isi paket bila ada (mis. 300+30).
    //
    // Sumber harga, dicek 17 Nov 2026:
    // - Mobile Legends, Free Fire, PUBG Mobile, Valorant: Codashop.
    //   ML dicek 23 Okt 2026 dari halaman resmi Codashop (tidak
    //   berubah dari 13 Okt) dan dikonfirmasi Digidang 6 Okt 2026;
    //   FF dan Valorant dari halaman Codashop (crawl 13-16 Nov 2026);
    //   PUBG dari Digidang 6 Okt 2026 (halaman Codashop).
    // - Genshin Impact: itemku (halaman top up resmi, crawl 14 Nov
    //   2026), dicek silang dengan Codashop via Digidang 6 Okt 2026
    //   (selisihnya ~11% = PPN yang ditambahkan Codashop di checkout).
    // - Roblox, Honor of Kings, Call of Duty: Mobile: harga paket
    //   TIDAK terverifikasi dari Codashop/itemku (Codashop menjual
    //   Roblox sebagai gift card rupiah dan HoK sebagai voucher
    //   Midasbuy USD; CP CODM tidak ditemukan di Codashop) — ketiga
    //   game ini tetap memakai tile nominal rupiah.
    private function packageList(): array
    {
        return [
            'Mobile Legends' => [
                85 => ['jumlah' => 85, 'harga' => 25116, 'bonus' => null],
                170 => ['jumlah' => 170, 'harga' => 50232, 'bonus' => null],
                240 => ['jumlah' => 240, 'harga' => 70980, 'bonus' => null],
                296 => ['jumlah' => 296, 'harga' => 87360, 'bonus' => null],
                408 => ['jumlah' => 408, 'harga' => 120121, 'bonus' => null],
                568 => ['jumlah' => 568, 'harga' => 163800, 'bonus' => null],
                875 => ['jumlah' => 875, 'harga' => 251160, 'bonus' => null],
                2010 => ['jumlah' => 2010, 'harga' => 546000, 'bonus' => null],
            ],
            'Free Fire' => [
                50 => ['jumlah' => 50, 'harga' => 7207, 'bonus' => null],
                140 => ['jumlah' => 140, 'harga' => 18018, 'bonus' => null],
                355 => ['jumlah' => 355, 'harga' => 45045, 'bonus' => null],
                720 => ['jumlah' => 720, 'harga' => 90090, 'bonus' => null],
                1450 => ['jumlah' => 1450, 'harga' => 180180, 'bonus' => null],
                2180 => ['jumlah' => 2180, 'harga' => 270270, 'bonus' => null],
            ],
            'Genshin Impact' => [
                60 => ['jumlah' => 60, 'harga' => 16468, 'bonus' => null],
                330 => ['jumlah' => 330, 'harga' => 80844, 'bonus' => '300 + 30 bonus'],
                1090 => ['jumlah' => 1090, 'harga' => 254509, 'bonus' => '980 + 110 bonus'],
                2240 => ['jumlah' => 2240, 'harga' => 488058, 'bonus' => '1.980 + 260 bonus'],
                3880 => ['jumlah' => 3880, 'harga' => 813432, 'bonus' => '3.280 + 600 bonus'],
                8080 => ['jumlah' => 8080, 'harga' => 1652261, 'bonus' => '6.480 + 1.600 bonus'],
            ],
            'PUBG Mobile' => [
                60 => ['jumlah' => 60, 'harga' => 19000, 'bonus' => null],
                325 => ['jumlah' => 325, 'harga' => 95000, 'bonus' => '300 + 25 bonus'],
                660 => ['jumlah' => 660, 'harga' => 190000, 'bonus' => '600 + 60 bonus'],
                1800 => ['jumlah' => 1800, 'harga' => 475000, 'bonus' => '1.500 + 300 bonus'],
            ],
            'Valorant' => [
                475 => ['jumlah' => 475, 'harga' => 56000, 'bonus' => null],
                1000 => ['jumlah' => 1000, 'harga' => 112000, 'bonus' => null],
                2050 => ['jumlah' => 2050, 'harga' => 224000, 'bonus' => null],
                3650 => ['jumlah' => 3650, 'harga' => 389000, 'bonus' => null],
                5350 => ['jumlah' => 5350, 'harga' => 559000, 'bonus' => null],
                11000 => ['jumlah' => 11000, 'harga' => 1099000, 'bonus' => null],
            ],
        ];
    }

    // Paket yang sama dengan packageList(), ditambah harga per unit
    // (dibulatkan) untuk ditampilkan di tile.
    private function packagesForView(): array
    {
        $packages = $this->packageList();

        foreach ($packages as $game => $daftar) {
            foreach ($daftar as $kunci => $paket) {
                $packages[$game][$kunci]['perUnit'] = (int) round($paket['harga'] / $paket['jumlah']);
            }
        }

        return $packages;
    }

    // Nominal rupiah untuk game tanpa paket terverifikasi.
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
    // dicek 17 Nov 2026). Hanya dipakai sebagai garis kecil di tile
    // nominal fallback (game tanpa paket); estimasi dibulatkan ke
    // bawah, pakai tanda ±.
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
}
