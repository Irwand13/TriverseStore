<?php
/* ============================================================
   TriverseStore — Data Produk sebagai OBJEK (Week 6 · Sprint 05)
   Dataset kanonis yang sama seperti week sebelumnya (lihat
   ../DATASET.md), tetapi kini dibungkus objek: lima objek Seller
   dibuat sekali, lalu sepuluh objek Game memegang seller-nya
   masing-masing (W6.2: object dibuat dengan `new`, relasi
   antar-object).
   ============================================================ */

require_once __DIR__ . '/../classes/Game.php';
require_once __DIR__ . '/../classes/Seller.php';

$sellers = [
    'S1' => new Seller('RakaStore_ID', 4.9, 2314, 'Jakarta'),
    'S2' => new Seller('NadiaGameShop', 4.8, 1872, 'Bandung'),
    'S3' => new Seller('VortexID', 4.9, 986, 'Surabaya'),
    'S4' => new Seller('SultanPlay', 4.7, 754, 'Medan'),
    'S5' => new Seller('BloxMart ID', 4.8, 3102, 'Yogyakarta'),
];

/** @var Game[] $products */
$products = [
    new Game('P1', 'Akun Mobile Legends Mythical Glory — 87 Skin', 'Mobile Legends: Bang Bang', 'MOBA', 'mobile-legends.jpg', 850000, 15, 'Tersedia',
        '87 skin termasuk Epic dan Collector, semua emblem maksimal, win rate 68%.',
        'Akun pribadi tangan pertama, win rate 68% dari 4.300 pertandingan. Semua emblem sudah maksimal dan 87 skin termasuk seri Epic dan Collector.',
        'Android / iOS', 'Mythical Glory, 1.240 poin', 'Skin Epic Layla "Miss Hikari", emblem maks', $sellers['S1']),
    new Game('P2', 'Akun Genshin Impact AR 58 — 12 Karakter Bintang 5', 'Genshin Impact', 'RPG', 'genshin-impact.jpg', 1450000, 0, 'Tersedia',
        '12 karakter bintang 5 dengan artefak rapi, siap Spiral Abyss lantai 12.',
        'Eksplorasi map 90%+, artefak rapi siap Spiral Abyss lantai 12. Primogem sisa 4.800 dan resin selalu terpakai wajar.',
        'PC / Android / iOS', 'Adventure Rank 58', 'Raiden Shogun C2, Nahida, 12 karakter bintang 5', $sellers['S2']),
    new Game('P3', 'Akun Valorant Immortal — Bundle Glitchpop', 'Valorant', 'FPS', 'valorant.jpg', 2700000, 10, 'Tersedia',
        'Akun Episode 1 dengan bundle Glitchpop dan 54 skin, MMR tinggi.',
        'Akun dari season pertama (Episode 1) dengan badge langka. MMR tinggi, riwayat bersih tanpa sanksi, siap push Radiant.',
        'PC', 'Immortal 3, 412 RR', 'Bundle Glitchpop, Vandal Prime, 54 skin', $sellers['S3']),
    new Game('P4', 'Akun Apex Legends Predator — Heirloom Wraith', 'Apex Legends', 'Battle Royale', 'apex-legends.jpg', 1150000, 0, 'Stok Terbatas',
        'Heirloom Wraith dan 42 skin legendaris, badge 20-bomb di tiga legend.',
        'Akun Predator dengan heirloom Wraith dan 42 skin legendaris. Badge 20-bomb dan 4K damage di tiga legend berbeda.',
        'PC / PS / Xbox', 'Apex Predator, 21.400 kill', 'Heirloom Kunai Wraith, 42 skin legendaris', $sellers['S4']),
    new Game('P5', 'Akun Free Fire Grandmaster — Vault 400+ Item', 'Free Fire', 'Battle Royale', 'free-fire.jpg', 675000, 25, 'Tersedia',
        'Vault 400+ item hasil top up resmi, 4 evo gun dan emote langka.',
        'Koleksi vault besar hasil top up resmi sejak 2021. Evo gun 4 biji dan emote langka lengkap.',
        'Android / iOS', 'Grandmaster', 'Vault 400+ item, bundle Cobra', $sellers['S1']),
    new Game('P6', 'Akun GTA V Online Rank 218 — Aset Lengkap', 'Grand Theft Auto V', 'Aksi', 'gta-v.jpg', 425000, 0, 'Tersedia',
        'Semua bisnis aktif dan garasi 40+ mobil modif, uang sisa $GTA 18 juta.',
        'Akun GTA Online mapan: semua bisnis aktif, garasi berisi 40+ mobil hasil modifikasi, uang sisa $GTA 18 juta.',
        'PC (Steam)', 'Rank 218', 'Bunker, Nightclub, 40+ mobil modif', $sellers['S5']),
    new Game('P7', 'Akun eFootball Dream Team 3150 — Full Epic', 'eFootball', 'Olahraga', 'efootball.jpg', 560000, 20, 'Tersedia',
        'Skuad Dream Team kekuatan 3150 berisi kartu Epic dan Big Time.',
        'Skuad Dream Team kekuatan 3150 dengan pemain Epic dan Big Time. Koin sisa 1.200 untuk gacha berikutnya.',
        'Android / iOS / PS', 'Kekuatan tim 3150', 'Kartu Epic Messi, Neymar, Rummenigge', $sellers['S2']),
    new Game('P8', 'Akun Honkai: Star Rail TL 70 — 9 Karakter Bintang 5', 'Honkai: Star Rail', 'RPG', 'honkai-star-rail.jpg', 980000, 0, 'Terjual',
        'Akun endgame, semua konten selesai termasuk Apocalyptic Shadow.',
        'Akun endgame, semua konten selesai termasuk Apocalyptic Shadow. Status: sudah terjual.',
        'PC / Android / iOS', 'Trailblaze Level 70', 'Acheron E2, Firefly, 9 karakter bintang 5', $sellers['S3']),
    new Game('P9', 'Akun Zenless Zone Zero Inter-Knot 55 — Miyabi & Yanagi', 'Zenless Zone Zero', 'RPG', 'zenless-zone-zero.jpg', 1275000, 15, 'Stok Terbatas',
        'Trio agen S-Rank meta sekarang: Miyabi, Yanagi, dan Astra Yao.',
        'Trio agen S-Rank meta sekarang. Hollow Zero dan Shiyu Defense tembus penuh tiap reset.',
        'PC / Android / iOS', 'Inter-Knot Level 55', 'Miyabi, Yanagi, Astra Yao', $sellers['S4']),
    new Game('P10', 'Akun Elden Ring Level 312 — Semua Remembrance', 'Elden Ring', 'RPG', 'elden-ring.jpg', 890000, 0, 'Tersedia',
        'Semua Remembrance terkumpul dan 9 senjata legendaris level maksimal.',
        'Build lengkap siap DLC: semua Remembrance terkumpul, 9 senjata legendaris +10, dan material upgrade melimpah.',
        'PC / PS', 'Level 312, NG+3', 'Semua senjata legendaris, set Malenia', $sellers['S5']),
];

/** Mencari satu objek Game berdasarkan id; null bila tidak ditemukan. */
function cariProduk(array $products, string $id): ?Game
{
    foreach ($products as $produk) {
        if ($produk->getId() === $id) {
            return $produk;
        }
    }
    return null;
}
