@extends('layouts.app', ['judul' => 'Katalog Akun Game'])

@section('content')
    <main>
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
                        <div class="stat-value">{{ $totalProducts }}</div>
                        <div class="stat-note">akun aktif minggu ini</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Penjual</div>
                        <div class="stat-value sage">{{ $sellerCount }}</div>
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

        <section class="section" id="katalog">
            <div class="container">
                <div class="section-head">
                    <div>
                        <h2>Katalog akun game</h2>
                        <p>Semua akun melewati pemeriksaan kepemilikan oleh tim kami sebelum tampil di katalog.</p>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="{{ route('products.create') }}">Tambah Produk</a>
                    </div>
                </div>

                <div class="toolbar">
                    <form class="search-box" method="get" action="{{ route('products.index') }}" style="display: flex; gap: 0.5rem;">
                        <input type="search" name="q" placeholder="Cari akun, game, atau kategori..." aria-label="Cari akun" value="{{ $kataKunci }}">
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
                        <h3>Tidak ada akun yang cocok</h3>
                        <p>Coba kata kunci lain atau pilih kategori "Semua".</p>
                    </div>
                @endif
            </div>
        </section>

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

        <section class="section" id="tentang" style="padding-top: 0;">
            <div class="container">
                <div class="section-head">
                    <div>
                        <h2>Tentang TriverseStore</h2>
                        <p>TriverseStore adalah proyek marketplace akun game yang dibangun bertahap selama satu semester mata kuliah Web Programming — mulai dari halaman HTML statis, lalu JavaScript, API, PHP prosedural, PHP OOP, arsitektur MVC, hingga Laravel + database.</p>
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
@endsection
