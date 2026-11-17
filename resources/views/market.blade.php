@extends('layouts.app', ['judul' => 'Market'])

@section('content')
    <main>
        <section class="section">
            <div class="container">
                <div class="section-head">
                    <div>
                        <h2>Market</h2>
                        <p>Semua akun game yang dijual di TriverseStore. Cari, filter kategori, atau urutkan berdasarkan harga.</p>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="{{ route('products.create') }}">Jual Akun</a>
                    </div>
                </div>

                <div class="toolbar">
                    <form class="search-box" method="get" action="{{ route('market') }}" style="display: flex; gap: 0.5rem;">
                        <input type="search" name="q" placeholder="Cari akun, game, atau kategori..." aria-label="Cari akun" value="{{ $kataKunci }}">
                        @if ($kategoriAktif !== 'Semua')
                            <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                        @endif
                        @if ($urut !== 'terbaru')
                            <input type="hidden" name="urut" value="{{ $urut }}">
                        @endif
                        <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                    </form>
                    <div class="filter-group" role="group" aria-label="Filter kategori">
                        @foreach ($kategoriList as $kategori)
                            <a class="filter-chip{{ $kategori === $kategoriAktif ? ' active' : '' }}" href="{{ route('market', ['kategori' => $kategori, 'q' => $kataKunci, 'urut' => $urut]) }}">{{ $kategori }}</a>
                        @endforeach
                    </div>
                    <form method="get" action="{{ route('market') }}" style="display: flex; gap: 0.5rem; align-items: center;">
                        <input type="hidden" name="q" value="{{ $kataKunci }}">
                        <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                        <label for="urut" style="font-size: 0.85rem;">Urutkan</label>
                        <select id="urut" name="urut" onchange="this.form.submit()">
                            <option value="terbaru" @selected($urut === 'terbaru')>Terbaru</option>
                            <option value="termurah" @selected($urut === 'termurah')>Harga termurah</option>
                            <option value="termahal" @selected($urut === 'termahal')>Harga termahal</option>
                            <option value="terlama" @selected($urut === 'terlama')>Terlama</option>
                        </select>
                    </form>
                </div>

                <p style="color: var(--ink-soft); font-size: 0.9rem;">Menampilkan {{ count($products) }} akun.</p>

                @if (count($products) > 0)
                    <div class="game-grid">
                        @foreach ($products as $product)
                            @include('products._card', ['product' => $product])
                        @endforeach
                    </div>
                @else
                    <div class="state-box">
                        <h3>Tidak ada akun yang cocok</h3>
                        <p>Coba kata kunci lain atau pilih kategori "Semua".</p>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
