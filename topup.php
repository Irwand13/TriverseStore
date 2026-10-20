<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Top up';
$pageDescription = 'Pilih game dan nominal, lalu tinjau pesanan. Prototipe dengan harga contoh.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main">
  <header class="border-b border-border bg-card/40">
    <div class="wrap py-10 md:py-14" data-reveal>
      <h1 class="font-display text-3xl font-semibold md:text-5xl">Top up</h1>
      <p class="mt-3 max-w-xl text-muted-foreground">Pilih game, tentukan nominal, lalu masukkan ID game untuk meninjau pesanan. Harga hanya contoh, dan belum ada pesanan atau pembayaran yang diproses di prototipe ini.</p>
    </div>
  </header>
  <div class="wrap section">

  <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
    <?php foreach (topups() as $slug => $cfg):
        $game = games()[$slug];
        $cardHref = 'topup-game.php?id=' . urlencode($slug);
        $cardNote = $cfg['currency'] . ' · mulai ' . format_rupiah(topup_from_price($cfg));
        include __DIR__ . '/includes/game-card.php';
    endforeach; ?>
  </div>
</div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
