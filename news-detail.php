<?php
require_once __DIR__ . '/includes/functions.php';

$article = find_article($_GET['id'] ?? null);
if ($article === null) {
    $nfTitle = 'Artikel tidak ditemukan';
    $nfText  = 'Tautan mungkin salah ketik, atau artikel tidak ada dalam daftar.';
    $nfHref  = 'news.php';
    $nfLabel = 'Kembali ke berita dan panduan';
    include __DIR__ . '/includes/not-found.php';
    exit;
}

$others = array_slice(array_filter(articles(), fn($a) => $a['slug'] !== $article['slug']), 0, 2);
$pageTitle = $article['title'];
$pageDescription = $article['summary'];
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main" class="wrap section">
  <?= breadcrumb([['Berita dan panduan', 'news.php'], [$article['category'], news_url(['category' => $article['category']])], [$article['title'], null]]) ?>

  <article class="mx-auto mt-6 max-w-3xl">
    <p class="text-sm text-muted-foreground"><?= e($article['category']) ?> &middot; <time datetime="<?= e($article['date']) ?>"><?= e(format_date($article['date'])) ?></time> &middot; Artikel contoh</p>
    <h1 class="mt-2 font-display text-3xl font-semibold leading-tight md:text-4xl"><?= e($article['title']) ?></h1>
    <p class="mt-4 text-lg text-muted-foreground"><?= e($article['summary']) ?></p>
    <div class="cover cover-wide mt-8 rounded-xl border border-border"><?= cover_art($article, false, 'wide') ?></div>

    <div class="article-body max-w-prose">
      <?php foreach ($article['body'] as $p): ?><p><?= e($p) ?></p><?php endforeach; ?>
    </div>

    <a href="news.php" class="btn mt-10" data-variant="outline">Kembali ke berita dan panduan</a>
  </article>

  <?php if ($others): ?>
    <section class="mx-auto mt-16 max-w-3xl border-t border-border pt-8" aria-labelledby="more-h">
      <h2 id="more-h" class="font-display text-xl font-semibold">Baca juga</h2>
      <ul class="mt-4">
        <?php foreach ($others as $a): ?>
          <li><a href="news-detail.php?id=<?= e(urlencode($a['slug'])) ?>" class="row-link">
            <span class="row-title font-display text-lg font-semibold"><?= e($a['title']) ?></span>
            <span class="shrink-0 text-sm text-muted-foreground"><?= e($a['category']) ?></span>
          </a></li>
        <?php endforeach; ?>
      </ul>
    </section>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
