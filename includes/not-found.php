<?php
// Butuh $nfTitle, $nfText, $nfHref, $nfLabel. Mengirim status 404 yang sebenarnya.
http_response_code(404);
$pageTitle = $nfTitle;
include __DIR__ . '/head.php';
include __DIR__ . '/navbar.php';
?>
<main id="main" class="wrap section max-w-2xl">
  <h1 class="font-display text-3xl font-semibold md:text-4xl"><?= e($nfTitle) ?></h1>
  <p class="mt-4 text-muted-foreground"><?= e($nfText) ?></p>
  <a href="<?= e($nfHref) ?>" class="btn mt-8"><?= e($nfLabel) ?></a>
</main>
<?php include __DIR__ . '/footer.php'; ?>
