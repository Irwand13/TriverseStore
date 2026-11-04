# Week 7 — Sprint 06: MVC — From OOP to MVC

**Penanggung jawab:** Alfino14 · **Branch acuan:** `week7`

## Tema Sprint

Mengorganisasi aplikasi PHP OOP Week 6 ke arsitektur **MVC**: tanggung
jawab dipisah menjadi **Model** (data), **View** (tampilan), dan
**Controller** (pengatur alur). Alur request-nya:

```
User → request → Controller → meminta data ke Model → Model mengembalikan
data → Controller meneruskan ke View → View menghasilkan HTML → User
```

Hasil akhir di layar **identik** dengan Week 6 — yang berubah hanya
organisasi kodenya. Week ini adalah jembatan langsung ke Laravel (framework
MVC) yang dipakai proyek TriverseStore sebenarnya.

## Pemetaan Sub-Tugas

| Kode | Sub-Tugas | Penerapan di folder ini |
|------|-----------|-------------------------|
| W7.1 | Desain Struktur MVC | Folder `app/Models`, `app/Views`, `app/Controllers` memisahkan tiga tanggung jawab; `public/` menjadi satu-satunya folder yang diekspos server (front controller + aset). |
| W7.2 | Bangun Model & Controller | Model `Game` (typed property + method akses data statis `all()`, `find()`, `filter()`, `related()`), Model `Seller` & `Cart`; `GameController` dengan method `index()`, `show()`, `process()`, `notFound()`. |
| W7.3 | Bangun View & Hubungkan Alur Penuh | View di `app/Views/games/` menampilkan data dari Controller dengan short echo `<?= ?>`; View tidak pernah mengambil data sendiri. Alur request → Controller → Model → View berjalan untuk katalog, detail, dan 404. |
| W7.4 | Demo MVC Flow & Review Sprint 06 | Lihat pertanyaan demo di bawah. |

## Struktur Folder

```
week7/
├── public/
│   ├── index.php         # FRONT CONTROLLER: satu-satunya pintu masuk (?page=)
│   ├── css/style.css     # Salinan file CSS yang sama sejak Week 2
│   └── assets/img/       # Gambar yang sama persis dengan week sebelumnya
├── app/
│   ├── Models/
│   │   ├── Game.php      # Class Week 6 + method akses data (all/find/filter/related)
│   │   ├── Seller.php    # Class Week 6, kini berperan sebagai Model
│   │   └── Cart.php      # Class Week 6, kini berperan sebagai Model
│   ├── Controllers/
│   │   └── GameController.php   # index(), show(), process(), notFound()
│   └── Views/
│       ├── layout.php    # Kerangka HTML + renderLayout() (head/header/footer)
│       ├── helpers.php   # formatRupiah() + renderKartuProduk() untuk View
│       ├── games/
│       │   ├── index.php # View katalog
│       │   └── detail.php# View detail produk
│       └── errors/
│           └── 404.php   # View tidak ditemukan
└── README.md
```

Tidak ada folder `includes/` atau `data/` lagi: partial header/footer
menjadi `layout.php`, dan file data menjadi tanggung jawab Model.

## Cara Menjalankan

Document root diarahkan ke `public/`:

```bat
php -S localhost:8000 -t public
```

(dari folder `week7/`), lalu buka `http://localhost:8000`.
Rute: katalog = `index.php`, detail = `index.php?page=detail&id=P1`,
rute tak dikenal = 404. PHP 8.2, tanpa database/framework.

## Poin Penjelasan untuk Dosen

1. **Fungsi tiap komponen:** Model mengelola data (dataset + cara
   mengambilnya), Controller mengatur proses (membaca parameter request,
   memutuskan View mana dan data apa), View hanya menampilkan.
2. **Komunikasi Controller ↔ Model:** Controller memanggil method Model
   (`Game::filter(...)`, `Game::find(...)`) dan menerima objek kembali —
   Controller tidak tahu (dan tidak peduli) dari mana data berasal.
3. **Komunikasi Controller → View:** data diserahkan sebagai array ke
   `renderLayout()` lalu di-`extract()` menjadi variabel View; View
   menampilkannya dengan `<?= ?>`.
4. **Front controller:** satu file `public/index.php` menerima semua
   request dan memetakan `?page=` ke method Controller — pola yang sama
   dengan routing Laravel.
5. **Keuntungan pemisahan:** mengganti sumber data (mis. dari array ke
   database) cukup mengubah Model; mengganti tampilan cukup mengubah View;
   keduanya tidak mengganggu Controller.

## Pertanyaan Demo (Sprint 06)

- *Apa fungsi Controller?* — Menerima request, mengatur proses, memanggil
  Model, dan meneruskan data ke View (`GameController::index/show`).
- *Data apa yang dikelola Model?* — Sepuluh listing akun game dan lima
  penjual (dataset kanonis proyek) beserta method aksesnya.
- *Apa yang ditampilkan View?* — Katalog, detail produk, dan halaman 404
  dalam kerangka layout yang sama.
- *Bagaimana Controller berkomunikasi dengan Model?* — Memanggil method
  statis Model dan menerima objek `Game` sebagai hasil.
- *Bagaimana data sampai ke View?* — Controller menyerahkan array data ke
  `renderLayout()`; View membaca variabelnya dan mencetak dengan `<?= ?>`.

## Evolusi dari Week Sebelumnya (Week 6 → Week 7)

| Berkas/Folder | Perubahan |
|---------------|-----------|
| `public/index.php` | **Baru.** Front controller + routing `?page=` sederhana. |
| `app/Controllers/GameController.php` | **Baru.** Logika yang di Week 6 tersebar di kepala `index.php`/`detail.php` (baca `$_GET`, saring, tentukan 404) kini menjadi method Controller. |
| `app/Models/Game.php` | Class Game Week 6 **dipindah** dari `classes/` dan ditambah method akses data statis: `all()`, `find()`, `filter()`, `related()`, `sellerCount()`. |
| `app/Models/Seller.php`, `app/Models/Cart.php` | Class Week 6 **dipindah apa adanya** dari `classes/` (hanya komentar kepala disesuaikan). |
| `app/Views/games/index.php`, `detail.php` | Badan halaman Week 6 dipotong menjadi View konten; logika pengambilan datanya dibuang — data datang dari Controller. Markup & class tidak berubah. |
| `app/Views/layout.php` | **Baru.** Pengganti `includes/header.php` + `footer.php`: satu fungsi `renderLayout($judul, $kontenFile, $data)`. |
| `app/Views/helpers.php` | Fungsi `formatRupiah()` + `renderKartuProduk()` dari `includes/functions.php` Week 6, dipindah khusus untuk View; tautan kartu kini `index.php?page=detail&id=...`. |
| `data/products.php` | **Dihapus.** Isinya (dataset kanonis) pindah ke `Game::all()` di Model — nilai tidak berubah satu pun. |
| `public/css/style.css` | **Salinan persis** file CSS yang sama sejak Week 2 (token desain tunggal tidak berubah di seluruh perjalanan). |
| `public/assets/img/*` | Tidak berubah. |

Hasilnya: enam week, satu tampilan, satu dataset — setiap week hanya
mengubah **satu lapisan** (struktur → perilaku → sumber data → sisi server →
objek → arsitektur), sehingga merge antar week tidak pernah bentrok.
