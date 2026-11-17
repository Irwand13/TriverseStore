@extends('layouts.app', ['judul' => $product->judul])

@section('content')
    <main class="container">
        <nav class="breadcrumb">
            <a href="{{ route('products.index') }}">Katalog</a>
            <span>/</span>
            <span>{{ $product->kategori }}</span>
            <span>/</span>
            <span>{{ $product->game }}</span>
        </nav>

        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
            <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product->id) }}">Ubah Produk</a>
            <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Hapus produk ini?')" style="display: inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-secondary btn-sm" type="submit">Hapus Produk</button>
            </form>
        </div>

        <div class="detail-grid">
            <div class="detail-media">
                <img src="{{ $product->getGambarUrl() }}" alt="Key art {{ $product->game }}">
            </div>

            <div class="detail-info">
                <span class="card-category">{{ $product->kategori }} · {{ $product->game }}</span>
                <h1>{{ $product->judul }}</h1>
                <div class="card-meta" style="margin-top: 0.6rem;">
                    <span class="rating"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>{{ $product->seller_rating }}</span>
                    <span class="dot"></span>
                    <span>{{ number_format($product->seller_penjualan, 0, ',', '.') }} penjualan penjual</span>
                    <span class="dot"></span>
                    <span class="badge {{ $product->getBadgeClass() }}">{{ $product->status }}</span>
                </div>
                <p class="lead">{{ $product->deskripsi }}</p>

                <dl class="spec-list">
                    <div class="spec-row"><dt>Game</dt><dd>{{ $product->game }}</dd></div>
                    <div class="spec-row"><dt>Platform</dt><dd>{{ $product->platform }}</dd></div>
                    <div class="spec-row"><dt>Level / Rank</dt><dd>{{ $product->level }}</dd></div>
                    <div class="spec-row"><dt>Item Unggulan</dt><dd>{{ $product->item_unggulan }}</dd></div>
                    <div class="spec-row"><dt>Kota Penjual</dt><dd>{{ $product->seller_kota }}</dd></div>
                </dl>

                <div class="buy-panel">
                    @if ($product->getHargaCoret() !== null)
                        <div class="price-old">Rp {{ number_format($product->getHargaCoret(), 0, ',', '.') }}</div>
                    @endif
                    <div class="price">Rp {{ number_format($product->getHargaAkhir(), 0, ',', '.') }}</div>
                    <p style="font-size: 0.85rem; color: var(--ink-soft); margin-block: 0.5rem 1rem;">Sudah termasuk garansi rekber 24 jam. Biaya layanan 5% ditanggung penjual.</p>
                    @if ($product->isTerjual())
                        <button class="btn btn-secondary btn-block" disabled>Akun Sudah Terjual</button>
                    @else
                        <a class="btn btn-primary btn-block" href="{{ route('products.index') }}#rekber">Beli via Rekber</a>
                    @endif
                    <div class="seller-box">
                        <div class="seller-avatar">{{ $product->getSellerInisial() }}</div>
                        <div>
                            <div class="seller-name">{{ $product->seller_nama }}</div>
                            <div class="seller-meta">{{ $product->getSellerRingkasan() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (count($related) > 0)
        <section class="section" style="padding-top: 0;">
            <div class="section-head">
                <div>
                    <h2>Listing lainnya</h2>
                    <p>Akun lain dari kategori {{ $product->kategori }}.</p>
                </div>
                <a class="btn btn-secondary btn-sm" href="{{ route('products.index') }}#katalog">Lihat Semua</a>
            </div>
            <div class="game-grid">
                @foreach ($related as $produkLain)
                    @include('products._card', ['product' => $produkLain])
                @endforeach
            </div>
        </section>
        @endif
    </main>
@endsection
