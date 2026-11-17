@extends('layouts.app', ['judul' => 'Top Up Game'])

@section('content')
    <main>
        <section class="section">
            <div class="container" style="max-width: 720px;">
                <div class="form-card">
                    <h2>Top Up Game</h2>
                    <p>Isi game, nominal, dan ID akun game-mu. Order langsung dicatat dan bisa dilihat di halaman Akun.</p>
                    <div class="alert alert-success show" role="status" style="margin-bottom: 1.25rem;">Mode demo: tidak ada pembayaran sungguhan dan tidak ada payment gateway. Order hanya dicatat sebagai contoh alur.</div>
                    <form method="POST" action="{{ route('topup.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="game">Game</label>
                            <select id="game" name="game" required>
                                @foreach ($games as $game => $mataUang)
                                    <option value="{{ $game }}" @selected(old('game') === $game)>{{ $game }} ({{ $mataUang }})</option>
                                @endforeach
                            </select>
                            @error('game')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <select id="nominal" name="nominal" required>
                                @foreach ($nominals as $nilai => $label)
                                    <option value="{{ $nilai }}" @selected(old('nominal') == $nilai)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('nominal')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label for="game_user_id">ID Akun Game</label>
                            <input type="text" id="game_user_id" name="game_user_id" value="{{ old('game_user_id') }}" maxlength="100" placeholder="Contoh: 12345678 (Mobile Legends)" required>
                            @error('game_user_id')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Buat Order Top Up</button>
                    </form>
                    @guest
                        <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--ink-soft);">Masuk dulu supaya order ini tersimpan di akunmu: <a href="{{ route('login') }}">Masuk</a> atau <a href="{{ route('register') }}">Daftar</a>.</p>
                    @endguest
                </div>
            </div>
        </section>
    </main>
@endsection
