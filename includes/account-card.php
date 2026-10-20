<?php /* Butuh $account. Harga dan status ditaruh di atas gambar supaya kartu terasa seperti etalase. */ $g = account_game($account); ?>
<a href="account-detail.php?id=<?= e(urlencode($account['slug'])) ?>" class="tile card gap-0 overflow-hidden py-0 transition duration-300 hover:-translate-y-1 hover:border-primary/60 hover:shadow-xl hover:shadow-black/30 <?= $account['status'] === 'sold' ? 'opacity-60' : '' ?>">
  <span class="cover">
    <?= account_cover($account) ?>
    <span class="absolute right-2 top-2"><?= status_badge($account['status']) ?></span>
    <span class="absolute bottom-2 left-2 rounded-md bg-background/85 px-2.5 py-1 font-display font-semibold backdrop-blur"><?= e(format_rupiah($account['price'])) ?></span>
  </span>
  <span class="block p-3.5">
    <span class="tile-title block text-sm font-medium"><?= e($account['title']) ?></span>
    <span class="mt-0.5 block text-sm text-muted-foreground"><?= e($g['title']) ?> &middot; <?= e($account['level']) ?></span>
  </span>
</a>
