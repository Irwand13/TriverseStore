<?php
/* Partial header — dipakai index.php & detail.php (Week 5).
   Variabel yang diharapkan: $pageTitle (string). */
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
    <link rel="stylesheet" href="assets/css/style.css">
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
