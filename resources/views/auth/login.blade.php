@extends('layouts.app', ['judul' => 'Masuk'])

@section('content')
    <div class="auth-wrap">
        <div class="container">
            <div class="auth-layout">
                <aside class="auth-brand">
                    <p class="eyebrow"><span class="dot"></span>TriverseStore — Rekening Bersama</p>
                    <h2>Jual beli akun game, <em>tanpa takut ketipu.</em></h2>
                    <p class="auth-brand-lead">Semua transaksi dilindungi rekber — dana diteruskan ke penjual setelah kamu mengonfirmasi akun diterima.</p>
                    <div class="auth-steps">
                        <div class="escrow-step">
                            <div class="step-num">01</div>
                            <h3>Dana ditahan sistem</h3>
                            <p>Dana dipegang TriverseStore, bukan penjual.</p>
                        </div>
                        <div class="escrow-step">
                            <div class="step-num">02</div>
                            <h3>Serah terima akun</h3>
                            <p>Penjual menyerahkan akun, kamu cek isinya.</p>
                        </div>
                        <div class="escrow-step">
                            <div class="step-num">03</div>
                            <h3>Dana diteruskan</h3>
                            <p>Konfirmasi akun diterima, dana diteruskan ke penjual.</p>
                        </div>
                    </div>
                    <p class="auth-trust"><span class="badge badge-available">Dana ditahan sistem</span></p>
                </aside>
                <div class="form-card auth-card">
                    <p class="form-step">Selamat datang kembali</p>
                    <h2>Masuk</h2>
                    <p>Masuk ke akun TriverseStore-mu untuk menjual akun dan melihat pesanan.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="255" required>
                            @error('email')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" id="password" name="password" required>
                            @error('password')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Masuk</button>
                    </form>
                    <p class="auth-foot">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
