<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    // Simpan produk baru dari form.
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $product = Product::create($data);

        return redirect()->route('products.show', $product->id)
            ->with('sukses', 'Produk "' . $product->judul . '" berhasil ditambahkan.');
    }

    // Form ubah produk.
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', [
            'product' => $product,
            'kategoriList' => $this->kategoriList(),
            'gambarList' => $this->gambarList(),
        ]);
    }

    // Simpan perubahan dari form ubah.
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate($this->rules($product->id));

        $product->update($data);

        return redirect()->route('products.show', $product->id)
            ->with('sukses', 'Produk "' . $product->judul . '" berhasil diubah.');
    }

    // Hapus produk dari database.
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $judul = $product->judul;
        $product->delete();

        return redirect()->route('products.index')
            ->with('sukses', 'Produk "' . $judul . '" berhasil dihapus.');
    }

    // Aturan validasi form tambah/ubah. Saat ubah, kode boleh
    // tetap sama dengan kode produk itu sendiri.
    private function rules($kecualiId = null): array
    {
        $kode = Rule::unique('products', 'kode');
        if ($kecualiId !== null) {
            $kode = $kode->ignore($kecualiId);
        }

        return [
            'kode' => ['required', 'string', 'max:10', $kode],
            'judul' => 'required|string|max:255',
            'game' => 'required|string|max:255',
            'kategori' => 'required|in:MOBA,RPG,FPS,Battle Royale,Aksi,Olahraga',
            'seller_nama' => 'required|string|max:255',
            'seller_rating' => 'required|numeric|min:0|max:5',
            'seller_penjualan' => 'required|integer|min:0',
            'seller_kota' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'diskon' => 'required|integer|min:0|max:100',
            'status' => 'required|in:Tersedia,Stok Terbatas,Terjual',
            'gambar' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'deskripsi' => 'required|string',
            'platform' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'item_unggulan' => 'required|string',
        ];
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
