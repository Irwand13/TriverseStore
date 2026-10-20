<?php
require_once __DIR__ . '/includes/functions.php';

$categories = game_categories();
$q = query_text('q');
$category = query_text('category');
if (!array_key_exists($category, $categories)) { $category = ''; }   // hanya kategori yang ada di data

$results = search_games($q, $category);
$count = count($results);

$pageTitle = $category !== '' ? "Game $category" : 'Katalog game';
$pageDescription = 'Cari dan saring katalog game Triverse.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main">
  <header class="border-b border-border bg-card/40">
    <div class="wrap py-10 md:py-14" data-reveal>
      <h1 class="font-display text-3xl font-semibold md:text-5xl">Katalog game</h1>
      <p class="mt-3 max-w-xl text-muted-foreground">Telusuri semua game yang ada di Triverse, lalu buka detailnya.</p>
    </div>
  </header>
  <div class="wrap section">

  <form action="catalog.php" method="get" role="search" class="mt-6 flex max-w-xl items-center gap-2">
    <?php if ($category !== ''): ?><input type="hidden" name="category" value="<?= e($category) ?>"><?php endif; ?>
    <label for="cat-q" class="sr-only">Cari di katalog</label>
    <input id="cat-q" name="q" type="search" maxlength="60" value="<?= e($q) ?>" placeholder="Judul, genre, pengembang, atau tag" class="input flex-1">
    <button type="submit" class="btn">Cari</button>
  </form>

  <nav class="mt-5 flex flex-wrap gap-2" aria-label="Saring berdasarkan kategori">
    <?php $on = $category === ''; ?>
    <a href="<?= e(catalog_url(['q' => $q])) ?>" class="btn rounded-full" data-variant="<?= $on ? 'primary' : 'outline' ?>" data-size="sm" <?= $on ? 'aria-current="true"' : '' ?>>Semua</a>
    <?php foreach ($categories as $name => $n): $on = $category === $name; ?>
      <a href="<?= e(catalog_url(['q' => $q, 'category' => $name])) ?>" class="btn rounded-full" data-variant="<?= $on ? 'primary' : 'outline' ?>" data-size="sm" <?= $on ? 'aria-current="true"' : '' ?>><?= e($name) ?></a>
    <?php endforeach; ?>
  </nav>

  <p class="mt-8 text-sm text-muted-foreground" role="status">
    <?= $count ?> game<?= $q !== '' ? ' dengan kata kunci &ldquo;' . e($q) . '&rdquo;' : '' ?><?= $category !== '' ? ' di kategori ' . e($category) : '' ?>
  </p>

  <?php if ($results): ?>
    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4">
      <?php foreach ($results as $game): include __DIR__ . '/includes/game-card.php'; endforeach; ?>
    </div>
  <?php else: ?>
    <div class="mt-6 max-w-md border-t border-border pt-6">
      <p class="font-display text-xl font-semibold">Tidak ada game yang cocok</p>
      <p class="mt-2 text-muted-foreground">Periksa ejaan, coba kata kunci yang lebih singkat seperti nama genre, atau hapus filter kategori.</p>
      <a href="catalog.php" class="btn mt-5" data-variant="outline">Hapus pencarian dan filter</a>
    </div>
  <?php endif; ?>
</div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
