<?php
$current = basename($_SERVER['SCRIPT_NAME']);
$nav = [
    'topup.php'       => ['Top Up',      ['topup.php', 'topup-game.php']],
    'marketplace.php' => ['Marketplace', ['marketplace.php', 'account-detail.php']],
    'catalog.php'     => ['Game',        ['catalog.php', 'game-detail.php']],
    'news.php'        => ['Berita',      ['news.php', 'news-detail.php']],
];
$q = query_text('q');
$searchIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>';
?>
<header class="sticky top-0 z-40 border-b border-border bg-background/80 backdrop-blur">
  <div class="wrap flex items-center gap-4 py-3 md:gap-6">
    <a href="index.php" class="flex items-center gap-2.5 font-display text-lg font-bold">
      <svg width="22" height="18" viewBox="0 0 22 18" aria-hidden="true"><rect width="22" height="4" fill="var(--primary)"/><rect y="7" width="15" height="4" fill="var(--primary)"/><rect y="14" width="8" height="4" fill="var(--primary)"/></svg>
      Triverse
    </a>

    <nav class="hidden md:block" aria-label="Menu utama">
      <ul class="flex gap-1">
        <?php foreach ($nav as $file => [$label, $pages]): $on = in_array($current, $pages, true); ?>
          <li><a href="<?= e($file) ?>" class="btn <?= $on ? 'bg-accent text-foreground' : 'text-muted-foreground' ?>" data-variant="ghost" <?= $on ? 'aria-current="page"' : '' ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <form action="catalog.php" method="get" role="search" class="ml-auto hidden items-center gap-2 md:flex">
      <label for="nav-q" class="sr-only">Cari game</label>
      <input id="nav-q" name="q" type="search" maxlength="60" value="<?= e($q) ?>" placeholder="Cari game" class="input w-52">
      <button type="submit" class="btn" data-variant="outline" data-size="icon" aria-label="Cari"><?= $searchIcon ?></button>
    </form>

    <button id="menu-toggle" type="button" class="btn ml-auto md:hidden" data-variant="outline" data-size="icon" aria-expanded="false" aria-controls="mobile-menu">
      <span class="sr-only">Buka menu</span>
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
  </div>

  <div id="mobile-menu" class="wrap hidden pb-4 md:hidden">
    <form action="catalog.php" method="get" role="search" class="mb-3 flex items-center gap-2">
      <label for="m-q" class="sr-only">Cari game</label>
      <input id="m-q" name="q" type="search" maxlength="60" value="<?= e($q) ?>" placeholder="Cari game" class="input flex-1">
      <button type="submit" class="btn" data-variant="outline" data-size="icon" aria-label="Cari"><?= $searchIcon ?></button>
    </form>
    <ul class="divide-y divide-border border-y border-border">
      <?php foreach ($nav as $file => [$label, $pages]): ?>
        <li><a href="<?= e($file) ?>" class="block py-3 font-medium"><?= e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</header>
