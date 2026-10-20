<?php
require_once __DIR__ . '/includes/functions.php';

$game = find_game($_GET['id'] ?? null);
if ($game === null) {
    $nfTitle = 'Game tidak ditemukan';
    $nfText  = 'Tautan mungkin salah ketik, atau game tidak ada di katalog.';
    $nfHref  = 'catalog.php';
    $nfLabel = 'Kembali ke katalog';
    include __DIR__ . '/includes/not-found.php';
    exit;
}

$related = related_games($game);
$pageTitle = $game['title'];
$pageDescription = $game['description'];
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main">
  <div class="fill-art relative h-36 overflow-hidden border-b border-border md:h-56">
    <?= cover_art($game, false, 'banner') ?>
    <div class="absolute inset-0 bg-linear-to-t from-background to-transparent"></div>
  </div>
  <div class="wrap section">
  <?= breadcrumb([['Katalog', 'catalog.php'], [$game['category'], catalog_url(['category' => $game['category']])], [$game['title'], null]]) ?>

  <article class="mt-6 grid gap-8 md:grid-cols-12 md:gap-12">
    <div class="md:col-span-4"><div class="cover"><?= cover_art($game) ?></div></div>

    <div class="md:col-span-8">
      <h1 class="font-display text-3xl font-semibold md:text-4xl"><?= e($game['title']) ?></h1>
      <p class="mt-1 text-muted-foreground"><?= e($game['genre']) ?></p>
      <p class="mt-6 max-w-prose text-lg"><?= e($game['description']) ?></p>

      <dl class="mt-8 grid max-w-xl grid-cols-1 border-t border-border text-sm sm:grid-cols-2 sm:gap-x-8">
        <?php foreach ([
            'Kategori'   => $game['category'],
            'Pengembang' => $game['developer'],
            'Rilis'      => (string) $game['year'],
            'Platform'   => implode(', ', $game['platforms']),
            'Mode'       => $game['modes'],
            'Tag'        => implode(', ', $game['tags']),
        ] as $label => $value): ?>
          <div class="flex justify-between gap-4 border-b border-border py-3">
            <dt class="text-muted-foreground"><?= e($label) ?></dt>
            <dd class="text-right font-medium"><?= e($value) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>

      <p class="mt-6 max-w-xl text-sm text-muted-foreground">Ini data contoh untuk prototipe. Sampul adalah ilustrasi buatan, bukan artwork resmi game.</p>
      <div class="mt-6 flex flex-wrap gap-3">
        <?php if (find_topup($game['slug'])): ?><a href="topup-game.php?id=<?= e(urlencode($game['slug'])) ?>" class="btn">Top up game ini</a><?php endif; ?>
        <a href="marketplace.php?game=<?= e(urlencode($game['slug'])) ?>" class="btn" data-variant="outline">Lihat listing akun</a>
        <a href="catalog.php" class="btn" data-variant="outline">Kembali ke katalog</a>
      </div>
    </div>
  </article>

  <?php if ($related): ?>
    <section class="mt-16 border-t border-border pt-10" aria-labelledby="rel-h">
      <h2 id="rel-h" class="font-display text-2xl font-semibold">Game terkait</h2>
      <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-4">
        <?php foreach ($related as $game): include __DIR__ . '/includes/game-card.php'; endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
