<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Controller tetap menjadi perantara seperti di Week 7: menerima
// request, meminta data ke Model, lalu meneruskan ke View.
// Bedanya, Model kini membaca dari database lewat Eloquent.
//
// Sprint 08: controller yang sama juga melayani REST API
// (routes/api.php). Bila request datang lewat /api, responsnya
// JSON; bila lewat web, responsnya tetap View/redirect seperti
// sebelumnya. Satu controller, dua macam respons — sesuai pola
// PPT yang memakai satu ProgramController untuk web dan API.
class ProductController extends Controller
{
    // Katalog: ambil produk terfilter dari Model, serahkan ke View.
    // Lewat API: kembalikan daftar yang sama sebagai JSON.
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

        if ($this->isApi($request)) {
            return response()->json(['data' => $products], 200);
        }

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
    // Lewat API: kembalikan produknya sebagai JSON.
    public function show(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($this->isApi($request)) {
            return response()->json(['data' => $product], 200);
        }

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
        ]);
    }

    // Simpan produk baru dari form. Penjual diisi dari akun
    // yang login; kolom yang tidak ada di form diisi default
    // supaya listing langsung tampil di katalog. Gambar wajib
    // di-upload user — tidak ada lagi gambar default.
    //
    // Lewat API (JSON, tanpa login): gambar boleh kosong dan
    // penjual diisi 'TriverseStore' dengan user_id null, supaya
    // demo Postman seperti di PPT bisa jalan tanpa auth.
    public function store(Request $request)
    {
        $isApi = $this->isApi($request);
        $data = $request->validate($this->rules(! $isApi), $this->messages());

        $user = $request->user();

        $product = Product::create([
            'user_id' => $user?->id,
            'kode' => 'P' . (Product::max('id') + 1),
            'judul' => $data['judul'],
            'game' => $data['game'],
            'kategori' => $data['kategori'],
            'seller_nama' => $user?->name ?? 'TriverseStore',
            'seller_rating' => 5.0,
            'seller_penjualan' => 0,
            'seller_kota' => 'Indonesia',
            'harga' => $data['harga'],
            'diskon' => 0,
            'status' => 'Tersedia',
            // Kolom gambar NOT NULL di skema week9, jadi produk API
            // tanpa gambar disimpan sebagai string kosong — artinya
            // "tanpa gambar". getGambarUrl() dan Blade sudah
            // menanganinya (tidak ada <img> yang dirender).
            'gambar' => $request->hasFile('gambar') ? $this->simpanGambar($request) : '',
            'deskripsi_singkat' => $data['deskripsi_singkat'],
            'deskripsi' => $data['deskripsi_singkat'],
            'platform' => 'Semua Platform',
            'level' => 'Tidak dicantumkan',
            'item_unggulan' => 'Tidak dicantumkan',
        ]);

        if ($isApi) {
            return response()->json([
                'message' => 'Berhasil',
                'data' => $product,
            ], 201);
        }

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
        ]);
    }

    // Simpan perubahan dari form ubah. Hanya kolom form yang
    // berubah; penjual dan data lain tetap seperti semula.
    // Gambar lama tetap dipakai bila tidak ada upload baru.
    //
    // Lewat API: cek pemilik dilewati karena demo API tanpa
    // login (lihat catatan di pastikanPemilik).
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $isApi = $this->isApi($request);

        if (! $isApi) {
            $this->pastikanPemilik($product);
        }

        $data = $request->validate($this->rules(false), $this->messages());

        $perubahan = [
            'judul' => $data['judul'],
            'game' => $data['game'],
            'kategori' => $data['kategori'],
            'harga' => $data['harga'],
            'deskripsi_singkat' => $data['deskripsi_singkat'],
            'deskripsi' => $data['deskripsi_singkat'],
        ];

        if ($request->hasFile('gambar')) {
            $this->hapusGambarUpload($product->gambar);
            $perubahan['gambar'] = $this->simpanGambar($request);
        }

        $product->update($perubahan);

        if ($isApi) {
            return response()->json([
                'message' => 'Berhasil',
                'data' => $product,
            ], 200);
        }

        return redirect()->route('products.show', $product->id)
            ->with('sukses', 'Produk "' . $product->judul . '" berhasil diubah.');
    }

    // Hapus produk dari database. Listing milik user lain
    // tidak bisa dihapus.
    //
    // Lewat API: kembalikan JSON {"message": "Produk berhasil
    // dihapus."} seperti demo PPT; cek pemilik dilewati
    // karena demo API tanpa login.
    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $isApi = $this->isApi($request);

        if (! $isApi) {
            $this->pastikanPemilik($product);
        }

        $this->hapusGambarUpload($product->gambar);

        $judul = $product->judul;
        $product->delete();

        if ($isApi) {
            return response()->json(['message' => 'Produk berhasil dihapus.'], 200);
        }

        return redirect()->route('products.index')
            ->with('sukses', 'Produk "' . $judul . '" berhasil dihapus.');
    }

    // Request API adalah request ke rute /api/* atau yang
    // minta JSON lewat header Accept.
    private function isApi(Request $request): bool
    {
        return $request->is('api/*') || $request->expectsJson();
    }

    // Listing seeder tidak punya pemilik, jadi boleh diurus
    // user login mana pun; listing ber-pemilik hanya oleh pemiliknya.
    //
    // Catatan Sprint 08: cek ini hanya berlaku untuk web. API
    // demo di PPT tidak memakai login sama sekali, jadi tanpa
    // user yang bisa dicocokkan, update/hapus lewat API
    // diizinkan untuk semua produk. Di aplikasi sungguhan,
    // API seperti ini wajib dilindungi token (mis. Sanctum).
    private function pastikanPemilik(Product $product): void
    {
        if ($product->user_id !== null && $product->user_id !== auth()->id()) {
            abort(403);
        }
    }

    // Aturan validasi form tambah/ubah yang sudah dipendekkan:
    // hanya kolom esensial. Kode dan penjual tidak lagi diisi
    // lewat form, melainkan oleh Controller saat menyimpan.
    // Gambar wajib saat tambah, opsional saat ubah (pakai lama).
    //
    // Sprint 08: judul mengikuti aturan PPT — maksimal 100
    // karakter (sebelumnya 255). Gambar opsional bila request
    // datang lewat API JSON yang tidak membawa file.
    private function rules(bool $gambarWajib): array
    {
        return [
            'judul' => 'required|string|max:100',
            'game' => 'required|string|max:255',
            'kategori' => 'required|in:MOBA,RPG,FPS,Battle Royale,Aksi,Olahraga',
            'harga' => 'required|integer|min:1000',
            'deskripsi_singkat' => 'required|string|max:500',
            'gambar' => ($gambarWajib ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    // Pesan error validasi Bahasa Indonesia, mengikuti contoh
    // PPT ("Nama wajib diisi.", "Nama maksimal 100 karakter.").
    // Pesan ini yang tampil di form web dan di respons 422 API.
    private function messages(): array
    {
        return [
            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 100 karakter.',
            'game.required' => 'Game wajib diisi.',
            'game.string' => 'Game harus berupa teks.',
            'game.max' => 'Game maksimal 255 karakter.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.in' => 'Kategori tidak valid.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga minimal Rp 1.000.',
            'deskripsi_singkat.required' => 'Deskripsi wajib diisi.',
            'deskripsi_singkat.string' => 'Deskripsi harus berupa teks.',
            'deskripsi_singkat.max' => 'Deskripsi maksimal 500 karakter.',
            'gambar.required' => 'Gambar wajib diunggah.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WebP.',
            'gambar.max' => 'Gambar maksimal 2 MB.',
        ];
    }

    // Simpan upload ke public/uploads/products supaya langsung
    // bisa dibuka lewat URL tanpa storage:link. Nama file unik
    // dari waktu + slug judul; yang disimpan di database hanya
    // path relatifnya.
    private function simpanGambar(Request $request): string
    {
        $file = $request->file('gambar');
        $nama = time() . '-' . Str::slug($request->input('judul')) . '.' . $file->getClientOriginalExtension();
        $tujuan = public_path('uploads/products');

        if (! is_dir($tujuan)) {
            mkdir($tujuan, 0755, true);
        }

        $file->move($tujuan, $nama);

        return 'uploads/products/' . $nama;
    }

    // Hapus file upload lama saat diganti atau saat produk dihapus.
    // Key art kanonis seeder (assets/img) bukan milik user, jadi
    // tidak pernah dihapus dari sini.
    private function hapusGambarUpload(?string $gambar): void
    {
        if ($gambar === null || ! str_starts_with($gambar, 'uploads/products/')) {
            return;
        }

        $path = public_path($gambar);

        if (is_file($path)) {
            unlink($path);
        }
    }

    private function kategoriList(): array
    {
        return ['Semua', 'MOBA', 'RPG', 'FPS', 'Battle Royale', 'Aksi', 'Olahraga'];
    }
}
