<?php
/* ============================================================
   Helper khusus View — Week 7 · Sprint 06 (MVC)
   Fungsi pemformat tampilan yang dipakai file-file View.
   View tidak mengambil data sendiri; helper ini hanya
   memformat data yang sudah diserahkan Controller.
   ============================================================ */

/** Memformat angka menjadi string Rupiah: 850000 -> "Rp 850.000". */
function formatRupiah(int $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/** Merender satu kartu produk dari objek Model Game. Markup identik semua week. */
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
            <h3><a href="index.php?page=detail&id=<?= $produk->getId() ?>"><?= htmlspecialchars($produk->getJudul()) ?></a></h3>
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
                <a class="btn btn-secondary btn-sm" href="index.php?page=detail&id=<?= $produk->getId() ?>">Lihat Detail</a>
            </div>
        </div>
    </article>
    <?php
}
