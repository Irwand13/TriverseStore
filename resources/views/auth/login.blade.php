@extends('layouts.app', ['judul' => 'Masuk'])

@section('content')
    <div class="container narrow auth-wrap">
        <div class="form-card">
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
@endsection
