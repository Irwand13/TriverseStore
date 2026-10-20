<?php
require_once __DIR__ . '/includes/functions.php';

$cats = article_categories();
$category = query_text('category');
if (!in_array($category, $cats, true)) { $category = ''; }

$list = array_values(array_filter(articles(), fn($a) => $category === '' || $a['category'] === $category));
usort($list, fn($a, $b) => strcmp($b['date'], $a['date']));

$pageTitle = 'News and guides';
$pageDescription = 'Sample guides and features for the Triverse prototype.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main" class="wrap section">
  <h1 class="font-display text-3xl font-semibold md:text-4xl">News and guides</h1>
  <p class="mt-3 max-w-xl text-muted">These articles are sample content written for the prototype. They are not fetched from a live source, and the dates are placeholders.</p>

  <nav class="mt-6 flex flex-wrap gap-2" aria-label="Filter by category">
    <a href="news.php" class="chip <?= $category === '' ? 'is-active' : '' ?>">All</a>
    <?php foreach ($cats as $c): ?>
      <a href="<?= e(news_url(['category' => $c])) ?>" class="chip <?= $category === $c ? 'is-active' : '' ?>"><?= e($c) ?></a>
    <?php endforeach; ?>
  </nav>

  <?php if ($list): ?>
    <ul class="mt-10">
      <?php foreach ($list as $a): ?>
        <li class="border-t border-rule first:border-t-0">
          <a href="news-detail.php?id=<?= e(urlencode($a['slug'])) ?>" class="tile grid gap-4 py-6 sm:grid-cols-12 sm:gap-8">
            <span class="cover cover-wide sm:col-span-4"><?= cover_art($a, false) ?></span>
            <span class="sm:col-span-8">
              <span class="block text-sm text-muted"><?= e($a['category']) ?> &middot; <time datetime="<?= e($a['date']) ?>"><?= e(format_date($a['date'])) ?></time></span>
              <span class="mt-1 block font-display text-xl font-semibold tile-title"><?= e($a['title']) ?></span>
              <span class="mt-2 block max-w-xl text-muted"><?= e($a['summary']) ?></span>
              <span class="mt-3 block text-sm font-medium text-accent">Read article</span>
            </span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="mt-10 text-muted">No articles in this category. <a class="text-accent underline" href="news.php">Show all articles</a>.</p>
  <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
