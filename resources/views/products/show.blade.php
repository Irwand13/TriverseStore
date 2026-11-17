@extends('layouts.app', ['judul' => $product->judul])

@section('content')
    <div class="container">
        <div class="page-head">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('products.index') }}">Katalog</a>
                <span>/</span>
                <span>{{ $product->kategori }}</span>
                <span>/</span>
                <span class="crumb-here">{{ $product->game }}</span>
            </nav>
            <h1>{{ $product->judul }}</h1>
        </div>

        @auth
            @if ($product->user_id === null || $product->user_id === auth()->id())
                <div class="page-actions">
                    <span>Ini listing kamu.</span>
                    <span class="spacer"></span>
                    <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product->id) }}">Ubah Produk</a>
                    <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus Produk</button>
                    </form>
                </div>
            @endif
        @endauth

        <div class="detail-grid">
            <div>
                <div class="detail-media">
                    <img src="{{ $product->getGambarUrl() }}" alt="Gambar akun {{ $product->judul }}">
                </div>

                <div class="detail-about">
                    <span class="card-category">{{ $product->kategori }} · {{ $product->game }}</span>
                    <h2>Tentang akun ini</h2>
                    <p class="lead">{{ $product->deskripsi }}</p>

                    <dl class="spec-grid">
                        <div class="spec-row"><dt>Game</dt><dd>{{ $product->game }}</dd></div>
                        <div class="spec-row"><dt>Platform</dt><dd>{{ $product->platform }}</dd></div>
                        <div class="spec-row"><dt>Level / Rank</dt><dd>{{ $product->level }}</dd></div>
                        <div class="spec-row"><dt>Item Unggulan</dt><dd>{{ $product->item_unggulan }}</dd></div>
                        <div class="spec-row"><dt>Kota Penjual</dt><dd>{{ $product->seller_kota }}</dd></div>
                        <div class="spec-row"><dt>Status</dt><dd>{{ $product->status }}</dd></div>
                    </dl>

                    <ul class="check-list">
                        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>Akun lolos pemeriksaan kepemilikan oleh tim kami</li>
                        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>Data login diserahkan lewat rekening bersama</li>
                        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>Garansi refund penuh bila tidak sesuai deskripsi</li>
                        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>Mediasi admin bila ada sengketa serah terima</li>
                    </ul>
                </div>
            </div>

            <div class="detail-info">
                <div class="detail-meta">
                    <span class="rating"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>{{ number_format($product->seller_rating, 1) }}</span>
                    <span class="dot" aria-hidden="true"></span>
                    <span>{{ number_format($product->seller_penjualan, 0, ',', '.') }} penjualan penjual</span>
                    <span class="dot" aria-hidden="true"></span>
                    <span class="badge {{ $product->getBadgeClass() }}">{{ $product->status }}</span>
                </div>

                <div class="buy-panel">
                    @if ($product->getHargaCoret() !== null)
                        <div class="price-old">Rp {{ number_format($product->getHargaCoret(), 0, ',', '.') }}</div>
                    @endif
                    <div class="price">Rp {{ number_format($product->getHargaAkhir(), 0, ',', '.') }}</div>
                    <div class="buy-rows">
                        <div class="fee-row"><span>Harga akun</span><span>Rp {{ number_format($product->getHargaAkhir(), 0, ',', '.') }}</span></div>
                        <div class="fee-row"><span>Biaya layanan (5%, ditanggung penjual)</span><span>Rp 0</span></div>
                        <div class="fee-row"><span>Biaya rekber</span><span>Rp 0</span></div>
                        <div class="fee-total"><span class="total-label">Total bayar</span><span class="total-value">Rp {{ number_format($product->getHargaAkhir(), 0, ',', '.') }}</span></div>
                    </div>
                    @if ($product->isTerjual())
                        <button class="btn btn-secondary btn-block" disabled>Akun Sudah Terjual</button>
                    @else
                        <a class="btn btn-primary btn-block" href="{{ route('products.index') }}#rekber">Beli via Rekber</a>
                    @endif
                    <p class="buy-note">Dana ditahan TriverseStore sampai kamu mengonfirmasi akun diterima.</p>
                </div>

                <div class="seller-card">
                    <div class="seller-head">
                        <div class="seller-avatar">{{ $product->getSellerInisial() }}</div>
                        <div>
                            <div class="seller-name">{{ $product->seller_nama }}</div>
                            <div class="seller-meta">{{ $product->getSellerRingkasan() }}</div>
                        </div>
                    </div>
                    <div class="seller-stats">
                        <div class="seller-stat">
                            <div class="value">{{ number_format($product->seller_rating, 1) }}</div>
                            <div class="label">Rating</div>
                        </div>
                        <div class="seller-stat">
                            <div class="value">{{ number_format($product->seller_penjualan, 0, ',', '.') }}</div>
                            <div class="label">Terjual</div>
                        </div>
                        <div class="seller-stat">
                            <div class="value">{{ $product->seller_kota }}</div>
                            <div class="label">Kota</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (count($related) > 0)
            <section class="section section-flush">
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
    </div>
@endsection
