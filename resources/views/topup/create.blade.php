@extends('layouts.app', ['judul' => 'Top Up Game'])

@section('content')
    <div class="container">
        <div class="page-head">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('products.index') }}">Beranda</a>
                <span>/</span>
                <span class="crumb-here">Top Up</span>
            </nav>
            <h1>Top Up Game</h1>
            <p>Isi game, nominal, dan ID akun game-mu. Order langsung dicatat dan bisa dilihat di halaman Akun.</p>
        </div>

        <div class="topup-layout">
            <div class="form-card">
                <p class="form-step">Langkah 1 dari 3 — Pilih game</p>
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
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <select id="nominal" name="nominal" required>
                            @foreach ($nominals as $nilai => $label)
                                <option value="{{ $nilai }}" @selected(old('nominal') == $nilai)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('nominal')<p class="form-error">{{ $message }}</p>@enderror
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

            <aside class="side-card">
                <h3>Alur top up</h3>
                <p>Tiga langkah dari form sampai diamond masuk ke akunmu.</p>
                <ol class="side-steps">
                    <li><span class="step-no">01</span><span>Pilih game dan nominal, lalu isi ID akun game-mu.</span></li>
                    <li><span class="step-no">02</span><span>Order dicatat dan masuk antrean pemrosesan.</span></li>
                    <li><span class="step-no">03</span><span>Diamond dikirim ke ID yang kamu isi; status bisa dipantau di halaman Akun.</span></li>
                </ol>
            </aside>
        </div>
    </div>
@endsection
