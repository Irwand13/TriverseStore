@extends('layouts.app', ['judul' => 'Top Up Game'])

@section('content')
    <div class="container">
        <div class="page-head topup-head">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('products.index') }}">Beranda</a>
                <span>/</span>
                <span class="crumb-here">Top Up</span>
            </nav>
            <p class="eyebrow">Top-Up Demo · Tanpa Payment Gateway</p>
            <h1>Top Up Game</h1>
            <p>Isi game, paket, dan ID akun game-mu. Order langsung dicatat dan bisa dilihat di halaman Akun.</p>
        </div>

        <div class="topup-layout">
            <div class="form-card topup-card">
                <p class="form-step">Top up demo — tiga langkah</p>
                <h2>Isi detail top up</h2>
                <p>Mode demo: tidak ada pembayaran sungguhan dan tidak ada payment gateway. Order hanya dicatat sebagai contoh alur.</p>
                <form method="POST" action="{{ route('topup.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="game">Game</label>
                        <select id="game" name="game" required>
                            @foreach ($games as $game => $mataUang)
                                <option value="{{ $game }}" @selected(old('game') === $game)>{{ $game }} ({{ $mataUang }})</option>
                            @endforeach
                        </select>
                        @error('game')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    @php($gameTerpilih = old('game', 'Mobile Legends'))
                    <div class="form-group">
                        @foreach ($packages as $game => $daftar)
                            <div class="paket-group" data-games="{{ $game }}" @if ($gameTerpilih !== $game) hidden @endif>
                                <label id="paket-label-{{ $loop->index }}">Paket {{ $games[$game] }}</label>
                                <div class="paket-tiles" role="radiogroup" aria-labelledby="paket-label-{{ $loop->index }}">
                                    @foreach ($daftar as $kunci => $paket)
                                        <label class="paket-tile">
                                            <input type="radio" name="paket" value="{{ $kunci }}" @checked(old('paket') == $kunci || (old('paket') === null && $loop->first))>
                                            <span class="paket-jumlah">{{ number_format($paket['jumlah'], 0, ',', '.') }} {{ $games[$game] }}</span>
                                            <span class="paket-harga">Rp {{ number_format($paket['harga'], 0, ',', '.') }}</span>
                                            <span class="paket-satuan">@if ($paket['bonus']){{ $paket['bonus'] }}@else Rp {{ number_format($paket['perUnit'], 0, ',', '.') }} / {{ $games[$game] }}@endif</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="nominal-group" data-games="Roblox|Honor of Kings|Call of Duty: Mobile" @if (isset($packages[$gameTerpilih])) hidden @endif>
                            <label id="nominal-label">Nominal</label>
                            <div class="nominal-tiles" role="radiogroup" aria-labelledby="nominal-label">
                                @foreach ($nominals as $nilai => $label)
                                    <label class="nominal-tile">
                                        <input type="radio" name="nominal" value="{{ $nilai }}" @checked(old('nominal') == $nilai || (old('nominal') === null && $loop->first))>
                                        <span class="nominal-price">{{ $label }}</span>
                                        <span class="nominal-diamond">±{{ number_format($tarifDiamond[$nilai]['diamond'], 0, ',', '.') }} Diamond ML</span>
                                        <span class="nominal-rate">Rp {{ number_format($tarifDiamond[$nilai]['perDiamond'], 0, ',', '.') }} / Diamond</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('paket')<p class="form-error">{{ $message }}</p>@enderror
                        @error('nominal')<p class="form-error">{{ $message }}</p>@enderror
                        <p class="form-hint nominal-footnote" data-games="Mobile Legends|Free Fire|Genshin Impact|PUBG Mobile|Valorant" @if (! isset($packages[$gameTerpilih])) hidden @endif>Harga paket dari Codashop (Mobile Legends, Free Fire, PUBG Mobile, Valorant) dan itemku (Genshin Impact, dicek silang dengan Codashop) — dicek 17 Nov 2026. Harga bisa berubah sewaktu-waktu. Top up ini demo, bukan harga jual.</p>
                        <p class="form-hint nominal-footnote" data-games="Roblox|Honor of Kings|Call of Duty: Mobile" @if (isset($packages[$gameTerpilih])) hidden @endif>Perkiraan Diamond Mobile Legends berdasarkan harga pasar (Codashop, itemku, VYGaming, Sehtzone — dicek 17 Nov 2026). Harga bisa berubah; mata uang game lain beda nilainya. Top up ini demo, bukan harga jual.</p>
                    </div>
                    <div class="form-group">
                        <label for="game_user_id">ID Akun Game</label>
                        <input type="text" id="game_user_id" name="game_user_id" value="{{ old('game_user_id') }}" maxlength="100" placeholder="Contoh: 12345678 (Mobile Legends)" required>
                        <p class="form-hint">Periksa lagi ID-mu — diamond yang salah kirim tidak bisa ditarik kembali.</p>
                        @error('game_user_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Buat Order Top Up</button>
                </form>
                @guest
                    <p class="auth-foot">Masuk dulu supaya order ini tersimpan di akunmu: <a href="{{ route('login') }}">Masuk</a> atau <a href="{{ route('register') }}">Daftar</a>.</p>
                @endguest
            </div>

            <aside class="side-card side-card--dark topup-side">
                <h3>Alur top up</h3>
                <p>Tiga langkah dari form sampai mata uang game masuk ke akunmu.</p>
                <ol class="side-steps">
                    <li><span class="step-no">01</span><span>Pilih game dan paketnya, lalu isi ID akun game-mu.</span></li>
                    <li><span class="step-no">02</span><span>Order dicatat dan masuk antrean pemrosesan.</span></li>
                    <li><span class="step-no">03</span><span>Paket dikirim ke ID yang kamu isi; status bisa dipantau di halaman Akun.</span></li>
                </ol>
            </aside>
        </div>
    </div>

    <script>
        // Ganti kelompok paket mengikuti game yang dipilih: kelompok
        // yang disembunyikan ikut di-disable supaya radionya tidak
        // terkirim dan tidak menghalangi submit.
        (function () {
            var pilihGame = document.getElementById('game');
            var kelompok = document.querySelectorAll('[data-games]');
            function tampilkan() {
                var game = pilihGame.value;
                kelompok.forEach(function (el) {
                    var cocok = el.getAttribute('data-games').split('|').indexOf(game) !== -1;
                    el.hidden = !cocok;
                    el.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                        radio.disabled = !cocok;
                    });
                    if (cocok && !el.querySelector('input[type="radio"]:checked')) {
                        var pertama = el.querySelector('input[type="radio"]');
                        if (pertama) pertama.checked = true;
                    }
                });
            }
            pilihGame.addEventListener('change', tampilkan);
            tampilkan();
        })();
    </script>
@endsection
