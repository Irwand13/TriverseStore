<?php
/* ============================================================
   Model Game — Week 7 · Sprint 06 (MVC)
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

    /* ==========================================================
       Akses data — tugas MODEL dalam MVC (Week 7 · Sprint 06)
       Model mengelola data aplikasi: menyimpan dataset kanonis
       dan menyediakan cara mengambilnya (all, find, related).
       Di proyek nyata sumber ini adalah database; di sini data
       statis proyek (lihat ../DATASET.md) dibungkus objek.
       ========================================================== */

    /** @return Seller[] Lima penjual kanonis, dikunci oleh id S1–S5. */
    private static function sellers(): array
    {
        return [
            'S1' => new Seller('RakaStore_ID', 4.9, 2314, 'Jakarta'),
            'S2' => new Seller('NadiaGameShop', 4.8, 1872, 'Bandung'),
            'S3' => new Seller('VortexID', 4.9, 986, 'Surabaya'),
            'S4' => new Seller('SultanPlay', 4.7, 754, 'Medan'),
            'S5' => new Seller('BloxMart ID', 4.8, 3102, 'Yogyakarta'),
        ];
    }

    /** @return Game[] Seluruh listing pada katalog. */
    public static function all(): array
    {
        $s = self::sellers();

        return [
            new Game('P1', 'Akun Mobile Legends Mythical Glory — 87 Skin', 'Mobile Legends: Bang Bang', 'MOBA', 'mobile-legends.jpg', 850000, 15, 'Tersedia',
                '87 skin termasuk Epic dan Collector, semua emblem maksimal, win rate 68%.',
                'Akun pribadi tangan pertama, win rate 68% dari 4.300 pertandingan. Semua emblem sudah maksimal dan 87 skin termasuk seri Epic dan Collector.',
                'Android / iOS', 'Mythical Glory, 1.240 poin', 'Skin Epic Layla "Miss Hikari", emblem maks', $s['S1']),
            new Game('P2', 'Akun Genshin Impact AR 58 — 12 Karakter Bintang 5', 'Genshin Impact', 'RPG', 'genshin-impact.jpg', 1450000, 0, 'Tersedia',
                '12 karakter bintang 5 dengan artefak rapi, siap Spiral Abyss lantai 12.',
                'Eksplorasi map 90%+, artefak rapi siap Spiral Abyss lantai 12. Primogem sisa 4.800 dan resin selalu terpakai wajar.',
                'PC / Android / iOS', 'Adventure Rank 58', 'Raiden Shogun C2, Nahida, 12 karakter bintang 5', $s['S2']),
            new Game('P3', 'Akun Valorant Immortal — Bundle Glitchpop', 'Valorant', 'FPS', 'valorant.jpg', 2700000, 10, 'Tersedia',
                'Akun Episode 1 dengan bundle Glitchpop dan 54 skin, MMR tinggi.',
                'Akun dari season pertama (Episode 1) dengan badge langka. MMR tinggi, riwayat bersih tanpa sanksi, siap push Radiant.',
                'PC', 'Immortal 3, 412 RR', 'Bundle Glitchpop, Vandal Prime, 54 skin', $s['S3']),
            new Game('P4', 'Akun Apex Legends Predator — Heirloom Wraith', 'Apex Legends', 'Battle Royale', 'apex-legends.jpg', 1150000, 0, 'Stok Terbatas',
                'Heirloom Wraith dan 42 skin legendaris, badge 20-bomb di tiga legend.',
                'Akun Predator dengan heirloom Wraith dan 42 skin legendaris. Badge 20-bomb dan 4K damage di tiga legend berbeda.',
                'PC / PS / Xbox', 'Apex Predator, 21.400 kill', 'Heirloom Kunai Wraith, 42 skin legendaris', $s['S4']),
            new Game('P5', 'Akun Free Fire Grandmaster — Vault 400+ Item', 'Free Fire', 'Battle Royale', 'free-fire.jpg', 675000, 25, 'Tersedia',
                'Vault 400+ item hasil top up resmi, 4 evo gun dan emote langka.',
                'Koleksi vault besar hasil top up resmi sejak 2021. Evo gun 4 biji dan emote langka lengkap.',
                'Android / iOS', 'Grandmaster', 'Vault 400+ item, bundle Cobra', $s['S1']),
            new Game('P6', 'Akun GTA V Online Rank 218 — Aset Lengkap', 'Grand Theft Auto V', 'Aksi', 'gta-v.jpg', 425000, 0, 'Tersedia',
                'Semua bisnis aktif dan garasi 40+ mobil modif, uang sisa $GTA 18 juta.',
                'Akun GTA Online mapan: semua bisnis aktif, garasi berisi 40+ mobil hasil modifikasi, uang sisa $GTA 18 juta.',
                'PC (Steam)', 'Rank 218', 'Bunker, Nightclub, 40+ mobil modif', $s['S5']),
            new Game('P7', 'Akun eFootball Dream Team 3150 — Full Epic', 'eFootball', 'Olahraga', 'efootball.jpg', 560000, 20, 'Tersedia',
                'Skuad Dream Team kekuatan 3150 berisi kartu Epic dan Big Time.',
                'Skuad Dream Team kekuatan 3150 dengan pemain Epic dan Big Time. Koin sisa 1.200 untuk gacha berikutnya.',
                'Android / iOS / PS', 'Kekuatan tim 3150', 'Kartu Epic Messi, Neymar, Rummenigge', $s['S2']),
            new Game('P8', 'Akun Honkai: Star Rail TL 70 — 9 Karakter Bintang 5', 'Honkai: Star Rail', 'RPG', 'honkai-star-rail.jpg', 980000, 0, 'Terjual',
                'Akun endgame, semua konten selesai termasuk Apocalyptic Shadow.',
                'Akun endgame, semua konten selesai termasuk Apocalyptic Shadow. Status: sudah terjual.',
                'PC / Android / iOS', 'Trailblaze Level 70', 'Acheron E2, Firefly, 9 karakter bintang 5', $s['S3']),
            new Game('P9', 'Akun Zenless Zone Zero Inter-Knot 55 — Miyabi & Yanagi', 'Zenless Zone Zero', 'RPG', 'zenless-zone-zero.jpg', 1275000, 15, 'Stok Terbatas',
                'Trio agen S-Rank meta sekarang: Miyabi, Yanagi, dan Astra Yao.',
                'Trio agen S-Rank meta sekarang. Hollow Zero dan Shiyu Defense tembus penuh tiap reset.',
                'PC / Android / iOS', 'Inter-Knot Level 55', 'Miyabi, Yanagi, Astra Yao', $s['S4']),
            new Game('P10', 'Akun Elden Ring Level 312 — Semua Remembrance', 'Elden Ring', 'RPG', 'elden-ring.jpg', 890000, 0, 'Tersedia',
                'Semua Remembrance terkumpul dan 9 senjata legendaris level maksimal.',
                'Build lengkap siap DLC: semua Remembrance terkumpul, 9 senjata legendaris +10, dan material upgrade melimpah.',
                'PC / PS', 'Level 312, NG+3', 'Semua senjata legendaris, set Malenia', $s['S5']),
        ];
    }

    /** Jumlah penjual kanonis (untuk statistik hero). */
    public static function sellerCount(): int
    {
        return count(self::sellers());
    }

    /** Satu Game berdasarkan id; null bila tidak ditemukan. */
    public static function find(string $id): ?Game
    {
        foreach (self::all() as $game) {
            if ($game->getId() === $id) {
                return $game;
            }
        }
        return null;
    }

    /**
     * Menyaring katalog berdasarkan kategori & kata kunci —
     * logika filter yang di Week 5–6 ditulis di halaman kini
     * menjadi tanggung jawab Model.
     *
     * @return Game[]
     */
    public static function filter(string $kategori, string $kataKunci): array
    {
        $hasil = [];
        foreach (self::all() as $game) {
            $cocokKategori = ($kategori === 'Semua' || $game->getKategori() === $kategori);
            $cocokKata = ($kataKunci === '' ||
                stripos($game->getJudul() . ' ' . $game->getGame() . ' ' . $game->getKategori(), $kataKunci) !== false);
            if ($cocokKategori && $cocokKata) {
                $hasil[] = $game;
            }
        }
        return $hasil;
    }

    /** @return Game[] Game lain dari kategori yang sama. */
    public static function related(Game $game, int $limit = 3): array
    {
        $hasil = [];
        foreach (self::all() as $kandidat) {
            if ($kandidat->getKategori() === $game->getKategori() && $kandidat->getId() !== $game->getId()) {
                $hasil[] = $kandidat;
            }
            if (count($hasil) >= $limit) {
                break;
            }
        }
        return $hasil;
    }
}
