<?php
/* ============================================================
   Layout utama — Week 7 · Sprint 06 (MVC)
   renderLayout() adalah satu-satunya tempat kerangka HTML
   (head, header, footer) ditulis. Controller memanggilnya
   dengan judul halaman + file View konten + data; konten
   dirender lebih dulu ke string (output buffering), lalu
   disisipkan ke kerangka. View konten tidak pernah menulis
   header/footer sendiri.
   ============================================================ */

function renderLayout(string $judul, string $kontenFile, array $data = []): void
{
    extract($data);
    $pageTitle = $judul;

    ob_start();
    require $kontenFile;
    $konten = ob_get_clean();
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — TriverseStore</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- ===== Header / Navigasi ===== -->
    <header class="site-header">
        <div class="container header-inner">
            <a class="wordmark" href="index.php">Triverse<span class="accent">Store</span></a>
            <nav class="main-nav">
                <a href="index.php" class="active">Katalog</a>
                <a href="index.php#rekber">Cara Rekber</a>
                <a href="index.php#tentang">Tentang</a>
            </nav>
            <div class="header-actions">
                <a class="btn btn-secondary btn-sm" href="index.php#katalog">Masuk</a>
                <a class="btn btn-primary btn-sm" href="index.php#katalog">Jual Akun</a>
            </div>
        </div>
    </header>

<?= $konten ?>

    <!-- ===== Footer ===== -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a class="wordmark" href="index.php">Triverse<span class="accent">Store</span></a>
                    <p style="margin-top: 0.75rem;">Marketplace akun game dengan rekening bersama. Beli dan jual akun tanpa khawatir penipuan.</p>
                </div>
                <div>
                    <h3>Marketplace</h3>
                    <ul class="footer-links">
                        <li><a href="index.php#katalog">Katalog Akun</a></li>
                        <li><a href="index.php#rekber">Cara Rekber</a></li>
                        <li><a href="index.php#tentang">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Bantuan</h3>
                    <ul class="footer-links">
                        <li><a href="index.php#rekber">Panduan Pembeli</a></li>
                        <li><a href="index.php#rekber">Panduan Penjual</a></li>
                        <li><a href="index.php#tentang">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; 2026 TriverseStore — Tugas Kelompok Web Programming.</span>
                <span>Week 7 · Sprint 06 — MVC</span>
            </div>
        </div>
    </footer>

</body>
</html>
    <?php
}
