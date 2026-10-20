<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Top up';
$pageDescription = 'Choose a game and an amount, then review your order. Prototype with sample prices.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main" class="wrap section">
  <h1 class="font-display text-3xl font-semibold md:text-4xl">Top up</h1>
  <p class="mt-3 max-w-xl text-muted">Pick a game, choose an amount and enter your game ID to review the order. Prices are sample data, and no order or payment is made in this prototype.</p>

  <div class="mt-10 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4">
    <?php foreach (topups() as $slug => $cfg): $g = games()[$slug]; ?>
      <a href="topup-game.php?id=<?= e(urlencode($slug)) ?>" class="tile block">
        <span class="cover"><?= cover_art($g) ?></span>
        <span class="mt-3 block font-display text-base font-semibold tile-title"><?= e($g['title']) ?></span>
        <span class="block text-sm text-muted"><?= e($cfg['currency']) ?> &middot; from <?= e(format_rupiah(topup_from_price($cfg))) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
