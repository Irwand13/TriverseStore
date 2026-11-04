<?php
/* View: 404 — Week 7 (MVC). Menerima $pesan dari Controller. */
?>
    <main class="container">
        <div class="notfound">
            <h1>404</h1>
            <p><?= htmlspecialchars($pesan) ?></p>
            <a class="btn btn-primary" href="index.php">Kembali ke Katalog</a>
        </div>
    </main>
