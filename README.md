# Week 5 — Sprint 04: PHP Dasar — From Client-Side to Server-Side

**Penanggung jawab:** nurdiansyah-io · **Branch acuan:** `week5`

## Tema Sprint

Logika halaman berpindah dari browser ke **server**: user membuka halaman →
browser mengirim *request* → web server menjalankan script PHP → hasil
proses dikirim kembali sebagai **HTML response**. Program PHP prosedural
mengikuti alur Input → Process → Output dengan delapan topik dasar: syntax,
variable, datatype, operator, conditional, loop, function, output.

## Pemetaan Sub-Tugas

| Kode | Sub-Tugas | Penerapan di folder ini |
|------|-----------|-------------------------|
| W5.1 | Setup PHP & Halaman PHP Pertama | `index.php` dan `detail.php` adalah halaman `.php` yang dijalankan server lokal (`php -S`); seluruh output-nya adalah HTML hasil proses PHP. |
| W5.2 | Variable & Conditional | Variable `$kategoriAktif` dan `$kataKunci` dibaca dari `$_GET`; conditional `if/else` menentukan badge status, harga coret, tombol beli vs "Sudah Terjual", dan cabang halaman 404. |
| W5.3 | Loop & Function | `foreach` menyaring dan merender katalog dari array; function berparameter dengan `return` di `includes/functions.php`: `formatRupiah()`, `hargaCoret()`, `badgeClass()`, dan `renderKartuProduk()`. |
| W5.4 | Konten Dinamis Server-Side & Demo Sprint 04 | Seluruh katalog, filter, dan halaman detail dihasilkan server dari `data/products.php` — tidak ada lagi JavaScript untuk data. |

## Struktur Folder

```
week5/
├── index.php             # Katalog + filter GET (kategori & pencarian)
├── detail.php            # Detail produk ?id=P1; 404 bila id tidak ada
├── data/
│   └── products.php      # Dataset kanonis sebagai array PHP + cariProduk()
├── includes/
│   ├── functions.php     # formatRupiah, hargaCoret, badgeClass, render kartu
│   ├── header.php        # Partial kepala halaman (dipakai bersama)
│   └── footer.php        # Partial kaki halaman (dipakai bersama)
├── assets/
│   ├── css/style.css     # Identik dengan Week 4 (tanpa perubahan)
│   └── img/              # Sama persis dengan week sebelumnya
└── README.md
```

## Cara Menjalankan

Dari folder `week5/`:

```bat
php -S localhost:8000
```

Buka `http://localhost:8000`. Membutuhkan PHP 8.2 (sesuai laptop
pengembangan). Tanpa database dan tanpa framework — PHP murni.

## Poin Penjelasan untuk Dosen

1. **Perbedaan client-side vs server-side:** di Week 3–4 browser mengunduh
   data lalu JavaScript menyaringnya; di Week 5 penyaringan terjadi di
   server — HTML yang tiba di browser sudah berisi hasil filter saja.
   Buktinya terlihat di URL: `index.php?kategori=RPG&q=akun`.
2. **Variable & tipe data:** string (`$judul`), integer (`$harga`), float
   (`$rating`), array (`$products`), dan null (`hargaCoret()` mengembalikan
   `null` bila tidak ada diskon).
3. **Conditional & operator:** perbandingan ketat `===` pada status dan
   kategori, `if/elseif` lewat `match` pada `badgeClass()`.
4. **Function:** `formatRupiah(850000)` mengembalikan `"Rp 850.000"` —
   logika yang sama dipakai katalog, detail, dan panel beli tanpa duplikasi.
5. **Output:** `echo` dan tag pendek `<?= ... ?>` menyisipkan hasil proses
   PHP ke dalam HTML; `htmlspecialchars()` menjaga output teks tetap aman.

## Pertanyaan Demo (Sprint 04)

- *Bagaimana conditional/loop digunakan?* — Conditional menyaring produk
  dan menentukan label status; loop `foreach` merender setiap produk hasil
  saringan menjadi kartu.
- *Apa yang dihasilkan PHP?* — Dokumen HTML lengkap (katalog dan detail)
  yang datanya berasal dari array di server.
- *Perbedaan proses PHP dengan JavaScript?* — PHP berjalan sekali di
  server sebelum halaman dikirim; JavaScript berjalan di browser setelah
  halaman diterima.

## Evolusi dari Week Sebelumnya (Week 4 → Week 5)

| Berkas | Perubahan |
|--------|-----------|
| `index.php`, `detail.php` | **Baru** (pengganti `index.html`/`detail.html`): markup, class, dan teks **identik** dengan Week 4, tetapi kini dihasilkan PHP di server. Detail tidak lagi mencontohkan P1 saja — semua produk punya halaman detail lewat `?id=`. |
| `data/products.php` | **Baru.** Dataset kanonis yang di Week 4 berbentuk `games.json` kini menjadi array PHP. |
| `includes/functions.php` | **Baru.** Padanan server-side dari helper JavaScript Week 3–4 (`formatRupiah`, dsb.) plus `renderKartuProduk()`. |
| `includes/header.php`, `includes/footer.php` | **Baru.** Header/footer yang sebelumnya disalin di tiap HTML kini satu partial bersama. |
| `api/games.json`, `assets/js/*` | **Dihapus.** Tidak ada lagi fetch maupun JavaScript untuk data. |
| `assets/css/style.css`, `assets/img/*` | **Tidak berubah sama sekali.** |

Karena markup hasil PHP byte-per-byte sekelas dengan markup Week 4, perpindahan
teknologi ini tidak mengubah tampilan sama sekali — yang berubah hanya tempat
logikanya berjalan, persis pesan Sprint 04.
