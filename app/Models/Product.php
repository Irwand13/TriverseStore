<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Satu Product = satu listing akun game di tabel products.
// Pengganti Model Game Week 7: datanya kini hidup di database
// dan diurus Eloquent (all, find, create, update, delete),
// bukan lagi array statis di dalam class.
class Product extends Model
{
    protected $fillable = [
        'user_id', 'kode', 'judul', 'game', 'kategori',
        'seller_nama', 'seller_rating', 'seller_penjualan', 'seller_kota',
        'harga', 'diskon', 'status', 'gambar',
        'deskripsi_singkat', 'deskripsi', 'platform', 'level', 'item_unggulan',
    ];

    // Akun yang membuat listing; null untuk sepuluh produk seeder.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'seller_rating' => 'float',
        'seller_penjualan' => 'integer',
        'harga' => 'integer',
        'diskon' => 'integer',
    ];

    // Harga akhir yang dibayar pembeli; kolom harga di dataset
    // sudah merupakan harga final setelah diskon.
    public function getHargaAkhir(): int
    {
        return $this->harga;
    }

    // Harga sebelum diskon; null bila produk tidak diskon.
    public function getHargaCoret(): ?int
    {
        if ($this->diskon <= 0) {
            return null;
        }

        return (int) round($this->harga / (1 - $this->diskon / 100));
    }

    // Kelas badge CSS mengikuti status.
    public function getBadgeClass(): string
    {
        return match ($this->status) {
            'Tersedia' => 'badge-available',
            'Stok Terbatas' => 'badge-limited',
            default => 'badge-sold',
        };
    }

    public function isTerjual(): bool
    {
        return $this->status === 'Terjual';
    }

    // Huruf pertama nama penjual, untuk avatar lingkaran di detail.
    public function getSellerInisial(): string
    {
        return strtoupper(substr($this->seller_nama, 0, 1));
    }

    // Ringkasan penjual satu baris, mis. "Rating 4.9 · 2.314 penjualan · Jakarta".
    public function getSellerRingkasan(): string
    {
        return 'Rating ' . $this->seller_rating . ' · ' . number_format($this->seller_penjualan, 0, ',', '.') . ' penjualan · ' . $this->seller_kota;
    }

    public function getRingkasan(): string
    {
        return $this->judul . ' — ' . $this->game . ' (' . $this->status . ')';
    }
}
