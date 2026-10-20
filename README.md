# Triverse Store

Prototipe platform **top up game** dan **marketplace akun game**, dilengkapi katalog game dan artikel panduan.
Dibuat dengan HTML5, CSS3, Tailwind CSS, PHP, dan sedikit JavaScript vanilla. Tampilan memakai **komponen gaya shadcn/ui lewat [Basecoat](https://basecoatui.com)** (versi HTML + Tailwind, tanpa React).

**Status:** semua data (game, listing, penjual, harga, artikel) adalah **data contoh** di file PHP. Belum ada database, login, pembayaran, atau integrasi API. Tidak ada tombol yang berpura-pura memproses transaksi.

## Cara menjalankan

Butuh PHP 8.0 atau lebih baru, dan koneksi internet (untuk Tailwind dan font, lihat bagian keterbatasan).

**Terminal:**
```bash
cd TriverseStore
php -S localhost:8000
```
Buka http://localhost:8000/index.php

**XAMPP / Laragon:** taruh folder di `htdocs` (XAMPP) atau `www` (Laragon), jalankan Apache, lalu buka `http://localhost/TriverseStore/`.

Live Server di VS Code tidak bisa menjalankan PHP.

## Halaman

| File | Fungsi |
|---|---|
| `index.php` | Beranda: pengantar, game unggulan, top up, listing terbaru, kategori, berita |
| `topup.php` | Daftar game yang bisa di-top up, dengan harga terendah |
| `topup-game.php` | `?id=<slug>`: pilih nominal, isi ID game (dan server), lalu tinjau pesanan. Form POST divalidasi di PHP dan berakhir di pratinjau |
| `marketplace.php` | Listing akun dengan filter: pencarian, game, kategori, rentang harga, urutan |
| `account-detail.php` | `?id=<slug>`: detail listing, isi akun, status, catatan privasi |
| `catalog.php` | Katalog game dengan pencarian dan filter kategori |
| `game-detail.php` | `?id=<slug>`: detail game dan game terkait |
| `news.php`, `news-detail.php` | Daftar dan isi artikel contoh |

## Struktur

```
includes/   head.php, navbar.php, footer.php, game-card.php, account-card.php, not-found.php, functions.php
data/       games.php, accounts.php, topup.php, news.php   data contoh, terpisah dari template
config/     app.php                                       nama dan tagline situs
assets/     css/input.css (sumber), css/style.css (tema), css/app.css (hasil build), js/app.js, images/
package.json  hanya untuk build CSS
```

`includes/functions.php` berisi semua fungsi bantu: `e()` (pembungkus `htmlspecialchars`), pemuat data, validasi slug, pencarian, validasi form top up, dan generator sampul. Halaman hanya berisi markup dan sedikit logika.

## Tentang data contoh

- **Gambar:** belum ada artwork resmi, jadi tiap game punya ilustrasi SVG buatan sendiri (kristal untuk MOBA, pulau dan parasut untuk battle royale, pulau melayang untuk RPG dunia terbuka, dan seterusnya) yang digambar oleh `art_scene()` di `includes/functions.php`. Ada tiga bentuk: `portrait` (kartu), `wide` (artikel, ubin kategori), dan `banner` (hero dan header halaman detail).
- **Game:** memakai nama game populer di Indonesia supaya alurnya terasa nyata. Nama game milik masing-masing penerbit, dan situs ini tidak berafiliasi dengan mereka. Sampul adalah ilustrasi buatan, **bukan artwork resmi**.
- **Harga dan nominal top up** di `data/topup.php` hanya contoh, bukan harga resmi. **Format ID** (panjang digit, Zone ID, pilihan server) adalah perkiraan; cek ke dokumentasi penyedia top up sebelum dipakai sungguhan.
- **Listing akun, penjual, dan artikel** sepenuhnya fiktif. Tanggal hanya penanda. Tidak ada rating, jumlah pengguna, atau statistik karangan.
- **Kredensial login tidak ada di data** dan tidak pernah ditampilkan. Halaman listing menyatakan bahwa serah terima akun dan penanganan sengketa akan dirancang bersama sistem pesanan, dan bahwa aturan penerbit soal pemindahan akun bisa berbeda.

Untuk memakai gambar sendiri (misalnya poster yang kamu punya izin memakainya), taruh file di `assets/images/` dan tambahkan `'image' => 'nama.jpg'` pada data game. Gambar itu akan dipakai di semua tempat sampul tampil; ilustrasi SVG hanya jadi cadangan. Jika file tidak ada, sampul SVG dipakai.

## Desain

Konsep: katalog dan etalase, bukan halaman promosi. Tata letak rata kiri, garis tipis, dan daftar berbentuk indeks. Latar teal gelap dengan satu warna aksen (kuning marigold) untuk tombol utama, menu aktif, dan sorotan. Font: Chakra Petch (judul) dan Figtree (isi). Token warna ada di `assets/css/style.css`.

## Keamanan dasar

- Semua output dinamis lewat `e()`.
- Parameter `id`, `q`, `category`, `game`, `min`, `max`, `sort` divalidasi: slug hanya `[a-z0-9-]`, kategori dan game harus ada di data, angka harus bilangan bulat, teks dipangkas dan dibatasi panjangnya, nilai non-teks (array) diabaikan.
- Form top up mengecek nominal terhadap daftar milik game itu sendiri, sehingga nilai yang diubah-ubah ditolak. Data yang diisi tidak disimpan.
- ID tidak dikenal menghasilkan halaman 404 yang sebenarnya.

## UI: shadcn/ui lewat Basecoat

shadcn/ui asli adalah komponen React, sehingga tidak bisa dipakai di proyek ini. **Basecoat** (`basecoat-css`) adalah implementasi shadcn/ui untuk HTML biasa + Tailwind: token tema sama (`--primary`, `--border`, `--ring`, ...) dan markup semantik. Yang dipakai: `btn`, `card`, `badge`, `alert`, `breadcrumb`, `field`, `input`, `select`, dan radio. Tidak ada JavaScript Basecoat yang dimuat.

Tema ada di `assets/css/style.css` (blok `.dark`): `--primary` kuning marigold, `--background` teal gelap. Situs selalu gelap (`<html class="dark">`).

Contoh markup (lihat `includes/functions.php` untuk helper `breadcrumb()`, `ui_alert()`, `status_badge()`):
```html
<a class="btn" href="#">Utama</a>
<a class="btn" data-variant="outline" data-size="sm" href="#">Garis tepi</a>
<span class="badge" data-variant="secondary">Dipesan</span>
<div class="field"><label for="x">Label</label><input id="x" class="input"></div>
```

## CSS: dikompilasi, bukan CDN

`assets/css/app.css` adalah hasil build Tailwind v4 + Basecoat dan **sudah disertakan**, jadi situs langsung jalan tanpa Node. Node hanya dibutuhkan jika kamu mengubah gaya atau menambah class Tailwind baru:

```bash
npm install            # sekali saja
npm run build:css      # bangun ulang assets/css/app.css
npm run watch:css      # bangun ulang otomatis saat file berubah
```
Edit `assets/css/style.css` (tema dan gaya khusus) atau template PHP, **jangan** edit `app.css` langsung. Node hanya alat build CSS, bukan backend aplikasi.

Yang masih dari internet: font Google (Chakra Petch dan Figtree), yang jatuh ke font sistem jika gagal dimuat.

## Yang sudah diuji

Dengan PHP 8.3 CLI dan server bawaannya: sintaks semua file PHP; status HTTP semua halaman; pencarian dan filter katalog dan marketplace (termasuk min/max yang tertukar, urutan harga, dan parameter sampah atau array); ID tidak valid menghasilkan 404 (termasuk `../`); form top up dengan input valid dan tidak valid untuk game dengan Zone ID, dengan pilihan server, dan tanpa server; nominal yang diubah-ubah; escape payload `<script>`; nilai form tetap setelah error; tidak ada warning PHP; semua tautan dan aset lokal bisa dibuka; tidak ada sisa teks antarmuka berbahasa Inggris.

**Belum diuji:** tampilan dan responsivitas di browser sungguhan, serta hasil render CSS gaya shadcn (kompilasi CSS dan keberadaan class sudah diperiksa, tetapi tampilan visual belum dilihat). Tolong cek di lebar layar HP, tablet, dan desktop.

## Tahap berikutnya

Database (koneksi PDO di `config/` dan `includes/`, lalu ganti `games()`, `accounts()`, `articles()`, dan `topups()` di `functions.php` dengan query), autentikasi, halaman penjual untuk membuat listing, pembayaran dan pelacakan pesanan, serta migrasi ke Laravel (file `data/` menjadi migration dan seeder, `includes/` menjadi layout Blade).
