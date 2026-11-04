/* ============================================================
   TriverseStore — Halaman Detail Berbasis API (Week 4 · Sprint 03)
   Contoh W4.2 untuk SATU object: data produk P1 diambil dari
   api/games.json dengan fetch(), lalu properti object JSON
   (data.judul, data.harga, ...) dirender ke elemen detail.
   Keranjang tetap dibagikan lewat localStorage seperti Week 3.
   ============================================================ */

const DETAIL_API_URL = "api/games.json";
const FEATURED_ID = "P1";

function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString("id-ID");
}

function badgeClass(status) {
    if (status === "Tersedia") return "badge-available";
    if (status === "Stok Terbatas") return "badge-limited";
    return "badge-sold";
}

function readCart() {
    try {
        return JSON.parse(localStorage.getItem("ts_cart")) || [];
    } catch (error) {
        return [];
    }
}

// Mengisi seluruh elemen detail dari satu object produk
function renderDetail(product) {
    document.querySelector("#detailImage").src = "assets/img/" + product.gambar;
    document.querySelector("#detailImage").alt = "Key art " + product.game;
    document.querySelector("#detailCategory").textContent = product.kategori + " · " + product.game;
    document.querySelector("#detailTitle").textContent = product.judul;
    document.querySelector("#detailRating").textContent = product.rating;
    document.querySelector("#detailSales").textContent = product.penjualan.toLocaleString("id-ID") + " penjualan penjual";

    const badge = document.querySelector("#detailBadge");
    badge.textContent = product.status;
    badge.className = "badge " + badgeClass(product.status);

    document.querySelector("#detailDesc").textContent = product.deskripsi;
    document.querySelector("#specGame").textContent = product.game;
    document.querySelector("#specPlatform").textContent = product.platform;
    document.querySelector("#specLevel").textContent = product.level;
    document.querySelector("#specItem").textContent = product.itemUnggulan;
    document.querySelector("#specKota").textContent = product.kota;

    document.querySelector("#detailPriceOld").textContent =
        product.hargaCoret ? formatRupiah(product.hargaCoret) : "";
    document.querySelector("#detailPrice").textContent = formatRupiah(product.harga);
    document.querySelector("#sellerAvatar").textContent = product.seller.charAt(0);
    document.querySelector("#sellerName").textContent = product.seller;
    document.querySelector("#sellerMeta").textContent =
        `Rating ${product.rating} · ${product.penjualan.toLocaleString("id-ID")} penjualan · ${product.kota}`;
}

async function loadDetail() {
    const loading = document.querySelector("#detailLoading");
    const errorBox = document.querySelector("#detailError");
    const grid = document.querySelector("#detailGrid");

    loading.hidden = false;
    errorBox.hidden = true;
    grid.hidden = true;

    try {
        const response = await fetch(DETAIL_API_URL);
        if (!response.ok) {
            throw new Error("Gagal mengambil data (HTTP " + response.status + ")");
        }
        const data = await response.json();
        const product = data.products.find((p) => p.id === FEATURED_ID);
        renderDetail(product);
        grid.hidden = false;
    } catch (error) {
        document.querySelector("#detailErrorMessage").textContent = error.message;
        errorBox.hidden = false;
    } finally {
        loading.hidden = true;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const countEl = document.querySelector("#cartCount");
    const alert = document.querySelector("#detailAlert");
    const addButton = document.querySelector("#addToCartDetail");

    function refreshCount() {
        countEl.textContent = readCart().length;
    }

    refreshCount();
    loadDetail();

    document.querySelector("#detailRetry").addEventListener("click", loadDetail);

    document.querySelector("#cartToggle").addEventListener("click", () => {
        location.href = "index.html#keranjang";
    });

    addButton.addEventListener("click", () => {
        const cart = readCart();
        if (!cart.includes(FEATURED_ID)) {
            cart.push(FEATURED_ID);
            localStorage.setItem("ts_cart", JSON.stringify(cart));
        }
        refreshCount();
        alert.className = "alert alert-success show";
        alert.textContent = "Akun ini sudah ada di keranjangmu. Buka halaman katalog untuk menyelesaikan pembayaran rekber.";
        addButton.textContent = "Sudah di Keranjang";
    });
});
