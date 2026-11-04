# Week 3 — Sprint 02: JavaScript — From Static to Interactive

**Penanggung jawab:** Irwand13 (Irwand) · **Branch acuan:** `week3`

## Tema Sprint

Menambahkan JavaScript pada halaman Week 2 agar merespons aksi pengguna:
aksi pengguna → **event** → JavaScript menjalankan kode → **manipulasi DOM**
→ tampilan berubah tanpa memuat ulang halaman.

## Pemetaan Sub-Tugas

| Kode | Sub-Tugas | Penerapan di folder ini |
|------|-----------|-------------------------|
| W3.1 | Selector & Manipulasi DOM | `assets/js/app.js` memakai `querySelector` (id `#searchInput`, `#gameGrid`), `querySelectorAll` (class `.filter-chip`), lalu mengisi katalog dengan `innerHTML` dari template literal; teks harga/total diubah dengan `textContent`. |
| W3.2 | Event Handling (Click, Input, Submit) | Event `input` pada kotak pencarian (filter langsung), `click` pada chip kategori & tombol keranjang, `submit` pada form pemesanan — semua dengan `addEventListener`. |
| W3.3 | Satu Interaksi Utuh (Task 03) | Keranjang belanja utuh: klik "+ Keranjang" → item tersimpan → badge header, panel keranjang, dan total berubah → checkout menampilkan ringkasan rekber. Termasuk `setAttribute`-style lewat `dataset`, `classList.add/remove` pada chip aktif, dan perubahan `hidden` pada state kosong. |
| W3.4 | Demo & Review Sprint 02 | Lihat pertanyaan demo di bawah; interaksi terlihat langsung, tidak mengganggu UI, dan halaman lama tetap utuh. |

## Struktur Folder

```
week3/
├── index.html            # Sama seperti Week 2; katalog kini dirender JS
├── detail.html           # Sama seperti Week 2 + tombol "Tambah ke Keranjang"
├── assets/
│   ├── css/style.css     # File Week 2 + delta kecil (kelas .split-grid)
│   ├── img/              # Sama persis dengan Week 2
│   └── js/
│       ├── data.js       # Dataset kanonis sebagai array of objects
│       ├── app.js        # Render katalog, pencarian, filter, keranjang, form
│       └── detail.js     # Interaksi halaman detail (keranjang bersama)
└── README.md
```

## Cara Menjalankan

Buka `index.html` dengan browser (klik dua kali). JavaScript murni tanpa
library/framework. Keranjang disimpan di `localStorage` (kunci `ts_cart`)
sehingga isinya sama antara halaman katalog dan detail.

Catatan materi Tailwind (slide 8): proyek ini **sengaja tetap memakai CSS
kustom** agar sistem desainnya konsisten dari Week 2 sampai Week 7; Tailwind
dibahas sebagai perbandingan gaya penulisan (utility class) pada saat demo.

## Poin Penjelasan untuk Dosen

1. **Selector:** `querySelector` mengambil satu elemen (id/class/tag),
   `querySelectorAll` mengambil banyak elemen sekaligus — persis tiga pola
   selector di slide.
2. **Render dari data:** katalog tidak lagi ditulis manual di HTML; fungsi
   `buildCardHTML()` membangun markup kartu yang *sama persis* dengan Week 2
   dari array `PRODUCTS`, lalu `container.innerHTML` menampilkannya sekaligus.
3. **Event:** perbedaan `click` (aksi tombol), `input` (setiap ketikan), dan
   `submit` (pengiriman form, dicegah reload-nya dengan `preventDefault()`).
4. **State di sisi klien:** array `cart` adalah sumber kebenaran keranjang;
   setiap perubahan memanggil `renderCart()` agar badge, daftar, dan total
   selalu sinkron.

## Pertanyaan Demo (Sprint 02)

- *Interaksi apa yang ditunjukkan?* — Pencarian & filter katalog, tambah/
  hapus keranjang dengan total otomatis, dan form pemesanan dengan pesan hasil.
- *Event apa yang digunakan?* — `click`, `input`, dan `submit`.
- *Apa yang dilakukan JavaScript?* — Memfilter array data, membangun ulang
  HTML katalog, dan memperbarui panel keranjang.
- *Elemen apa yang berubah?* — `#gameGrid`, `#cartItems`, `#cartTotal`,
  `#cartCount`, dan kotak pesan `#orderAlert`.

## Evolusi dari Week Sebelumnya (Week 2 → Week 3)

| Berkas | Perubahan |
|--------|-----------|
| `index.html` | Diubah: kartu katalog statis dihapus → diganti toolbar (pencarian + chip kategori) dan container kosong `#gameGrid`; ditambah tombol Keranjang di header dan section "Keranjang & Pemesanan" (panel keranjang + form). Hero, strip rekber, tentang, dan footer **tidak berubah**. |
| `detail.html` | Diubah kecil: tombol Keranjang di header, kotak pesan `#detailAlert`, tombol "Tambah ke Keranjang" di panel beli, dan tag `<script>`. Sisanya identik. |
| `assets/css/style.css` | Disalin utuh dari Week 2, ditambah satu blok kecil di akhir: kelas `.split-grid` untuk layout dua kolom keranjang/form. Tidak ada token warna/font yang berubah. |
| `assets/js/data.js` | **Baru.** Dataset kanonis yang di Week 2 tersebar sebagai HTML statis kini ditulis sekali sebagai array of objects. |
| `assets/js/app.js` | **Baru.** Seluruh lapisan interaksi halaman katalog. |
| `assets/js/detail.js` | **Baru.** Interaksi halaman detail. |
| `assets/img/*` | Tidak berubah sama sekali. |

Karena markup kartu yang dihasilkan JavaScript identik dengan markup statis
Week 2, menggabungkan (merge) Week 3 ke Week 2 tidak menimbulkan konflik
tampilan — yang bertambah murni lapisan perilaku.
