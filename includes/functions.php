<?php
declare(strict_types=1);

/** Escape any dynamic value before printing it into HTML. */
function e(?string $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function config(string $key)
{
    static $c = null;
    $c ??= require __DIR__ . '/../config/app.php';
    return $c[$key] ?? null;
}

/** Lists are loaded once and each record gets its slug added. */
function load_list(string $file): array
{
    $list = require __DIR__ . '/../data/' . $file;
    foreach ($list as $slug => $item) { $list[$slug]['slug'] = $slug; }
    return $list;
}
function games(): array    { static $g = null; return $g ??= load_list('games.php'); }
function articles(): array { static $a = null; return $a ??= load_list('news.php'); }

/** Slugs may only contain lowercase letters, digits and hyphens. */
function valid_slug($v): bool { return is_string($v) && preg_match('/^[a-z0-9-]{1,60}$/', $v) === 1; }
function find_game($id): ?array    { return valid_slug($id) ? (games()[$id] ?? null) : null; }
function find_article($id): ?array { return valid_slug($id) ? (articles()[$id] ?? null) : null; }

/** Read a short, trimmed text value from the query string ('' if missing or not text). */
function query_text(string $key, int $max = 60): string
{
    $v = $_GET[$key] ?? '';
    if (!is_string($v)) { return ''; }
    $v = trim(preg_replace('/\s+/u', ' ', $v) ?? '');
    return function_exists('mb_substr') ? mb_substr($v, 0, $max) : substr($v, 0, $max);
}
function lower(string $s): string { return function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); }

/** category name => number of games */
function game_categories(): array
{
    $counts = array_count_values(array_column(games(), 'category'));
    ksort($counts);
    return $counts;
}
function article_categories(): array
{
    $c = array_values(array_unique(array_column(articles(), 'category')));
    sort($c);
    return $c;
}

function search_games(string $q, string $category): array
{
    $needle = lower($q);
    $out = [];
    foreach (games() as $g) {
        if ($category !== '' && $g['category'] !== $category) { continue; }
        if ($needle !== '') {
            $hay = lower(implode(' ', [$g['title'], $g['category'], $g['genre'], $g['developer'], implode(' ', $g['tags'])]));
            if (!str_contains($hay, $needle)) { continue; }
        }
        $out[] = $g;
    }
    return $out;
}

/** Same category first, then other games, never the game itself. */
function related_games(array $game, int $limit = 4): array
{
    $same = $other = [];
    foreach (games() as $g) {
        if ($g['slug'] === $game['slug']) { continue; }
        if ($g['category'] === $game['category']) { $same[] = $g; } else { $other[] = $g; }
    }
    return array_slice(array_merge($same, $other), 0, $limit);
}

function catalog_url(array $params = []): string
{
    $params = array_filter($params, fn($v) => $v !== '' && $v !== null);
    return 'catalog.php' . ($params ? '?' . http_build_query($params) : '');
}
function news_url(array $params = []): string
{
    $params = array_filter($params, fn($v) => $v !== '' && $v !== null);
    return 'news.php' . ($params ? '?' . http_build_query($params) : '');
}

function format_date(string $iso): string
{
    $t = strtotime($iso);
    if (!$t) { return ''; }
    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return date('j', $t) . ' ' . $months[(int) date('n', $t) - 1] . ' ' . date('Y', $t);
}

/**
 * Adegan ilustrasi (koordinat 400x500, tanpa latar). Setiap motif menggambar satu "dunia" sederhana.
 */
function art_scene(string $motif, string $c2, string $c3): string
{
    $s = '';
    switch ($motif) {
        case 'crystal': // MOBA: kristal di tengah lane, menara di kiri-kanan
            $s .= "<path d='M-20 520 L200 340 L420 520Z' fill='$c2' opacity='.16'/><path d='M200 340 L200 520' stroke='$c3' stroke-width='3' opacity='.25'/>";
            $s .= "<ellipse cx='200' cy='350' rx='100' ry='20' fill='$c3' opacity='.35'/>";
            $s .= "<polygon points='200,60 268,190 200,340 132,190' fill='$c2'/><polygon points='200,60 268,190 200,205' fill='#fff' opacity='.3'/><polygon points='200,60 132,190 200,205' fill='$c3' opacity='.4'/><polygon points='200,205 268,190 200,340' fill='#000' opacity='.25'/>";
            foreach ([50, 300] as $x) { $s .= "<rect x='$x' y='300' width='50' height='110' fill='$c2' opacity='.55'/><polygon points='" . $x . ",300 " . ($x + 25) . ",262 " . ($x + 50) . ",300' fill='$c3' opacity='.8'/>"; }
            break;
        case 'island': // battle royale: pulau, parasut, laut
            $s .= "<circle cx='300' cy='150' r='64' fill='$c3'/><circle cx='300' cy='150' r='96' fill='$c3' opacity='.2'/>";
            $s .= "<path d='M40 400 Q120 290 200 330 Q280 270 360 400Z' fill='$c2'/><path d='M40 400 Q120 330 200 350 Q280 320 360 400Z' fill='#000' opacity='.3'/>";
            $s .= "<path d='M150 330 L150 270' stroke='#000' stroke-width='5' opacity='.6'/><path d='M150 270 q-34 -6 -46 18 M150 270 q34 -6 46 18 M150 270 q-6 -32 -28 -38 M150 270 q6 -32 28 -38' stroke='#000' stroke-width='5' fill='none' opacity='.6' stroke-linecap='round'/>";
            foreach ([[90, 110, 1], [210, 60, .8], [330, 230, .7]] as [$x, $y, $k]) {
                $s .= "<g transform='translate($x $y) scale($k)'><path d='M-30 0 A30 26 0 0 1 30 0Z' fill='#fff' opacity='.9'/><path d='M-30 0 L0 56 M30 0 L0 56' stroke='#fff' stroke-width='2' opacity='.7'/><rect x='-5' y='56' width='10' height='14' fill='$c3'/></g>";
            }
            for ($i = 0; $i < 4; $i++) { $y = 410 + $i * 26; $s .= "<path d='M0 $y Q50 " . ($y - 14) . " 100 $y T200 $y T300 $y T400 $y V520 H0Z' fill='$c2' opacity='" . (0.35 - $i * 0.06) . "'/>"; }
            break;
        case 'zone': // peta topografi + zona aman
            for ($i = 1; $i <= 7; $i++) { $rx = 30 + $i * 26; $ry = 24 + $i * 22; $s .= "<ellipse cx='200' cy='250' rx='$rx' ry='$ry' fill='none' stroke='$c2' stroke-width='2' opacity='" . (0.55 - $i * 0.05) . "' transform='rotate(" . ($i * 7 - 20) . " 200 250)'/>"; }
            $s .= "<circle cx='200' cy='250' r='112' fill='none' stroke='$c3' stroke-width='4' stroke-dasharray='14 10'/><circle cx='200' cy='250' r='112' fill='$c3' opacity='.08'/>";
            $s .= "<path d='M200 120 V190 M200 310 V380 M70 250 H140 M260 250 H330' stroke='$c3' stroke-width='4' stroke-linecap='round'/><circle cx='200' cy='250' r='9' fill='$c3'/>";
            $s .= "<path d='M300 110 l16 -30 l16 30 q-16 20 -32 0Z' fill='#e5483b'/><circle cx='316' cy='98' r='5' fill='#fff'/>";
            break;
        case 'floating': // pulau melayang
            $s .= "<circle cx='200' cy='170' r='100' fill='$c3' opacity='.22'/><circle cx='200' cy='170' r='56' fill='$c3' opacity='.55'/>";
            foreach ([[200, 270, 1], [82, 170, .45], [320, 350, .55]] as [$x, $y, $k]) {
                $s .= "<g transform='translate($x $y) scale($k)'><ellipse cx='0' cy='0' rx='110' ry='24' fill='$c2'/><path d='M-110 0 Q-60 30 -30 70 L0 150 L30 70 Q60 30 110 0Z' fill='$c2' opacity='.7'/><path d='M-110 0 Q-60 30 -30 70 L0 150 L0 0Z' fill='#000' opacity='.25'/><path d='M-60 -6 l12 -40 l12 40 M10 -6 l10 -52 l10 52' stroke='#000' stroke-width='6' opacity='.45' fill='none'/></g>";
            }
            $s .= "<path d='M240 290 V400' stroke='#fff' stroke-width='5' opacity='.45'/><path d='M252 290 V380' stroke='#fff' stroke-width='3' opacity='.3'/>";
            $s .= "<path d='M60 90 q8 -8 16 0 q8 -8 16 0 M290 70 q6 -6 12 0 q6 -6 12 0' stroke='#fff' stroke-width='2' fill='none' opacity='.7'/>";
            break;
        case 'rail': // orbit dan planet
            $s .= "<circle cx='200' cy='235' r='84' fill='$c2'/><circle cx='176' cy='212' r='84' fill='#fff' opacity='.12'/><path d='M116 235 a84 84 0 0 0 168 0Z' fill='#000' opacity='.28'/>";
            $s .= "<ellipse cx='200' cy='235' rx='190' ry='44' fill='none' stroke='$c3' stroke-width='5' opacity='.9' transform='rotate(-18 200 235)'/><ellipse cx='200' cy='235' rx='150' ry='30' fill='none' stroke='$c2' stroke-width='2' opacity='.6' transform='rotate(-18 200 235)'/>";
            $s .= "<circle cx='335' cy='185' r='9' fill='$c3'/><circle cx='70' cy='290' r='6' fill='#fff' opacity='.8'/><circle cx='300' cy='370' r='14' fill='$c2' opacity='.5'/>";
            break;
        case 'agent': // bidang tajam + penanda situs
            $s .= "<polygon points='60,500 190,120 250,120 120,500' fill='$c2' opacity='.5'/><polygon points='170,500 300,90 340,90 210,500' fill='$c2' opacity='.3'/><polygon points='250,500 380,200 420,200 290,500' fill='$c2' opacity='.7'/>";
            $s .= "<circle cx='200' cy='235' r='92' fill='none' stroke='$c3' stroke-width='5'/><path d='M140 175 L260 295 M260 175 L140 295' stroke='$c3' stroke-width='14' stroke-linecap='square'/>";
            $s .= "<path d='M200 100 V130 M200 340 V370 M65 235 H95 M305 235 H335' stroke='$c3' stroke-width='4'/>";
            break;
        case 'ops': // hex dan bidikan
            for ($r = 0; $r < 5; $r++) { for ($c = 0; $c < 5; $c++) { $x = 40 + $c * 80 + ($r % 2) * 40; $y = 70 + $r * 70; $s .= "<polygon points='" . ($x) . "," . ($y - 34) . " " . ($x + 30) . "," . ($y - 17) . " " . ($x + 30) . "," . ($y + 17) . " " . ($x) . "," . ($y + 34) . " " . ($x - 30) . "," . ($y + 17) . " " . ($x - 30) . "," . ($y - 17) . "' fill='none' stroke='$c2' stroke-width='2' opacity='.3'/>"; } }
            $s .= "<circle cx='200' cy='235' r='96' fill='$c2' opacity='.18'/><circle cx='200' cy='235' r='96' fill='none' stroke='$c3' stroke-width='4'/><circle cx='200' cy='235' r='54' fill='none' stroke='$c3' stroke-width='2' opacity='.7'/>";
            $s .= "<path d='M200 110 V170 M200 300 V360 M75 235 H135 M265 235 H325' stroke='$c3' stroke-width='5' stroke-linecap='round'/><circle cx='200' cy='235' r='7' fill='#e5483b'/>";
            $s .= "<polygon points='200,360 226,410 174,410' fill='$c3' opacity='.85'/>";
            break;
        case 'castle': // benteng dan desa
            $s .= "<circle cx='310' cy='130' r='56' fill='$c3'/><circle cx='310' cy='130' r='84' fill='$c3' opacity='.2'/>";
            $s .= "<path d='M-20 400 Q90 340 200 380 Q310 330 420 390 V520 H-20Z' fill='$c2' opacity='.55'/>";
            $s .= "<rect x='140' y='230' width='120' height='140' fill='#2b2b2b' opacity='.9'/><rect x='140' y='230' width='120' height='140' fill='$c2' opacity='.25'/>";
            foreach ([140, 166, 192, 218, 244] as $x) { $s .= "<rect x='$x' y='212' width='16' height='20' fill='#2b2b2b' opacity='.9'/>"; }
            foreach ([100, 260] as $x) { $s .= "<rect x='$x' y='200' width='40' height='170' fill='#242424'/><polygon points='" . ($x - 6) . ",200 " . ($x + 20) . ",150 " . ($x + 46) . ",200' fill='$c3'/>"; }
            $s .= "<path d='M184 370 V316 a16 16 0 0 1 32 0 V370Z' fill='#000' opacity='.65'/><path d='M200 150 V104 L226 114 L200 124' stroke='$c3' stroke-width='3' fill='$c3'/>";
            foreach ([[40, 380], [320, 385]] as [$x, $y]) { $s .= "<rect x='$x' y='$y' width='44' height='34' fill='#2b2b2b' opacity='.8'/><polygon points='" . ($x - 4) . ",$y " . ($x + 22) . "," . ($y - 22) . " " . ($x + 48) . ",$y' fill='$c3' opacity='.8'/>"; }
            break;
        case 'rings':
            foreach ([50, 95, 140, 185] as $r) { $s .= "<circle cx='290' cy='170' r='$r' fill='none' stroke='$c2' stroke-width='3' opacity='.55'/>"; }
            $s .= "<circle cx='290' cy='170' r='22' fill='$c3'/>";
            break;
        case 'peaks':
            $s .= "<circle cx='300' cy='130' r='46' fill='$c3'/><path d='M0 360 L110 200 L190 310 L280 170 L400 330 V500 H0Z' fill='$c2' opacity='.6'/><path d='M0 420 L130 300 L230 380 L330 290 L400 360 V500 H0Z' fill='$c2' opacity='.85'/>";
            break;
        case 'grid':
            for ($i = 0; $i <= 400; $i += 40) { $s .= "<path d='M$i 0V500M0 " . ($i * 1.25) . "H400' stroke='$c2' stroke-width='2' opacity='.3'/>"; }
            $s .= "<rect x='200' y='80' width='120' height='120' fill='$c3'/><rect x='240' y='120' width='120' height='120' fill='none' stroke='$c2' stroke-width='3'/>";
            break;
        case 'waves':
            for ($i = 0; $i < 6; $i++) { $y = 120 + $i * 42; $s .= "<path d='M0 $y Q50 " . ($y - 26) . " 100 $y T200 $y T300 $y T400 $y' fill='none' stroke='$c2' stroke-width='4' opacity='" . (0.9 - $i * 0.1) . "'/>"; }
            $s .= "<circle cx='310' cy='80' r='30' fill='$c3'/>";
            break;
        case 'slash':
            $s .= "<polygon points='140,0 260,0 60,500 -60,500' fill='$c2' opacity='.75'/><polygon points='290,0 330,0 130,500 90,500' fill='$c3'/><polygon points='380,0 440,0 240,500 180,500' fill='$c2' opacity='.4'/>";
            break;
        case 'dots':
            for ($x = 30; $x < 400; $x += 44) { for ($y = 30; $y < 300; $y += 44) { $s .= "<circle cx='$x' cy='$y' r='5' fill='$c2' opacity='.45'/>"; } }
            $s .= "<circle cx='250' cy='150' r='60' fill='$c3'/>";
            break;
    }
    return $s;
}

/**
 * Sampul. Memakai assets/images/<image> bila ada dan filenya ada; jika tidak, menggambar ilustrasi SVG
 * dari palet dan motif ('art'), sehingga situs tidak bergantung pada gambar eksternal.
 * $variant: 'portrait' (4:5, kartu), 'wide' (16:10, artikel), 'banner' (3:1, hero).
 */
function cover_art(array $item, bool $showTitle = false, string $variant = 'portrait'): string
{
    static $n = 0;
    $alt = isset($item['body']) ? 'Ilustrasi artikel ' . $item['title'] : 'Sampul ' . $item['title'] . ' (ilustrasi buatan)';

    if (!empty($item['image']) && is_file(__DIR__ . '/../assets/images/' . basename($item['image']))) {
        return '<img src="assets/images/' . e(basename($item['image'])) . '" alt="' . e($alt) . '" width="400" height="500" loading="lazy">';
    }

    [$bg, $c2, $c3, $motif] = $item['art'];
    $id = 'cv' . (++$n);
    [$w, $h, $ox, $k] = match ($variant) { 'wide' => [800, 500, 400, 1.0], 'banner' => [1200, 400, 780, 0.8], default => [400, 500, 0, 1.0] };

    // Bintang kecil, tetap sama untuk item yang sama
    mt_srand(crc32($item['title']));
    $stars = '';
    for ($i = 0; $i < ($variant === 'portrait' ? 16 : 34); $i++) {
        $stars .= "<circle cx='" . mt_rand(8, $w - 8) . "' cy='" . mt_rand(8, (int) ($h * 0.6)) . "' r='" . (mt_rand(6, 16) / 10) . "' fill='#fff' opacity='" . (mt_rand(25, 70) / 100) . "'/>";
    }
    $scene = art_scene($motif, $c2, $c3);
    $gx = $ox + 200 * $k; $gy = $h * 0.42; $gr = $w * ($variant === 'portrait' ? 0.75 : 0.5);

    $svg = "<svg viewBox='0 0 $w $h' preserveAspectRatio='xMidYMid slice' role='img' aria-label='" . e($alt) . "' xmlns='http://www.w3.org/2000/svg'>"
        . "<defs>"
        . "<linearGradient id='{$id}b' x1='0' y1='0' x2='0' y2='1'><stop offset='0' stop-color='$bg'/><stop offset='1' stop-color='#050a0b'/></linearGradient>"
        . "<radialGradient id='{$id}g' cx='$gx' cy='$gy' r='$gr' gradientUnits='userSpaceOnUse'><stop offset='0' stop-color='$c3' stop-opacity='.5'/><stop offset='1' stop-color='$c3' stop-opacity='0'/></radialGradient>"
        . "<linearGradient id='{$id}v' x1='0' y1='0' x2='0' y2='1'><stop offset='.55' stop-color='#000' stop-opacity='0'/><stop offset='1' stop-color='#000' stop-opacity='.7'/></linearGradient>";
    if ($variant !== 'portrait') {
        $svg .= "<linearGradient id='{$id}k' gradientUnits='userSpaceOnUse' x1='$ox' y1='0' x2='" . ($ox + 100) . "' y2='0'><stop offset='0' stop-color='#000'/><stop offset='1' stop-color='#fff'/></linearGradient>"
              . "<mask id='{$id}m'><rect width='$w' height='$h' fill='url(#{$id}k)'/></mask>";
    }
    $svg .= "</defs><rect width='$w' height='$h' fill='url(#{$id}b)'/><rect width='$w' height='$h' fill='url(#{$id}g)'/>$stars";
    $svg .= $variant === 'portrait'
        ? $scene
        : "<g mask='url(#{$id}m)'><g transform='translate($ox 0) scale($k)'>$scene</g></g>";
    $svg .= "<rect width='$w' height='$h' fill='url(#{$id}v)'/>";

    if ($showTitle && $variant === 'portrait') {
        $lines = []; $cur = '';
        foreach (explode(' ', $item['title']) as $word) {
            if ($cur !== '' && strlen($cur . ' ' . $word) > 13) { $lines[] = $cur; $cur = $word; } else { $cur = trim($cur . ' ' . $word); }
        }
        if ($cur !== '') { $lines[] = $cur; }
        $lines = array_slice($lines, 0, 4);
        $y = 452 - (count($lines) - 1) * 44;
        foreach ($lines as $i => $line) {
            $svg .= "<text x='28' y='" . ($y + $i * 44) . "' font-family='Chakra Petch, sans-serif' font-size='40' font-weight='700' fill='#fff'>" . e($line) . "</text>";
        }
    }
    return $svg . '</svg>';
}

/* ---------- Marketplace ---------- */

function accounts(): array { static $a = null; return $a ??= load_list('accounts.php'); }
function find_account($id): ?array { return valid_slug($id) ? (accounts()[$id] ?? null) : null; }

function format_rupiah(int $n): string { return 'Rp ' . number_format($n, 0, ',', '.'); }

const ACCOUNT_STATUS = ['available' => 'Tersedia', 'reserved' => 'Dipesan', 'sold' => 'Terjual'];

/** The game record a listing belongs to. */
function account_game(array $account): array { return games()[$account['game']]; }

/** Cover art for a listing reuses its game's artwork. */
function account_cover(array $account): string { return cover_art(account_game($account)); }

function account_categories(): array
{
    $c = array_values(array_unique(array_column(accounts(), 'category')));
    sort($c);
    return $c;
}
function account_games(): array
{
    $slugs = array_values(array_unique(array_column(accounts(), 'game')));
    $out = [];
    foreach ($slugs as $s) { $out[$s] = games()[$s]['title']; }
    asort($out);
    return $out;
}

/** Read a non-negative whole number from the query string, or null if absent or invalid. */
function query_int(string $key, int $max = 100000000): ?int
{
    $v = $_GET[$key] ?? '';
    if (!is_string($v) || !preg_match('/^\d{1,9}$/', $v)) { return null; }
    return min((int) $v, $max);
}

function search_accounts(string $q, string $game, string $category, ?int $min, ?int $max, string $sort): array
{
    $needle = lower($q);
    $out = [];
    foreach (accounts() as $a) {
        if ($game !== '' && $a['game'] !== $game) { continue; }
        if ($category !== '' && $a['category'] !== $category) { continue; }
        if ($min !== null && $a['price'] < $min) { continue; }
        if ($max !== null && $a['price'] > $max) { continue; }
        if ($needle !== '') {
            $hay = lower($a['title'] . ' ' . account_game($a)['title'] . ' ' . $a['category'] . ' ' . implode(' ', $a['items']));
            if (!str_contains($hay, $needle)) { continue; }
        }
        $out[] = $a;
    }
    usort($out, match ($sort) {
        'price-asc'  => fn($x, $y) => $x['price'] <=> $y['price'],
        'price-desc' => fn($x, $y) => $y['price'] <=> $x['price'],
        default      => fn($x, $y) => strcmp($y['listed'], $x['listed']),
    });
    return $out;
}

function status_badge(string $status): string
{
    $label = ACCOUNT_STATUS[$status] ?? 'Tidak diketahui';
    $variant = ['available' => 'primary', 'reserved' => 'secondary', 'sold' => 'outline'][$status] ?? 'outline';
    return '<span class="badge" data-variant="' . $variant . '">' . e($label) . '</span>';
}

/* ---------- Top up (hanya pratinjau: tidak ada data yang disimpan atau dikirim) ---------- */

function topups(): array { static $t = null; return $t ??= require __DIR__ . '/../data/topup.php'; }
function find_topup($id): ?array { return valid_slug($id) ? (topups()[$id] ?? null) : null; }
function topup_from_price(array $cfg): int { return min(array_column($cfg['packages'], 1)); }

/** Read a short text value from POST data ('' if missing or not text). Whitespace is removed. */
function post_text(string $key, int $max = 30): string
{
    $v = $_POST[$key] ?? '';
    return is_string($v) ? substr(preg_replace('/\s+/', '', $v) ?? '', 0, $max) : '';
}

/** Returns [errors, values]. errors is empty when everything is valid. */
function validate_topup(array $cfg): array
{
    $values = ['package' => post_text('package', 3), 'user_id' => post_text('user_id'), 'server_id' => post_text('server_id')];
    $errors = [];
    if (!ctype_digit($values['package']) || !isset($cfg['packages'][(int) $values['package']])) {
        $errors['package'] = 'Pilih salah satu nominal.';
    }
    if ($values['user_id'] === '') {
        $errors['user_id'] = 'Masukkan ' . $cfg['user_label'] . '.';
    } elseif (!preg_match($cfg['user_pattern'], $values['user_id'])) {
        $errors['user_id'] = $cfg['user_label'] . ' tidak sesuai format. ' . $cfg['user_hint'];
    }
    if ($cfg['server']) {
        $srv = $cfg['server'];
        if (isset($srv['options'])) {
            if (!in_array($values['server_id'], $srv['options'], true)) { $errors['server_id'] = 'Pilih ' . $srv['label'] . '.'; }
        } elseif ($values['server_id'] === '') {
            $errors['server_id'] = 'Masukkan ' . $srv['label'] . '.';
        } elseif (!preg_match($srv['pattern'], $values['server_id'])) {
            $errors['server_id'] = $srv['label'] . ' tidak sesuai format. ' . $srv['hint'];
        }
    }
    return [$errors, $values];
}


/* ---------- Komponen UI (markup gaya shadcn/ui lewat Basecoat) ---------- */

/** Breadcrumb. $items = [[label, href|null], ...]; item terakhir (href null) adalah halaman saat ini. */
function breadcrumb(array $items): string
{
    $chev = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>';
    $out = '<nav class="breadcrumb text-sm text-muted-foreground" aria-label="Jejak halaman"><ol class="gap-1.5">';
    foreach ($items as $i => [$label, $href]) {
        if ($i > 0) { $out .= '<li aria-hidden="true">' . $chev . '</li>'; }
        $out .= $href === null
            ? '<li><span aria-current="page" class="text-foreground">' . e($label) . '</span></li>'
            : '<li><a href="' . e($href) . '" class="hover:text-foreground">' . e($label) . '</a></li>';
    }
    return $out . '</ol></nav>';
}

/** Alert. $bodyHtml harus sudah di-escape oleh pemanggil. */
function ui_alert(string $title, string $bodyHtml, bool $destructive = false, string $class = ''): string
{
    $icon = $destructive
        ? '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>'
        : '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>';
    return '<div class="alert ' . e($class) . '"' . ($destructive ? ' role="alert" data-variant="destructive"' : '') . '>'
        . '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $icon . '</svg>'
        . '<h2>' . e($title) . '</h2><section>' . $bodyHtml . '</section></div>';
}

/** Ikon garis sederhana (gaya Lucide). */
function icon(string $name, int $size = 22): string
{
    $paths = [
        'gem'     => '<path d="M6 3h12l4 6-10 13L2 9Z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/>',
        'store'   => '<path d="M3 9l1.5-5h15L21 9"/><path d="M4 9v11h16V9"/><path d="M9 20v-6h6v6"/><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/>',
        'gamepad' => '<line x1="6" x2="10" y1="12" y2="12"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="15" x2="15.01" y1="13" y2="13"/><line x1="18" x2="18.01" y1="11" y2="11"/><rect width="20" height="12" x="2" y="6" rx="2"/>',
        'arrow'   => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
    ];
    return '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($paths[$name] ?? '') . '</svg>';
}
