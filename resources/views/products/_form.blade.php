{{-- Field form tambah/ubah produk. Dipakai create dan edit;
     $product bernilai null saat tambah. Nilai lama (old) selalu
     diutamakan supaya isian tidak hilang saat validasi gagal. --}}
<div class="form-group">
    <label for="kode">Kode Produk</label>
    <input type="text" id="kode" name="kode" value="{{ old('kode', $product->kode ?? '') }}" maxlength="10" required @isset($product) readonly @endisset>
    @error('kode')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="judul">Judul Listing</label>
    <input type="text" id="judul" name="judul" value="{{ old('judul', $product->judul ?? '') }}" maxlength="255" required>
    @error('judul')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="game">Game</label>
    <input type="text" id="game" name="game" value="{{ old('game', $product->game ?? '') }}" maxlength="255" required>
    @error('game')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="kategori">Kategori</label>
    <select id="kategori" name="kategori" required>
        @foreach (['MOBA', 'RPG', 'FPS', 'Battle Royale', 'Aksi', 'Olahraga'] as $kategori)
            <option value="{{ $kategori }}" @selected(old('kategori', $product->kategori ?? 'MOBA') === $kategori)>{{ $kategori }}</option>
        @endforeach
    </select>
    @error('kategori')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="seller_nama">Nama Penjual</label>
    <input type="text" id="seller_nama" name="seller_nama" value="{{ old('seller_nama', $product->seller_nama ?? '') }}" maxlength="255" required>
    @error('seller_nama')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="seller_rating">Rating Penjual (0–5)</label>
    <input type="number" id="seller_rating" name="seller_rating" value="{{ old('seller_rating', $product->seller_rating ?? '') }}" step="0.1" min="0" max="5" required>
    @error('seller_rating')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="seller_penjualan">Jumlah Penjualan Penjual</label>
    <input type="number" id="seller_penjualan" name="seller_penjualan" value="{{ old('seller_penjualan', $product->seller_penjualan ?? '') }}" min="0" required>
    @error('seller_penjualan')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="seller_kota">Kota Penjual</label>
    <input type="text" id="seller_kota" name="seller_kota" value="{{ old('seller_kota', $product->seller_kota ?? '') }}" maxlength="255" required>
    @error('seller_kota')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="harga">Harga (Rp)</label>
    <input type="number" id="harga" name="harga" value="{{ old('harga', $product->harga ?? '') }}" min="0" required>
    @error('harga')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="diskon">Diskon (%)</label>
    <input type="number" id="diskon" name="diskon" value="{{ old('diskon', $product->diskon ?? 0) }}" min="0" max="100" required>
    @error('diskon')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status" required>
        @foreach (['Tersedia', 'Stok Terbatas', 'Terjual'] as $status)
            <option value="{{ $status }}" @selected(old('status', $product->status ?? 'Tersedia') === $status)>{{ $status }}</option>
        @endforeach
    </select>
    @error('status')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="gambar">Gambar Produk</label>
    <select id="gambar" name="gambar" required>
        @foreach ($gambarList as $file => $namaGame)
            <option value="{{ $file }}" @selected(old('gambar', $product->gambar ?? '') === $file)>{{ $namaGame }} ({{ $file }})</option>
        @endforeach
    </select>
    @error('gambar')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="deskripsi_singkat">Deskripsi Singkat</label>
    <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="2" required>{{ old('deskripsi_singkat', $product->deskripsi_singkat ?? '') }}</textarea>
    @error('deskripsi_singkat')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="deskripsi">Deskripsi Lengkap</label>
    <textarea id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
    @error('deskripsi')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="platform">Platform</label>
    <input type="text" id="platform" name="platform" value="{{ old('platform', $product->platform ?? '') }}" maxlength="255" required>
    @error('platform')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="level">Level / Rank</label>
    <input type="text" id="level" name="level" value="{{ old('level', $product->level ?? '') }}" maxlength="255" required>
    @error('level')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="item_unggulan">Item Unggulan</label>
    <textarea id="item_unggulan" name="item_unggulan" rows="2" required>{{ old('item_unggulan', $product->item_unggulan ?? '') }}</textarea>
    @error('item_unggulan')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<button class="btn btn-primary btn-block" type="submit">{{ $submitLabel }}</button>
