<?php
// LISTING CONTOH. Akun, penjual, dan harga hanya fiktif.
// 'game' harus slug dari data/games.php. Kata sandi/kredensial login SENGAJA tidak ada di data ini
// dan tidak boleh ditampilkan di halaman listing.
// status: available | reserved | sold      category: Pemula | Menengah | Lanjutan | Koleksi
return [
    'mlbb-mythic-72-hero' => [
        'title' => 'Rank Mythic, 72 hero dan 90 skin', 'game' => 'mobile-legends', 'category' => 'Lanjutan',
        'price' => 2400000, 'status' => 'available', 'level' => 'Rank Mythic', 'region' => 'Indonesia', 'login' => 'Terhubung via email',
        'items' => ['72 hero terbuka', '90 skin', 'Emblem sudah dinaikkan'],
        'description' => 'Akun ranked yang aktif dengan koleksi hero luas, jadi pemilik baru bisa langsung bermain tanpa mengumpulkan hero dari awal.',
        'seller' => 'rizky_mlbb', 'listed' => '2026-10-17',
    ],
    'mlbb-epic-45-hero' => [
        'title' => 'Rank Epic dengan 45 hero', 'game' => 'mobile-legends', 'category' => 'Menengah',
        'price' => 650000, 'status' => 'available', 'level' => 'Rank Epic', 'region' => 'Indonesia', 'login' => 'Terhubung via email',
        'items' => ['45 hero terbuka', '20 skin'],
        'description' => 'Akun tengah-tengah yang cocok sebagai dasar untuk mulai naik rank.',
        'seller' => 'nanda_g', 'listed' => '2026-10-11',
    ],
    'mlbb-warrior-baru' => [
        'title' => 'Akun baru dengan beberapa hero dasar', 'game' => 'mobile-legends', 'category' => 'Pemula',
        'price' => 120000, 'status' => 'sold', 'level' => 'Rank Warrior', 'region' => 'Indonesia', 'login' => 'Terhubung via email',
        'items' => ['12 hero terbuka'],
        'description' => 'Listing ini sudah terjual dan tetap ditampilkan sebagai contoh bagaimana status "Terjual" ditandai.',
        'seller' => 'dimas_play', 'listed' => '2026-09-20',
    ],
    'ff-heroic-koleksi' => [
        'title' => 'Rank Heroic dengan bundle langka', 'game' => 'free-fire', 'category' => 'Koleksi',
        'price' => 1800000, 'status' => 'available', 'level' => 'Rank Heroic', 'region' => 'Indonesia', 'login' => 'Login sosial',
        'items' => ['6 bundle langka', '25 senjata skin', 'Koleksi karakter lengkap'],
        'description' => 'Dibuat untuk kolektor. Beberapa bundle di akun ini tidak lagi dijual di toko dalam game.',
        'seller' => 'bayu_ff', 'listed' => '2026-10-14',
    ],
    'ff-gold-menengah' => [
        'title' => 'Rank Gold dengan 8 karakter', 'game' => 'free-fire', 'category' => 'Menengah',
        'price' => 350000, 'status' => 'reserved', 'level' => 'Rank Gold', 'region' => 'Indonesia', 'login' => 'Login sosial',
        'items' => ['8 karakter', '10 senjata skin'],
        'description' => 'Akun siap main dengan beberapa karakter pilihan, cocok untuk pemain yang ingin berlatih di mode ranked.',
        'seller' => 'putri_ff', 'listed' => '2026-10-06',
    ],
    'pubg-conqueror-langka' => [
        'title' => 'Rank Conqueror, set pakaian langka', 'game' => 'pubg-mobile', 'category' => 'Lanjutan',
        'price' => 3100000, 'status' => 'available', 'level' => 'Rank Conqueror', 'region' => 'Asia', 'login' => 'Terhubung via email',
        'items' => ['Set pakaian langka', 'Skin senjata level maksimal', 'Banyak kartu pengaturan nama'],
        'description' => 'Akun ranked tinggi dengan koleksi kosmetik yang sulit didapat lagi di musim sekarang.',
        'seller' => 'agus_pubg', 'listed' => '2026-10-12',
    ],
    'genshin-ar55' => [
        'title' => 'Adventure Rank 55, 18 karakter bintang 5', 'game' => 'genshin-impact', 'category' => 'Lanjutan',
        'price' => 2900000, 'status' => 'available', 'level' => 'Adventure Rank 55', 'region' => 'Asia', 'login' => 'Terhubung via email',
        'items' => ['18 karakter bintang 5', 'Beberapa senjata bintang 5', 'Peta dunia hampir lengkap'],
        'description' => 'Akun tahap akhir dengan banyak karakter, cocok untuk pemain yang ingin mencoba berbagai susunan tim tanpa mengulang dari awal.',
        'seller' => 'sari_wing', 'listed' => '2026-10-15',
    ],
    'genshin-ar30' => [
        'title' => 'Adventure Rank 30 dengan 5 karakter bintang 5', 'game' => 'genshin-impact', 'category' => 'Menengah',
        'price' => 700000, 'status' => 'reserved', 'level' => 'Adventure Rank 30', 'region' => 'Asia', 'login' => 'Terhubung via email',
        'items' => ['5 karakter bintang 5', 'Quest utama bab awal selesai'],
        'description' => 'Akun tengah dengan beberapa karakter kuat dan cerita yang masih panjang untuk dijalani.',
        'seller' => 'mira_kayu', 'listed' => '2026-10-04',
    ],
    'hsr-tl60' => [
        'title' => 'Trailblaze Level 60, cerita utama tamat', 'game' => 'honkai-star-rail', 'category' => 'Menengah',
        'price' => 950000, 'status' => 'available', 'level' => 'Trailblaze Level 60', 'region' => 'Asia', 'login' => 'Terhubung via email',
        'items' => ['10 karakter bintang 5', 'Cerita utama tamat'],
        'description' => 'Akun dengan cerita utama yang sudah selesai dan tim yang seimbang untuk mode endgame.',
        'seller' => 'putri_dusk', 'listed' => '2026-10-18',
    ],
    'valorant-immortal-koleksi' => [
        'title' => 'Rank Immortal dengan koleksi skin senjata', 'game' => 'valorant', 'category' => 'Lanjutan',
        'price' => 2200000, 'status' => 'available', 'level' => 'Rank Immortal', 'region' => 'Asia Pasifik', 'login' => 'Terhubung via email',
        'items' => ['Banyak skin senjata', 'Semua agen terbuka'],
        'description' => 'Akun ranked tinggi dengan semua agen terbuka, jadi tidak perlu mengumpulkan agen dari awal.',
        'seller' => 'rafi_vanta', 'listed' => '2026-10-09',
    ],
];
