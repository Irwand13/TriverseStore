<?php
// Butuh $game. Opsional: $cardHref dan $cardNote untuk mengganti tautan dan baris keterangan.
$href = $cardHref ?? 'game-detail.php?id=' . urlencode($game['slug']);
$note = $cardNote ?? $game['genre'];
?>
<a href="<?= e($href) ?>" class="tile card gap-0 overflow-hidden py-0 transition duration-300 hover:-translate-y-1 hover:border-primary/60 hover:shadow-xl hover:shadow-black/30">
  <span class="cover">
    <?= cover_art($game) ?>
    <span class="badge absolute left-2 top-2" data-variant="secondary"><?= e($game['category']) ?></span>
  </span>
  <span class="block p-3.5">
    <span class="tile-title block font-display font-semibold"><?= e($game['title']) ?></span>
    <span class="mt-0.5 block text-sm text-muted-foreground"><?= e($note) ?></span>
  </span>
</a>
