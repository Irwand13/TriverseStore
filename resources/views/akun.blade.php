@extends('layouts.app', ['judul' => 'Akun Saya'])

@section('content')
    <div class="container">
        <div class="page-head">
            <h1>Akun Saya</h1>
            <p>Profil, listing yang kamu buat, dan order top up milikmu.</p>
        </div>

        <div class="profile-head">
            <div class="seller-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }} · Member sejak {{ $user->created_at->format('d M Y') }}</p>
            </div>
            <span class="spacer"></span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-secondary" type="submit">Keluar</button>
            </form>
        </div>

        <div class="stats-4">
            <div class="stat-card">
                <div class="stat-label">Listing saya</div>
                <div class="stat-value sage">{{ count($listingSaya) }}</div>
                <div class="stat-note">akun game dijual</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Order top up</div>
                <div class="stat-value clay">{{ count($topupSaya) }}</div>
                <div class="stat-note">pesanan tercatat</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Penjualan</div>
                <div class="stat-value">0</div>
                <div class="stat-note">akun terjual</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Rating</div>
                <div class="stat-value">—</div>
                <div class="stat-note">belum ada ulasan</div>
            </div>
        </div>

        <div class="section-head">
            <div>
                <h2>Listing saya</h2>
                <p>Akun game yang kamu pasang di TriverseStore.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('products.create') }}">Jual Akun</a>
        </div>

        @if (count($listingSaya) > 0)
            <div class="game-grid mb-2">
                @foreach ($listingSaya as $product)
                    @include('products._card', ['product' => $product, 'tampilkanAksi' => true])
                @endforeach
            </div>
        @else
            <div class="state-box mb-2">
                <h3>Belum ada listing</h3>
                <p>Kamu belum menjual akun apa pun. Pasang listing pertamamu lewat tombol Jual Akun.</p>
                <a class="btn btn-primary" href="{{ route('products.create') }}">Jual Akun</a>
            </div>
        @endif

        <div class="section-head">
            <div>
                <h2>Order top up saya</h2>
                <p>Pesanan top up game yang tercatat di akunmu (demo).</p>
            </div>
            <a class="btn btn-primary" href="{{ route('topup.create') }}">Top Up Game</a>
        </div>

        @if (count($topupSaya) > 0)
            <div class="form-card">
                @foreach ($topupSaya as $order)
                    <div class="order-row">
                        <div>
                            <a href="{{ route('topup.show', $order->id) }}">Order #{{ $order->id }} — {{ $order->game }}</a>
                            <div class="order-meta">{{ $order->getNominalLabel() }} · ID {{ $order->game_user_id }} · {{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <span class="badge badge-limited">{{ $order->status }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="state-box">
                <h3>Belum ada order top up</h3>
                <p>Kamu belum pernah top up. Coba isi form top up — order langsung tercatat di sini.</p>
                <a class="btn btn-primary" href="{{ route('topup.create') }}">Top Up Game</a>
            </div>
        @endif
    </div>
@endsection
