<?php
require_once __DIR__ . '/includes/functions.php';

$featured = null;
foreach (games() as $g) { if (!empty($g['featured'])) { $featured = $g; break; } }
$featured ??= array_values(games())[0];

$selected = array_slice(array_filter(games(), fn($g) => $g['slug'] !== $featured['slug']), 0, 5);
$topupList = array_slice(topups(), 0, 5, true);
$latest = array_slice(search_accounts('', '', '', null, null, 'newest'), 0, 4);
$news = array_values(articles());
$lead = $news[0];
$more = array_slice($news, 1, 3);

$pageTitle = 'Triverse Store';
$pageDescription = 'Browse a game catalog by genre, read short guides, and open any game for the details that matter.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main">

  <!-- Intro and featured game: the focal point -->
  <section class="wrap section grid items-center gap-10 lg:grid-cols-12 lg:gap-14">
    <div class="lg:col-span-6">
      <h1 class="font-display text-4xl font-semibold leading-tight md:text-5xl">Top up games. Find accounts.</h1>
      <p class="mt-5 max-w-md text-lg text-muted">Choose a game and an amount to top up, or compare account listings by game, progress and price. Both are previews for now: no orders are placed yet.</p>
      <div class="mt-8 flex flex-wrap gap-3">
        <a href="topup.php" class="btn btn-primary">Top up a game</a>
        <a href="marketplace.php" class="btn">Browse the marketplace</a>
      </div>
    </div>

    <a href="game-detail.php?id=<?= e(urlencode($featured['slug'])) ?>" class="tile grid gap-5 sm:grid-cols-2 lg:col-span-6">
      <span class="cover"><?= cover_art($featured) ?></span>
      <span class="flex flex-col justify-end">
        <span class="text-sm font-semibold text-accent">Featured game</span>
        <span class="mt-1 font-display text-2xl font-semibold tile-title"><?= e($featured['title']) ?></span>
        <span class="mt-1 text-sm text-muted"><?= e($featured['genre']) ?> &middot; <?= e(implode(', ', $featured['platforms'])) ?></span>
        <span class="mt-3 text-muted"><?= e($featured['description']) ?></span>
      </span>
    </a>
  </section>

  <!-- Top up: an index of games, with the lowest price shown -->
  <section class="border-t border-rule" aria-labelledby="tu-h">
    <div class="wrap section grid gap-8 md:grid-cols-12">
      <div class="md:col-span-4">
        <h2 id="tu-h" class="font-display text-2xl font-semibold">Top up</h2>
        <p class="mt-3 max-w-xs text-muted">Pick a game, choose an amount and review the order. Prices are sample data.</p>
        <a href="topup.php" class="mt-5 inline-block text-sm font-medium text-accent hover:underline">All top-up games</a>
      </div>
      <ul class="md:col-span-8">
        <?php foreach ($topupList as $slug => $cfg): ?>
          <li>
            <a href="topup-game.php?id=<?= e(urlencode($slug)) ?>" class="row-link">
              <span><span class="row-title font-display text-lg font-semibold"><?= e(games()[$slug]['title']) ?></span> <span class="ml-2 text-sm text-muted"><?= e($cfg['currency']) ?></span></span>
              <span class="shrink-0 text-sm text-muted">from <?= e(format_rupiah(topup_from_price($cfg))) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <!-- Latest marketplace listings -->
  <section class="border-t border-rule" aria-labelledby="mk-h">
    <div class="wrap section">
      <div class="flex items-baseline justify-between gap-4">
        <h2 id="mk-h" class="font-display text-2xl font-semibold">Latest listings</h2>
        <a href="marketplace.php" class="text-sm font-medium text-accent hover:underline">Open the marketplace</a>
      </div>
      <p class="mt-2 text-sm text-muted">Sample listings. Buying and selling are not available yet.</p>
      <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-4">
        <?php foreach ($latest as $account): include __DIR__ . '/includes/account-card.php'; endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Categories as an index, not cards -->
  <section class="border-y border-rule" aria-labelledby="cat-h">
    <div class="wrap section grid gap-8 md:grid-cols-12">
      <div class="md:col-span-4">
        <h2 id="cat-h" class="font-display text-2xl font-semibold">Browse by category</h2>
        <p class="mt-3 max-w-xs text-muted">Pick a genre to see every game in it.</p>
      </div>
      <ul class="md:col-span-8">
        <?php foreach (game_categories() as $name => $count): ?>
          <li>
            <a href="<?= e(catalog_url(['category' => $name])) ?>" class="row-link">
              <span class="row-title font-display text-lg font-semibold"><?= e($name) ?></span>
              <span class="text-sm text-muted"><?= (int) $count ?> <?= $count === 1 ? 'game' : 'games' ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <!-- Selected games -->
  <section class="wrap section" aria-labelledby="sel-h">
    <div class="flex items-baseline justify-between gap-4">
      <h2 id="sel-h" class="font-display text-2xl font-semibold">Selected games</h2>
      <a href="catalog.php" class="text-sm font-medium text-accent hover:underline">All <?= count(games()) ?> games</a>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-5">
      <?php foreach ($selected as $game): include __DIR__ . '/includes/game-card.php'; endforeach; ?>
    </div>
  </section>

  <!-- News -->
  <section class="border-t border-rule" aria-labelledby="news-h">
    <div class="wrap section">
      <div class="flex items-baseline justify-between gap-4">
        <h2 id="news-h" class="font-display text-2xl font-semibold">News and guides</h2>
        <a href="news.php" class="text-sm font-medium text-accent hover:underline">All articles</a>
      </div>
      <p class="mt-2 text-sm text-muted">Sample articles written for this prototype.</p>
      <div class="mt-8 grid gap-10 lg:grid-cols-12">
        <a href="news-detail.php?id=<?= e(urlencode($lead['slug'])) ?>" class="tile lg:col-span-7">
          <span class="cover cover-wide"><?= cover_art($lead, false) ?></span>
          <span class="mt-4 block text-sm text-muted"><?= e($lead['category']) ?> &middot; <time datetime="<?= e($lead['date']) ?>"><?= e(format_date($lead['date'])) ?></time></span>
          <span class="mt-1 block font-display text-2xl font-semibold tile-title"><?= e($lead['title']) ?></span>
          <span class="mt-2 block max-w-xl text-muted"><?= e($lead['summary']) ?></span>
        </a>
        <ul class="lg:col-span-5">
          <?php foreach ($more as $a): ?>
            <li>
              <a href="news-detail.php?id=<?= e(urlencode($a['slug'])) ?>" class="row-link flex-col !items-start !gap-1">
                <span class="text-sm text-muted"><?= e($a['category']) ?> &middot; <?= e(format_date($a['date'])) ?></span>
                <span class="row-title font-display text-lg font-semibold"><?= e($a['title']) ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>

</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
