<?php
require_once __DIR__ . '/includes/functions.php';

$cfg = find_topup($_GET['id'] ?? null);
if ($cfg === null) {
    $nfTitle = 'Game not available for top up';
    $nfText  = 'This link may be mistyped, or the game has no top-up options yet.';
    $nfHref  = 'topup.php';
    $nfLabel = 'Back to top up';
    include __DIR__ . '/includes/not-found.php';
    exit;
}
$slug = $_GET['id'];
$game = games()[$slug];

$errors = [];
$values = ['package' => '', 'user_id' => '', 'server_id' => ''];
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';
if ($submitted) { [$errors, $values] = validate_topup($cfg); }
$valid = $submitted && !$errors;
$chosen = $valid ? $cfg['packages'][(int) $values['package']] : null;

$pageTitle = 'Top up ' . $game['title'];
$pageDescription = 'Choose an amount of ' . $cfg['currency'] . ' and review your order.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main" class="wrap section">
  <nav class="text-sm text-muted" aria-label="Breadcrumb">
    <a class="hover:text-ink" href="topup.php">Top up</a> / <span><?= e($game['title']) ?></span>
  </nav>

  <div class="mt-6 grid gap-8 md:grid-cols-12 md:gap-12">
    <aside class="md:col-span-3">
      <div class="cover max-w-[12rem] md:max-w-none"><?= cover_art($game) ?></div>
      <p class="mt-3 text-sm text-muted"><?= e($cfg['currency']) ?></p>
    </aside>

    <div class="md:col-span-9 md:max-w-2xl">
      <h1 class="font-display text-3xl font-semibold md:text-4xl">Top up <?= e($game['title']) ?></h1>

      <?php if ($valid): ?>
        <section class="mt-8" aria-labelledby="sum-h">
          <h2 id="sum-h" class="font-display text-xl font-semibold">Order preview</h2>
          <dl class="mt-4 border-t border-rule text-sm">
            <?php
              $rows = ['Game' => $game['title'], 'Item' => $chosen[0], $cfg['user_label'] => $values['user_id']];
              if ($cfg['server']) { $rows[$cfg['server']['label']] = $values['server_id']; }
              foreach ($rows as $label => $value): ?>
              <div class="flex justify-between gap-4 border-b border-rule py-3"><dt class="text-muted"><?= e($label) ?></dt><dd class="font-medium"><?= e($value) ?></dd></div>
            <?php endforeach; ?>
            <div class="flex justify-between gap-4 border-b border-rule py-4"><dt class="font-semibold">Total</dt><dd class="font-display text-xl font-semibold"><?= e(format_rupiah($chosen[1])) ?></dd></div>
          </dl>
          <p class="mt-6 border border-rule p-4 text-sm text-muted">This is a preview only. No order was created, no payment was taken, and the details you entered were not saved. Payment and order tracking will be added in a later stage.</p>
          <div class="mt-6 flex flex-wrap gap-3">
            <a href="topup-game.php?id=<?= e(urlencode($slug)) ?>" class="btn btn-primary">Change details</a>
            <a href="topup.php" class="btn">Back to top up</a>
          </div>
        </section>

      <?php else: ?>
        <?php if ($errors): ?>
          <div class="mt-6 border border-accent p-4 text-sm" role="alert">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-1 list-disc pl-5 text-muted"><?php foreach ($errors as $m): ?><li><?= e($m) ?></li><?php endforeach; ?></ul>
          </div>
        <?php endif; ?>

        <form method="post" action="topup-game.php?id=<?= e(urlencode($slug)) ?>" class="mt-8 space-y-10" novalidate>
          <fieldset>
            <legend class="font-display text-lg font-semibold">1. Choose an amount</legend>
            <div class="mt-4 grid gap-2 sm:grid-cols-2">
              <?php foreach ($cfg['packages'] as $i => [$label, $price]): ?>
                <label class="pack">
                  <input type="radio" name="package" value="<?= (int) $i ?>" <?= $values['package'] === (string) $i ? 'checked' : '' ?>>
                  <span class="font-medium"><?= e($label) ?></span>
                  <span class="text-muted"><?= e(format_rupiah($price)) ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <fieldset>
            <legend class="font-display text-lg font-semibold">2. Enter your game ID</legend>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
              <div>
                <label for="user_id" class="field-label"><?= e($cfg['user_label']) ?></label>
                <input id="user_id" name="user_id" type="text" inputmode="numeric" maxlength="20" autocomplete="off" class="field" value="<?= e($values['user_id']) ?>" aria-describedby="user_hint" <?= isset($errors['user_id']) ? 'aria-invalid="true"' : '' ?>>
                <p id="user_hint" class="mt-1 text-xs text-muted"><?= e($cfg['user_hint']) ?></p>
              </div>
              <?php if ($cfg['server']): ?>
                <div>
                  <label for="server_id" class="field-label"><?= e($cfg['server']['label']) ?></label>
                  <input id="server_id" name="server_id" type="text" inputmode="numeric" maxlength="10" autocomplete="off" class="field" value="<?= e($values['server_id']) ?>" aria-describedby="server_hint" <?= isset($errors['server_id']) ? 'aria-invalid="true"' : '' ?>>
                  <p id="server_hint" class="mt-1 text-xs text-muted"><?= e($cfg['server']['hint']) ?></p>
                </div>
              <?php endif; ?>
            </div>
          </fieldset>

          <div>
            <button type="submit" class="btn btn-primary">Review order</button>
            <p class="mt-3 text-xs text-muted">You will see a summary next. Nothing is charged or saved.</p>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
