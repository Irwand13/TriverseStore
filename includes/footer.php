<footer class="mt-auto border-t border-border">
  <div class="wrap grid gap-10 py-12 md:grid-cols-12">
    <div class="md:col-span-5">
      <p class="font-display text-lg font-bold">Triverse</p>
      <p class="mt-3 max-w-sm text-sm text-muted-foreground">Prototipe tugas kuliah. Listing, penjual, harga, dan artikel di sini adalah data contoh. Nama game milik masing-masing penerbit, dan situs ini tidak berafiliasi dengan mereka. Pemesanan, akun, dan pembayaran belum tersedia.</p>
    </div>
    <nav class="md:col-span-3" aria-label="Jelajahi kategori game">
      <p class="text-sm font-semibold">Kategori game</p>
      <ul class="mt-3 space-y-2 text-sm text-muted-foreground">
        <?php foreach (game_categories() as $name => $count): ?>
          <li><a class="hover:text-foreground" href="<?= e(catalog_url(['category' => $name])) ?>"><?= e($name) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <nav class="md:col-span-4" aria-label="Situs">
      <p class="text-sm font-semibold">Situs</p>
      <ul class="mt-3 space-y-2 text-sm text-muted-foreground">
        <li><a class="hover:text-foreground" href="index.php">Beranda</a></li>
        <li><a class="hover:text-foreground" href="topup.php">Top up</a></li>
        <li><a class="hover:text-foreground" href="marketplace.php">Marketplace</a></li>
        <li><a class="hover:text-foreground" href="catalog.php">Katalog game</a></li>
        <li><a class="hover:text-foreground" href="news.php">Berita dan panduan</a></li>
      </ul>
    </nav>
  </div>
  <div class="border-t border-border">
    <p class="wrap py-4 text-xs text-muted-foreground">&copy; <?= e(date('Y')) ?> Triverse Store. Prototipe tugas kuliah.</p>
  </div>
</footer>
<script src="assets/js/app.js" defer></script>
</body>
</html>
