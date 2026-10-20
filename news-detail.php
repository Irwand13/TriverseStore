<?php
require_once __DIR__ . '/includes/functions.php';

$article = find_article($_GET['id'] ?? null);
if ($article === null) {
    $nfTitle = 'Article not found';
    $nfText  = 'This link may be mistyped, or the article is not in the list.';
    $nfHref  = 'news.php';
    $nfLabel = 'Back to news and guides';
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
  <nav class="text-sm text-muted" aria-label="Breadcrumb">
    <a class="hover:text-ink" href="news.php">News and guides</a> /
    <a class="hover:text-ink" href="<?= e(news_url(['category' => $article['category']])) ?>"><?= e($article['category']) ?></a>
  </nav>

  <article class="mx-auto mt-6 max-w-3xl">
    <p class="text-sm text-muted"><?= e($article['category']) ?> &middot; <time datetime="<?= e($article['date']) ?>"><?= e(format_date($article['date'])) ?></time> &middot; Sample article</p>
    <h1 class="mt-2 font-display text-3xl font-semibold leading-tight md:text-4xl"><?= e($article['title']) ?></h1>
    <p class="mt-4 text-lg text-muted"><?= e($article['summary']) ?></p>
    <div class="cover cover-wide mt-8"><?= cover_art($article, false) ?></div>

    <div class="article-body max-w-prose">
      <?php foreach ($article['body'] as $p): ?><p><?= e($p) ?></p><?php endforeach; ?>
    </div>

    <a href="news.php" class="btn mt-10">Back to news and guides</a>
  </article>

  <?php if ($others): ?>
    <section class="mx-auto mt-16 max-w-3xl border-t border-rule pt-8" aria-labelledby="more-h">
      <h2 id="more-h" class="font-display text-xl font-semibold">Keep reading</h2>
      <ul class="mt-4">
        <?php foreach ($others as $a): ?>
          <li><a href="news-detail.php?id=<?= e(urlencode($a['slug'])) ?>" class="row-link">
            <span class="row-title font-display text-lg font-semibold"><?= e($a['title']) ?></span>
            <span class="shrink-0 text-sm text-muted"><?= e($a['category']) ?></span>
          </a></li>
        <?php endforeach; ?>
      </ul>
    </section>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
