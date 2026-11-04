<?php
/* ============================================================
   TriverseStore — Fungsi Pembantu (Week 6 · Sprint 05)
   Dibandingkan Week 5: logika badge & harga coret PINDAH dari
   function lepas menjadi method milik objek Game
   ($game->getBadgeClass(), $game->getHargaCoret()).
   Yang tersisa di sini hanya pemformat tampilan.
   ============================================================ */

require_once __DIR__ . '/../classes/Game.php';

/** Memformat angka menjadi string Rupiah: 850000 -> "Rp 850.000". */
function formatRupiah(int $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/**
 * Merender satu kartu produk dari objek Game (W6.4: HTML dinamis
 * dari method object). Markup sama persis dengan week sebelumnya.
 */
function renderKartuProduk(Game $produk): void
{
    $seller = $produk->getSeller();
    $coret = $produk->getHargaCoret();
    ?>
    <article class="game-card">
        <div class="card-media">
            <img src="assets/img/<?= htmlspecialchars($produk->getGambar()) ?>" alt="Key art <?= htmlspecialchars($produk->getGame()) ?>">
            <?php if ($produk->getDiskon() > 0): ?>
                <span class="badge badge-promo">&minus;<?= $produk->getDiskon() ?>%</span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <span class="card-category"><?= htmlspecialchars($produk->getKategori()) ?></span>
            <h3><a href="detail.php?id=<?= $produk->getId() ?>"><?= htmlspecialchars($produk->getJudul()) ?></a></h3>
            <div class="card-meta">
                <span><?= htmlspecialchars($seller->getNama()) ?></span>
                <span class="dot"></span>
                <span class="rating"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg><?= $seller->getRating() ?></span>
            </div>
            <p class="card-desc"><?= htmlspecialchars($produk->getDeskripsiSingkat()) ?></p>
            <div class="card-price-row">
                <div>
                    <?php if ($coret !== null): ?>
                        <div class="price-old"><?= formatRupiah($coret) ?></div>
                    <?php endif; ?>
                    <div class="price"><?= formatRupiah($produk->getHargaAkhir()) ?></div>
                </div>
                <span class="badge <?= $produk->getBadgeClass() ?>"><?= htmlspecialchars($produk->getStatus()) ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-secondary btn-sm" href="detail.php?id=<?= $produk->getId() ?>">Lihat Detail</a>
            </div>
        </div>
    </article>
    <?php
}
