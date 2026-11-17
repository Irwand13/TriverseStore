@extends('layouts.app', ['judul' => 'Daftar Akun'])

@section('content')
    <div class="auth-wrap">
        <div class="container">
            <div class="auth-layout">
                <aside class="auth-brand">
                    <p class="eyebrow"><span class="dot"></span>TriverseStore — Rekening Bersama</p>
                    <h2>Punya akun game <em>nganggur?</em></h2>
                    <p class="auth-brand-lead">Buat akun TriverseStore untuk menjual akun game dan melihat order top up-mu. Dana pembeli ditahan sistem sampai akun diterima.</p>
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
                    <p class="form-step">Satu menit untuk daftar</p>
                    <h2>Daftar Akun</h2>
                    <p>Buat akun TriverseStore untuk menjual akun game dan melihat order top up-mu.</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="255" required>
                            @error('name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="255" required>
                            @error('email')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi (minimal 8 karakter)</label>
                            <input type="password" id="password" name="password" required>
                            @error('password')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Ulangi Kata Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Buat Akun</button>
                    </form>
                    <p class="auth-foot">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
