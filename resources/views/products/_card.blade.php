{{-- Satu kartu produk. Markup identik dengan Week 7; yang berubah
     hanya tautannya (route Laravel) dan aksi CRUD di bawahnya. --}}
<article class="game-card">
    <div class="card-media">
        <img src="{{ $product->getGambarUrl() }}" alt="Key art {{ $product->game }}">
        @if ($product->diskon > 0)
            <span class="badge badge-promo">&minus;{{ $product->diskon }}%</span>
        @endif
    </div>
    <div class="card-body">
        <span class="card-category">{{ $product->kategori }}</span>
        <h3><a href="{{ route('products.show', $product->id) }}">{{ $product->judul }}</a></h3>
        <div class="card-meta">
            <span>{{ $product->seller_nama }}</span>
            <span class="dot"></span>
            <span class="rating"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>{{ $product->seller_rating }}</span>
        </div>
        <p class="card-desc">{{ $product->deskripsi_singkat }}</p>
        <div class="card-price-row">
            <div>
                @if ($product->getHargaCoret() !== null)
                    <div class="price-old">Rp {{ number_format($product->getHargaCoret(), 0, ',', '.') }}</div>
                @endif
                <div class="price">Rp {{ number_format($product->getHargaAkhir(), 0, ',', '.') }}</div>
            </div>
            <span class="badge {{ $product->getBadgeClass() }}">{{ $product->status }}</span>
        </div>
        <div class="card-actions">
            <a class="btn btn-secondary btn-sm" href="{{ route('products.show', $product->id) }}">Lihat Detail</a>
            <a class="btn btn-secondary btn-sm" href="{{ route('products.edit', $product->id) }}">Ubah</a>
            <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Hapus produk ini?')" style="display: inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-secondary btn-sm" type="submit">Hapus</button>
            </form>
        </div>
    </div>
</article>
