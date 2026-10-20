<?php
// SAMPLE LISTINGS. Fictional accounts, sellers and prices.
// 'game' must be a slug from data/games.php. Passwords and login credentials are
// deliberately NOT part of this data and must never be shown on a listing page.
// status: available | reserved | sold      category: Starter | Mid-game | Endgame | Collector
return [
    'ashfall-lv48-pilgrim' => [
        'title' => 'Level 48 pilgrim, northern shrine unlocked', 'game' => 'ashfall-pilgrim', 'category' => 'Mid-game',
        'price' => 850000, 'status' => 'available', 'level' => 'Level 48', 'region' => 'Asia', 'login' => 'Email-linked',
        'items' => ['Ember sword (rare)', '6 of 9 settlements allied', 'Full coastal map revealed'],
        'description' => 'A steady mid-game save that has finished the coastal chapters. The northern shrine route is open, so the next story arc can start right away.',
        'seller' => 'mira_kayu', 'listed' => '2026-10-15',
    ],
    'ashfall-lv12-fresh' => [
        'title' => 'Fresh start with early gear pack', 'game' => 'ashfall-pilgrim', 'category' => 'Starter',
        'price' => 150000, 'status' => 'available', 'level' => 'Level 12', 'region' => 'Asia', 'login' => 'Email-linked',
        'items' => ['Starter armour set', 'Tutorial region cleared'],
        'description' => 'A lightly played account for someone who wants to skip the tutorial hours. Nothing rare, which is reflected in the price.',
        'seller' => 'dimas_play', 'listed' => '2026-10-10',
    ],
    'vanta-diamond-rank' => [
        'title' => 'Diamond-rank operator roster, all agents', 'game' => 'vanta-sector', 'category' => 'Endgame',
        'price' => 2750000, 'status' => 'available', 'level' => 'Rank Diamond', 'region' => 'Asia', 'login' => 'Social login',
        'items' => ['All 18 operators unlocked', '40 weapon skins', 'Two seasonal event sets'],
        'description' => 'A fully unlocked roster at a competitive rank. The seller notes the account has no past penalties.',
        'seller' => 'rafi_vanta', 'listed' => '2026-10-17',
    ],
    'vanta-gold-starter' => [
        'title' => 'Gold-rank account with six operators', 'game' => 'vanta-sector', 'category' => 'Mid-game',
        'price' => 520000, 'status' => 'reserved', 'level' => 'Rank Gold', 'region' => 'Asia', 'login' => 'Email-linked',
        'items' => ['6 operators unlocked', '12 weapon skins'],
        'description' => 'A good base for a player who wants to start ranked play without grinding for operators.',
        'seller' => 'nanda_g', 'listed' => '2026-10-05',
    ],
    'glasswing-completionist' => [
        'title' => 'Completed story, all party members maxed', 'game' => 'glasswing-saga', 'category' => 'Endgame',
        'price' => 1900000, 'status' => 'available', 'level' => 'Level 90', 'region' => 'Global', 'login' => 'Email-linked',
        'items' => ['All 12 party members at max level', 'Every side quest finished', 'New Game+ unlocked'],
        'description' => 'A finished save, useful for players who want to try late-game builds instead of replaying the whole story.',
        'seller' => 'sari_wing', 'listed' => '2026-09-29',
    ],
    'glasswing-early-party' => [
        'title' => 'Chapter 3 save with four party members', 'game' => 'glasswing-saga', 'category' => 'Starter',
        'price' => 200000, 'status' => 'sold', 'level' => 'Level 21', 'region' => 'Global', 'login' => 'Email-linked',
        'items' => ['4 party members', 'Chapter 3 reached'],
        'description' => 'This listing has been sold and stays visible as an example of how sold items are marked.',
        'seller' => 'sari_wing', 'listed' => '2026-09-18',
    ],
    'redline-garage-collector' => [
        'title' => 'Garage of 31 cars including limited liveries', 'game' => 'redline-harbor', 'category' => 'Collector',
        'price' => 3200000, 'status' => 'available', 'level' => 'Level 70', 'region' => 'Asia', 'login' => 'Social login',
        'items' => ['31 cars', '5 limited-edition liveries', 'Harbor season champion title'],
        'description' => 'Built for collectors rather than racers. The limited liveries are no longer obtainable in the current season.',
        'seller' => 'bayu_redline', 'listed' => '2026-10-12',
    ],
    'lantern-veteran' => [
        'title' => 'Veteran lantern-bearer with rare light skins', 'game' => 'hollow-lantern', 'category' => 'Mid-game',
        'price' => 430000, 'status' => 'available', 'level' => 'Level 35', 'region' => 'Asia', 'login' => 'Email-linked',
        'items' => ['3 rare lantern skins', 'All four roles unlocked'],
        'description' => 'A co-op account with every role unlocked, which makes it easy to fill whichever slot your group needs.',
        'seller' => 'putri_dusk', 'listed' => '2026-10-14',
    ],
    'brickwork-grand-charter' => [
        'title' => 'Grand Charter town, three seasons in', 'game' => 'brickwork-kingdoms', 'category' => 'Endgame',
        'price' => 1250000, 'status' => 'reserved', 'level' => 'Town level 20', 'region' => 'Global', 'login' => 'Email-linked',
        'items' => ['Grand Charter unlocked', 'All trade routes open', '2 exclusive banners'],
        'description' => 'A mature town with every trade route open, ready for the late-game defense scenarios.',
        'seller' => 'agus_brick', 'listed' => '2026-10-02',
    ],
    'night-courier-starter' => [
        'title' => 'Starter scooter set, first district cleared', 'game' => 'night-courier', 'category' => 'Starter',
        'price' => 175000, 'status' => 'available', 'level' => 'Level 9', 'region' => 'Asia', 'login' => 'Social login',
        'items' => ['3 scooters', 'First district cleared'],
        'description' => 'A small account for trying the game with a few upgrades already in place.',
        'seller' => 'dimas_play', 'listed' => '2026-10-18',
    ],
];
