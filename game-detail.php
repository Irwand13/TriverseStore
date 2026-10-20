<?php
require_once __DIR__ . '/includes/functions.php';

$game = find_game($_GET['id'] ?? null);
if ($game === null) {
    $nfTitle = 'Game not found';
    $nfText  = 'This link may be mistyped, or the game is not in the catalog.';
    $nfHref  = 'catalog.php';
    $nfLabel = 'Back to the catalog';
    include __DIR__ . '/includes/not-found.php';
    exit;
}

$related = related_games($game);
$pageTitle = $game['title'];
$pageDescription = $game['description'];
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main" class="wrap section">
  <nav class="text-sm text-muted" aria-label="Breadcrumb">
    <a class="hover:text-ink" href="catalog.php">Catalog</a> /
    <a class="hover:text-ink" href="<?= e(catalog_url(['category' => $game['category']])) ?>"><?= e($game['category']) ?></a>
  </nav>

  <article class="mt-6 grid gap-8 md:grid-cols-12 md:gap-12">
    <div class="md:col-span-4"><div class="cover"><?= cover_art($game) ?></div></div>

    <div class="md:col-span-8">
      <h1 class="font-display text-3xl font-semibold md:text-4xl"><?= e($game['title']) ?></h1>
      <p class="mt-1 text-muted"><?= e($game['genre']) ?></p>
      <p class="mt-6 max-w-prose text-lg"><?= e($game['description']) ?></p>

      <dl class="mt-8 grid max-w-xl grid-cols-1 border-t border-rule text-sm sm:grid-cols-2 sm:gap-x-8">
        <?php foreach ([
            'Category'  => $game['category'],
            'Developer' => $game['developer'],
            'Released'  => (string) $game['year'],
            'Platforms' => implode(', ', $game['platforms']),
            'Modes'     => $game['modes'],
            'Tags'      => implode(', ', $game['tags']),
        ] as $label => $value): ?>
          <div class="flex justify-between gap-4 border-b border-rule py-3">
            <dt class="text-muted"><?= e($label) ?></dt>
            <dd class="text-right font-medium"><?= e($value) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>

      <p class="mt-6 max-w-xl text-sm text-muted">This is a sample catalog entry. Buying and accounts are not available yet.</p>
      <div class="mt-6 flex flex-wrap gap-3">
        <?php if (find_topup($game['slug'])): ?><a href="topup-game.php?id=<?= e(urlencode($game['slug'])) ?>" class="btn btn-primary">Top up this game</a><?php endif; ?>
        <a href="catalog.php" class="btn">Back to the catalog</a>
        <a href="<?= e(catalog_url(['category' => $game['category']])) ?>" class="btn">More <?= e($game['category']) ?> games</a>
      </div>
    </div>
  </article>

  <?php if ($related): ?>
    <section class="mt-16 border-t border-rule pt-10" aria-labelledby="rel-h">
      <h2 id="rel-h" class="font-display text-2xl font-semibold">Related games</h2>
      <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-4">
        <?php foreach ($related as $game): include __DIR__ . '/includes/game-card.php'; endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
