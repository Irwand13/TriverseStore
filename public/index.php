<?php
/* ============================================================
   Front Controller — Week 7 · Sprint 06 (MVC)
   Satu-satunya pintu masuk aplikasi. Semua request tiba di
   sini, dibaca parameter ?page=, lalu diserahkan ke method
   Controller yang sesuai:
     (tanpa ?page=)        -> GameController::index()
     ?page=detail&id=P1    -> GameController::show()
     ?page=cari (POST)     -> GameController::process()
     ?page=selain itu      -> halaman 404
   Jalankan dari folder week7:  php -S localhost:8000 -t public
   ============================================================ */

require_once __DIR__ . '/../app/Controllers/GameController.php';

$controller = new GameController();
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        $controller->index();
        break;
    case 'detail':
        $controller->show();
        break;
    case 'cari':
        $controller->process();
        break;
    default:
        $controller->notFound('Halaman "' . $page . '" tidak dikenal.');
        break;
}
