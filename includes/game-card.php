<?php /* Expects $game. One consistent treatment everywhere games are listed. */ ?>
<a href="game-detail.php?id=<?= e(urlencode($game['slug'])) ?>" class="tile block">
  <span class="cover"><?= cover_art($game) ?></span>
  <span class="mt-3 block font-display text-base font-semibold tile-title"><?= e($game['title']) ?></span>
  <span class="block text-sm text-muted"><?= e($game['genre']) ?></span>
</a>
