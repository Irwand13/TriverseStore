@extends('layouts.app', ['judul' => 'Market'])

@section('content')
    <div class="container">
        <div class="page-head">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('products.index') }}">Beranda</a>
                <span>/</span>
                <span class="crumb-here">Market</span>
            </nav>
            <h1>Market</h1>
            <p>Semua akun game yang dijual di TriverseStore. Cari, filter kategori, atau urutkan berdasarkan harga.</p>
        </div>

        <div class="market-layout">
            <aside class="filter-side">
                <div class="filter-head">
                    <h3>Filter</h3>
                    <a href="{{ route('market') }}">Reset</a>
                </div>
                <div class="filter-group-title">Kategori</div>
                <ul class="filter-list">
                    @foreach ($kategoriList as $kategori)
                        <li><a href="{{ route('market', ['kategori' => $kategori, 'q' => $kataKunci, 'urut' => $urut]) }}" class="{{ $kategori === $kategoriAktif ? 'active' : '' }}">{{ $kategori }}</a></li>
                    @endforeach
                </ul>
                <p class="filter-note">Semua akun yang tampil sudah lolos pemeriksaan kepemilikan dan dilindungi rekber.</p>
            </aside>

            <div>
                <form class="toolbar" method="get" action="{{ route('market') }}">
                    <div class="toolbar-form">
                        <div class="search-box">
                            <input type="search" name="q" placeholder="Cari akun, game, atau kategori" aria-label="Cari akun" value="{{ $kataKunci }}">
                        </div>
                        <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                        <input type="hidden" name="urut" value="{{ $urut }}">
                        <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                    </div>
                    <div class="sort-wrap">
                        <label for="urut">Urutkan</label>
                        <select id="urut" name="urut" onchange="this.form.submit()">
                            <option value="terbaru" @selected($urut === 'terbaru')>Terbaru</option>
                            <option value="termurah" @selected($urut === 'termurah')>Harga termurah</option>
                            <option value="termahal" @selected($urut === 'termahal')>Harga termahal</option>
                            <option value="terlama" @selected($urut === 'terlama')>Terlama</option>
                        </select>
                    </div>
                </form>

                @if ($kataKunci !== '' || $kategoriAktif !== 'Semua')
                    <div class="toolbar toolbar-chips">
                        @if ($kataKunci !== '')
                            <a class="chip-clear" href="{{ route('market', ['kategori' => $kategoriAktif, 'urut' => $urut]) }}">"{{ $kataKunci }}" <span class="chip-x" aria-hidden="true">×</span></a>
                        @endif
                        @if ($kategoriAktif !== 'Semua')
                            <a class="chip-clear" href="{{ route('market', ['q' => $kataKunci, 'urut' => $urut]) }}">{{ $kategoriAktif }} <span class="chip-x" aria-hidden="true">×</span></a>
                        @endif
                    </div>
                @endif

                <p class="result-count">Menampilkan {{ count($products) }} akun.</p>

                @if (count($products) > 0)
                    <div class="game-grid">
                        @foreach ($products as $product)
                            @include('products._card', ['product' => $product])
                        @endforeach
                        <div class="promo-cell">
                            <h3>Punya akun nganggur?</h3>
                            <p>Jual akunmu lewat rekber — dana diteruskan setelah pembeli mengonfirmasi.</p>
                            <a class="btn btn-secondary" href="{{ route('products.create') }}">Jual Akun</a>
                        </div>
                    </div>
                @else
                    <div class="state-box">
                        <svg class="state-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                        <h3>Tidak ada akun yang cocok</h3>
                        <p>Coba kata kunci lain atau pilih kategori "Semua". Semua listing yang tampil sudah lolos pemeriksaan tim kami.</p>
                        <a class="btn btn-secondary" href="{{ route('market') }}">Lihat semua akun</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
