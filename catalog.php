<?php
require_once __DIR__ . '/includes/functions.php';

$categories = game_categories();
$q = query_text('q');
$category = query_text('category');
if (!array_key_exists($category, $categories)) { $category = ''; }   // only known categories are accepted

$results = search_games($q, $category);
$count = count($results);

$pageTitle = $category !== '' ? "$category games" : 'Catalog';
$pageDescription = 'Search and filter the Triverse game catalog.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main" class="wrap section">
  <h1 class="font-display text-3xl font-semibold md:text-4xl">Catalog</h1>

  <form action="catalog.php" method="get" role="search" class="mt-6 flex max-w-xl gap-2">
    <?php if ($category !== ''): ?><input type="hidden" name="category" value="<?= e($category) ?>"><?php endif; ?>
    <div class="search flex flex-1">
      <label for="cat-q" class="sr-only">Search the catalog</label>
      <input id="cat-q" name="q" type="search" maxlength="60" value="<?= e($q) ?>" placeholder="Title, genre, studio or tag">
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
  </form>

  <nav class="mt-5 flex flex-wrap gap-2" aria-label="Filter by category">
    <a href="<?= e(catalog_url(['q' => $q])) ?>" class="chip <?= $category === '' ? 'is-active' : '' ?>" <?= $category === '' ? 'aria-current="true"' : '' ?>>All</a>
    <?php foreach ($categories as $name => $n): $on = $category === $name; ?>
      <a href="<?= e(catalog_url(['q' => $q, 'category' => $name])) ?>" class="chip <?= $on ? 'is-active' : '' ?>" <?= $on ? 'aria-current="true"' : '' ?>><?= e($name) ?></a>
    <?php endforeach; ?>
  </nav>

  <p class="mt-8 text-sm text-muted" role="status">
    <?= $count ?> <?= $count === 1 ? 'game' : 'games' ?><?= $q !== '' ? ' matching &ldquo;' . e($q) . '&rdquo;' : '' ?><?= $category !== '' ? ' in ' . e($category) : '' ?>
  </p>

  <?php if ($results): ?>
    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4">
      <?php foreach ($results as $game): include __DIR__ . '/includes/game-card.php'; endforeach; ?>
    </div>
  <?php else: ?>
    <div class="mt-6 max-w-md border-t border-rule pt-6">
      <p class="font-display text-xl font-semibold">No games match your search</p>
      <p class="mt-2 text-muted">Check the spelling, try a shorter term such as a genre, or remove the category filter.</p>
      <a href="catalog.php" class="btn mt-5">Clear search and filters</a>
    </div>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
