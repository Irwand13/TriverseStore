@extends('layouts.app', ['judul' => 'Tentang Kami'])

@section('content')
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow"><span class="dot"></span>Tentang TriverseStore</span>
                <h1>Marketplace akun game yang dibangun dengan rekber.</h1>
                <p class="lead">TriverseStore mempertemukan pembeli dan penjual akun game terverifikasi. Setiap listing melewati pemeriksaan kepemilikan, dan setiap transaksi dijaga rekening bersama.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('market') }}">Jelajahi Market</a>
                    <a class="btn btn-secondary" href="{{ route('topup.create') }}">Top Up Game</a>
                </div>
            </div>
            <div class="hero-stats">
                <div class="stat-card">
                    <div class="stat-label">Listing akun</div>
                    <div class="stat-value">10</div>
                    <div class="stat-note">akun aktif minggu ini</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Penjual</div>
                    <div class="stat-value sage">5</div>
                    <div class="stat-note">terverifikasi identitas</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Transaksi rekber</div>
                    <div class="stat-value clay">12.480</div>
                    <div class="stat-note">selesai tanpa sengketa</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="cara-rekber">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2>Cara kerja rekber</h2>
                    <p>Dana pembeli tidak langsung sampai ke penjual. TriverseStore menahannya sampai serah terima akun dikonfirmasi.</p>
                </div>
            </div>
            <div class="steps">
                <div class="step-card">
                    <div class="step-num">01</div>
                    <h3>Pembeli membayar</h3>
                    <p>Pembayaran masuk ke rekening bersama TriverseStore, bukan langsung ke penjual.</p>
                </div>
                <div class="step-card key">
                    <span class="step-tag">Dana aman di sini</span>
                    <div class="step-num">02</div>
                    <h3>Dana ditahan sistem</h3>
                    <p>Selama akun belum diserahkan, dana tidak bisa diambil siapa pun — penjual pun tidak.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">03</div>
                    <h3>Serah terima akun</h3>
                    <p>Penjual menyerahkan data login lewat jalur rekber; pembeli memeriksa dan mengonfirmasi.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">04</div>
                    <h3>Dana diteruskan</h3>
                    <p>Setelah konfirmasi, dana diteruskan ke penjual. Tanpa konfirmasi 1×24 jam, dana kembali ke pembeli.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-tight" id="jaminan">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2>Garansi dan perlindungan</h2>
                    <p>Tiga janji yang berlaku di setiap transaksi, bukan sekadar tulisan di halaman depan.</p>
                </div>
            </div>
            <div class="trust-row">
                <div class="trust-item">
                    <h3>Refund penuh</h3>
                    <p>Akun tidak sesuai deskripsi atau tidak diserahkan dalam 1×24 jam — dana kembali 100% ke pembeli.</p>
                </div>
                <div class="trust-item">
                    <h3>Mediasi admin</h3>
                    <p>Sengketa ditangani admin dengan bukti chat dan riwayat status, bukan adu klaim sepihak.</p>
                </div>
                <div class="trust-item">
                    <h3>Data login terenkripsi</h3>
                    <p>Data akun hanya dibuka pembeli pada transaksi terkait, dan tidak disimpan sembarangan.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-tight">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2>Tim di balik TriverseStore</h2>
                    <p>TriverseStore adalah proyek kelompok mata kuliah Web Programming — dibangun bertahap selama satu semester, dari halaman HTML statis, JavaScript, API, PHP prosedural, PHP OOP, arsitektur MVC, hingga Laravel + database.</p>
                </div>
            </div>
            <div class="hero-stats">
                <div class="stat-card">
                    <div class="stat-label">Pemeriksaan akun</div>
                    <div class="stat-value">100%</div>
                    <div class="stat-note">listing melewati cek kepemilikan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Garansi rekber</div>
                    <div class="stat-value sage">24 jam</div>
                    <div class="stat-note">masa konfirmasi serah terima</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Biaya layanan</div>
                    <div class="stat-value clay">5%</div>
                    <div class="stat-note">dari nilai transaksi, transparan</div>
                </div>
            </div>
            <p class="closing-note">Punya pertanyaan soal listing atau rekber? Hubungi tim kami lewat halaman Akun setelah masuk, atau datang langsung saat jam praktikum.</p>
        </div>
    </section>
@endsection
