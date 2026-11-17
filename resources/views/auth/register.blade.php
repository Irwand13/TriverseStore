@extends('layouts.app', ['judul' => 'Daftar Akun'])

@section('content')
    <div class="container narrow auth-wrap">
        <div class="form-card">
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
@endsection
