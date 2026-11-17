<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

// Controller tetap menjadi perantara seperti di Week 7: menerima
// request, meminta data ke Model, lalu meneruskan ke View.
// Bedanya, Model kini membaca dari database lewat Eloquent.
class ProductController extends Controller
{
    // Katalog: ambil produk terfilter dari Model, serahkan ke View.
    public function index(Request $request)
    {
        $kategoriAktif = $request->query('kategori', 'Semua');
        $kataKunci = trim($request->query('q', ''));

        $products = Product::query()
            ->when($kategoriAktif !== 'Semua', fn ($query) => $query->where('kategori', $kategoriAktif))
            ->when($kataKunci !== '', fn ($query) => $query->where(function ($query) use ($kataKunci) {
                $query->where('judul', 'like', '%' . $kataKunci . '%')
                    ->orWhere('game', 'like', '%' . $kataKunci . '%')
                    ->orWhere('kategori', 'like', '%' . $kataKunci . '%');
            }))
            ->orderBy('id')
            ->get();

        return view('products.index', [
            'products' => $products,
            'totalProducts' => Product::count(),
            'sellerCount' => Product::distinct('seller_nama')->count('seller_nama'),
            'kategoriAktif' => $kategoriAktif,
            'kataKunci' => $kataKunci,
            'kategoriList' => $this->kategoriList(),
        ]);
    }

    // Market: katalog lengkap dengan cari, filter kategori,
    // dan urutkan harga. Home tetap menampilkan semua produk
    // sebagai landing; market yang jadi halaman belanjanya.
    public function market(Request $request)
    {
        $kategoriAktif = $request->query('kategori', 'Semua');
        $kataKunci = trim($request->query('q', ''));
        $urut = $request->query('urut', 'terbaru');

        $products = Product::query()
            ->when($kategoriAktif !== 'Semua', fn ($query) => $query->where('kategori', $kategoriAktif))
            ->when($kataKunci !== '', fn ($query) => $query->where(function ($query) use ($kataKunci) {
                $query->where('judul', 'like', '%' . $kataKunci . '%')
                    ->orWhere('game', 'like', '%' . $kataKunci . '%')
                    ->orWhere('kategori', 'like', '%' . $kataKunci . '%');
            }))
            ->when($urut === 'termurah', fn ($query) => $query->orderBy('harga'))
            ->when($urut === 'termahal', fn ($query) => $query->orderByDesc('harga'))
            ->when($urut === 'terbaru', fn ($query) => $query->orderByDesc('id'))
            ->when($urut === 'terlama', fn ($query) => $query->orderBy('id'))
            ->get();

        return view('market', [
            'products' => $products,
            'kategoriAktif' => $kategoriAktif,
            'kataKunci' => $kataKunci,
            'urut' => $urut,
            'kategoriList' => $this->kategoriList(),
        ]);
    }

    // Detail satu produk; 404 bila id tidak ada di database.
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $related = Product::where('kategori', $product->kategori)
            ->where('id', '!=', $product->id)
            ->orderBy('id')
            ->take(3)
            ->get();

        return view('products.show', [
            'product' => $product,
            'related' => $related,
        ]);
    }

    // Form tambah produk.
    public function create()
    {
        return view('products.create', [
            'kategoriList' => $this->kategoriList(),
            'gambarList' => $this->gambarList(),
        ]);
    }

    // Simpan produk baru dari form. Penjual diisi dari akun
    // yang login; kolom yang tidak ada di form diisi default
    // supaya listing langsung tampil di katalog.
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $product = Product::create([
            'user_id' => $request->user()->id,
            'kode' => 'P' . (Product::max('id') + 1),
            'judul' => $data['judul'],
            'game' => $data['game'],
            'kategori' => $data['kategori'],
            'seller_nama' => $request->user()->name,
            'seller_rating' => 5.0,
            'seller_penjualan' => 0,
            'seller_kota' => 'Indonesia',
            'harga' => $data['harga'],
            'diskon' => 0,
            'status' => 'Tersedia',
            'gambar' => $data['gambar'] ?? $this->gambarUntukGame($data['game']),
            'deskripsi_singkat' => $data['deskripsi_singkat'],
            'deskripsi' => $data['deskripsi_singkat'],
            'platform' => 'Semua Platform',
            'level' => 'Tidak dicantumkan',
            'item_unggulan' => 'Tidak dicantumkan',
        ]);

        return redirect()->route('products.show', $product->id)
            ->with('sukses', 'Produk "' . $product->judul . '" berhasil ditambahkan.');
    }

    // Form ubah produk. Listing milik user lain tidak bisa diubah.
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->pastikanPemilik($product);

        return view('products.edit', [
            'product' => $product,
            'kategoriList' => $this->kategoriList(),
            'gambarList' => $this->gambarList(),
        ]);
    }

    // Simpan perubahan dari form ubah. Hanya kolom form yang
    // berubah; penjual dan data lain tetap seperti semula.
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->pastikanPemilik($product);

        $data = $request->validate($this->rules());

        $product->update([
            'judul' => $data['judul'],
            'game' => $data['game'],
            'kategori' => $data['kategori'],
            'harga' => $data['harga'],
            'deskripsi_singkat' => $data['deskripsi_singkat'],
            'gambar' => $data['gambar'] ?? $product->gambar,
        ]);

        return redirect()->route('products.show', $product->id)
            ->with('sukses', 'Produk "' . $product->judul . '" berhasil diubah.');
    }

    // Hapus produk dari database. Listing milik user lain
    // tidak bisa dihapus.
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->pastikanPemilik($product);

        $judul = $product->judul;
        $product->delete();

        return redirect()->route('products.index')
            ->with('sukses', 'Produk "' . $judul . '" berhasil dihapus.');
    }

    // Listing seeder tidak punya pemilik, jadi boleh diurus
    // user login mana pun; listing ber-pemilik hanya oleh pemiliknya.
    private function pastikanPemilik(Product $product): void
    {
        if ($product->user_id !== null && $product->user_id !== auth()->id()) {
            abort(403);
        }
    }

    // Aturan validasi form tambah/ubah yang sudah dipendekkan:
    // hanya kolom esensial. Kode dan penjual tidak lagi diisi
    // lewat form, melainkan oleh Controller saat menyimpan.
    private function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'game' => 'required|string|max:255',
            'kategori' => 'required|in:MOBA,RPG,FPS,Battle Royale,Aksi,Olahraga',
            'harga' => 'required|integer|min:1000',
            'deskripsi_singkat' => 'required|string|max:500',
            'gambar' => 'nullable|string|max:255',
        ];
    }

    // Gambar default mengikuti nama game bila cocok dengan
    // salah satu key art kanonis; kalau tidak, pakai yang pertama.
    private function gambarUntukGame(string $game): string
    {
        foreach ($this->gambarList() as $file => $namaGame) {
            if (strtolower($namaGame) === strtolower($game)) {
                return $file;
            }
        }

        return 'mobile-legends.jpg';
    }

    private function kategoriList(): array
    {
        return ['Semua', 'MOBA', 'RPG', 'FPS', 'Battle Royale', 'Aksi', 'Olahraga'];
    }

    // Sepuluh key art kanonis; form hanya boleh memilih salah satunya
    // supaya gambar produk tidak pernah salah label.
    private function gambarList(): array
    {
        return [
            'mobile-legends.jpg' => 'Mobile Legends: Bang Bang',
            'genshin-impact.jpg' => 'Genshin Impact',
            'valorant.jpg' => 'Valorant',
            'apex-legends.jpg' => 'Apex Legends',
            'free-fire.jpg' => 'Free Fire',
            'gta-v.jpg' => 'Grand Theft Auto V',
            'efootball.jpg' => 'eFootball',
            'honkai-star-rail.jpg' => 'Honkai: Star Rail',
            'zenless-zone-zero.jpg' => 'Zenless Zone Zero',
            'elden-ring.jpg' => 'Elden Ring',
        ];
    }
}
