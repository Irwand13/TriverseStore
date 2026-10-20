<?php
require_once __DIR__ . '/includes/functions.php';

$cfg = find_topup($_GET['id'] ?? null);
if ($cfg === null) {
    $nfTitle = 'Game belum tersedia untuk top up';
    $nfText  = 'Tautan mungkin salah ketik, atau game ini belum punya pilihan top up.';
    $nfHref  = 'topup.php';
    $nfLabel = 'Kembali ke top up';
    include __DIR__ . '/includes/not-found.php';
    exit;
}
$slug = $_GET['id'];
$game = games()[$slug];
$srv = $cfg['server'];

$errors = [];
$values = ['package' => '', 'user_id' => '', 'server_id' => ''];
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';
if ($submitted) { [$errors, $values] = validate_topup($cfg); }
$valid = $submitted && !$errors;
$chosen = $valid ? $cfg['packages'][(int) $values['package']] : null;

$pageTitle = 'Top up ' . $game['title'];
$pageDescription = 'Pilih nominal ' . $cfg['currency'] . ' dan tinjau pesanan.';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/navbar.php';
?>
<main id="main">
  <div class="fill-art relative h-36 overflow-hidden border-b border-border md:h-56">
    <?= cover_art($game, false, 'banner') ?>
    <div class="absolute inset-0 bg-linear-to-t from-background to-transparent"></div>
  </div>
  <div class="wrap section">
  <?= breadcrumb([['Top up', 'topup.php'], [$game['title'], null]]) ?>

  <div class="mt-6 grid gap-8 md:grid-cols-12 md:gap-12">
    <aside class="md:col-span-3">
      <div class="cover max-w-[12rem] overflow-hidden rounded-lg border border-border md:max-w-none"><?= cover_art($game) ?></div>
      <p class="mt-3 text-sm text-muted-foreground"><?= e($cfg['currency']) ?></p>
    </aside>

    <div class="md:col-span-9 md:max-w-2xl">
      <h1 class="font-display text-3xl font-semibold md:text-4xl">Top up <?= e($game['title']) ?></h1>

      <?php if ($valid): ?>
        <section class="mt-8" aria-labelledby="sum-h">
          <div class="card">
            <header>
              <h2 id="sum-h" class="font-display text-xl">Pratinjau pesanan</h2>
              <p class="text-sm text-muted-foreground">Periksa kembali sebelum melanjutkan.</p>
            </header>
            <section>
              <dl class="text-sm">
                <?php
                  $rows = ['Game' => $game['title'], 'Item' => $chosen[0], $cfg['user_label'] => $values['user_id']];
                  if ($srv) { $rows[$srv['label']] = $values['server_id']; }
                  foreach ($rows as $label => $value): ?>
                  <div class="flex justify-between gap-4 border-b border-border py-3"><dt class="text-muted-foreground"><?= e($label) ?></dt><dd class="font-medium"><?= e($value) ?></dd></div>
                <?php endforeach; ?>
                <div class="flex justify-between gap-4 pt-4"><dt class="font-semibold">Total</dt><dd class="font-display text-xl font-semibold"><?= e(format_rupiah($chosen[1])) ?></dd></div>
              </dl>
            </section>
          </div>
          <?= ui_alert('Ini hanya pratinjau', '<p>Tidak ada pesanan yang dibuat, tidak ada pembayaran yang diproses, dan data yang kamu isi tidak disimpan. Pembayaran dan pelacakan pesanan akan ditambahkan di tahap berikutnya.</p>', false, 'mt-6') ?>
          <div class="mt-6 flex flex-wrap gap-3">
            <a href="topup-game.php?id=<?= e(urlencode($slug)) ?>" class="btn">Ubah data</a>
            <a href="topup.php" class="btn" data-variant="outline">Kembali ke top up</a>
          </div>
        </section>

      <?php else: ?>
        <?php if ($errors): ?>
          <?php
            $li = '';
            foreach ($errors as $m) { $li .= '<li>' . e($m) . '</li>'; }
            echo ui_alert('Periksa kembali data berikut', '<ul>' . $li . '</ul>', true, 'mt-6');
          ?>
        <?php endif; ?>

        <form method="post" action="topup-game.php?id=<?= e(urlencode($slug)) ?>" class="mt-8 space-y-10" novalidate>
          <fieldset>
            <legend class="font-display text-lg font-semibold">1. Pilih nominal</legend>
            <div class="mt-4 grid gap-2 sm:grid-cols-2" role="radiogroup" aria-label="Nominal top up">
              <?php foreach ($cfg['packages'] as $i => [$label, $price]): ?>
                <label class="flex cursor-pointer items-center justify-between gap-3 rounded-md border border-input p-3 text-sm transition-colors hover:bg-accent has-checked:border-primary has-checked:bg-accent">
                  <span class="flex items-center gap-3">
                    <input type="radio" class="input" name="package" value="<?= (int) $i ?>" <?= $values['package'] === (string) $i ? 'checked' : '' ?>>
                    <span class="font-medium"><?= e($label) ?></span>
                  </span>
                  <span class="text-muted-foreground"><?= e(format_rupiah($price)) ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <fieldset>
            <legend class="font-display text-lg font-semibold">2. Masukkan ID game</legend>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
              <div class="field">
                <label for="user_id"><?= e($cfg['user_label']) ?></label>
                <input id="user_id" name="user_id" type="text" inputmode="numeric" maxlength="20" autocomplete="off" class="input" value="<?= e($values['user_id']) ?>" aria-describedby="user_hint" <?= isset($errors['user_id']) ? 'aria-invalid="true"' : '' ?>>
                <p id="user_hint" class="text-xs text-muted-foreground"><?= e($cfg['user_hint']) ?></p>
              </div>
              <?php if ($srv && isset($srv['options'])): ?>
                <div class="field">
                  <label for="server_id"><?= e($srv['label']) ?></label>
                  <select id="server_id" name="server_id" class="select" <?= isset($errors['server_id']) ? 'aria-invalid="true"' : '' ?>>
                    <option value="">Pilih <?= e($srv['label']) ?></option>
                    <?php foreach ($srv['options'] as $opt): ?><option <?= $values['server_id'] === $opt ? 'selected' : '' ?>><?= e($opt) ?></option><?php endforeach; ?>
                  </select>
                </div>
              <?php elseif ($srv): ?>
                <div class="field">
                  <label for="server_id"><?= e($srv['label']) ?></label>
                  <input id="server_id" name="server_id" type="text" inputmode="numeric" maxlength="10" autocomplete="off" class="input" value="<?= e($values['server_id']) ?>" aria-describedby="server_hint" <?= isset($errors['server_id']) ? 'aria-invalid="true"' : '' ?>>
                  <p id="server_hint" class="text-xs text-muted-foreground"><?= e($srv['hint']) ?></p>
                </div>
              <?php endif; ?>
            </div>
          </fieldset>

          <div>
            <button type="submit" class="btn">Tinjau pesanan</button>
            <p class="mt-3 text-xs text-muted-foreground">Kamu akan melihat ringkasan pesanan. Tidak ada yang ditagih atau disimpan.</p>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
