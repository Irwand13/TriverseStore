# Week 4 — Sprint 03: API & Fetch — From Interactive to Data-Driven

**Penanggung jawab:** Alfino14 · **Branch acuan:** `week4`

## Tema Sprint

Menghubungkan halaman ke API: aplikasi mengirim *request* ke endpoint →
server memproses → *response* berisi data **JSON** → data ditampilkan
dinamis di halaman. Di proyek ini endpoint disimulasikan secara lokal
dengan file `api/games.json` (pola REST yang sama: satu endpoint
mengembalikan satu object berisi `products` berupa array of objects).

## Pemetaan Sub-Tugas

| Kode | Sub-Tugas | Penerapan di folder ini |
|------|-----------|-------------------------|
| W4.1 | Koneksi API Pertama (Fetch & Promise) | `assets/js/app.js` fungsi `loadProducts()`: `fetch("api/games.json")` ditangani dengan `async/await` + `try/catch/finally`; blok komentar di kepala file membandingkan pola `.then()` berantai dari slide. Pemeriksaan `response.ok` melempar `Error` bila respons gagal. |
| W4.2 | Render Data JSON ke DOM | Array of objects dirender dengan `map()` + template literal menjadi kartu katalog (markup identik Week 2–3); satu object tunggal (produk unggulan P1) dirender ke halaman `detail.html` oleh `assets/js/detail.js` dengan mengakses properti `data.judul`, `data.harga`, dst. |
| W4.3 | Loading State & Error Handling | Kotak "Mengambil data..." + spinner tampil selama request; bila gagal, kotak error berisi pesan + tombol **Coba Lagi**; tombol **Simulasikan Error API** sengaja meminta endpoint yang tidak ada agar penanganan error dapat didemonstrasikan. |
| W4.4 | Demo Data Flow & Checklist Sprint 03 | Lihat pertanyaan demo di bawah. |

## Struktur Folder

```
week4/
├── index.html            # Sama seperti Week 3 + kotak loading/error di katalog
├── detail.html           # Diisi dari satu object JSON (P1) lewat fetch
├── api/
│   └── games.json        # Simulasi REST API: dataset kanonis format JSON
├── assets/
│   ├── css/style.css     # Identik dengan Week 3 (tanpa perubahan)
│   ├── img/              # Sama persis dengan week sebelumnya
│   └── js/
│       ├── app.js        # Fetch + seluruh interaksi Week 3
│       └── detail.js     # Fetch + render detail satu produk
└── README.md
```

`assets/js/data.js` dari Week 3 **dihapus** — data tidak lagi menempel di
kode, melainkan diambil dari API. Inilah satu-satunya perubahan konseptual
week ini; semua markup, CSS, dan perilaku interaksi tetap sama.

## Cara Menjalankan

`fetch()` tidak bekerja dari `file://`, jadi jalankan lewat server lokal
dari folder `week4/`:

```bat
php -S localhost:8000
```

Lalu buka `http://localhost:8000`. (Alternatif: ekstensi Live Server di
VS Code.) Bila dibuka langsung sebagai file, halaman menampilkan kotak
error yang menjelaskan hal ini — itu memang perilaku error handling-nya.

## Poin Penjelasan untuk Dosen

1. **Alur data:** request → response JSON → `response.json()` → object
   JavaScript → render ke DOM. Arah sebaliknya tidak ada: halaman tidak
   pernah mengubah file JSON.
2. **Dua cara menangani Promise:** `.then()` berantai (di komentar) vs
   `async/await` (dipakai) — hasil akhirnya sama, keterbacaan berbeda.
3. **Tiga state antarmuka:** *loading* (indikator tampil), *success* (data
   dirender), *error* (pesan + jalan keluar berupa tombol coba lagi). State
   dikelola dengan atribut `hidden` dan `finally` memastikan indikator
   loading selalu berhenti.
4. **Render massal:** `products.map(buildCardHTML).join("")` membangun
   seluruh kartu sebagai string lalu sekali di-assign ke `innerHTML` —
   setara pola `forEach` + template literal di slide.

## Pertanyaan Demo (Sprint 03)

- *API apa yang digunakan?* — Endpoint REST lokal `api/games.json` yang
  mengembalikan object berisi array `products`.
- *Data apa yang diambil?* — Sepuluh produk akun game beserta penjual,
  harga, diskon, dan statusnya.
- *Bagaimana data diproses?* — Difilter (pencarian/kategori) di JavaScript,
  lalu dirender menjadi kartu HTML.
- *Apa yang terjadi ketika request gagal?* — Loading berhenti, kotak error
  tampil berisi penyebab dan tombol "Coba Lagi" (dapat ditunjukkan dengan
  tombol "Simulasikan Error API").

## Evolusi dari Week Sebelumnya (Week 3 → Week 4)

| Berkas | Perubahan |
|--------|-----------|
| `api/games.json` | **Baru.** Dataset kanonis yang sama, kini sebagai respons API (JSON). |
| `assets/js/data.js` | **Dihapus.** Data tidak lagi didefinisikan di JavaScript. |
| `assets/js/app.js` | Diubah: sumber data diganti `loadProducts()` (fetch + async/await + loading/error); seluruh fungsi render/keranjang/form dipertahankan apa adanya. |
| `assets/js/detail.js` | Ditulis ulang: detail produk kini diambil dengan fetch dan dirender dari satu object JSON; logika keranjang bersama tetap. |
| `index.html` | Diubah kecil: ditambah kotak loading `#loadingState`, kotak error `#errorState`, tombol "Simulasikan Error API", dan tag `data.js` dihapus. |
| `detail.html` | Diubah: bidang-bidang detail diberi `id` dan dikosongkan — isinya datang dari API; ditambah state loading/error untuk detail. |
| `assets/css/style.css`, `assets/img/*` | **Tidak berubah sama sekali** (spinner & kotak state sudah tersedia di sistem desain sejak Week 2). |
