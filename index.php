<?php
/* ============================================================
   TriverseStore — Halaman Katalog (Week 6 · Sprint 05)
   Sama seperti Week 5 (filter server-side lewat GET), tetapi
   data kini berupa OBJEK: halaman memanggil method lewat
   operator -> (mis. $produk->getJudul(), $produk->getSeller()).
   ============================================================ */

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/data/products.php';

$kategoriAktif = $_GET['kategori'] ?? 'Semua';
$kataKunci     = trim($_GET['q'] ?? '');

$kategoriList = ['Semua', 'MOBA', 'RPG', 'FPS', 'Battle Royale', 'Aksi', 'Olahraga'];

// Penyaringan katalog: kini membaca data lewat getter objek
$hasil = [];
foreach ($products as $produk) {
    $cocokKategori = ($kategoriAktif === 'Semua' || $produk->getKategori() === $kategoriAktif);
    $cocokKata = ($kataKunci === '' ||
        stripos($produk->getJudul() . ' ' . $produk->getGame() . ' ' . $produk->getKategori(), $kataKunci) !== false);
    if ($cocokKategori && $cocokKata) {
        $hasil[] = $produk;
    }
}

$pageTitle = 'Katalog Akun Game';
$weekLabel = 'Week 6 · Sprint 05 — PHP OOP';
require __DIR__ . '/includes/header.php';
?>

    <main>
        <!-- ===== Hero ===== -->
        <section class="hero">
            <div class="container hero-grid">
                <div>
                    <h1>Akun game pilihan, transaksi aman pakai rekber.</h1>
                    <p class="lead">TriverseStore mempertemukan pembeli dan penjual akun game terverifikasi. Dana diteruskan ke penjual hanya setelah akun berpindah tangan dengan aman.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="#katalog">Lihat Katalog</a>
                        <a class="btn btn-secondary" href="#rekber">Cara Kerja Rekber</a>
                    </div>
                </div>
                <div class="hero-stats">
                    <div class="stat-card">
                        <div class="stat-label">Listing Akun</div>
                        <div class="stat-value"><?= count($products) ?></div>
                        <div class="stat-note">akun aktif minggu ini</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Penjual</div>
                        <div class="stat-value sage"><?= count($sellers) ?></div>
                        <div class="stat-note">terverifikasi identitas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Transaksi Rekber</div>
                        <div class="stat-value clay">12.480</div>
                        <div class="stat-note">selesai tanpa sengketa</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== Katalog (dirender dari objek) ===== -->
        <section class="section" id="katalog">
            <div class="container">
                <div class="section-head">
                    <div>
                        <h2>Katalog akun game</h2>
                        <p>Semua akun melewati pemeriksaan kepemilikan oleh tim kami sebelum tampil di katalog.</p>
                    </div>
                </div>

                <div class="toolbar">
                    <form class="search-box" method="get" action="index.php" style="display: flex; gap: 0.5rem;">
                        <input type="search" name="q" placeholder="Cari akun, game, atau kategori..." aria-label="Cari akun" value="<?= htmlspecialchars($kataKunci) ?>">
                        <?php if ($kategoriAktif !== 'Semua'): ?>
                            <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategoriAktif) ?>">
                        <?php endif; ?>
                        <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                    </form>
                    <div class="filter-group" role="group" aria-label="Filter kategori">
                        <?php foreach ($kategoriList as $kategori): ?>
                            <?php
                            $params = ['kategori' => $kategori];
                            if ($kataKunci !== '') {
                                $params['q'] = $kataKunci;
                            }
                            ?>
                            <a class="filter-chip<?= $kategori === $kategoriAktif ? ' active' : '' ?>" href="index.php?<?= http_build_query($params) ?>#katalog"><?= $kategori ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (count($hasil) > 0): ?>
                    <div class="game-grid">
                        <?php foreach ($hasil as $produk): ?>
                            <?php renderKartuProduk($produk); ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="state-box">
                        <h3>Tidak ada akun yang cocok</h3>
                        <p>Coba kata kunci lain atau pilih kategori "Semua".</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ===== Rekber ===== -->
        <section class="section" id="rekber" style="padding-top: 0;">
            <div class="container">
                <div class="rekber-strip">
                    <div class="rekber-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    </div>
                    <div>
                        <h2>Transaksi aman dengan rekening bersama</h2>
                        <p>Pembayaranmu ditahan oleh TriverseStore dan baru diteruskan ke penjual setelah kamu mengonfirmasi akun diterima dan bisa diakses penuh.</p>
                    </div>
                    <div class="rekber-steps">
                        <span class="rekber-step">Bayar ke TriverseStore</span>
                        <span class="rekber-step">Dana ditahan sistem</span>
                        <span class="rekber-step">Serah terima akun</span>
                        <span class="rekber-step">Dana diteruskan</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== Tentang ===== -->
        <section class="section" id="tentang" style="padding-top: 0;">
            <div class="container">
                <div class="section-head">
                    <div>
                        <h2>Tentang TriverseStore</h2>
                        <p>TriverseStore adalah proyek marketplace akun game yang dibangun bertahap selama satu semester mata kuliah Web Programming — mulai dari halaman HTML statis, lalu JavaScript, API, PHP prosedural, PHP OOP, hingga arsitektur MVC.</p>
                    </div>
                </div>
                <div class="hero-stats">
                    <div class="stat-card">
                        <div class="stat-label">Pemeriksaan Akun</div>
                        <div class="stat-value">100%</div>
                        <div class="stat-note">listing melewati cek kepemilikan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Garansi Rekber</div>
                        <div class="stat-value sage">24 jam</div>
                        <div class="stat-note">masa konfirmasi serah terima</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Biaya Layanan</div>
                        <div class="stat-value clay">5%</div>
                        <div class="stat-note">dari nilai transaksi, transparan</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/includes/footer.php'; ?>
