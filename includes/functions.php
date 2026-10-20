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
    return $t ? date('j F Y', $t) : '';
}

/**
 * Cover artwork. Uses assets/images/<image> when the record has one and the file exists;
 * otherwise draws an original SVG cover from the record's 'art' palette and motif,
 * so the site never depends on external images.
 */
function cover_art(array $item, bool $showTitle = true): string
{
    static $n = 0;
    $alt = $showTitle ? 'Cover art for ' . $item['title'] : 'Illustration for the article ' . $item['title'];

    if (!empty($item['image']) && is_file(__DIR__ . '/../assets/images/' . basename($item['image']))) {
        return '<img src="assets/images/' . e(basename($item['image'])) . '" alt="' . e($alt) . '" width="400" height="500" loading="lazy">';
    }

    [$bg, $shape, $accent, $motif] = $item['art'];
    $id = 'cv' . (++$n);
    $s = '';
    switch ($motif) {
        case 'rings':
            foreach ([50, 95, 140, 185] as $r) { $s .= "<circle cx='290' cy='170' r='$r' fill='none' stroke='$shape' stroke-width='3' opacity='.55'/>"; }
            $s .= "<circle cx='290' cy='170' r='22' fill='$accent'/>";
            break;
        case 'peaks':
            $s .= "<circle cx='300' cy='130' r='46' fill='$accent'/>";
            $s .= "<path d='M0 360 L110 200 L190 310 L280 170 L400 330 V500 H0Z' fill='$shape' opacity='.6'/>";
            $s .= "<path d='M0 420 L130 300 L230 380 L330 290 L400 360 V500 H0Z' fill='$shape' opacity='.85'/>";
            break;
        case 'grid':
            for ($i = 0; $i <= 400; $i += 40) { $s .= "<path d='M$i 0V500M0 " . ($i * 1.25) . "H400' stroke='$shape' stroke-width='2' opacity='.3'/>"; }
            $s .= "<rect x='200' y='80' width='120' height='120' fill='$accent'/><rect x='240' y='120' width='120' height='120' fill='none' stroke='$shape' stroke-width='3'/>";
            break;
        case 'waves':
            for ($i = 0; $i < 6; $i++) { $y = 120 + $i * 42; $s .= "<path d='M0 $y Q50 " . ($y - 26) . " 100 $y T200 $y T300 $y T400 $y' fill='none' stroke='$shape' stroke-width='4' opacity='" . (0.9 - $i * 0.1) . "'/>"; }
            $s .= "<circle cx='310' cy='80' r='30' fill='$accent'/>";
            break;
        case 'slash':
            $s .= "<polygon points='140,0 260,0 60,500 -60,500' fill='$shape' opacity='.75'/>";
            $s .= "<polygon points='290,0 330,0 130,500 90,500' fill='$accent'/>";
            $s .= "<polygon points='380,0 440,0 240,500 180,500' fill='$shape' opacity='.4'/>";
            break;
        case 'dots':
            for ($x = 30; $x < 400; $x += 44) { for ($y = 30; $y < 300; $y += 44) { $s .= "<circle cx='$x' cy='$y' r='5' fill='$shape' opacity='.45'/>"; } }
            $s .= "<circle cx='250' cy='150' r='60' fill='$accent'/>";
            break;
    }

    $svg = "<svg viewBox='0 0 400 500' preserveAspectRatio='xMidYMid slice' role='img' aria-label='" . e($alt) . "' xmlns='http://www.w3.org/2000/svg'>"
         . "<defs><linearGradient id='$id' x1='0' y1='0' x2='0' y2='1'><stop offset='.45' stop-color='#000' stop-opacity='0'/><stop offset='1' stop-color='#000' stop-opacity='.75'/></linearGradient></defs>"
         . "<rect width='400' height='500' fill='$bg'/>$s<rect width='400' height='500' fill='url(#$id)'/>";

    if ($showTitle) {
        $lines = []; $cur = '';
        foreach (explode(' ', $item['title']) as $w) {
            if ($cur !== '' && strlen($cur . ' ' . $w) > 13) { $lines[] = $cur; $cur = $w; } else { $cur = trim($cur . ' ' . $w); }
        }
        if ($cur !== '') { $lines[] = $cur; }
        $lines = array_slice($lines, 0, 4);
        $y = 452 - (count($lines) - 1) * 44;
        $svg .= "<rect x='28' y='" . ($y - 58) . "' width='44' height='5' fill='$accent'/>";
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

const ACCOUNT_STATUS = ['available' => 'Available', 'reserved' => 'Reserved', 'sold' => 'Sold'];

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
    $label = ACCOUNT_STATUS[$status] ?? 'Unknown';
    return '<span class="badge badge-' . e($status) . '">' . e($label) . '</span>';
}

/* ---------- Top up (preview only: nothing is stored or sent anywhere) ---------- */

function topups(): array { static $t = null; return $t ??= require __DIR__ . '/../data/topup.php'; }
function find_topup($id): ?array { return valid_slug($id) ? (topups()[$id] ?? null) : null; }
function topup_from_price(array $cfg): int { return min(array_column($cfg['packages'], 1)); }

/** Read a short text value from POST data ('' if missing or not text). */
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
        $errors['package'] = 'Choose one of the amounts.';
    }
    if ($values['user_id'] === '') {
        $errors['user_id'] = 'Enter your ' . $cfg['user_label'] . '.';
    } elseif (!preg_match($cfg['user_pattern'], $values['user_id'])) {
        $errors['user_id'] = 'That ' . $cfg['user_label'] . ' does not look right. ' . $cfg['user_hint'];
    }
    if ($cfg['server']) {
        if ($values['server_id'] === '') {
            $errors['server_id'] = 'Enter your ' . $cfg['server']['label'] . '.';
        } elseif (!preg_match($cfg['server']['pattern'], $values['server_id'])) {
            $errors['server_id'] = 'That ' . $cfg['server']['label'] . ' does not look right. ' . $cfg['server']['hint'];
        }
    }
    return [$errors, $values];
}
