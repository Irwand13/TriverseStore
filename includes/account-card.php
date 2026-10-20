<?php /* Expects $account. Listing tile: same cover frame as game tiles. */ $g = account_game($account); ?>
<a href="account-detail.php?id=<?= e(urlencode($account['slug'])) ?>" class="tile block <?= $account['status'] === 'sold' ? 'opacity-60' : '' ?>">
  <span class="cover"><?= account_cover($account) ?></span>
  <span class="mt-3 flex items-center justify-between gap-2">
    <span class="font-display text-lg font-semibold"><?= e(format_rupiah($account['price'])) ?></span>
    <?= status_badge($account['status']) ?>
  </span>
  <span class="mt-1 block font-medium tile-title"><?= e($account['title']) ?></span>
  <span class="block text-sm text-muted"><?= e($g['title']) ?> &middot; <?= e($account['level']) ?></span>
</a>
