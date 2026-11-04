<?php
/* ============================================================
   GameController — Week 7 · Sprint 06 (MVC)
   Controller adalah perantara: menerima request, meminta data
   ke Model, lalu meneruskan data ke View. Controller TIDAK
   menulis HTML dan TIDAK menyimpan data sendiri.
   Method mengikuti pola slide: index(), show(), process().
   ============================================================ */

require_once __DIR__ . '/../Models/Game.php';
require_once __DIR__ . '/../Models/Cart.php';
require_once __DIR__ . '/../Views/layout.php';
require_once __DIR__ . '/../Views/helpers.php';

class GameController
{
    /** Halaman katalog: ambil data terfilter dari Model, serahkan ke View. */
    public function index(): void
    {
        $kategoriAktif = $_GET['kategori'] ?? 'Semua';
        $kataKunci     = trim($_GET['q'] ?? '');

        $games = Game::filter($kategoriAktif, $kataKunci);

        renderLayout('Katalog Akun Game', __DIR__ . '/../Views/games/index.php', [
            'games'         => $games,
            'totalGames'    => count(Game::all()),
            'sellerCount'   => Game::sellerCount(),
            'kategoriAktif' => $kategoriAktif,
            'kataKunci'     => $kataKunci,
            'kategoriList'  => ['Semua', 'MOBA', 'RPG', 'FPS', 'Battle Royale', 'Aksi', 'Olahraga'],
        ]);
    }

    /** Halaman detail satu produk (?page=detail&id=P1). */
    public function show(): void
    {
        $id = $_GET['id'] ?? 'P1';
        $game = Game::find($id);

        if ($game === null) {
            $this->notFound('Produk dengan id "' . $id . '" tidak ditemukan di katalog.');
            return;
        }

        $related = Game::related($game);

        // Demo class Cart (diwarisi dari Week 6): Controller menyiapkan
        // objeknya, View hanya menampilkannya.
        $cart = new Cart();
        if (!$game->isTerjual()) {
            $cart->tambah($game);
        }
        if (count($related) > 0 && !$related[0]->isTerjual()) {
            $cart->tambah($related[0]);
        }

        renderLayout($game->getJudul(), __DIR__ . '/../Views/games/detail.php', [
            'game'    => $game,
            'related' => $related,
            'cart'    => $cart,
        ]);
    }

    /** Contoh method proses: menerima kiriman form pencarian lalu mengarahkan ke katalog terfilter. */
    public function process(): void
    {
        $params = [];
        if (!empty($_POST['kategori'])) {
            $params['kategori'] = $_POST['kategori'];
        }
        if (!empty($_POST['q'])) {
            $params['q'] = $_POST['q'];
        }
        $query = $params === [] ? '' : '?' . http_build_query($params);
        header('Location: index.php' . $query);
        exit;
    }

    /** Halaman 404 untuk produk/rute yang tidak dikenal. */
    public function notFound(string $pesan): void
    {
        http_response_code(404);
        renderLayout('Tidak Ditemukan', __DIR__ . '/../Views/errors/404.php', [
            'pesan' => $pesan,
        ]);
    }
}
