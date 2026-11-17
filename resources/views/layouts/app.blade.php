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
    <a class="skip-link" href="#konten">Lewati ke konten</a>

    <div class="announce">Semua transaksi dilindungi rekber — dana diteruskan ke penjual setelah kamu mengonfirmasi akun diterima.</div>

    <header class="site-header">
        <div class="container header-inner">
            <a class="wordmark" href="{{ route('products.index') }}">Triverse<span class="accent">Store</span></a>
            <nav class="main-nav" aria-label="Navigasi utama">
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('market') }}" class="{{ request()->routeIs('market') ? 'active' : '' }}">Market</a>
                <a href="{{ route('topup.create') }}" class="{{ request()->routeIs('topup.*') ? 'active' : '' }}">Top Up</a>
                <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>
            </nav>
            <div class="header-actions">
                @auth
                    <a class="btn btn-secondary btn-sm" href="{{ route('akun') }}">{{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline-form">
                        @csrf
                        <button class="btn btn-secondary btn-sm" type="submit">Keluar</button>
                    </form>
                @else
                    <a class="btn btn-secondary btn-sm" href="{{ route('login') }}">Masuk</a>
                    <a class="btn btn-secondary btn-sm" href="{{ route('register') }}">Daftar</a>
                @endauth
                <a class="btn btn-primary btn-sm" href="{{ route('products.create') }}">Jual Akun</a>
            </div>
        </div>
    </header>

    @if (session('sukses'))
        <div class="container flash">
            <div class="alert alert-success show" role="status">{{ session('sukses') }}</div>
        </div>
    @endif

    <main id="konten">
        @yield('content')
    </main>

    <nav class="mobile-nav" aria-label="Navigasi bawah">
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg>
            Beranda
        </a>
        <a href="{{ route('market') }}" class="{{ request()->routeIs('market') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            Market
        </a>
        <a href="{{ route('products.create') }}" class="nav-sell">
            <span class="sell-dot">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            </span>
            Jual
        </a>
        <a href="{{ route('topup.create') }}" class="{{ request()->routeIs('topup.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
            Top Up
        </a>
        <a href="{{ route('akun') }}" class="{{ request()->routeIs('akun') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            Akun
        </a>
    </nav>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a class="wordmark" href="{{ route('products.index') }}">Triverse<span class="accent">Store</span></a>
                    <p class="footer-tagline">Marketplace akun game dengan rekening bersama. Beli dan jual akun tanpa khawatir penipuan.</p>
                </div>
                <div>
                    <div class="footer-label">Marketplace</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('market') }}">Market</a></li>
                        <li><a href="{{ route('topup.create') }}">Top Up Game</a></li>
                        <li><a href="{{ route('products.create') }}">Jual Akun</a></li>
                        <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-label">Keamanan</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('tentang') }}#cara-rekber">Cara Kerja Rekber</a></li>
                        <li><a href="{{ route('tentang') }}#jaminan">Garansi dan Refund</a></li>
                        <li><a href="{{ route('tentang') }}#jaminan">Tips Anti Penipuan</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-label">Bantuan</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('tentang') }}#cara-rekber">Panduan Pembeli</a></li>
                        <li><a href="{{ route('tentang') }}#cara-rekber">Panduan Penjual</a></li>
                        <li><a href="{{ route('akun') }}">Akun Saya</a></li>
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
