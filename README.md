# Week 6 — Sprint 05: PHP OOP — From Procedural to Object-Oriented

**Penanggung jawab:** Irwand13 (Irwand) · **Branch acuan:** `week6`

## Tema Sprint

Kode Week 5 yang prosedural (data dan function terpisah) difaktorkan ulang
menjadi **berorientasi objek**: data dan perilaku menyatu di dalam *object*
yang dibuat dari *class* (blueprint). Halaman, tampilan, dan hasil akhir
**sama persis** dengan Week 5 — yang berubah adalah cara datanya dikelola.

## Pemetaan Sub-Tugas

| Kode | Sub-Tugas | Penerapan di folder ini |
|------|-----------|-------------------------|
| W6.1 | Rancang & Buat Class | Tiga class: `classes/Game.php` (listing akun), `classes/Seller.php` (penjual), `classes/Cart.php` (keranjang) — masing-masing di file sendiri. |
| W6.2 | Property, Method & Akses Object | Objek dibuat dengan `new` di `data/products.php`; halaman mengaksesnya dengan operator `->`, mis. `$produk->getJudul()` dan `$produk->getSeller()->getNama()` (Game memegang objek Seller). |
| W6.3 | Constructor & Encapsulation | Semua property `private` bertipe (typed property); nilai awal diisi `__construct()`; akses dari luar hanya lewat getter, mis. `getHargaAkhir()`, `getHargaCoret()`, `getBadgeClass()`. |
| W6.4 | Konten Dinamis dari Object & Demo Sprint 05 | Seluruh katalog/detail dirender dari method objek; bagian **Demo Class Cart** di `detail.php` membuktikan objek `Cart` menghitung totalnya sendiri lewat `totalHarga()`. |

## Struktur Folder

```
week6/
├── index.php             # Sama seperti Week 5, kini membaca objek
├── detail.php            # Sama seperti Week 5 + panel Demo Class Cart
├── classes/
│   ├── Game.php          # Class produk: property, constructor, getter, method harga/badge
│   ├── Seller.php        # Class penjual: ringkasan & inisial avatar
│   └── Cart.php          # Class keranjang: tambah, hapus, totalHarga
├── data/
│   └── products.php      # Dataset kanonis sebagai objek (5 Seller, 10 Game)
├── includes/
│   ├── functions.php     # Tinggal formatRupiah + renderKartuProduk(Game)
│   ├── header.php        # Identik dengan Week 5
│   └── footer.php        # Identik dengan Week 5
├── assets/
│   ├── css/style.css     # Identik dengan Week 5 (tanpa perubahan)
│   └── img/              # Sama persis dengan week sebelumnya
└── README.md
```

## Cara Menjalankan

Dari folder `week6/`: `php -S localhost:8000`, lalu buka
`http://localhost:8000`. PHP 8.2, tanpa database/framework.

## Poin Penjelasan untuk Dosen

1. **Prosedural vs OOP pada data yang sama:** di Week 5 harga coret dihitung
   function lepas `hargaCoret($produk)`; di Week 6 ia menjadi tanggung jawab
   objeknya sendiri: `$produk->getHargaCoret()`. Data tidak lagi "dititipkan"
   ke function — objek membawa datanya dan tahu cara mengolahnya.
2. **Encapsulation:** property `private` tidak bisa diubah sembarangan dari
   luar; halaman hanya membaca lewat getter. Mencoba mengakses
   `$produk->harga` langsung akan menghasilkan error — itu disengaja.
3. **Constructor:** `new Game('P1', ..., $seller)` menjamin setiap objek
   lahir lengkap; tidak ada objek setengah jadi.
4. **Relasi antar-objek:** `Game` memegang `Seller`, sehingga
   `$produk->getSeller()->getRingkasan()` menghasilkan data penjual tanpa
   array tambahan.
5. **Class sebagai unit perilaku:** `Cart` menyimpan daftar Game dan
   menghitung `totalHarga()` dari method-nya sendiri.

## Pertanyaan Demo (Sprint 05)

- *Class apa yang dibuat?* — `Game`, `Seller`, dan `Cart`.
- *Object apa yang digunakan?* — 10 objek `Game`, 5 objek `Seller`, dan
  1 objek `Cart` pada demo halaman detail.
- *Property apa yang dimiliki?* — Game: id, judul, game, kategori, gambar,
  harga, diskon, status, deskripsi, platform, level, itemUnggulan, seller.
- *Method apa yang dibuat?* — Getter untuk semua property, plus
  `getHargaAkhir()`, `getHargaCoret()`, `getBadgeClass()`, `getRingkasan()`
  pada Game; `tambah()`, `hapus()`, `totalHarga()` pada Cart.
- *Bagaimana object menghasilkan data pada halaman?* — View memanggil
  method lewat `->` dan menyisipkan hasilnya dengan `<?= ?>`.
- *Bagian mana yang lebih mudah dikelola dengan object?* — Logika harga &
  status: satu tempat di class, bukan tersebar di banyak function.

## Evolusi dari Week Sebelumnya (Week 5 → Week 6)

| Berkas | Perubahan |
|--------|-----------|
| `classes/Game.php`, `classes/Seller.php`, `classes/Cart.php` | **Baru.** Inti refactor week ini. |
| `data/products.php` | Ditulis ulang: array asosiatif → objek. Nilai dataset tidak berubah satu pun. Fungsi `cariProduk()` kini mengembalikan `?Game`. |
| `includes/functions.php` | Menyusut: `hargaCoret()` dan `badgeClass()` **dihapus** karena pindah menjadi method Game; `renderKartuProduk()` menerima objek `Game`. |
| `index.php` | Diubah mekanis: akses `$produk['judul']` → `$produk->getJudul()`. Alur, markup, dan hasil HTML identik. |
| `detail.php` | Sama seperti index, ditambah satu section baru **Demo Class Cart** yang memakai class `Cart`. |
| `includes/header.php`, `includes/footer.php` | **Tidak berubah** (hanya label week di footer yang diganti lewat variabel `$weekLabel`). |
| `assets/css/style.css`, `assets/img/*` | **Tidak berubah sama sekali.** |

Refactor ini membuktikan pemisahan yang bersih: mengganti total cara data
dikelola (array → objek) tanpa menyentuh satu baris pun tampilan.
