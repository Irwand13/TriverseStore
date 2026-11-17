@extends('layouts.app', ['judul' => 'Order Top Up #' . $order->id])

@section('content')
    <div class="container">
        <div class="page-head">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('topup.create') }}">Top Up</a>
                <span>/</span>
                <span class="crumb-here">Order #{{ $order->id }}</span>
            </nav>
            <h1>Order Top Up #{{ $order->id }}</h1>
            <p>Ringkasan order top up game-mu.</p>
        </div>

        <div class="topup-layout">
            <div class="form-card">
                <p class="form-step">Langkah 2 dari 3 — Order dicatat</p>
                <h2>Ringkasan order</h2>
                <p>Mode demo: tidak ada pembayaran sungguhan. Order ini hanya contoh alur top up.</p>
                <dl class="spec-list">
                    <div class="spec-row"><dt>Game</dt><dd>{{ $order->game }}</dd></div>
                    <div class="spec-row"><dt>Mata Uang</dt><dd>{{ $mataUang }}</dd></div>
                    <div class="spec-row"><dt>Nominal</dt><dd>{{ $order->getNominalLabel() }}</dd></div>
                    <div class="spec-row"><dt>ID Akun Game</dt><dd>{{ $order->game_user_id }}</dd></div>
                    <div class="spec-row"><dt>Status</dt><dd><span class="badge badge-limited">{{ $order->status }}</span></dd></div>
                    <div class="spec-row"><dt>Dibuat</dt><dd>{{ $order->created_at->format('d M Y, H:i') }}</dd></div>
                </dl>
                <div class="btn-row">
                    <a class="btn btn-primary" href="{{ route('topup.create') }}">Top Up Lagi</a>
                    <a class="btn btn-secondary" href="{{ route('akun') }}">Lihat Akun Saya</a>
                </div>
            </div>

            <aside class="side-card">
                <h3>Status order</h3>
                <p>Ordermu sedang menunggu pemrosesan. Langkah berikutnya:</p>
                <ol class="side-steps">
                    <li><span class="step-no">01</span><span>Order dicatat — selesai.</span></li>
                    <li><span class="step-no">02</span><span>Pemrosesan — diamond sedang disiapkan untuk ID {{ $order->game_user_id }}.</span></li>
                    <li><span class="step-no">03</span><span>Selesai — diamond masuk ke akun game-mu.</span></li>
                </ol>
            </aside>
        </div>
    </div>
@endsection
