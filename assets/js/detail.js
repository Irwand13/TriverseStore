/* ============================================================
   TriverseStore — Interaksi Halaman Detail (Week 3 · Sprint 02)
   Contoh W3.3 pada satu produk (P1): tombol "Tambah ke Keranjang"
   mengubah DOM (badge jumlah di header + pesan sukses) tanpa
   memuat ulang halaman. Keranjang dibagikan dengan halaman
   katalog lewat localStorage (kunci "ts_cart").
   ============================================================ */

document.addEventListener("DOMContentLoaded", () => {
    const countEl = document.querySelector("#cartCount");
    const alert = document.querySelector("#detailAlert");
    const addButton = document.querySelector("#addToCartDetail");

    function readCart() {
        try {
            return JSON.parse(localStorage.getItem("ts_cart")) || [];
        } catch (error) {
            return [];
        }
    }

    function refreshCount() {
        countEl.textContent = readCart().length;
    }

    refreshCount();

    // Event "click": tombol keranjang di header menuju panel keranjang katalog
    document.querySelector("#cartToggle").addEventListener("click", () => {
        location.href = "index.html#keranjang";
    });

    // Event "click": tambahkan produk ini ke keranjang bersama
    addButton.addEventListener("click", () => {
        const cart = readCart();
        const productId = addButton.dataset.id;

        if (!cart.includes(productId)) {
            cart.push(productId);
            localStorage.setItem("ts_cart", JSON.stringify(cart));
        }

        refreshCount();
        alert.className = "alert alert-success show";
        alert.textContent = "Akun ini sudah ada di keranjangmu. Buka halaman katalog untuk menyelesaikan pembayaran rekber.";
        addButton.textContent = "Sudah di Keranjang";
    });
});
