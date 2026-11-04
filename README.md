# Week 2 — Sprint 01: HTML & CSS (Halaman Statis)

**Penanggung jawab:** nurdiansyah-io · **Branch acuan:** `week2`
**Status:** PPT Week 2 belum tersedia — sub-tugas W2.1–W2.3 bersifat *sementara*,
disusun dari pola Sprint 01 yang dirujuk slide Week 3. Wajib disesuaikan
begitu `week2.pptx` resmi terbit.

## Tema Sprint

Fondasi web: **HTML membentuk struktur konten** dan **CSS mengatur tampilan,
layout, dan responsivitas**. Di week ini TriverseStore dibangun sebagai
halaman statis murni — belum ada JavaScript dan belum ada server.

## Pemetaan Sub-Tugas

| Kode | Sub-Tugas | Penerapan di folder ini |
|------|-----------|-------------------------|
| W2.1 | Struktur HTML Halaman Statis *(sementara)* | `index.html` (header/nav, hero, section katalog, rekber, tentang, footer) dan `detail.html` (breadcrumb, galeri, info produk, panel beli) memakai elemen semantik HTML5. |
| W2.2 | Styling CSS: Tampilan, Layout, Responsivitas *(sementara)* | `assets/css/style.css` — satu sistem desain untuk seluruh proyek: variabel warna (paper `#FAF7F2`, ink `#221D15`, terracotta `#C4502B`, sage `#5F7161`), font Fraunces + Inter, grid katalog responsif, media query 900px & 640px. |
| W2.3 | Demo Sprint 01 & Commit *(sementara)* | Halaman dapat didemo langsung dari file; lihat pertanyaan demo di bawah. |

## Struktur Folder

```
week2/
├── index.html            # Beranda: hero, katalog 10 akun, rekber, tentang
├── detail.html           # Contoh halaman detail (produk P1: akun MLBB)
├── assets/
│   ├── css/style.css     # Sistem desain tunggal (dipakai semua week)
│   └── img/              # Key art / screenshot resmi tiap game (10 file)
└── README.md
```

## Cara Menjalankan

Cukup buka `index.html` dengan browser (klik dua kali). Tidak butuh server,
tidak butuh build. Semua aset (CSS & gambar) bersifat lokal/relatif.

## Dataset

Sepuluh produk, lima penjual, dan semua nilai (harga, diskon, rating, status)
mengikuti satu dataset kanonis proyek di `../DATASET.md` dan **identik** di
semua week. Gambar adalah key art/screenshot resmi tiap game (sumber tercatat
di DATASET.md), bukan gambar acak atau tile warna.

## Poin Penjelasan untuk Dosen

1. **Pemisahan struktur & presentasi:** HTML hanya berisi struktur dan konten;
   seluruh tampilan diatur `style.css`. Mengganti satu variabel warna di
   `:root` mengubah seluruh situs.
2. **Komponen kartu produk (`.game-card`):** satu pola markup dipakai berulang
   untuk 10 produk — gambar, kategori, judul, penjual + rating, deskripsi,
   harga (dengan harga coret bila diskon), badge status, tombol. Pola berulang
   inilah yang di week berikutnya dirender otomatis oleh JavaScript/PHP.
3. **Layout modern:** Flexbox untuk header & toolbar, CSS Grid untuk katalog
   dan hero; `aspect-ratio: 16/9` menjaga bingkai gambar tetap seragam.
4. **Responsivitas:** grid katalog memakai `auto-fill minmax(255px, 1fr)`,
   ditambah media query untuk tablet dan ponsel.

## Pertanyaan Demo (Sprint 01)

- *Elemen HTML apa saja yang membentuk halaman?* — `header`, `nav`, `main`,
  `section`, `article` (kartu), dan `footer`, dipilih secara semantik.
- *Bagaimana CSS mengatur layout katalog?* — CSS Grid dengan kolom otomatis
  dan jarak (gap) konsisten; kartu memakai Flexbox kolom agar harga selalu
  menempel di bawah.

## Evolusi dari Week Sebelumnya

Week 2 adalah titik awal (belum ada week sebelumnya). Seluruh file di folder
ini menjadi **basis yang disalin ke Week 3**; yang berubah di Week 3 hanya
lapisan perilakunya (JavaScript), bukan struktur markup atau CSS-nya.
