@extends('layouts.app', ['judul' => 'Katalog Akun Game'])

@section('content')
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow"><span class="dot"></span>Marketplace akun game Indonesia, dilindungi rekber</span>
                <h1>Akun game pilihan, transaksi aman pakai rekber.</h1>
                <p class="lead">TriverseStore mempertemukan pembeli dan penjual akun game terverifikasi. Dana diteruskan ke penjual hanya setelah akun berpindah tangan dengan aman.</p>
                <form class="hero-search" method="get" action="{{ route('market') }}" role="search">
                    <input type="search" name="q" placeholder="Cari akun, game, atau kategori" aria-label="Cari akun" value="{{ $kataKunci }}">
                    <select name="kategori" aria-label="Pilih kategori">
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori }}" @selected($kategori === $kategoriAktif)>{{ $kategori === 'Semua' ? 'Semua game' : $kategori }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>
                <div class="stat-row">
                    <div class="stat">
                        <div class="stat-value">{{ number_format($totalProducts, 0, ',', '.') }}</div>
                        <div class="stat-note">Listing akun aktif</div>
                    </div>
                    <div class="stat-div" aria-hidden="true"></div>
                    <div class="stat">
                        <div class="stat-value sage">{{ $sellerCount }}</div>
                        <div class="stat-note">Penjual terverifikasi</div>
                    </div>
                    <div class="stat-div" aria-hidden="true"></div>
                    <div class="stat">
                        <div class="stat-value clay">12.480</div>
                        <div class="stat-note">Transaksi rekber selesai</div>
                    </div>
                </div>
            </div>
            <div class="escrow-card">
                <div class="escrow-head">
                    <span class="escrow-title">Cara kerja rekber</span>
                    <span class="badge badge-available">Dana ditahan sistem</span>
                </div>
                <h3>Uangmu tidak langsung pergi ke penjual.</h3>
                <p>Setiap transaksi melewati rekening bersama TriverseStore. Penjual baru dibayar setelah akun benar-benar ada di tanganmu dan sesuai deskripsi.</p>
                <div class="timeline">
                    <div class="timeline-track">
                        <span class="tl-dot done">1</span>
                        <span class="tl-line done"></span>
                        <span class="tl-dot done">2</span>
                        <span class="tl-line"></span>
                        <span class="tl-dot">3</span>
                        <span class="tl-line"></span>
                        <span class="tl-dot">4</span>
                    </div>
                    <div class="timeline-labels">
                        <span>Bayar</span>
                        <span>Dana ditahan</span>
                        <span>Serah terima</span>
                        <span>Selesai</span>
                    </div>
                </div>
                <div class="escrow-note">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    <span>Tidak sesuai deskripsi? Ajukan komplain dan dana kembali 100%.</span>
                </div>
                <a class="escrow-link" href="{{ route('tentang') }}#cara-rekber">Pelajari cara kerja rekber</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2>Belanja berdasarkan game</h2>
                    <p>Pilih kategori, langsung lihat akun yang dijual di kategori itu.</p>
                </div>
                <a class="btn btn-secondary btn-sm" href="{{ route('market') }}">Lihat semua game</a>
            </div>
            <div class="cat-tiles">
                @foreach ($kategoriList as $kategori)
                    @if ($kategori !== 'Semua')
                        <a class="cat-tile" href="{{ route('market', ['kategori' => $kategori]) }}">
                            <span class="cat-initial">{{ strtoupper(substr($kategori, 0, 1)) }}</span>
                            <span class="cat-name">{{ $kategori }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-tight" id="katalog">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2>Katalog akun game</h2>
                    <p>Semua akun melewati pemeriksaan kepemilikan oleh tim kami sebelum tampil di katalog.</p>
                </div>
                <a class="btn btn-primary" href="{{ route('products.create') }}">Tambah Produk</a>
            </div>

            <div class="toolbar">
                <form class="toolbar-form" method="get" action="{{ route('products.index') }}">
                    <div class="search-box">
                        <input type="search" name="q" placeholder="Cari akun, game, atau kategori" aria-label="Cari akun" value="{{ $kataKunci }}">
                    </div>
                    @if ($kategoriAktif !== 'Semua')
                        <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                    @endif
                    <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                </form>
                <div class="filter-group" role="group" aria-label="Filter kategori">
                    @foreach ($kategoriList as $kategori)
                        <a class="filter-chip{{ $kategori === $kategoriAktif ? ' active' : '' }}" href="{{ route('products.index', ['kategori' => $kategori, 'q' => $kataKunci]) }}#katalog">{{ $kategori }}</a>
                    @endforeach
                </div>
            </div>

            @if (count($products) > 0)
                <div class="game-grid">
                    @foreach ($products as $product)
                        @include('products._card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="state-box">
                    <svg class="state-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    <h3>Tidak ada akun yang cocok</h3>
                    <p>Coba kata kunci lain atau pilih kategori lain. Semua listing yang tampil sudah lolos pemeriksaan tim kami.</p>
                    <a class="btn btn-secondary" href="{{ route('products.index') }}#katalog">Lihat semua akun</a>
                </div>
            @endif
        </div>
    </section>

    <section class="section section-tight" id="rekber">
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

    <section class="section section-tight">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2>Kenapa beli di TriverseStore</h2>
                    <p>Tiga hal yang kami jaga di setiap transaksi, bukan sekadar janji di halaman depan.</p>
                </div>
            </div>
            <div class="trust-row">
                <div class="trust-item">
                    <h3>Data login terenkripsi</h3>
                    <p>Data akun diserahkan lewat rekening bersama dan hanya bisa dibuka pembeli pada transaksi terkait.</p>
                </div>
                <div class="trust-item">
                    <h3>Mediasi admin 24 jam</h3>
                    <p>Komplain ditangani admin dengan bukti chat dan riwayat status, bukan adu klaim sepihak.</p>
                </div>
                <div class="trust-item">
                    <h3>Garansi refund penuh</h3>
                    <p>Penjual tidak menyerahkan akun dalam 1×24 jam? Dana otomatis kembali ke pembeli.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
