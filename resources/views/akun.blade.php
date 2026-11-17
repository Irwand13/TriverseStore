@extends('layouts.app', ['judul' => 'Akun Saya'])

@section('content')
    <main>
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <h2>Akun Saya</h2>
                        <p>Profil, listing yang kamu buat, dan order top up milikmu.</p>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button class="btn btn-secondary" type="submit">Keluar</button>
                        </form>
                    </div>
                </div>

                <div class="hero-stats" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Nama</div>
                        <div class="stat-value" style="font-size: 1.25rem;">{{ $user->name }}</div>
                        <div class="stat-note">{{ $user->email }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Member Sejak</div>
                        <div class="stat-value" style="font-size: 1.25rem;">{{ $user->created_at->format('d M Y') }}</div>
                        <div class="stat-note">akun TriverseStore</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Listing Saya</div>
                        <div class="stat-value sage">{{ count($listingSaya) }}</div>
                        <div class="stat-note">akun game dijual</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Order Top Up</div>
                        <div class="stat-value clay">{{ count($topupSaya) }}</div>
                        <div class="stat-note">pesanan tercatat</div>
                    </div>
                </div>

                <div class="section-head">
                    <div>
                        <h2>Listing saya</h2>
                        <p>Akun game yang kamu pasang di TriverseStore.</p>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="{{ route('products.create') }}">Jual Akun</a>
                    </div>
                </div>

                @if (count($listingSaya) > 0)
                    <div class="game-grid" style="margin-bottom: 2rem;">
                        @foreach ($listingSaya as $product)
                            @include('products._card', ['product' => $product])
                        @endforeach
                    </div>
                @else
                    <div class="state-box" style="margin-bottom: 2rem;">
                        <h3>Belum ada listing</h3>
                        <p>Kamu belum menjual akun apa pun. Pasang listing pertamamu lewat tombol Jual Akun.</p>
                    </div>
                @endif

                <div class="section-head">
                    <div>
                        <h2>Order top up saya</h2>
                        <p>Pesanan top up game yang tercatat di akunmu (demo).</p>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="{{ route('topup.create') }}">Top Up Game</a>
                    </div>
                </div>

                @if (count($topupSaya) > 0)
                    <dl class="spec-list">
                        @foreach ($topupSaya as $order)
                            <div class="spec-row">
                                <dt><a href="{{ route('topup.show', $order->id) }}">Order #{{ $order->id }} — {{ $order->game }}</a></dt>
                                <dd>{{ $order->getNominalLabel() }} · ID {{ $order->game_user_id }} · <span class="badge badge-limited">{{ $order->status }}</span></dd>
                            </div>
                        @endforeach
                    </dl>
                @else
                    <div class="state-box">
                        <h3>Belum ada order top up</h3>
                        <p>Kamu belum pernah top up. Coba isi form top up — order langsung tercatat di sini.</p>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
