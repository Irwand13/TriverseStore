<?php
$current = basename($_SERVER['SCRIPT_NAME']);
$nav = ['topup.php' => ['Top Up', ['topup.php', 'topup-game.php']], 'marketplace.php' => ['Marketplace', ['marketplace.php', 'account-detail.php']], 'catalog.php' => ['Games', ['catalog.php', 'game-detail.php']], 'news.php' => ['News', ['news.php', 'news-detail.php']]];
$q = query_text('q');
?>
<header class="border-b border-rule">
  <div class="wrap flex items-center gap-4 py-4 md:gap-8">
    <a href="index.php" class="flex items-center gap-2.5 font-display text-lg font-bold">
      <svg width="22" height="18" viewBox="0 0 22 18" aria-hidden="true"><rect width="22" height="4" fill="var(--accent)"/><rect y="7" width="15" height="4" fill="var(--accent)"/><rect y="14" width="8" height="4" fill="var(--accent)"/></svg>
      Triverse
    </a>

    <nav class="hidden md:block" aria-label="Main">
      <ul class="flex gap-6 text-sm font-medium">
        <?php foreach ($nav as $file => [$label, $pages]): $on = in_array($current, $pages, true); ?>
          <li><a href="<?= e($file) ?>" class="nav-link <?= $on ? 'is-active' : '' ?>" <?= $on ? 'aria-current="page"' : '' ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <form action="catalog.php" method="get" role="search" class="search ml-auto hidden md:flex">
      <label for="nav-q" class="sr-only">Search games</label>
      <input id="nav-q" name="q" type="search" maxlength="60" value="<?= e($q) ?>" placeholder="Search games">
      <button type="submit" aria-label="Search"><svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="8.5" cy="8.5" r="6"/><path d="m13 13 5 5"/></svg></button>
    </form>

    <button id="menu-toggle" type="button" class="ml-auto p-2 md:hidden" aria-expanded="false" aria-controls="mobile-menu">
      <span class="sr-only">Menu</span>
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>

  <div id="mobile-menu" class="wrap hidden pb-4 md:hidden">
    <form action="catalog.php" method="get" role="search" class="search mb-3 flex">
      <label for="m-q" class="sr-only">Search games</label>
      <input id="m-q" name="q" type="search" maxlength="60" value="<?= e($q) ?>" placeholder="Search games">
      <button type="submit" aria-label="Search"><svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="8.5" cy="8.5" r="6"/><path d="m13 13 5 5"/></svg></button>
    </form>
    <ul class="divide-y divide-rule border-y border-rule">
      <?php foreach ($nav as $file => [$label, $pages]): ?>
        <li><a href="<?= e($file) ?>" class="block py-3 font-medium"><?= e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</header>
