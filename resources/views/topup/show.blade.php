@extends('layouts.app', ['judul' => 'Order Top Up #' . $order->id])

@section('content')
    <main>
        <section class="section">
            <div class="container" style="max-width: 720px;">
                <div class="form-card">
                    <h2>Order Top Up #{{ $order->id }}</h2>
                    <p>Ringkasan order top up game-mu.</p>
                    <div class="alert alert-success show" role="status" style="margin-bottom: 1.25rem;">Mode demo: tidak ada pembayaran sungguhan. Order ini hanya contoh alur top up.</div>
                    <dl class="spec-list">
                        <div class="spec-row"><dt>Game</dt><dd>{{ $order->game }}</dd></div>
                        <div class="spec-row"><dt>Mata Uang</dt><dd>{{ $mataUang }}</dd></div>
                        <div class="spec-row"><dt>Nominal</dt><dd>{{ $order->getNominalLabel() }}</dd></div>
                        <div class="spec-row"><dt>ID Akun Game</dt><dd>{{ $order->game_user_id }}</dd></div>
                        <div class="spec-row"><dt>Status</dt><dd><span class="badge badge-limited">{{ $order->status }}</span></dd></div>
                        <div class="spec-row"><dt>Dibuat</dt><dd>{{ $order->created_at->format('d M Y, H:i') }}</dd></div>
                    </dl>
                    <div style="display: flex; gap: 0.5rem; margin-top: 1.25rem;">
                        <a class="btn btn-primary btn-sm" href="{{ route('topup.create') }}">Top Up Lagi</a>
                        <a class="btn btn-secondary btn-sm" href="{{ route('akun') }}">Lihat Akun Saya</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
