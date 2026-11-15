# Week 9 — Sprint 07: Laravel + CRUD + Database — From MVC to Framework

**Penanggung jawab:** Irwand · **Branch:** `week9`

## Tema Sprint

Memindahkan pengelolaan data TriverseStore dari PHP MVC manual (Week 7)
ke **Laravel + database**: struktur tabel didefinisikan lewat migration,
Model Eloquent menghubungkan tabel ke Laravel, dan CRUD lengkap
(tambah, tampil, ubah, hapus) berjalan dengan prinsip yang sama seperti
di PPT — **data yang tampil harus berasal dari database, bukan hard-code
di HTML**. Alur request-nya:

```
User → Laravel → Model → Eloquent → Database → Data → View → HTML → User
```

Hasil akhir di layar **identik** dengan Week 7 — yang berubah hanya
sumber datanya. Week ini adalah lompatan yang dijanjikan README Week 7:
dari MVC buatan sendiri ke framework MVC yang sesungguhnya.

## Pemetaan Sub-Tugas

| Kode | Sub-Tugas | Penerapan di folder ini |
|------|-----------|-------------------------|
| W9.1 | Struktur Database | Migration `create_products_table` (id, kode, judul, game, kategori, data penjual, harga, diskon, status, gambar, deskripsi, platform, level, item unggulan, timestamps); dijalankan dengan `php artisan migrate`. |
| W9.2 | Model | Model `Product` (extends Model, `$fillable` semua kolom) + method yang sama seperti Model Game Week 7 (`getHargaAkhir()`, `getHargaCoret()`, `getBadgeClass()`, `isTerjual()`); Eloquent mengurus data sebagai object (`Product::all()`, `findOrFail($id)`, `create([...])`). |
| W9.3 | CRUD | `ProductController` dengan `index()`, `show()`, `create()`, `store()`, `edit()`, `update()`, `destroy()` + rute CRUD di `routes/web.php` + Blade views (index, show, create, edit). Seeder mengisi 10 produk kanonis. |

## Struktur Folder

```
week9/
├── app/
│   ├── Http/Controllers/
│   │   └── ProductController.php   # index, show, create, store, edit, update, destroy
│   └── Models/
│       └── Product.php             # Eloquent Model + $fillable + method harga/badge
├── bootstrap/app.php               # Bootstrap aplikasi Laravel
├── config/                         # Konfigurasi (app, database, view, session, ...)
├── database/
│   ├── migrations/
│   │   └── 2026_11_15_000000_create_products_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   └── ProductSeeder.php       # 10 produk kanonis DATASET.md
│   └── database.sqlite             # Dibuat saat setup (lihat bawah)
├── public/
│   ├── index.php                   # Front controller Laravel
│   ├── css/style.css               # Salinan file CSS yang sama sejak Week 2
│   └── assets/img/                 # Gambar yang sama persis dengan week sebelumnya
├── resources/views/
│   ├── layouts/app.blade.php       # Kerangka HTML + @yield (pengganti layout.php Week 7)
│   └── products/
│       ├── index.blade.php         # Katalog (hero, filter, grid kartu)
│       ├── show.blade.php          # Detail produk + listing lainnya
│       ├── create.blade.php        # Form tambah produk
│       ├── edit.blade.php          # Form ubah produk
│       ├── _form.blade.php         # Field form bersama create/edit
│       └── _card.blade.php         # Kartu produk (pengganti renderKartuProduk)
├── routes/
│   └── web.php                     # Rute CRUD produk
├── .env.example                    # Contoh konfigurasi (SQLite sebagai default)
├── artisan                         # CLI Laravel
├── composer.json                   # Laravel 11 + dependensi
└── README.md
```

Tidak ada lagi `app/Views/*.php` manual: Blade menggantikan
`layout.php` + `helpers.php` + view `games/`; `Game::all()` statis
digantikan `Product::all()` Eloquent yang membaca tabel `products`.

## Cara Menjalankan

Folder `vendor/` tidak disertakan di repository — instal dulu:

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Lalu buka `http://127.0.0.1:8000`.
Rute: katalog = `/`, detail = `/products/1`,
tambah = `/products/create`, ubah = `/products/1/edit`.
PHP 8.2+, database default SQLite (tanpa MySQL).

## Poin Penjelasan untuk Dosen

1. **Fungsi Migration:** cara Laravel mendefinisikan dan mengelola
   struktur database lewat kode (`Schema::create`); tabel `products`
   dibuat dengan `php artisan migrate`, bukan dibuat manual di phpMyAdmin.
2. **Fungsi Model:** `Product` merepresentasikan tabel `products`
   sebagai class; `$fillable` mendaftarkan kolom yang boleh diisi massal.
3. **Fungsi Eloquent:** Model berkomunikasi dengan database dan
   mengembalikan object — `Product::all()` banyak object,
   `Product::findOrFail($id)` satu object, `create([...])` simpan baru.
4. **Alur CRUD:** form tambah/ubah mengirim request → route →
   Controller memvalidasi → Model menyimpan ke database → redirect
   dengan pesan sukses → halaman berikutnya membaca ulang dari database.
5. **Data dari database:** katalog, detail, dan filter membaca tabel
   `products`; tidak ada lagi array hard-code di dalam Model. Menghapus
   produk benar-benar menghapus barisnya; menambah produk benar-benar
   menambah baris baru (buktikan dengan `php artisan tinker` atau
   membuka file `database/database.sqlite`).

## Pertanyaan Demo (Sprint 07)

- *Apa fungsi Migration?* — Mendefinisikan struktur tabel lewat kode
  dan menjalankannya dengan `php artisan migrate`.
- *Apa fungsi Model?* — Menghubungkan tabel dengan Laravel lewat
  Eloquent (`Product` ↔ tabel `products`).
- *Apa fungsi Eloquent?* — Mengelola data sebagai object: ambil semua,
  ambil satu, simpan, ubah, hapus — tanpa menulis query SQL manual.
- *Apa perbedaan `Product::all()` dan `Product::find(1)`?* —
  `all()` mengembalikan semua data (banyak object, dipakai katalog);
  `find(1)` mengembalikan satu data (satu object, dipakai halaman detail).
- *Apa yang dimaksud CRUD?* — Create (tambah), Read (tampil),
  Update (ubah), Delete (hapus) — empat operasi dasar pengelolaan data.
- *Apa yang berubah ketika aplikasi mulai menggunakan database?* —
  Data tidak lagi hard-code: produk yang tampil adalah isi tabel, dan
  perubahan lewat form langsung mengubah isi tabel.

## Evolusi dari Week Sebelumnya (Week 7 → Week 9)

| Berkas/Folder | Perubahan |
|---------------|-----------|
| `app/Models/Game.php` | **Diganti** `app/Models/Product.php`: class yang sama, kini Eloquent Model — dataset statis `all()`/`find()` digantikan query database; method harga/badge/status dipertahankan. |
| `app/Models/Seller.php`, `app/Models/Cart.php` | **Dihapus.** Sprint 07 hanya membahas satu model/tabel: data penjual disimpan sebagai kolom biasa di tabel `products` (`seller_nama`, `seller_rating`, `seller_penjualan`, `seller_kota`). Relasi antar tabel masuk materi berikutnya. |
| `app/Controllers/GameController.php` | **Diganti** `app/Http/Controllers/ProductController.php`: `index()`/`show()` dipertahankan, ditambah `create()`, `store()`, `edit()`, `update()`, `destroy()` + validasi form. |
| `public/index.php` | **Diganti** front controller Laravel (`public/index.php` framework) — routing `?page=` digantikan rute di `routes/web.php`. |
| `app/Views/` | **Diganti** Blade di `resources/views/`: `layout.php` → `layouts/app.blade.php`, `helpers.php` (`renderKartuProduk`) → partial `_card.blade.php`, `games/index.php` → `products/index.blade.php`, `games/detail.php` → `products/show.blade.php`; ditambah `create.blade.php`, `edit.blade.php`, `_form.blade.php`. |
| `data/` (dihapus di Week 7) | **Diganti** migration + seeder: dataset kanonis kini hidup di tabel `products` (nilai tidak berubah satu pun). |
| `public/css/style.css` | **Salinan persis** file CSS yang sama sejak Week 2 (token desain tunggal tidak berubah di seluruh perjalanan). |
| `public/assets/img/*` | Tidak berubah. |
| `composer.json`, `artisan`, `bootstrap/`, `config/` | **Baru.** Kerangka Laravel 11. |

Catatan: Controller, Routing, dan Validation yang mendalam baru masuk
Pertemuan 10 — di Week 9 ini routing ditulis eksplisit per rute dan
validasi hanya aturan dasar form, sesuai cakupan PPT.

Hasilnya: sembilan week, satu tampilan, satu dataset — setiap week hanya
mengubah **satu lapisan** (struktur → perilaku → sumber data → sisi server →
objek → arsitektur → framework + database), sehingga merge antar week
tidak pernah bentrok.
