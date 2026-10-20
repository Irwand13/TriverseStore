<footer class="mt-auto border-t border-rule">
  <div class="wrap grid gap-10 py-12 md:grid-cols-12">
    <div class="md:col-span-5">
      <p class="font-display text-lg font-bold">Triverse</p>
      <p class="mt-3 max-w-sm text-sm text-muted">A game catalog and newsroom. This is a course prototype: every game, listing, seller and article shown is fictional sample content, and ordering and accounts do not exist yet.</p>
    </div>
    <nav class="md:col-span-3" aria-label="Browse by category">
      <p class="text-sm font-semibold">Browse</p>
      <ul class="mt-3 space-y-2 text-sm text-muted">
        <?php foreach (game_categories() as $name => $count): ?>
          <li><a class="hover:text-ink" href="<?= e(catalog_url(['category' => $name])) ?>"><?= e($name) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <nav class="md:col-span-4" aria-label="Site">
      <p class="text-sm font-semibold">Site</p>
      <ul class="mt-3 space-y-2 text-sm text-muted">
        <li><a class="hover:text-ink" href="index.php">Home</a></li>
        <li><a class="hover:text-ink" href="topup.php">Top up</a></li>
        <li><a class="hover:text-ink" href="marketplace.php">Marketplace</a></li>
        <li><a class="hover:text-ink" href="catalog.php">Game catalog</a></li>
        <li><a class="hover:text-ink" href="news.php">News and guides</a></li>
      </ul>
    </nav>
  </div>
  <div class="border-t border-rule">
    <p class="wrap py-4 text-xs text-muted">&copy; <?= e(date('Y')) ?> Triverse Store. Coursework prototype.</p>
  </div>
</footer>
<script src="assets/js/app.js" defer></script>
</body>
</html>
