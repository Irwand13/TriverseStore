<?php
/* ============================================================
   TriverseStore — Halaman Detail Produk (Week 6 · Sprint 05)
   Detail kini dibaca dari OBJEK Game: semua nilai tampil lewat
   method ($produk->getJudul(), $produk->getSeller()->getNama()).
   Bagian "Demo Class Cart" membuktikan class Cart bekerja:
   objek Cart diisi produk ini + satu produk terkait, lalu
   totalnya dihitung oleh method $cart->totalHarga().
   ============================================================ */

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/classes/Cart.php';
require_once __DIR__ . '/data/products.php';

$id = $_GET['id'] ?? 'P1';
$produk = cariProduk($products, $id);

if ($produk === null) {
    http_response_code(404);
    $pageTitle = 'Produk Tidak Ditemukan';
    $weekLabel = 'Week 6 · Sprint 05 — PHP OOP';
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

$seller = $produk->getSeller();
$coret = $produk->getHargaCoret();

// Produk lain dari kategori yang sama untuk "Listing lainnya"
$lainnya = [];
foreach ($products as $kandidat) {
    if ($kandidat->getKategori() === $produk->getKategori() && $kandidat->getId() !== $produk->getId()) {
        $lainnya[] = $kandidat;
    }
    if (count($lainnya) >= 3) {
        break;
    }
}

// Demo Class Cart: isi keranjang dengan produk ini + produk terkait pertama
$cart = new Cart();
if (!$produk->isTerjual()) {
    $cart->tambah($produk);
}
if (count($lainnya) > 0 && !$lainnya[0]->isTerjual()) {
    $cart->tambah($lainnya[0]);
}

$pageTitle = $produk->getJudul();
$weekLabel = 'Week 6 · Sprint 05 — PHP OOP';
require __DIR__ . '/includes/header.php';
?>

    <main class="container">
        <!-- ===== Breadcrumb ===== -->
        <nav class="breadcrumb">
            <a href="index.php">Katalog</a>
            <span>/</span>
            <span><?= htmlspecialchars($produk->getKategori()) ?></span>
            <span>/</span>
            <span><?= htmlspecialchars($produk->getGame()) ?></span>
        </nav>

        <!-- ===== Detail produk ===== -->
        <div class="detail-grid">
            <div class="detail-media">
                <img src="assets/img/<?= htmlspecialchars($produk->getGambar()) ?>" alt="Key art <?= htmlspecialchars($produk->getGame()) ?>">
            </div>

            <div class="detail-info">
                <span class="card-category"><?= htmlspecialchars($produk->getKategori()) ?> · <?= htmlspecialchars($produk->getGame()) ?></span>
                <h1><?= htmlspecialchars($produk->getJudul()) ?></h1>
                <div class="card-meta" style="margin-top: 0.6rem;">
                    <span class="rating"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg><?= $seller->getRating() ?></span>
                    <span class="dot"></span>
                    <span><?= number_format($seller->getPenjualan(), 0, ',', '.') ?> penjualan penjual</span>
                    <span class="dot"></span>
                    <span class="badge <?= $produk->getBadgeClass() ?>"><?= htmlspecialchars($produk->getStatus()) ?></span>
                </div>
                <p class="lead"><?= htmlspecialchars($produk->getDeskripsi()) ?></p>

                <dl class="spec-list">
                    <div class="spec-row"><dt>Game</dt><dd><?= htmlspecialchars($produk->getGame()) ?></dd></div>
                    <div class="spec-row"><dt>Platform</dt><dd><?= htmlspecialchars($produk->getPlatform()) ?></dd></div>
                    <div class="spec-row"><dt>Level / Rank</dt><dd><?= htmlspecialchars($produk->getLevel()) ?></dd></div>
                    <div class="spec-row"><dt>Item Unggulan</dt><dd><?= htmlspecialchars($produk->getItemUnggulan()) ?></dd></div>
                    <div class="spec-row"><dt>Kota Penjual</dt><dd><?= htmlspecialchars($seller->getKota()) ?></dd></div>
                </dl>

                <div class="buy-panel">
                    <?php if ($coret !== null): ?>
                        <div class="price-old"><?= formatRupiah($coret) ?></div>
                    <?php endif; ?>
                    <div class="price"><?= formatRupiah($produk->getHargaAkhir()) ?></div>
                    <p style="font-size: 0.85rem; color: var(--ink-soft); margin-block: 0.5rem 1rem;">Sudah termasuk garansi rekber 24 jam. Biaya layanan 5% ditanggung penjual.</p>
                    <?php if ($produk->isTerjual()): ?>
                        <button class="btn btn-secondary btn-block" disabled>Akun Sudah Terjual</button>
                    <?php else: ?>
                        <a class="btn btn-primary btn-block" href="index.php#rekber">Beli via Rekber</a>
                    <?php endif; ?>
                    <div class="seller-box">
                        <div class="seller-avatar"><?= htmlspecialchars($seller->getInisial()) ?></div>
                        <div>
                            <div class="seller-name"><?= htmlspecialchars($seller->getNama()) ?></div>
                            <div class="seller-meta"><?= htmlspecialchars($seller->getRingkasan()) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== Demo Class Cart ===== -->
        <section class="section" style="padding-top: 0;">
            <div class="section-head">
                <div>
                    <h2>Demo Class Cart</h2>
                    <p>Panel ini dirender dari objek <em>Cart</em>: produk di halaman ini dan satu produk terkait dimasukkan dengan method <em>tambah()</em>, lalu total dihitung oleh method <em>totalHarga()</em> milik objek itu sendiri.</p>
                </div>
            </div>
            <div class="cart-panel">
                <h2>Keranjang (objek Cart)</h2>
                <?php if ($cart->isEmpty()): ?>
                    <div class="cart-empty">Tidak ada produk yang bisa dimasukkan — produk ini sudah terjual.</div>
                <?php else: ?>
                    <?php foreach ($cart->getItems() as $item): ?>
                        <div class="cart-item">
                            <div>
                                <div class="item-name"><?= htmlspecialchars($item->getJudul()) ?></div>
                                <div class="item-meta"><?= htmlspecialchars($item->getRingkasan()) ?></div>
                            </div>
                            <div class="item-price"><?= formatRupiah($item->getHargaAkhir()) ?></div>
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-total-row">
                        <span class="total-label">Total (<?= $cart->jumlah() ?> produk)</span>
                        <span class="total-value"><?= formatRupiah($cart->totalHarga()) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ===== Listing lainnya ===== -->
        <?php if (count($lainnya) > 0): ?>
        <section class="section" style="padding-top: 0;">
            <div class="section-head">
                <div>
                    <h2>Listing lainnya</h2>
                    <p>Akun lain dari kategori <?= htmlspecialchars($produk->getKategori()) ?>.</p>
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
