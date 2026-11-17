@extends('layouts.app', ['judul' => 'Tentang Kami'])

@section('content')
    <main>
        <section class="hero">
            <div class="container hero-grid">
                <div>
                    <h1>Marketplace akun game yang dibangun dengan rekber.</h1>
                    <p class="lead">TriverseStore mempertemukan pembeli dan penjual akun game terverifikasi. Setiap listing melewati pemeriksaan kepemilikan, dan setiap transaksi dijaga rekening bersama.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="{{ route('market') }}">Jelajahi Market</a>
                        <a class="btn btn-secondary" href="{{ route('topup.create') }}">Top Up Game</a>
                    </div>
                </div>
                <div class="hero-stats">
                    <div class="stat-card">
                        <div class="stat-label">Listing Akun</div>
                        <div class="stat-value">10</div>
                        <div class="stat-note">akun aktif minggu ini</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Penjual</div>
                        <div class="stat-value sage">5</div>
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

        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <h2>Cara kerja rekber</h2>
                        <p>Dana pembeli tidak langsung sampai ke penjual. TriverseStore menahannya sampai serah terima akun dikonfirmasi.</p>
                    </div>
                </div>
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

        <section class="section" style="padding-top: 0;">
            <div class="container">
                <div class="section-head">
                    <div>
                        <h2>Tim di balik TriverseStore</h2>
                        <p>TriverseStore adalah proyek kelompok mata kuliah Web Programming — dibangun bertahap selama satu semester, dari halaman HTML statis, JavaScript, API, PHP prosedural, PHP OOP, arsitektur MVC, hingga Laravel + database.</p>
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
                <p style="margin-top: 1.5rem; color: var(--ink-soft);">Punya pertanyaan soal listing atau rekber? Hubungi tim kami lewat halaman Akun setelah masuk, atau datang langsung saat jam praktikum.</p>
            </div>
        </section>
    </main>
@endsection
