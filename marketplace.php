<?php
require_once __DIR__ . '/includes/functions.php';

$gameOptions = account_games();
$categories = account_categories();

// Every filter is validated; anything unknown is ignored.
$q = query_text('q');
$game = query_text('game');       if (!isset($gameOptions[$game])) { $game = ''; }
$category = query_text('category'); if (!in_array($category, $categories, true)) { $category = ''; }
$min = query_int('min');
$max = query_int('max');
if ($min !== null && $max !== null && $min > $max) { [$min, $max] = [$max, $min]; }
$sort = query_text('sort');       if (!in_array($sort, ['price-asc', 'price-desc'], true)) { $sort = 'newest'; }

$results = search_accounts($q, $game, $category, $min, $max, $sort);
$count = count($results);
$filtered = $q !== '' || $game !== '' || $category !== '' || $min !== null || $max !== null;

$pageTitle = 'Marketplace';
$pageDescription = 'Browse sample game account listings by game, category and price.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main" class="wrap section">
  <h1 class="font-display text-3xl font-semibold md:text-4xl">Marketplace</h1>
  <p class="mt-3 max-w-xl text-muted">Game accounts offered by sellers. Listings here are sample data for the prototype, and buying and selling are not available yet.</p>

  <form action="marketplace.php" method="get" role="search" class="mt-8 grid gap-4 border-y border-rule py-6 sm:grid-cols-2 lg:grid-cols-12">
    <div class="lg:col-span-4">
      <label for="f-q" class="field-label">Search</label>
      <div class="search flex"><input id="f-q" name="q" type="search" maxlength="60" value="<?= e($q) ?>" placeholder="Title, game or item"></div>
    </div>
    <div class="lg:col-span-2">
      <label for="f-game" class="field-label">Game</label>
      <select id="f-game" name="game" class="field">
        <option value="">All games</option>
        <?php foreach ($gameOptions as $slug => $title): ?><option value="<?= e($slug) ?>" <?= $game === $slug ? 'selected' : '' ?>><?= e($title) ?></option><?php endforeach; ?>
      </select>
    </div>
    <div class="lg:col-span-2">
      <label for="f-cat" class="field-label">Category</label>
      <select id="f-cat" name="category" class="field">
        <option value="">All categories</option>
        <?php foreach ($categories as $c): ?><option <?= $category === $c ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?>
      </select>
    </div>
    <div class="grid grid-cols-2 gap-2 lg:col-span-4">
      <div>
        <label for="f-min" class="field-label">Min price (Rp)</label>
        <input id="f-min" name="min" type="number" min="0" step="10000" inputmode="numeric" value="<?= $min !== null ? (int) $min : '' ?>" class="field" placeholder="0">
      </div>
      <div>
        <label for="f-max" class="field-label">Max price (Rp)</label>
        <input id="f-max" name="max" type="number" min="0" step="10000" inputmode="numeric" value="<?= $max !== null ? (int) $max : '' ?>" class="field" placeholder="Any">
      </div>
    </div>
    <div class="lg:col-span-4">
      <label for="f-sort" class="field-label">Sort by</label>
      <select id="f-sort" name="sort" class="field">
        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
        <option value="price-asc" <?= $sort === 'price-asc' ? 'selected' : '' ?>>Price, low to high</option>
        <option value="price-desc" <?= $sort === 'price-desc' ? 'selected' : '' ?>>Price, high to low</option>
      </select>
    </div>
    <div class="flex items-end gap-2 lg:col-span-8">
      <button type="submit" class="btn btn-primary">Apply filters</button>
      <?php if ($filtered || $sort !== 'newest'): ?><a href="marketplace.php" class="btn">Reset</a><?php endif; ?>
    </div>
  </form>

  <p class="mt-6 text-sm text-muted" role="status"><?= $count ?> <?= $count === 1 ? 'listing' : 'listings' ?><?= $filtered ? ' match your filters' : '' ?></p>

  <?php if ($results): ?>
    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4">
      <?php foreach ($results as $account): include __DIR__ . '/includes/account-card.php'; endforeach; ?>
    </div>
  <?php else: ?>
    <div class="mt-6 max-w-md border-t border-rule pt-6">
      <p class="font-display text-xl font-semibold">No listings match these filters</p>
      <p class="mt-2 text-muted">Try a wider price range, another category, or choose all games.</p>
      <a href="marketplace.php" class="btn mt-5">Reset filters</a>
    </div>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
