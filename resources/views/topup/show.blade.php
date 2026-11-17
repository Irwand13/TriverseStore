@extends('layouts.app', ['judul' => 'Order Top Up #' . $order->id])

@section('content')
    <div class="container">
        <div class="page-head topup-head">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('topup.create') }}">Top Up</a>
                <span>/</span>
                <span class="crumb-here">Order #{{ $order->id }}</span>
            </nav>
            <p class="eyebrow">Order Dicatat · Menunggu Pemrosesan</p>
            <h1>Order Top Up #{{ $order->id }}</h1>
            <p>Ringkasan order top up game-mu.</p>
        </div>

        <div class="topup-layout">
            <div class="form-card topup-card">
                <p class="form-step">Langkah 2 dari 3 — Order dicatat</p>
                <h2>Ringkasan order</h2>
                <div class="order-status">
                    <p class="order-status-label">Status order</p>
                    <p class="order-status-value">{{ $order->status }}</p>
                    <p class="order-status-note">{{ $mataUang }} sedang disiapkan untuk ID {{ $order->game_user_id }}. Pantau perkembangannya di halaman Akun.</p>
                </div>
                <p>Mode demo: tidak ada pembayaran sungguhan. Order ini hanya contoh alur top up.</p>
                <dl class="spec-list">
                    <div class="spec-row"><dt>Game</dt><dd>{{ $order->game }}</dd></div>
                    <div class="spec-row"><dt>Mata Uang</dt><dd>{{ $mataUang }}</dd></div>
                    @if ($order->paket)
                        <div class="spec-row"><dt>Paket</dt><dd>{{ $order->paket }}</dd></div>
                        <div class="spec-row"><dt>Harga</dt><dd>{{ $order->getNominalLabel() }}</dd></div>
                    @else
                        <div class="spec-row"><dt>Nominal</dt><dd>{{ $order->getNominalLabel() }}</dd></div>
                    @endif
                    <div class="spec-row"><dt>ID Akun Game</dt><dd>{{ $order->game_user_id }}</dd></div>
                    <div class="spec-row"><dt>Status</dt><dd><span class="badge badge-limited">{{ $order->status }}</span></dd></div>
                    <div class="spec-row"><dt>Dibuat</dt><dd>{{ $order->created_at->format('d M Y, H:i') }}</dd></div>
                </dl>
                @if ($order->paket)
                    <p class="form-hint nominal-footnote">Harga paket dari Codashop / itemku, dicek 17 Nov 2026. Harga bisa berubah sewaktu-waktu. Top up ini demo, bukan harga jual.</p>
                @endif
                <div class="btn-row">
                    <a class="btn btn-primary" href="{{ route('topup.create') }}">Top Up Lagi</a>
                    <a class="btn btn-secondary" href="{{ route('akun') }}">Lihat Akun Saya</a>
                </div>
            </div>

            <aside class="side-card side-card--dark topup-side">
                <h3>Status order</h3>
                <p>Ordermu sedang menunggu pemrosesan. Langkah berikutnya:</p>
                <ol class="side-steps">
                    <li class="step-done"><span class="step-no">01</span><span>Order dicatat — selesai.</span><span class="step-state">Selesai</span></li>
                    <li class="step-active"><span class="step-no">02</span><span>Pemrosesan — {{ $mataUang }} sedang disiapkan untuk ID {{ $order->game_user_id }}.</span><span class="step-state">Berjalan</span></li>
                    <li class="step-next"><span class="step-no">03</span><span>Selesai — {{ $mataUang }} masuk ke akun game-mu.</span><span class="step-state">Berikutnya</span></li>
                </ol>
            </aside>
        </div>
    </div>
@endsection
