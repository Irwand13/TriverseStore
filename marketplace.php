<?php
require_once __DIR__ . '/includes/functions.php';

$gameOptions = account_games();
$categories = account_categories();

// Semua filter divalidasi; nilai yang tidak dikenal diabaikan.
$q = query_text('q');
$game = query_text('game');         if (!isset($gameOptions[$game])) { $game = ''; }
$category = query_text('category'); if (!in_array($category, $categories, true)) { $category = ''; }
$min = query_int('min');
$max = query_int('max');
if ($min !== null && $max !== null && $min > $max) { [$min, $max] = [$max, $min]; }
$sort = query_text('sort');         if (!in_array($sort, ['price-asc', 'price-desc'], true)) { $sort = 'newest'; }

$results = search_accounts($q, $game, $category, $min, $max, $sort);
$count = count($results);
$filtered = $q !== '' || $game !== '' || $category !== '' || $min !== null || $max !== null;

$pageTitle = 'Marketplace';
$pageDescription = 'Jelajahi listing akun game contoh berdasarkan game, kategori, dan harga.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main">
  <header class="border-b border-border bg-card/40">
    <div class="wrap py-10 md:py-14" data-reveal>
      <h1 class="font-display text-3xl font-semibold md:text-5xl">Marketplace</h1>
      <p class="mt-3 max-w-xl text-muted-foreground">Akun game yang ditawarkan penjual. Listing di sini adalah data contoh untuk prototipe, dan jual beli belum tersedia.</p>
    </div>
  </header>
  <div class="wrap section">

  <form action="marketplace.php" method="get" role="search" class="mt-8 grid gap-4 border-y border-border py-6 sm:grid-cols-2 lg:grid-cols-12">
    <div class="field lg:col-span-4">
      <label for="f-q">Cari</label>
      <input id="f-q" name="q" type="search" maxlength="60" value="<?= e($q) ?>" placeholder="Judul, game, atau item" class="input">
    </div>
    <div class="field lg:col-span-2">
      <label for="f-game">Game</label>
      <select id="f-game" name="game" class="select">
        <option value="">Semua game</option>
        <?php foreach ($gameOptions as $slug => $title): ?><option value="<?= e($slug) ?>" <?= $game === $slug ? 'selected' : '' ?>><?= e($title) ?></option><?php endforeach; ?>
      </select>
    </div>
    <div class="field lg:col-span-2">
      <label for="f-cat">Kategori</label>
      <select id="f-cat" name="category" class="select">
        <option value="">Semua kategori</option>
        <?php foreach ($categories as $c): ?><option <?= $category === $c ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?>
      </select>
    </div>
    <div class="grid grid-cols-2 gap-2 lg:col-span-4">
      <div class="field">
        <label for="f-min">Harga minimum (Rp)</label>
        <input id="f-min" name="min" type="number" min="0" step="10000" inputmode="numeric" value="<?= $min !== null ? (int) $min : '' ?>" placeholder="0" class="input">
      </div>
      <div class="field">
        <label for="f-max">Harga maksimum (Rp)</label>
        <input id="f-max" name="max" type="number" min="0" step="10000" inputmode="numeric" value="<?= $max !== null ? (int) $max : '' ?>" placeholder="Bebas" class="input">
      </div>
    </div>
    <div class="field lg:col-span-4">
      <label for="f-sort">Urutkan</label>
      <select id="f-sort" name="sort" class="select">
        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Terbaru</option>
        <option value="price-asc" <?= $sort === 'price-asc' ? 'selected' : '' ?>>Harga: rendah ke tinggi</option>
        <option value="price-desc" <?= $sort === 'price-desc' ? 'selected' : '' ?>>Harga: tinggi ke rendah</option>
      </select>
    </div>
    <div class="flex items-end gap-2 lg:col-span-8">
      <button type="submit" class="btn">Terapkan filter</button>
      <?php if ($filtered || $sort !== 'newest'): ?><a href="marketplace.php" class="btn" data-variant="outline">Atur ulang</a><?php endif; ?>
    </div>
  </form>

  <p class="mt-6 text-sm text-muted-foreground" role="status"><?= $count ?> listing<?= $filtered ? ' sesuai filter' : '' ?></p>

  <?php if ($results): ?>
    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4">
      <?php foreach ($results as $account): include __DIR__ . '/includes/account-card.php'; endforeach; ?>
    </div>
  <?php else: ?>
    <div class="mt-6 max-w-md border-t border-border pt-6">
      <p class="font-display text-xl font-semibold">Tidak ada listing yang cocok</p>
      <p class="mt-2 text-muted-foreground">Coba perluas rentang harga, pilih kategori lain, atau tampilkan semua game.</p>
      <a href="marketplace.php" class="btn mt-5" data-variant="outline">Atur ulang filter</a>
    </div>
  <?php endif; ?>
</div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
