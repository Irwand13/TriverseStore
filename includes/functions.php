<?php
/* ============================================================
   TriverseStore — Fungsi Pembantu (Week 5 · Sprint 04)
   Contoh W5.3: function berparameter dengan return, dipakai
   ulang di index.php dan detail.php.
   ============================================================ */

/**
 * Memformat angka menjadi string Rupiah.
 * Contoh: formatRupiah(850000) -> "Rp 850.000"
 */
function formatRupiah(int $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/**
 * Menghitung harga coret (harga sebelum diskon).
 * Mengembalikan null bila produk tidak diskon.
 */
function hargaCoret(array $produk): ?int
{
    if ($produk['diskon'] <= 0) {
        return null;
    }
    return (int) round($produk['harga'] / (1 - $produk['diskon'] / 100));
}

/** Kelas badge CSS mengikuti status produk. */
function badgeClass(string $status): string
{
    return match ($status) {
        'Tersedia'      => 'badge-available',
        'Stok Terbatas' => 'badge-limited',
        default         => 'badge-sold',
    };
}

/**
 * Merender satu kartu produk (W5.4: konten dinamis server-side).
 * Markup kartu ini sama persis dengan Week 2–4; bedanya sekarang
 * HTML dibangun di server oleh PHP, bukan ditulis statis / oleh JS.
 */
function renderKartuProduk(array $produk): void
{
    $coret = hargaCoret($produk);
    ?>
    <article class="game-card">
        <div class="card-media">
            <img src="assets/img/<?= htmlspecialchars($produk['gambar']) ?>" alt="Key art <?= htmlspecialchars($produk['game']) ?>">
            <?php if ($produk['diskon'] > 0): ?>
                <span class="badge badge-promo">&minus;<?= $produk['diskon'] ?>%</span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <span class="card-category"><?= htmlspecialchars($produk['kategori']) ?></span>
            <h3><a href="detail.php?id=<?= $produk['id'] ?>"><?= htmlspecialchars($produk['judul']) ?></a></h3>
            <div class="card-meta">
                <span><?= htmlspecialchars($produk['seller']) ?></span>
                <span class="dot"></span>
                <span class="rating"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg><?= $produk['rating'] ?></span>
            </div>
            <p class="card-desc"><?= htmlspecialchars($produk['deskripsiSingkat']) ?></p>
            <div class="card-price-row">
                <div>
                    <?php if ($coret !== null): ?>
                        <div class="price-old"><?= formatRupiah($coret) ?></div>
                    <?php endif; ?>
                    <div class="price"><?= formatRupiah($produk['harga']) ?></div>
                </div>
                <span class="badge <?= badgeClass($produk['status']) ?>"><?= htmlspecialchars($produk['status']) ?></span>
            </div>
            <div class="card-actions">
                <a class="btn btn-secondary btn-sm" href="detail.php?id=<?= $produk['id'] ?>">Lihat Detail</a>
            </div>
        </div>
    </article>
    <?php
}
