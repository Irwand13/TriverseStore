<?php
// KONFIGURASI TOP UP CONTOH. Harga dan nominal hanya contoh, bukan harga resmi.
// Format ID juga perkiraan; cek ke dokumentasi penyedia sebelum dipakai sungguhan.
// 'server' bisa berupa kolom teks ('pattern') atau pilihan ('options').
// Nanti data ini datang dari database atau API penyedia. Belum ada yang terhubung.
return [
    'mobile-legends' => [
        'currency' => 'Diamond',
        'user_label' => 'User ID', 'user_hint' => '8 sampai 10 digit angka. Biasanya terlihat di menu profil dalam game.', 'user_pattern' => '/^\d{8,10}$/',
        'server' => ['label' => 'Zone ID', 'hint' => '4 atau 5 digit angka, tertulis di samping User ID.', 'pattern' => '/^\d{4,5}$/'],
        'packages' => [['86 Diamond', 22000], ['172 Diamond', 44000], ['257 Diamond', 65000], ['706 Diamond', 175000], ['2.195 Diamond', 530000]],
    ],
    'free-fire' => [
        'currency' => 'Diamond',
        'user_label' => 'Player ID', 'user_hint' => '9 sampai 11 digit angka. Biasanya terlihat di menu profil dalam game.', 'user_pattern' => '/^\d{9,11}$/',
        'server' => null,
        'packages' => [['50 Diamond', 8000], ['100 Diamond', 15000], ['310 Diamond', 45000], ['520 Diamond', 75000], ['1.060 Diamond', 150000]],
    ],
    'pubg-mobile' => [
        'currency' => 'UC',
        'user_label' => 'Player ID', 'user_hint' => '8 sampai 12 digit angka. Biasanya terlihat di menu profil dalam game.', 'user_pattern' => '/^\d{8,12}$/',
        'server' => null,
        'packages' => [['60 UC', 15000], ['325 UC', 75000], ['660 UC', 150000], ['1.800 UC', 400000]],
    ],
    'genshin-impact' => [
        'currency' => 'Genesis Crystal',
        'user_label' => 'UID', 'user_hint' => '9 digit angka. Biasanya terlihat di pojok layar atau menu profil.', 'user_pattern' => '/^\d{9}$/',
        'server' => ['label' => 'Server', 'options' => ['Asia', 'Eropa', 'Amerika', 'TW/HK/MO']],
        'packages' => [['60 Genesis Crystal', 16000], ['330 Genesis Crystal', 79000], ['1.090 Genesis Crystal', 249000], ['2.240 Genesis Crystal', 479000]],
    ],
    'honkai-star-rail' => [
        'currency' => 'Oneiric Shard',
        'user_label' => 'UID', 'user_hint' => '9 digit angka. Biasanya terlihat di menu profil dalam game.', 'user_pattern' => '/^\d{9}$/',
        'server' => ['label' => 'Server', 'options' => ['Asia', 'Eropa', 'Amerika', 'TW/HK/MO']],
        'packages' => [['60 Oneiric Shard', 16000], ['330 Oneiric Shard', 79000], ['1.090 Oneiric Shard', 249000]],
    ],
];
