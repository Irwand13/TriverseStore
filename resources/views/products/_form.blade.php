{{-- Field form tambah/ubah produk yang sudah dipendekkan:
     hanya kolom esensial. Dipakai create dan edit;
     $product bernilai null saat tambah. Nilai lama (old)
     selalu diutamakan supaya isian tidak hilang saat
     validasi gagal. Penjual diisi otomatis dari akun login. --}}
<div class="form-group">
    <label for="judul">Judul Listing</label>
    <input type="text" id="judul" name="judul" value="{{ old('judul', $product->judul ?? '') }}" maxlength="100" required>
    <p class="form-hint">Maksimal 100 karakter.</p>
    @error('judul')<p class="form-error">{{ $message }}</p>@enderror
</div>

<div class="form-row-2">
    <div class="form-group">
        <label for="game">Game</label>
        <input type="text" id="game" name="game" value="{{ old('game', $product->game ?? '') }}" maxlength="255" placeholder="Contoh: Mobile Legends: Bang Bang" required>
        @error('game')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori" required>
            @foreach (['MOBA', 'RPG', 'FPS', 'Battle Royale', 'Aksi', 'Olahraga'] as $kategori)
                <option value="{{ $kategori }}" @selected(old('kategori', $product->kategori ?? 'MOBA') === $kategori)>{{ $kategori }}</option>
            @endforeach
        </select>
        @error('kategori')<p class="form-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="form-group">
    <label for="harga">Harga (Rp)</label>
    <input type="number" id="harga" name="harga" value="{{ old('harga', $product->harga ?? '') }}" min="1000" required>
    <p class="form-hint">Harga minimal Rp 1.000. Biaya layanan 5% ditanggung penjual, bukan pembeli.</p>
    @error('harga')<p class="form-error">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="deskripsi_singkat">Deskripsi Singkat</label>
    <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3" maxlength="500" required>{{ old('deskripsi_singkat', $product->deskripsi_singkat ?? '') }}</textarea>
    <p class="form-hint">Maksimal 500 karakter — tulis yang penting: level, item utama, dan kondisi akun.</p>
    @error('deskripsi_singkat')<p class="form-error">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="gambar">Gambar Akun (wajib)</label>
    @isset($product)
        {{-- Produk dari API boleh tidak punya gambar. --}}
        @if ($product->gambar)
            <img class="form-preview" src="{{ $product->getGambarUrl() }}" alt="Gambar {{ $product->game }}">
            <p class="form-hint">Kosongkan bila tetap memakai gambar di atas.</p>
        @endif
        <input type="file" id="gambar" name="gambar" accept="image/*">
    @else
        <input type="file" id="gambar" name="gambar" accept="image/*" required>
    @endisset
    <p class="form-hint">Format JPG, JPEG, PNG, atau WebP, maksimal 2 MB. Pakai screenshot asli dari akunmu.</p>
    @error('gambar')<p class="form-error">{{ $message }}</p>@enderror
</div>

<div class="btn-row">
    <button class="btn btn-primary" type="submit">{{ $submitLabel }}</button>
    <a class="btn btn-secondary" href="{{ isset($product) ? route('products.show', $product->id) : route('products.index') }}">Batalkan</a>
</div>
