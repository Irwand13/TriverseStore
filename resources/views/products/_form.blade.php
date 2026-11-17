{{-- Field form tambah/ubah produk yang sudah dipendekkan:
     hanya kolom esensial. Dipakai create dan edit;
     $product bernilai null saat tambah. Nilai lama (old)
     selalu diutamakan supaya isian tidak hilang saat
     validasi gagal. Penjual diisi otomatis dari akun login. --}}
<div class="form-group">
    <label for="judul">Judul Listing</label>
    <input type="text" id="judul" name="judul" value="{{ old('judul', $product->judul ?? '') }}" maxlength="255" required>
    @error('judul')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="game">Game</label>
    <input type="text" id="game" name="game" value="{{ old('game', $product->game ?? '') }}" maxlength="255" placeholder="Contoh: Mobile Legends: Bang Bang" required>
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
    <label for="harga">Harga (Rp)</label>
    <input type="number" id="harga" name="harga" value="{{ old('harga', $product->harga ?? '') }}" min="1000" required>
    @error('harga')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="deskripsi_singkat">Deskripsi Singkat</label>
    <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3" maxlength="500" required>{{ old('deskripsi_singkat', $product->deskripsi_singkat ?? '') }}</textarea>
    @error('deskripsi_singkat')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="gambar">Gambar Akun (wajib)</label>
    @isset($product)
        <div style="margin-bottom: 0.5rem;">
            <img src="{{ $product->getGambarUrl() }}" alt="Gambar {{ $product->game }}" style="max-width: 220px; border-radius: 8px;">
        </div>
        <p style="font-size: 0.85rem; margin-bottom: 0.5rem;">Kosongkan bila tetap memakai gambar di atas.</p>
        <input type="file" id="gambar" name="gambar" accept="image/*">
    @else
        <input type="file" id="gambar" name="gambar" accept="image/*" required>
    @endisset
    <p style="font-size: 0.85rem; margin-top: 0.3rem;">Format JPG, JPEG, PNG, atau WebP, maksimal 2 MB.</p>
    @error('gambar')<p style="color: var(--clay-dark); font-size: 0.85rem; margin-top: 0.3rem;">{{ $message }}</p>@enderror
</div>

<button class="btn btn-primary btn-block" type="submit">{{ $submitLabel }}</button>
