<?php
require_once __DIR__ . '/includes/functions.php';

$cats = article_categories();
$category = query_text('category');
if (!in_array($category, $cats, true)) { $category = ''; }

$list = array_values(array_filter(articles(), fn($a) => $category === '' || $a['category'] === $category));
usort($list, fn($a, $b) => strcmp($b['date'], $a['date']));

$pageTitle = 'Berita dan panduan';
$pageDescription = 'Artikel contoh tentang top up, akun game, dan kebiasaan bermain yang sehat.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main">
  <header class="border-b border-border bg-card/40">
    <div class="wrap py-10 md:py-14" data-reveal>
      <h1 class="font-display text-3xl font-semibold md:text-5xl">Berita dan panduan</h1>
      <p class="mt-3 max-w-xl text-muted-foreground">Artikel di sini adalah contoh yang ditulis untuk prototipe. Isinya tidak diambil dari sumber berita, dan tanggalnya hanya penanda.</p>
    </div>
  </header>
  <div class="wrap section">

  <nav class="mt-6 flex flex-wrap gap-2" aria-label="Saring berdasarkan kategori">
    <?php $on = $category === ''; ?>
    <a href="news.php" class="btn rounded-full" data-variant="<?= $on ? 'primary' : 'outline' ?>" data-size="sm">Semua</a>
    <?php foreach ($cats as $c): $on = $category === $c; ?>
      <a href="<?= e(news_url(['category' => $c])) ?>" class="btn rounded-full" data-variant="<?= $on ? 'primary' : 'outline' ?>" data-size="sm"><?= e($c) ?></a>
    <?php endforeach; ?>
  </nav>

  <?php if ($list): ?>
    <ul class="mt-10">
      <?php foreach ($list as $a): ?>
        <li class="border-t border-border first:border-t-0">
          <a href="news-detail.php?id=<?= e(urlencode($a['slug'])) ?>" class="tile grid gap-4 py-6 sm:grid-cols-12 sm:gap-8">
            <span class="cover cover-wide sm:col-span-4"><?= cover_art($a, false, 'wide') ?></span>
            <span class="sm:col-span-8">
              <span class="block text-sm text-muted-foreground"><?= e($a['category']) ?> &middot; <time datetime="<?= e($a['date']) ?>"><?= e(format_date($a['date'])) ?></time></span>
              <span class="mt-1 block font-display text-xl font-semibold tile-title"><?= e($a['title']) ?></span>
              <span class="mt-2 block max-w-xl text-muted-foreground"><?= e($a['summary']) ?></span>
              <span class="mt-3 block text-sm font-medium text-primary">Baca artikel</span>
            </span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="mt-10 text-muted-foreground">Belum ada artikel di kategori ini. <a class="text-primary underline" href="news.php">Tampilkan semua artikel</a>.</p>
  <?php endif; ?>
</div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
