<?php
/* ============================================================
   Class Game — Week 6 · Sprint 05 (PHP OOP)
   Satu objek Game = satu listing akun game. Data (property)
   dan perilaku (method) kini menyatu di dalam class — inilah
   perbedaan OOP dari Week 5 yang prosedural.
   Relasi: setiap Game MEMEGANG satu objek Seller.
   ============================================================ */

require_once __DIR__ . '/Seller.php';

class Game
{
    private string $id;
    private string $judul;
    private string $game;
    private string $kategori;
    private string $gambar;
    private int $harga;
    private int $diskon;
    private string $status;
    private string $deskripsiSingkat;
    private string $deskripsi;
    private string $platform;
    private string $level;
    private string $itemUnggulan;
    private Seller $seller;

    public function __construct(
        string $id,
        string $judul,
        string $game,
        string $kategori,
        string $gambar,
        int $harga,
        int $diskon,
        string $status,
        string $deskripsiSingkat,
        string $deskripsi,
        string $platform,
        string $level,
        string $itemUnggulan,
        Seller $seller
    ) {
        $this->id = $id;
        $this->judul = $judul;
        $this->game = $game;
        $this->kategori = $kategori;
        $this->gambar = $gambar;
        $this->harga = $harga;
        $this->diskon = $diskon;
        $this->status = $status;
        $this->deskripsiSingkat = $deskripsiSingkat;
        $this->deskripsi = $deskripsi;
        $this->platform = $platform;
        $this->level = $level;
        $this->itemUnggulan = $itemUnggulan;
        $this->seller = $seller;
    }

    /* ---------- Getter (akses aman ke property private) ---------- */

    public function getId(): string { return $this->id; }
    public function getJudul(): string { return $this->judul; }
    public function getGame(): string { return $this->game; }
    public function getKategori(): string { return $this->kategori; }
    public function getGambar(): string { return $this->gambar; }
    public function getHarga(): int { return $this->harga; }
    public function getDiskon(): int { return $this->diskon; }
    public function getStatus(): string { return $this->status; }
    public function getDeskripsiSingkat(): string { return $this->deskripsiSingkat; }
    public function getDeskripsi(): string { return $this->deskripsi; }
    public function getPlatform(): string { return $this->platform; }
    public function getLevel(): string { return $this->level; }
    public function getItemUnggulan(): string { return $this->itemUnggulan; }
    public function getSeller(): Seller { return $this->seller; }

    /* ---------- Method perilaku ---------- */

    /**
     * Harga akhir yang dibayar pembeli. Di dataset proyek, kolom
     * harga sudah merupakan harga final setelah diskon.
     */
    public function getHargaAkhir(): int
    {
        return $this->harga;
    }

    /** Harga sebelum diskon; null bila produk tidak diskon. */
    public function getHargaCoret(): ?int
    {
        if ($this->diskon <= 0) {
            return null;
        }
        return (int) round($this->harga / (1 - $this->diskon / 100));
    }

    /** Kelas badge CSS mengikuti status — logika pindah dari function lepas (Week 5) menjadi method. */
    public function getBadgeClass(): string
    {
        return match ($this->status) {
            'Tersedia'      => 'badge-available',
            'Stok Terbatas' => 'badge-limited',
            default         => 'badge-sold',
        };
    }

    public function isTerjual(): bool
    {
        return $this->status === 'Terjual';
    }

    /** Ringkasan produk satu baris, dipakai panel demo keranjang. */
    public function getRingkasan(): string
    {
        return $this->judul . ' — ' . $this->game . ' (' . $this->status . ')';
    }
}
