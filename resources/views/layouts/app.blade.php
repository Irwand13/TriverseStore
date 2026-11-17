<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul ?? 'TriverseStore' }} — TriverseStore</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header class="site-header">
        <div class="container header-inner">
            <a class="wordmark" href="{{ route('products.index') }}">Triverse<span class="accent">Store</span></a>
            <nav class="main-nav">
                <a href="{{ route('products.index') }}" class="active">Katalog</a>
                <a href="{{ route('products.index') }}#rekber">Cara Rekber</a>
                <a href="{{ route('products.index') }}#tentang">Tentang</a>
            </nav>
            <div class="header-actions">
                <a class="btn btn-secondary btn-sm" href="{{ route('products.index') }}#katalog">Masuk</a>
                <a class="btn btn-primary btn-sm" href="{{ route('products.create') }}">Jual Akun</a>
            </div>
        </div>
    </header>

    @if (session('sukses'))
        <div class="container" style="padding-top: 1.25rem;">
            <div class="alert alert-success show" role="status">{{ session('sukses') }}</div>
        </div>
    @endif

    @yield('content')

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a class="wordmark" href="{{ route('products.index') }}">Triverse<span class="accent">Store</span></a>
                    <p style="margin-top: 0.75rem;">Marketplace akun game dengan rekening bersama. Beli dan jual akun tanpa khawatir penipuan.</p>
                </div>
                <div>
                    <h3>Marketplace</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('products.index') }}#katalog">Katalog Akun</a></li>
                        <li><a href="{{ route('products.index') }}#rekber">Cara Rekber</a></li>
                        <li><a href="{{ route('products.index') }}#tentang">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Bantuan</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('products.index') }}#rekber">Panduan Pembeli</a></li>
                        <li><a href="{{ route('products.index') }}#rekber">Panduan Penjual</a></li>
                        <li><a href="{{ route('products.index') }}#tentang">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; 2026 TriverseStore — Tugas Kelompok Web Programming.</span>
                <span>Week 9 · Sprint 07 — Laravel + CRUD + Database</span>
            </div>
        </div>
    </footer>

</body>
</html>
