<?php
require_once __DIR__ . '/includes/functions.php';

$featured = null;
foreach (games() as $g) { if (!empty($g['featured'])) { $featured = $g; break; } }
$featured ??= array_values(games())[0];

$selected = array_slice(array_filter(games(), fn($g) => $g['slug'] !== $featured['slug']), 0, 5);
$topupList = array_slice(topups(), 0, 5, true);
$latest = array_slice(search_accounts('', '', '', null, null, 'newest'), 0, 4);
$news = array_values(articles());
$lead = $news[0];
$more = array_slice($news, 1, 3);

// Game pertama di tiap kategori, dipakai sebagai gambar latar ubin kategori
$byCategory = [];
foreach (games() as $g) { $byCategory[$g['category']] ??= ['game' => $g, 'count' => 0]; $byCategory[$g['category']]['count']++; }
ksort($byCategory);

$services = [
    ['gem',     'Top up',       'Isi ulang diamond, UC, dan mata uang game lain. Pilih nominal, isi ID, lalu tinjau pesanan.', 'topup.php',       'Mulai top up'],
    ['store',   'Marketplace',  'Bandingkan listing akun berdasarkan game, progres, dan harga dalam satu tempat.',              'marketplace.php', 'Lihat listing'],
    ['gamepad', 'Katalog game', 'Baca detail game dulu sebelum memutuskan top up atau membeli akun.',                          'catalog.php',     'Jelajahi game'],
];

$pageTitle = 'Triverse Store';
$pageDescription = 'Top up game dan marketplace akun game. Pilih game, bandingkan listing, dan baca panduan.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main">

  <!-- Hero: banner bergambar dengan teks di atasnya -->
  <section class="wrap pt-5 md:pt-8">
    <div class="relative isolate overflow-hidden rounded-2xl border border-border" data-reveal>
      <div class="fill-art absolute inset-0 -z-20 hidden md:block"><?= cover_art($featured, false, 'banner') ?></div>
      <div class="fill-art absolute inset-0 -z-20 md:hidden"><?= cover_art($featured, false, 'portrait') ?></div>
      <div class="absolute inset-0 -z-10 bg-linear-to-t from-background via-background/70 to-transparent md:bg-linear-to-r md:from-background/90 md:via-background/45 md:to-transparent"></div>

      <div class="flex min-h-[28rem] flex-col justify-end gap-5 p-6 sm:p-10 md:min-h-[26rem] md:max-w-[36rem] md:justify-center lg:p-14">
        <h1 class="font-display text-4xl font-semibold leading-[1.05] tracking-tight md:text-5xl lg:text-6xl">Top up game dan temukan akun.</h1>
        <p class="max-w-md text-base text-foreground/80 md:text-lg">Pilih game dan nominal untuk top up, atau bandingkan listing akun berdasarkan game, progres, dan harga. Keduanya masih berupa pratinjau: belum ada pesanan yang diproses.</p>
        <div class="flex flex-wrap items-center gap-3">
          <a href="topup.php" class="btn" data-size="lg">Mulai top up</a>
          <a href="marketplace.php" class="btn bg-background/60 backdrop-blur" data-variant="outline" data-size="lg">Lihat marketplace</a>
        </div>
        <p class="text-sm text-foreground/70">Sedang disorot: <a class="font-medium text-foreground underline underline-offset-4 hover:text-primary" href="game-detail.php?id=<?= e(urlencode($featured['slug'])) ?>"><?= e($featured['title']) ?></a></p>
      </div>
    </div>

    <div class="mt-4 grid gap-4 md:grid-cols-3" data-reveal>
      <?php foreach ($services as [$ic, $title, $text, $href, $cta]): ?>
        <a href="<?= e($href) ?>" class="card group gap-3 p-5 transition duration-300 hover:-translate-y-0.5 hover:border-primary/60 hover:bg-accent">
          <span class="grid size-10 place-items-center rounded-lg bg-primary/15 text-primary"><?= icon($ic) ?></span>
          <span class="block font-display text-lg font-semibold"><?= e($title) ?></span>
          <span class="block text-sm text-muted-foreground"><?= e($text) ?></span>
          <span class="mt-1 inline-flex items-center gap-1.5 text-sm font-medium text-primary"><?= e($cta) ?> <span class="transition-transform group-hover:translate-x-1"><?= icon('arrow', 16) ?></span></span>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Top up: baris game dengan thumbnail -->
  <section class="mt-16 md:mt-24" aria-labelledby="tu-h">
    <div class="wrap grid gap-8 md:grid-cols-12" data-reveal>
      <div class="md:col-span-4">
        <h2 id="tu-h" class="font-display text-2xl font-semibold md:text-3xl">Top up cepat</h2>
        <p class="mt-3 max-w-xs text-muted-foreground">Pilih game, tentukan nominal, lalu tinjau pesanan. Harga hanya contoh.</p>
        <a href="topup.php" class="btn mt-5" data-variant="outline">Semua game top up</a>
      </div>
      <ul class="md:col-span-8">
        <?php foreach ($topupList as $slug => $cfg): $tg = games()[$slug]; ?>
          <li>
            <a href="topup-game.php?id=<?= e(urlencode($slug)) ?>" class="row-link tile items-center!">
              <span class="flex items-center gap-4">
                <span class="cover aspect-square! w-14 shrink-0 rounded-lg"><?= cover_art($tg) ?></span>
                <span>
                  <span class="row-title block font-display text-lg font-semibold"><?= e($tg['title']) ?></span>
                  <span class="block text-sm text-muted-foreground"><?= e($cfg['currency']) ?></span>
                </span>
              </span>
              <span class="shrink-0 text-sm text-muted-foreground">mulai <span class="font-medium text-foreground"><?= e(format_rupiah(topup_from_price($cfg))) ?></span></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <!-- Listing terbaru -->
  <section class="mt-16 border-y border-border bg-card/40 md:mt-24" aria-labelledby="mk-h">
    <div class="wrap section" data-reveal>
      <div class="flex items-end justify-between gap-4">
        <div>
          <h2 id="mk-h" class="font-display text-2xl font-semibold md:text-3xl">Listing terbaru</h2>
          <p class="mt-2 text-sm text-muted-foreground">Listing contoh. Jual beli belum tersedia.</p>
        </div>
        <a href="marketplace.php" class="btn shrink-0" data-variant="outline" data-size="sm">Buka marketplace</a>
      </div>
      <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
        <?php foreach ($latest as $account): include __DIR__ . '/includes/account-card.php'; endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Kategori: ubin bergambar -->
  <section class="wrap mt-16 md:mt-24" aria-labelledby="cat-h" data-reveal>
    <h2 id="cat-h" class="font-display text-2xl font-semibold md:text-3xl">Jelajahi kategori</h2>
    <p class="mt-2 text-muted-foreground">Pilih genre untuk melihat semua game di dalamnya.</p>
    <ul class="mt-8 grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-5">
      <?php foreach ($byCategory as $name => $info): ?>
        <li>
          <a href="<?= e(catalog_url(['category' => $name])) ?>" class="tile relative isolate flex aspect-[4/3] flex-col justify-end overflow-hidden rounded-xl border border-border p-4 transition-colors hover:border-primary/60">
            <span class="fill-art absolute inset-0 -z-20"><?= cover_art($info['game'], false, 'wide') ?></span>
            <span class="absolute inset-0 -z-10 bg-linear-to-t from-background/90 via-background/20 to-transparent"></span>
            <span class="tile-title font-display text-lg font-semibold"><?= e($name) ?></span>
            <span class="text-sm text-foreground/70"><?= (int) $info['count'] ?> game</span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <!-- Game pilihan -->
  <section class="wrap mt-16 md:mt-24" aria-labelledby="sel-h" data-reveal>
    <div class="flex items-end justify-between gap-4">
      <h2 id="sel-h" class="font-display text-2xl font-semibold md:text-3xl">Game pilihan</h2>
      <a href="catalog.php" class="btn shrink-0" data-variant="outline" data-size="sm">Semua <?= count(games()) ?> game</a>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
      <?php foreach ($selected as $game): include __DIR__ . '/includes/game-card.php'; endforeach; ?>
    </div>
  </section>

  <!-- Berita -->
  <section class="wrap mt-16 md:mt-24" aria-labelledby="news-h" data-reveal>
    <div class="flex items-end justify-between gap-4">
      <div>
        <h2 id="news-h" class="font-display text-2xl font-semibold md:text-3xl">Berita dan panduan</h2>
        <p class="mt-2 text-sm text-muted-foreground">Artikel contoh yang ditulis untuk prototipe ini.</p>
      </div>
      <a href="news.php" class="btn shrink-0" data-variant="outline" data-size="sm">Semua artikel</a>
    </div>
    <div class="mt-8 grid gap-8 lg:grid-cols-12">
      <a href="news-detail.php?id=<?= e(urlencode($lead['slug'])) ?>" class="tile lg:col-span-7">
        <span class="cover cover-wide rounded-xl border border-border"><?= cover_art($lead, false, 'wide') ?></span>
        <span class="mt-4 block text-sm text-muted-foreground"><?= e($lead['category']) ?> &middot; <time datetime="<?= e($lead['date']) ?>"><?= e(format_date($lead['date'])) ?></time></span>
        <span class="mt-1 block font-display text-2xl font-semibold tile-title"><?= e($lead['title']) ?></span>
        <span class="mt-2 block max-w-xl text-muted-foreground"><?= e($lead['summary']) ?></span>
      </a>
      <ul class="lg:col-span-5">
        <?php foreach ($more as $a): ?>
          <li>
            <a href="news-detail.php?id=<?= e(urlencode($a['slug'])) ?>" class="row-link flex-col items-start! gap-1!">
              <span class="text-sm text-muted-foreground"><?= e($a['category']) ?> &middot; <?= e(format_date($a['date'])) ?></span>
              <span class="row-title font-display text-lg font-semibold"><?= e($a['title']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
