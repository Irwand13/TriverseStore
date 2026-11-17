# Week 10 — Sprint 08: Controller, Routing & Validation — REST API

**Penanggung jawab:** Irwand · **Branch:** `week10` (lanjutan Sprint 07 di `week9`)

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
│   ├── web.php                     # Rute CRUD produk
│   └── api.php                     # REST API produk (Sprint 08)
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
Rute: katalog = `/`, market = `/market`, tentang = `/tentang`,
top up = `/topup`, akun = `/akun`, detail = `/products/1`,
tambah = `/products/create`, ubah = `/products/1/edit`.
API (Sprint 08): `GET/POST /api/products`,
`GET/PUT/DELETE /api/products/{id}`.
PHP 8.2+, database default SQLite (tanpa MySQL).

Catatan laptop (Irwand, 17 Nov 2026): `composer update` diblokir
security advisory Composer 2.11 — pakai `composer install` (dari lock).
PHP 8.2.34 Laragon: lock mengunci `laravel/pint` 1.32.3 yang butuh
PHP 8.3, jadi instal pakai `composer install --no-dev` (pint hanya
paket dev). Ekstensi `pdo_sqlite` harus aktif di php.ini Laragon
(`C:\laragon\bin\php\php-8.2.34-nts-Win32-vs16-x64\php.ini`).

## Upgrade 17 Nov 2026 — Halaman Baru + Auth + Form Pendek

- **Halaman baru:** Tentang Kami (`/tentang`), Market (`/market`,
  cari + filter kategori + urutkan harga), Top Up (`/topup`, form +
  ringkasan order demo, tanpa payment gateway), Akun (`/akun`).
- **Auth hand-rolled** (tanpa package baru): `RegisterController` +
  `LoginController`, rute `/register`, `/login`, `/logout`, tabel
  `users` + `password_reset_tokens`. Daftar/masuk dulu sebelum bisa
  jual akun: rute create/store/edit/update/destroy dipagari middleware
  `auth`; tamu diarahkan ke `/login`.
- **Form listing dipendekkan** (`products/_form.blade.php`): tinggal
  judul, game, kategori, harga, deskripsi singkat, gambar.
  Kode dibuat otomatis (`P` + id), penjual diisi dari nama akun login,
  kolom lain diisi default oleh Controller. Migration baru
  `add_user_id_to_products_table` mengikat listing ke akun pembuatnya
  supaya tampil di "Listing saya".
- **Gambar listing wajib di-upload sendiri** (JPG/JPEG/PNG/WebP,
  maks 2 MB): form memakai input file (`enctype="multipart/form-data"`),
  validasi `required|image` saat tambah; saat ubah boleh kosong dan
  gambar lama tetap dipakai, upload baru menggantikan file lama.
  File tersimpan di `public/uploads/products/` (nama unik) sehingga
  langsung tampil tanpa `storage:link`. Tidak ada lagi gambar default
  dari nama game — listing tanpa upload gambar ditolak validasi.
- **Top up:** tabel `top_up_orders` (game, nominal, ID akun game,
  status demo "Menunggu"); order milik user login tampil di Akun.

Update di laptop yang sudah jalan Week 9:

```powershell
cd "D:\SEMESTER 5\WEB\Project\TriverseStore"
git pull origin week9
php artisan serve
```

Tidak perlu `composer install` ulang (tidak ada package baru) dan
tidak perlu `migrate` (tidak ada perubahan skema database).
Akun lama tidak ada — daftar dulu lewat `/register` sebelum
mencoba tombol Jual Akun.

## Sprint 08 — REST API + Validasi (Week 10)

Sprint 08 (Pertemuan 10, "Controller, Routing & Validation") adalah
lanjutan Sprint 07: Task 01 (pindahkan CRUD ke Controller) sudah
terpenuhi oleh `ProductController` Week 9 — keenam method sudah ada dan
semua rute web sudah menunjuk ke controller — jadi tidak ada yang
diulang. Yang baru adalah Task 02 dan Task 03.

**Validasi (Task 02).** Aturan `judul` diperketat dari `max:255` menjadi
`required|string|max:100` sesuai PPT; `deskripsi_singkat` tetap
`required`. Pesan error kini Bahasa Indonesia ("Judul wajib diisi.",
"Judul maksimal 100 karakter.", "Deskripsi wajib diisi.", dst) dan
dipakai form web maupun respons API. Form juga dibatasi `maxlength`
100. Perbaikan kecil: `update()` Week 9 hanya mengubah
`deskripsi_singkat` — sekarang kolom `deskripsi` (yang dipakai halaman
detail) ikut berubah.

**REST API (Task 03).** Satu controller yang sama melayani web dan API,
sesuai pola PPT (bukan controller `Api\` terpisah): helper `isApi()`
mendeteksi rute `/api/*` — request API dijawab JSON, request web tetap
View/redirect seperti semula. Rute API didaftarkan di `routes/api.php`
(`Route::apiResource('products', ProductController::class)`) dan
`bootstrap/app.php` mendaftarkan file rute API — tanpa `install:api`,
tanpa Sanctum, tanpa package baru.

| Method | Endpoint | Respons |
|--------|----------|---------|
| GET | `/api/products` | 200 `{"data": [...]}` |
| POST | `/api/products` | 201 `{"message": "Berhasil", "data": {...}}` |
| GET | `/api/products/{id}` | 200 `{"data": {...}}`, 404 bila tidak ada |
| PUT/PATCH | `/api/products/{id}` | 200 `{"message": "Berhasil", "data": {...}}` |
| DELETE | `/api/products/{id}` | 200 `{"message": "Produk berhasil dihapus."}` |
| POST (data kosong) | `/api/products` | 422 `{"message": "...", "errors": {...}}` |

**Tanpa login.** API demo PPT dites lewat Postman tanpa auth, jadi API
tanpa login: produk yang dibuat lewat API disimpan dengan `user_id`
null dan `seller_nama` "TriverseStore"; update/hapus lewat API tidak
mengecek pemilik — komentar kode mencatat aplikasi sungguhan wajib
pakai token (mis. Sanctum). **Gambar lewat API:** JSON body tanpa file
harus tetap jalan — produk API tanpa gambar disimpan sebagai string
kosong `''` (tanpa migrasi, jadi tidak perlu `migrate`); `getGambarUrl()`
kini null-safe dan keempat Blade yang memakai gambar di-guard, sehingga
produk tanpa gambar tetap tampil di katalog/detail. Aturan web tidak
berubah: gambar listing tetap wajib di-upload, tanpa gambar default.

Mencoba API (server jalan di `http://127.0.0.1:8000`):

```bash
curl http://127.0.0.1:8000/api/products
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{"judul":"Akun Mobile Legends Sultan","game":"Mobile Legends","kategori":"Akun","harga":250000,"deskripsi_singkat":"Akun sultan, skin lengkap."}'
curl http://127.0.0.1:8000/api/products/11
curl -X PUT http://127.0.0.1:8000/api/products/11 \
  -H "Content-Type: application/json" \
  -d '{"judul":"Akun Mobile Legends Sultan","game":"Mobile Legends","kategori":"Akun","harga":300000,"deskripsi_singkat":"Akun sultan, skin lengkap."}'
curl -X DELETE http://127.0.0.1:8000/api/products/11
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Content-Type: application/json" -d '{}'
```

Update di laptop (branch baru `week10`):

```powershell
cd "D:\SEMESTER 5\WEB\Project\TriverseStore"
git fetch origin
git checkout week10
php artisan serve
```

Tidak perlu `composer install` (tidak ada package baru) dan tidak perlu
`migrate` (tidak ada perubahan skema database).

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
6. **Fungsi REST API (Sprint 08):** satu controller yang sama melayani
   web dan API — `isApi()` membedakan request `/api/*` (dijawab JSON)
   dari request web (dijawab View/redirect); `Route::apiResource`
   mendaftarkan kelima endpoint sekaligus.
7. **Fungsi HTTP Status Code (Sprint 08):** 200 sukses, 201 data baru
   berhasil dibuat, 404 data tidak ditemukan, 422 data gagal validasi —
   status code memberi tahu client hasil request tanpa harus membaca
   isi body.

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
- *Apa itu REST API? (Sprint 08)* — Cara aplikasi menyediakan datanya
  sebagai JSON lewat endpoint HTTP, supaya bisa dipakai program lain
  (Postman, aplikasi HP) tanpa membuka halaman web.
- *Apa beda respons web dan API? (Sprint 08)* — Web menjawab dengan
  halaman HTML (View), API menjawab dengan JSON (`{"data": ...}`).
- *Apa arti status code 200, 201, 404, 422? (Sprint 08)* — 200 sukses,
  201 data baru berhasil dibuat, 404 data tidak ditemukan, 422 data
  gagal validasi (mis. judul kosong atau lebih dari 100 karakter).

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

## Evolusi Week 9 → Week 10

| Berkas/Folder | Perubahan |
|---------------|-----------|
| `routes/api.php` | **Baru.** `Route::apiResource('products', ProductController::class)` — kelima endpoint REST. |
| `bootstrap/app.php` | **Diubah.** Mendaftarkan file rute API (`api: __DIR__.'/../routes/api.php'`) — tanpa `install:api`, tanpa Sanctum. |
| `app/Http/Controllers/ProductController.php` | **Diubah.** `show()` menerima `Request` agar bisa mendeteksi request API; helper `isApi()` memisahkan respons JSON (API) dari View/redirect (web); validasi `judul` `max:255` → `max:100` + pesan error Bahasa Indonesia; `update()` kini menyinkronkan `deskripsi` dan `deskripsi_singkat`. |
| `app/Models/Product.php` | **Diubah.** `getGambarUrl()` null-safe: mengembalikan `null` bila produk tidak punya gambar (produk API). |
| `resources/views/products/` | **Diubah.** Keempat Blade yang memakai gambar di-guard (`@if ($product->gambar)`); hero fan di katalog difilter produk bergambar; form judul `maxlength` 100. |
| `routes/web.php`, migration, seeder | Tidak berubah. |

Sprint 08 mengerjakan Controller, Routing, dan Validation yang mendalam
dari Pertemuan 10: satu controller melayani web dan API, validasi
diperketat, dan data produk tersedia sebagai JSON lewat REST API.

Hasilnya: sembilan week, satu tampilan, satu dataset — setiap week hanya
mengubah **satu lapisan** (struktur → perilaku → sumber data → sisi server →
objek → arsitektur → framework + database), sehingga merge antar week
tidak pernah bentrok.
