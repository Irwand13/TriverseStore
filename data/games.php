<?php
// SAMPLE DATA. All titles, studios and descriptions are fictional.
// Key = slug used in URLs (game-detail.php?id=<slug>).
// 'art' = [background, shape, accent, motif] drives the generated cover.
// To use a real image later, add 'image' => 'filename.jpg' (file in assets/images/).
return [
    'ashfall-pilgrim' => [
        'title' => 'Ashfall Pilgrim', 'category' => 'RPG', 'genre' => 'Open-world action RPG',
        'developer' => 'Cinderwake Studio', 'year' => 2025, 'platforms' => ['PC', 'Console'], 'modes' => 'Single-player',
        'description' => 'Walk a volcanic coastline toward a shrine that is slowly sinking. Each settlement you help changes which routes stay open, so no two journeys end at the same gate.',
        'tags' => ['exploration', 'story', 'crafting'], 'featured' => true,
        'art' => ['#3a1a12', '#e0703a', '#f2b632', 'peaks'],
    ],
    'low-tide-protocol' => [
        'title' => 'Low Tide Protocol', 'category' => 'Strategy', 'genre' => 'Naval tactics',
        'developer' => 'Saltmarsh Interactive', 'year' => 2024, 'platforms' => ['PC'], 'modes' => 'Single-player, online versus',
        'description' => 'Command a small fleet in shallow waters where the tide redraws the map every few turns. Short matches reward planning two moves ahead.',
        'tags' => ['turn-based', 'naval', 'competitive'], 'featured' => false,
        'art' => ['#0c2f3a', '#3fa7a0', '#f2b632', 'waves'],
    ],
    'quiet-signal' => [
        'title' => 'Quiet Signal', 'category' => 'Puzzle', 'genre' => 'Audio puzzle',
        'developer' => 'Mossy Pixel', 'year' => 2023, 'platforms' => ['PC', 'Mobile'], 'modes' => 'Single-player',
        'description' => 'Tune a failing radio station by ear, piecing together a mystery from fragments of broadcasts. Headphones recommended.',
        'tags' => ['mystery', 'relaxed', 'audio'], 'featured' => false,
        'art' => ['#1d2a3d', '#8fb4d9', '#f2b632', 'rings'],
    ],
    'redline-harbor' => [
        'title' => 'Redline Harbor', 'category' => 'Racing', 'genre' => 'Arcade street racing',
        'developer' => 'Redline Labs', 'year' => 2025, 'platforms' => ['PC', 'Console', 'Mobile'], 'modes' => 'Single-player, online',
        'description' => 'Night races through a working container port, with cranes and ferries as moving obstacles. Handling is forgiving, so the focus stays on lines and timing.',
        'tags' => ['arcade', 'night', 'drifting'], 'featured' => false,
        'art' => ['#2b0d14', '#d2453b', '#f2b632', 'slash'],
    ],
    'vanta-sector' => [
        'title' => 'Vanta Sector', 'category' => 'Shooter', 'genre' => 'Tactical team shooter',
        'developer' => 'Parallax Games', 'year' => 2024, 'platforms' => ['PC', 'Console'], 'modes' => '5v5 online',
        'description' => 'Five-on-five rounds on drifting space stations with destructible airlocks. Rounds are short and every loadout has a clear role.',
        'tags' => ['team-based', 'competitive', 'sci-fi'], 'featured' => false,
        'art' => ['#14211f', '#5bbf9a', '#f2b632', 'grid'],
    ],
    'hollow-lantern' => [
        'title' => 'Hollow Lantern', 'category' => 'Co-op', 'genre' => 'Cooperative dungeon crawler',
        'developer' => 'Duskbound', 'year' => 2025, 'platforms' => ['PC', 'Console'], 'modes' => '1-4 players co-op',
        'description' => 'One lantern, four players. Whoever holds the light cannot fight, so the group trades roles room by room.',
        'tags' => ['co-op', 'dungeon', 'friends'], 'featured' => false,
        'art' => ['#1b1626', '#a68cd6', '#f2b632', 'dots'],
    ],
    'glasswing-saga' => [
        'title' => 'Glasswing Saga', 'category' => 'RPG', 'genre' => 'Turn-based RPG',
        'developer' => 'Lumen Works', 'year' => 2022, 'platforms' => ['PC', 'Mobile'], 'modes' => 'Single-player',
        'description' => 'A party-based adventure with a hand-painted world and a battle system built on elemental timing. Side quests carry as much story as the main path.',
        'tags' => ['story', 'turn-based', 'party'], 'featured' => false,
        'art' => ['#10282b', '#7dd0c4', '#f2b632', 'rings'],
    ],
    'brickwork-kingdoms' => [
        'title' => 'Brickwork Kingdoms', 'category' => 'Strategy', 'genre' => 'City-building strategy',
        'developer' => 'Saltmarsh Interactive', 'year' => 2023, 'platforms' => ['PC', 'Mobile'], 'modes' => 'Single-player',
        'description' => 'Grow a walled town from a single well, balancing food, trade and defense. Seasons force trade-offs, and slow play is rewarded.',
        'tags' => ['building', 'management', 'relaxed'], 'featured' => false,
        'art' => ['#2a2314', '#d9a441', '#e9efec', 'grid'],
    ],
    'night-courier' => [
        'title' => 'Night Courier', 'category' => 'Racing', 'genre' => 'Delivery racing',
        'developer' => 'Redline Labs', 'year' => 2024, 'platforms' => ['Mobile', 'PC'], 'modes' => 'Single-player',
        'description' => 'Deliver parcels across a sleeping city on a scooter. Rain, traffic lights and a ticking schedule make each route a small puzzle.',
        'tags' => ['delivery', 'city', 'casual'], 'featured' => false,
        'art' => ['#0f2433', '#4d9de0', '#f2b632', 'slash'],
    ],
    'split-shift' => [
        'title' => 'Split Shift', 'category' => 'Co-op', 'genre' => 'Kitchen chaos co-op',
        'developer' => 'Mossy Pixel', 'year' => 2025, 'platforms' => ['PC', 'Console'], 'modes' => '2-4 players, local and online',
        'description' => 'Run a restaurant whose layout changes mid-service. Communication matters more than speed, and the rules stay simple enough for new players.',
        'tags' => ['party', 'local co-op', 'casual'], 'featured' => false,
        'art' => ['#2a1a0d', '#e0903a', '#e9efec', 'dots'],
    ],
];
