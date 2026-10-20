<?php
require_once __DIR__ . '/includes/functions.php';

$account = find_account($_GET['id'] ?? null);
if ($account === null) {
    $nfTitle = 'Listing not found';
    $nfText  = 'This link may be mistyped, or the listing was removed.';
    $nfHref  = 'marketplace.php';
    $nfLabel = 'Back to the marketplace';
    include __DIR__ . '/includes/not-found.php';
    exit;
}

$game = account_game($account);
$related = array_slice(array_filter(accounts(), fn($a) => $a['slug'] !== $account['slug'] && $a['game'] === $account['game']), 0, 4);
$pageTitle = $account['title'];
$pageDescription = $account['description'];
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main" class="wrap section">
  <nav class="text-sm text-muted" aria-label="Breadcrumb">
    <a class="hover:text-ink" href="marketplace.php">Marketplace</a> /
    <a class="hover:text-ink" href="marketplace.php?game=<?= e(urlencode($account['game'])) ?>"><?= e($game['title']) ?></a>
  </nav>

  <article class="mt-6 grid gap-8 md:grid-cols-12 md:gap-12">
    <div class="md:col-span-4"><div class="cover"><?= account_cover($account) ?></div></div>

    <div class="md:col-span-8">
      <div class="flex flex-wrap items-center gap-3">
        <p class="font-display text-2xl font-semibold"><?= e(format_rupiah($account['price'])) ?></p>
        <?= status_badge($account['status']) ?>
      </div>
      <h1 class="mt-2 font-display text-3xl font-semibold leading-tight md:text-4xl"><?= e($account['title']) ?></h1>
      <p class="mt-1 text-muted"><a class="hover:text-ink hover:underline" href="game-detail.php?id=<?= e(urlencode($account['game'])) ?>"><?= e($game['title']) ?></a> &middot; <?= e($account['category']) ?></p>
      <p class="mt-6 max-w-prose text-lg"><?= e($account['description']) ?></p>

      <h2 class="mt-8 font-display text-lg font-semibold">What is included</h2>
      <ul class="mt-2 max-w-xl list-disc space-y-1 pl-5 text-muted">
        <?php foreach ($account['items'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
      </ul>

      <dl class="mt-8 grid max-w-xl border-t border-rule text-sm sm:grid-cols-2 sm:gap-x-8">
        <?php foreach (['Progress' => $account['level'], 'Region' => $account['region'], 'Linked via' => $account['login'], 'Seller' => $account['seller'], 'Listed' => format_date($account['listed'])] as $label => $value): ?>
          <div class="flex justify-between gap-4 border-b border-rule py-3"><dt class="text-muted"><?= e($label) ?></dt><dd class="text-right font-medium"><?= e($value) ?></dd></div>
        <?php endforeach; ?>
      </dl>

      <section class="mt-8 max-w-xl border border-rule p-5" aria-labelledby="safe-h">
        <h2 id="safe-h" class="font-display text-lg font-semibold">Account details stay private</h2>
        <p class="mt-2 text-sm text-muted">Login details are never shown on a listing. How an account is handed over, and how disputes are handled, will be defined with the order system in a later stage. Publisher rules on account transfers will also be taken into account.</p>
        <p class="mt-3 text-sm text-muted">Ordering is not available in this prototype yet.</p>
      </section>

      <div class="mt-6 flex flex-wrap gap-3">
        <a href="marketplace.php" class="btn btn-primary">Back to the marketplace</a>
        <a href="marketplace.php?game=<?= e(urlencode($account['game'])) ?>" class="btn">More for <?= e($game['title']) ?></a>
      </div>
    </div>
  </article>

  <?php if ($related): ?>
    <section class="mt-16 border-t border-rule pt-10" aria-labelledby="rel-h">
      <h2 id="rel-h" class="font-display text-2xl font-semibold">Other listings for <?= e($game['title']) ?></h2>
      <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-4">
        <?php foreach ($related as $account): include __DIR__ . '/includes/account-card.php'; endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
