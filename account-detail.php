<?php
require_once __DIR__ . '/includes/functions.php';

$account = find_account($_GET['id'] ?? null);
if ($account === null) {
    $nfTitle = 'Listing tidak ditemukan';
    $nfText  = 'Tautan mungkin salah ketik, atau listing sudah dihapus.';
    $nfHref  = 'marketplace.php';
    $nfLabel = 'Kembali ke marketplace';
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
<main id="main">
  <div class="fill-art relative h-36 overflow-hidden border-b border-border md:h-56">
    <?= cover_art($game, false, 'banner') ?>
    <div class="absolute inset-0 bg-linear-to-t from-background to-transparent"></div>
  </div>
  <div class="wrap section">
  <?= breadcrumb([['Marketplace', 'marketplace.php'], [$game['title'], 'marketplace.php?game=' . urlencode($account['game'])], [$account['title'], null]]) ?>

  <article class="mt-6 grid gap-8 md:grid-cols-12 md:gap-12">
    <div class="md:col-span-4"><div class="cover"><?= account_cover($account) ?></div></div>

    <div class="md:col-span-8">
      <div class="flex flex-wrap items-center gap-3">
        <p class="font-display text-2xl font-semibold"><?= e(format_rupiah($account['price'])) ?></p>
        <?= status_badge($account['status']) ?>
      </div>
      <h1 class="mt-2 font-display text-3xl font-semibold leading-tight md:text-4xl"><?= e($account['title']) ?></h1>
      <p class="mt-1 text-muted-foreground"><a class="hover:text-foreground hover:underline" href="game-detail.php?id=<?= e(urlencode($account['game'])) ?>"><?= e($game['title']) ?></a> &middot; <?= e($account['category']) ?></p>
      <p class="mt-6 max-w-prose text-lg"><?= e($account['description']) ?></p>

      <h2 class="mt-8 font-display text-lg font-semibold">Isi akun</h2>
      <ul class="mt-2 max-w-xl list-disc space-y-1 pl-5 text-muted-foreground">
        <?php foreach ($account['items'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
      </ul>

      <dl class="mt-8 grid max-w-xl border-t border-border text-sm sm:grid-cols-2 sm:gap-x-8">
        <?php foreach (['Progres' => $account['level'], 'Region' => $account['region'], 'Terhubung via' => $account['login'], 'Penjual' => $account['seller'], 'Dipasang' => format_date($account['listed'])] as $label => $value): ?>
          <div class="flex justify-between gap-4 border-b border-border py-3"><dt class="text-muted-foreground"><?= e($label) ?></dt><dd class="text-right font-medium"><?= e($value) ?></dd></div>
        <?php endforeach; ?>
      </dl>

      <?= ui_alert('Data login akun tidak ditampilkan',
        '<p>Informasi login tidak pernah tampil di halaman listing. Cara serah terima akun dan penanganan sengketa akan dirancang bersama sistem pesanan di tahap berikutnya. Aturan penerbit game soal pemindahan akun juga akan dipertimbangkan, karena bisa berbeda di tiap game.</p><p>Pemesanan belum tersedia di prototipe ini.</p>',
        false, 'mt-8 max-w-xl') ?>

      <div class="mt-6 flex flex-wrap gap-3">
        <a href="marketplace.php" class="btn">Kembali ke marketplace</a>
        <a href="marketplace.php?game=<?= e(urlencode($account['game'])) ?>" class="btn" data-variant="outline">Listing lain untuk <?= e($game['title']) ?></a>
      </div>
    </div>
  </article>

  <?php if ($related): ?>
    <section class="mt-16 border-t border-border pt-10" aria-labelledby="rel-h">
      <h2 id="rel-h" class="font-display text-2xl font-semibold">Listing lain untuk <?= e($game['title']) ?></h2>
      <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-4">
        <?php foreach ($related as $account): include __DIR__ . '/includes/account-card.php'; endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
