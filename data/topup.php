<?php
// SAMPLE TOP-UP CONFIG. Fictional currencies and prices. Key = game slug from data/games.php.
// user_pattern / server_pattern describe what a valid ID looks like for that game.
// Later this comes from the database or a provider API; no provider is connected now.
return [
    'ashfall-pilgrim' => [
        'currency' => 'Ember Shards',
        'user_label' => 'Pilgrim ID', 'user_hint' => '8 to 10 digits, shown on the profile screen.', 'user_pattern' => '/^\d{8,10}$/',
        'server' => null,
        'packages' => [['60 Ember Shards', 16000], ['300 Ember Shards', 78000], ['680 Ember Shards', 155000], ['1,500 Ember Shards', 320000]],
    ],
    'vanta-sector' => [
        'currency' => 'Void Credits',
        'user_label' => 'Operator ID', 'user_hint' => '9 digits, shown under your name in the lobby.', 'user_pattern' => '/^\d{9}$/',
        'server' => ['label' => 'Server ID', 'hint' => '3 or 4 digits, shown next to the Operator ID.', 'pattern' => '/^\d{3,4}$/'],
        'packages' => [['100 Void Credits', 14000], ['310 Void Credits', 42000], ['520 Void Credits', 70000], ['1,060 Void Credits', 140000], ['2,180 Void Credits', 280000]],
    ],
    'glasswing-saga' => [
        'currency' => 'Prisms',
        'user_label' => 'Player ID', 'user_hint' => '7 to 9 digits, found in Settings under Account.', 'user_pattern' => '/^\d{7,9}$/',
        'server' => null,
        'packages' => [['80 Prisms', 15000], ['330 Prisms', 60000], ['1,090 Prisms', 190000], ['2,240 Prisms', 380000]],
    ],
    'redline-harbor' => [
        'currency' => 'Nitro Coins',
        'user_label' => 'Driver ID', 'user_hint' => '10 digits, shown on the garage screen.', 'user_pattern' => '/^\d{10}$/',
        'server' => null,
        'packages' => [['500 Nitro Coins', 12000], ['1,200 Nitro Coins', 28000], ['2,600 Nitro Coins', 58000], ['6,000 Nitro Coins', 125000]],
    ],
    'night-courier' => [
        'currency' => 'Fuel Tokens',
        'user_label' => 'Courier ID', 'user_hint' => '6 to 8 digits, shown on the delivery board.', 'user_pattern' => '/^\d{6,8}$/',
        'server' => null,
        'packages' => [['50 Fuel Tokens', 10000], ['150 Fuel Tokens', 29000], ['400 Fuel Tokens', 75000]],
    ],
    'low-tide-protocol' => [
        'currency' => 'Pearls',
        'user_label' => 'Commander ID', 'user_hint' => '8 digits, shown on the fleet screen.', 'user_pattern' => '/^\d{8}$/',
        'server' => ['label' => 'Region code', 'hint' => '2 or 3 digits, shown beside the Commander ID.', 'pattern' => '/^\d{2,3}$/'],
        'packages' => [['120 Pearls', 20000], ['600 Pearls', 95000], ['1,300 Pearls', 200000], ['3,000 Pearls', 450000]],
    ],
];
