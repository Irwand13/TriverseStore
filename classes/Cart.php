<?php
/* ============================================================
   Class Cart — Week 6 · Sprint 05 (PHP OOP)
   Keranjang belanja sebagai objek: menyimpan daftar Game dan
   menghitung totalnya sendiri. Di Week 3–4 perilaku ini ditulis
   prosedural di JavaScript; di sini dibungkus sebagai class.
   ============================================================ */

require_once __DIR__ . '/Game.php';

class Cart
{
    /** @var Game[] */
    private array $items = [];

    /** Menambahkan satu Game; produk yang sama tidak digandakan. */
    public function tambah(Game $game): void
    {
        foreach ($this->items as $item) {
            if ($item->getId() === $game->getId()) {
                return;
            }
        }
        $this->items[] = $game;
    }

    /** Menghapus produk berdasarkan id. */
    public function hapus(string $id): void
    {
        $this->items = array_values(array_filter(
            $this->items,
            fn (Game $item) => $item->getId() !== $id
        ));
    }

    /** @return Game[] */
    public function getItems(): array
    {
        return $this->items;
    }

    public function jumlah(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return $this->items === [];
    }

    /** Total harga akhir seluruh isi keranjang. */
    public function totalHarga(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getHargaAkhir();
        }
        return $total;
    }
}
