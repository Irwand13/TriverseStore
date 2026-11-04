<?php
/* ============================================================
   Class Seller — Week 6 · Sprint 05 (PHP OOP)
   W6.1/W6.3: class sebagai blueprint, property private
   (encapsulation), constructor untuk nilai awal, dan getter
   sebagai akses aman dari luar class.
   ============================================================ */

class Seller
{
    private string $nama;
    private float $rating;
    private int $penjualan;
    private string $kota;

    public function __construct(string $nama, float $rating, int $penjualan, string $kota)
    {
        $this->nama = $nama;
        $this->rating = $rating;
        $this->penjualan = $penjualan;
        $this->kota = $kota;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function getPenjualan(): int
    {
        return $this->penjualan;
    }

    public function getKota(): string
    {
        return $this->kota;
    }

    /** Huruf pertama nama, untuk avatar lingkaran di halaman detail. */
    public function getInisial(): string
    {
        return strtoupper(substr($this->nama, 0, 1));
    }

    /** Ringkasan satu baris untuk kotak penjual, mis. "Rating 4.9 · 2.314 penjualan · Jakarta". */
    public function getRingkasan(): string
    {
        return 'Rating ' . $this->rating
            . ' · ' . number_format($this->penjualan, 0, ',', '.') . ' penjualan'
            . ' · ' . $this->kota;
    }
}
