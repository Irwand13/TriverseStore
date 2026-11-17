@extends('layouts.app', ['judul' => 'Daftar Akun'])

@section('content')
    <main>
        <section class="section">
            <div class="container" style="max-width: 560px;">
                <div class="form-card">
                    <h2>Daftar Akun</h2>
                    <p>Buat akun TriverseStore untuk menjual akun game dan melihat order top up-mu.</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="255" required>
                            @error('name')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="255" required>
                            @error('email')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi (minimal 8 karakter)</label>
                            <input type="password" id="password" name="password" required>
                            @error('password')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Ulangi Kata Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Buat Akun</button>
                    </form>
                    <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--ink-soft);">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>.</p>
                </div>
            </div>
        </section>
    </main>
@endsection
