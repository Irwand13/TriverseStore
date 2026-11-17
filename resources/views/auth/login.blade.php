@extends('layouts.app', ['judul' => 'Masuk'])

@section('content')
    <main>
        <section class="section">
            <div class="container" style="max-width: 560px;">
                <div class="form-card">
                    <h2>Masuk</h2>
                    <p>Masuk ke akun TriverseStore-mu untuk menjual akun dan melihat pesanan.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="255" required>
                            @error('email')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" id="password" name="password" required>
                            @error('password')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Masuk</button>
                    </form>
                    <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--ink-soft);">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>.</p>
                </div>
            </div>
        </section>
    </main>
@endsection
