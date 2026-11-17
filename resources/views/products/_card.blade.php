{{-- Kartu listing: media + chip level, baris penjual, harga, dan badge status.
     Aksi ubah/hapus hanya tampil di halaman Akun lewat $tampilkanAksi. --}}
<article class="game-card">
    <div class="card-media">
        <a href="{{ route('products.show', $product->id) }}" aria-label="Lihat detail {{ $product->judul }}">
            <img src="{{ $product->getGambarUrl() }}" alt="Gambar akun {{ $product->judul }}" loading="lazy">
        </a>
        @if ($product->diskon > 0)
            <span class="badge badge-promo">&minus;{{ $product->diskon }}%</span>
        @endif
        <span class="media-chip">{{ $product->level }}</span>
    </div>
    <div class="card-body">
        <span class="card-category">{{ $product->kategori }}</span>
        <h3><a href="{{ route('products.show', $product->id) }}">{{ $product->judul }}</a></h3>
        <div class="card-seller">
            <span class="avatar" aria-hidden="true">{{ $product->getSellerInisial() }}</span>
            <span class="seller-name">{{ $product->seller_nama }}</span>
            <span class="rating">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                {{ number_format($product->seller_rating, 1) }}
                <span class="rating-count">({{ number_format($product->seller_penjualan, 0, ',', '.') }} terjual)</span>
            </span>
        </div>
        @if ($product->deskripsi_singkat)
            <p class="card-desc">{{ $product->deskripsi_singkat }}</p>
        @endif
        <div class="card-price-row">
            <div>
                @if ($product->getHargaCoret())
                    <div class="price-old">Rp {{ number_format($product->getHargaCoret(), 0, ',', '.') }}</div>
                @endif
                <div class="price">Rp {{ number_format($product->getHargaAkhir(), 0, ',', '.') }}</div>
            </div>
            <span class="badge {{ $product->getBadgeClass() }}">{{ $product->status }}</span>
        </div>
        @if (! empty($tampilkanAksi) && auth()->check() && ($product->user_id === null || $product->user_id === auth()->id()))
            <div class="card-actions">
                <a class="btn btn-primary btn-sm" href="{{ route('products.show', $product->id) }}">Lihat Detail</a>
                <a class="btn btn-secondary btn-sm" href="{{ route('products.edit', $product->id) }}">Ubah</a>
                <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Hapus listing ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                </form>
            </div>
        @endif
    </div>
</article>
