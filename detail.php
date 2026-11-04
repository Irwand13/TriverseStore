<?php
/* ============================================================
   TriverseStore — Halaman Detail Produk (Week 5 · Sprint 04)
   Produk dipilih lewat parameter GET (?id=P1), dicari di array
   data dengan function cariProduk(). Bila id tidak ditemukan,
   server menjawab HTTP 404 dan menampilkan halaman tidak
   ditemukan — contoh output kondisional di sisi server.
   ============================================================ */

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/data/products.php';

$id = $_GET['id'] ?? 'P1';
$produk = cariProduk($products, $id);

if ($produk === null) {
    http_response_code(404);
    $pageTitle = 'Produk Tidak Ditemukan';
    $weekLabel = 'Week 5 · Sprint 04 — PHP Dasar (Prosedural)';
    require __DIR__ . '/includes/header.php';
    ?>
    <main class="container">
        <div class="notfound">
            <h1>404</h1>
            <p>Produk dengan id "<?= htmlspecialchars($id) ?>" tidak ditemukan di katalog.</p>
            <a class="btn btn-primary" href="index.php">Kembali ke Katalog</a>
        </div>
    </main>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

// Produk lain dari kategori yang sama untuk bagian "Listing lainnya"
$lainnya = [];
foreach ($products as $kandidat) {
    if ($kandidat['kategori'] === $produk['kategori'] && $kandidat['id'] !== $produk['id']) {
        $lainnya[] = $kandidat;
    }
    if (count($lainnya) >= 3) {
        break;
    }
}

$coret = hargaCoret($produk);
$pageTitle = $produk['judul'];
$weekLabel = 'Week 5 · Sprint 04 — PHP Dasar (Prosedural)';
require __DIR__ . '/includes/header.php';
?>

    <main class="container">
        <!-- ===== Breadcrumb ===== -->
        <nav class="breadcrumb">
            <a href="index.php">Katalog</a>
            <span>/</span>
            <span><?= htmlspecialchars($produk['kategori']) ?></span>
            <span>/</span>
            <span><?= htmlspecialchars($produk['game']) ?></span>
        </nav>

        <!-- ===== Detail produk ===== -->
        <div class="detail-grid">
            <div class="detail-media">
                <img src="assets/img/<?= htmlspecialchars($produk['gambar']) ?>" alt="Key art <?= htmlspecialchars($produk['game']) ?>">
            </div>

            <div class="detail-info">
                <span class="card-category"><?= htmlspecialchars($produk['kategori']) ?> · <?= htmlspecialchars($produk['game']) ?></span>
                <h1><?= htmlspecialchars($produk['judul']) ?></h1>
                <div class="card-meta" style="margin-top: 0.6rem;">
                    <span class="rating"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg><?= $produk['rating'] ?></span>
                    <span class="dot"></span>
                    <span><?= number_format($produk['penjualan'], 0, ',', '.') ?> penjualan penjual</span>
                    <span class="dot"></span>
                    <span class="badge <?= badgeClass($produk['status']) ?>"><?= htmlspecialchars($produk['status']) ?></span>
                </div>
                <p class="lead"><?= htmlspecialchars($produk['deskripsi']) ?></p>

                <dl class="spec-list">
                    <div class="spec-row"><dt>Game</dt><dd><?= htmlspecialchars($produk['game']) ?></dd></div>
                    <div class="spec-row"><dt>Platform</dt><dd><?= htmlspecialchars($produk['platform']) ?></dd></div>
                    <div class="spec-row"><dt>Level / Rank</dt><dd><?= htmlspecialchars($produk['level']) ?></dd></div>
                    <div class="spec-row"><dt>Item Unggulan</dt><dd><?= htmlspecialchars($produk['itemUnggulan']) ?></dd></div>
                    <div class="spec-row"><dt>Kota Penjual</dt><dd><?= htmlspecialchars($produk['kota']) ?></dd></div>
                </dl>

                <div class="buy-panel">
                    <?php if ($coret !== null): ?>
                        <div class="price-old"><?= formatRupiah($coret) ?></div>
                    <?php endif; ?>
                    <div class="price"><?= formatRupiah($produk['harga']) ?></div>
                    <p style="font-size: 0.85rem; color: var(--ink-soft); margin-block: 0.5rem 1rem;">Sudah termasuk garansi rekber 24 jam. Biaya layanan 5% ditanggung penjual.</p>
                    <?php if ($produk['status'] === 'Terjual'): ?>
                        <button class="btn btn-secondary btn-block" disabled>Akun Sudah Terjual</button>
                    <?php else: ?>
                        <a class="btn btn-primary btn-block" href="index.php#rekber">Beli via Rekber</a>
                    <?php endif; ?>
                    <div class="seller-box">
                        <div class="seller-avatar"><?= htmlspecialchars(substr($produk['seller'], 0, 1)) ?></div>
                        <div>
                            <div class="seller-name"><?= htmlspecialchars($produk['seller']) ?></div>
                            <div class="seller-meta">Rating <?= $produk['rating'] ?> · <?= number_format($produk['penjualan'], 0, ',', '.') ?> penjualan · <?= htmlspecialchars($produk['kota']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== Listing lainnya ===== -->
        <?php if (count($lainnya) > 0): ?>
        <section class="section" style="padding-top: 0;">
            <div class="section-head">
                <div>
                    <h2>Listing lainnya</h2>
                    <p>Akun lain dari kategori <?= htmlspecialchars($produk['kategori']) ?>.</p>
                </div>
                <a class="btn btn-secondary btn-sm" href="index.php#katalog">Lihat Semua</a>
            </div>
            <div class="game-grid">
                <?php foreach ($lainnya as $produkLain): ?>
                    <?php renderKartuProduk($produkLain); ?>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

<?php require __DIR__ . '/includes/footer.php'; ?>
