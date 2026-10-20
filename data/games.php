<?php
// DATA CONTOH untuk prototipe. Nama game adalah milik masing-masing penerbit;
// situs ini tidak berafiliasi dengan mereka. Sampul digambar otomatis (bukan artwork resmi).
// Key = slug di URL (game-detail.php?id=<slug>). 'art' = [latar, bentuk, aksen, motif].
// Untuk memakai gambar sendiri: tambahkan 'image' => 'nama.jpg' (file di assets/images/).
return [
    'mobile-legends' => [
        'title' => 'Mobile Legends: Bang Bang', 'category' => 'MOBA', 'genre' => 'MOBA 5 lawan 5',
        'developer' => 'Moonton', 'year' => 2016, 'platforms' => ['Android', 'iOS'], 'modes' => 'Multipemain online',
        'description' => 'Game MOBA untuk ponsel dengan pertandingan singkat, banyak pilihan hero, dan mode ranked. Cocok dimainkan bersama tim atau teman.',
        'tags' => ['tim', 'kompetitif', 'ponsel'], 'featured' => true,
        'art' => ['#14264f', '#5b8cff', '#ffd166', 'crystal'],
    ],
    'free-fire' => [
        'title' => 'Free Fire', 'category' => 'Battle Royale', 'genre' => 'Battle royale',
        'developer' => 'Garena', 'year' => 2017, 'platforms' => ['Android', 'iOS'], 'modes' => 'Multipemain online',
        'description' => 'Battle royale untuk ponsel dengan pertandingan singkat dan karakter berkemampuan khusus. Bisa dimainkan solo, duo, atau skuad.',
        'tags' => ['battle royale', 'tim', 'ponsel'], 'featured' => false,
        'art' => ['#3b1d12', '#ff8a4c', '#ffd166', 'island'],
    ],
    'pubg-mobile' => [
        'title' => 'PUBG Mobile', 'category' => 'Battle Royale', 'genre' => 'Battle royale realistis',
        'developer' => 'Krafton', 'year' => 2018, 'platforms' => ['Android', 'iOS'], 'modes' => 'Multipemain online',
        'description' => 'Battle royale dengan peta luas, kendaraan, dan gaya bermain yang lebih realistis. Tersedia mode solo hingga skuad.',
        'tags' => ['battle royale', 'tim', 'ponsel'], 'featured' => false,
        'art' => ['#252c18', '#9bb34a', '#ffb454', 'zone'],
    ],
    'genshin-impact' => [
        'title' => 'Genshin Impact', 'category' => 'RPG', 'genre' => 'RPG dunia terbuka',
        'developer' => 'HoYoverse', 'year' => 2020, 'platforms' => ['Android', 'iOS', 'PC', 'PlayStation'], 'modes' => 'Single-player, co-op',
        'description' => 'RPG dunia terbuka dengan banyak karakter yang bisa dikumpulkan dan dipadukan dalam satu tim. Bisa dimainkan sendiri atau bersama teman.',
        'tags' => ['dunia terbuka', 'cerita', 'koleksi karakter'], 'featured' => false,
        'art' => ['#0f3d4a', '#7fe3d0', '#ffe08a', 'floating'],
    ],
    'honkai-star-rail' => [
        'title' => 'Honkai: Star Rail', 'category' => 'RPG', 'genre' => 'RPG turn-based',
        'developer' => 'HoYoverse', 'year' => 2023, 'platforms' => ['Android', 'iOS', 'PC'], 'modes' => 'Single-player',
        'description' => 'RPG turn-based bertema perjalanan antarbintang, dengan pertempuran bergiliran dan cerita yang berjalan lewat banyak dunia.',
        'tags' => ['turn-based', 'cerita', 'koleksi karakter'], 'featured' => false,
        'art' => ['#1a1b3a', '#8aa4ff', '#ffb3e6', 'rail'],
    ],
    'valorant' => [
        'title' => 'Valorant', 'category' => 'Shooter', 'genre' => 'Shooter taktis 5 lawan 5',
        'developer' => 'Riot Games', 'year' => 2020, 'platforms' => ['PC'], 'modes' => 'Multipemain online',
        'description' => 'Game tembak-menembak taktis di mana tiap agen punya kemampuan khusus. Satu ronde menuntut koordinasi dan penguasaan peta.',
        'tags' => ['tim', 'kompetitif', 'taktis'], 'featured' => false,
        'art' => ['#3a0f1a', '#ff4d5e', '#f4efe6', 'agent'],
    ],
    'call-of-duty-mobile' => [
        'title' => 'Call of Duty: Mobile', 'category' => 'Shooter', 'genre' => 'Shooter multipemain',
        'developer' => 'TiMi Studio Group', 'year' => 2019, 'platforms' => ['Android', 'iOS'], 'modes' => 'Multipemain online',
        'description' => 'Game tembak-menembak yang membawa mode multipemain dan battle royale ke ponsel dengan kontrol yang bisa disesuaikan.',
        'tags' => ['tim', 'kompetitif', 'ponsel'], 'featured' => false,
        'art' => ['#18231a', '#6fbf73', '#ffcf5a', 'ops'],
    ],
    'clash-of-clans' => [
        'title' => 'Clash of Clans', 'category' => 'Strategi', 'genre' => 'Strategi membangun desa',
        'developer' => 'Supercell', 'year' => 2012, 'platforms' => ['Android', 'iOS'], 'modes' => 'Online, klan',
        'description' => 'Bangun desa, latih pasukan, lalu serang desa pemain lain atau bergabung dalam klan untuk perang antarklan.',
        'tags' => ['strategi', 'klan', 'ponsel'], 'featured' => false,
        'art' => ['#1d3a2a', '#7bd16b', '#ffd34d', 'castle'],
    ],
];
