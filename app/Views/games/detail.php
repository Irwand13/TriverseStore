<?php
/* View: Detail produk — Week 7 (MVC)
   Menerima dari Controller: $game (Model Game), $related (Game[]),
   $cart (Model Cart). Semua nilai ditampilkan dengan short echo
   <?= ?> dari method objek — View tidak mengambil data sendiri. */
$seller = $game->getSeller();
$coret = $game->getHargaCoret();
?>
    <main class="container">
        <!-- ===== Breadcrumb ===== -->
        <nav class="breadcrumb">
            <a href="index.php">Katalog</a>
            <span>/</span>
            <span><?= htmlspecialchars($game->getKategori()) ?></span>
            <span>/</span>
            <span><?= htmlspecialchars($game->getGame()) ?></span>
        </nav>

        <!-- ===== Detail produk ===== -->
        <div class="detail-grid">
            <div class="detail-media">
                <img src="assets/img/<?= htmlspecialchars($game->getGambar()) ?>" alt="Key art <?= htmlspecialchars($game->getGame()) ?>">
            </div>

            <div class="detail-info">
                <span class="card-category"><?= htmlspecialchars($game->getKategori()) ?> · <?= htmlspecialchars($game->getGame()) ?></span>
                <h1><?= htmlspecialchars($game->getJudul()) ?></h1>
                <div class="card-meta" style="margin-top: 0.6rem;">
                    <span class="rating"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg><?= $seller->getRating() ?></span>
                    <span class="dot"></span>
                    <span><?= number_format($seller->getPenjualan(), 0, ',', '.') ?> penjualan penjual</span>
                    <span class="dot"></span>
                    <span class="badge <?= $game->getBadgeClass() ?>"><?= htmlspecialchars($game->getStatus()) ?></span>
                </div>
                <p class="lead"><?= htmlspecialchars($game->getDeskripsi()) ?></p>

                <dl class="spec-list">
                    <div class="spec-row"><dt>Game</dt><dd><?= htmlspecialchars($game->getGame()) ?></dd></div>
                    <div class="spec-row"><dt>Platform</dt><dd><?= htmlspecialchars($game->getPlatform()) ?></dd></div>
                    <div class="spec-row"><dt>Level / Rank</dt><dd><?= htmlspecialchars($game->getLevel()) ?></dd></div>
                    <div class="spec-row"><dt>Item Unggulan</dt><dd><?= htmlspecialchars($game->getItemUnggulan()) ?></dd></div>
                    <div class="spec-row"><dt>Kota Penjual</dt><dd><?= htmlspecialchars($seller->getKota()) ?></dd></div>
                </dl>

                <div class="buy-panel">
                    <?php if ($coret !== null): ?>
                        <div class="price-old"><?= formatRupiah($coret) ?></div>
                    <?php endif; ?>
                    <div class="price"><?= formatRupiah($game->getHargaAkhir()) ?></div>
                    <p style="font-size: 0.85rem; color: var(--ink-soft); margin-block: 0.5rem 1rem;">Sudah termasuk garansi rekber 24 jam. Biaya layanan 5% ditanggung penjual.</p>
                    <?php if ($game->isTerjual()): ?>
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

        <!-- ===== Demo Class Cart (objek disiapkan Controller) ===== -->
        <section class="section" style="padding-top: 0;">
            <div class="section-head">
                <div>
                    <h2>Demo Class Cart</h2>
                    <p>Objek <em>Cart</em> disiapkan oleh Controller dan diteruskan ke View ini — View hanya menampilkannya.</p>
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
        <?php if (count($related) > 0): ?>
        <section class="section" style="padding-top: 0;">
            <div class="section-head">
                <div>
                    <h2>Listing lainnya</h2>
                    <p>Akun lain dari kategori <?= htmlspecialchars($game->getKategori()) ?>.</p>
                </div>
                <a class="btn btn-secondary btn-sm" href="index.php#katalog">Lihat Semua</a>
            </div>
            <div class="game-grid">
                <?php foreach ($related as $produkLain): ?>
                    <?php renderKartuProduk($produkLain); ?>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>
