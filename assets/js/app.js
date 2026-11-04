/* ============================================================
   TriverseStore — Lapisan Data API (Week 4 · Sprint 03)
   Perbedaan dari Week 3: data TIDAK lagi menempel di kode
   (data.js dihapus). Katalog diambil dari REST API lokal
   "api/games.json" dengan fetch() + async/await, lengkap
   dengan loading state dan error handling (Task 03).
   - W4.1 fetch() & Promise (async/await, response.ok, try/catch)
   - W4.2 render object tunggal & array of objects ke DOM
   - W4.3 loading state & error handling
   Seluruh interaksi Week 3 (cari, filter, keranjang, form)
   dipertahankan; yang berubah hanya sumber datanya.
   ============================================================ */

const API_URL = "api/games.json";
const STAR_SVG = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>';

/* Pola Promise dengan .then() — versi perbandingan dari materi:

   fetch(API_URL)
       .then((response) => response.json())
       .then((data) => { products = data.products; })
       .catch((error) => console.error(error));

   Kode produksi di bawah memakai async/await karena alurnya
   lebih mudah dibaca dan ditangani dengan try/catch/finally. */

/* ---------- Helper ---------- */

function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString("id-ID");
}

function badgeClass(status) {
    if (status === "Tersedia") return "badge-available";
    if (status === "Stok Terbatas") return "badge-limited";
    return "badge-sold";
}

/* ---------- State ---------- */

let products = [];
let activeCategory = "Semua";
let cart = loadCart();

function loadCart() {
    try {
        return JSON.parse(localStorage.getItem("ts_cart")) || [];
    } catch (error) {
        return [];
    }
}

function saveCart() {
    localStorage.setItem("ts_cart", JSON.stringify(cart));
}

/* ---------- W4.1 + W4.3: Ambil data dari API ---------- */

async function loadProducts(url = API_URL) {
    const loading = document.querySelector("#loadingState");
    const errorBox = document.querySelector("#errorState");
    const grid = document.querySelector("#gameGrid");

    // Loading state: tampilkan indikator, kosongkan grid
    loading.hidden = false;
    errorBox.hidden = true;
    grid.innerHTML = "";

    try {
        const response = await fetch(url);

        // Error handling: respons bukan 2xx dianggap gagal
        if (!response.ok) {
            throw new Error("Gagal mengambil data (HTTP " + response.status + ")");
        }

        const data = await response.json();
        products = data.products;

        renderCatalog();
        renderCart();
        fillProductOptions();
    } catch (error) {
        document.querySelector("#errorMessage").textContent =
            error.message + ". Periksa koneksi atau coba lagi. Catatan: fetch() butuh server lokal (mis. php -S), tidak bisa dari file://.";
        errorBox.hidden = false;
    } finally {
        loading.hidden = true;
    }
}

/* ---------- Render katalog (markup identik Week 2 & 3) ---------- */

function buildCardHTML(product) {
    const promo = product.diskon > 0
        ? `<span class="badge badge-promo">&minus;${product.diskon}%</span>`
        : "";
    const hargaCoret = product.hargaCoret
        ? `<div class="price-old">${formatRupiah(product.hargaCoret)}</div>`
        : "";
    const tombol = product.status === "Terjual"
        ? '<button class="btn btn-secondary btn-sm" disabled>Sudah Terjual</button>'
        : `<button class="btn btn-primary btn-sm" data-add="${product.id}">+ Keranjang</button>`;

    return `
    <article class="game-card">
        <div class="card-media">
            <img src="assets/img/${product.gambar}" alt="Key art ${product.game}">
            ${promo}
        </div>
        <div class="card-body">
            <span class="card-category">${product.kategori}</span>
            <h3><a href="detail.html">${product.judul}</a></h3>
            <div class="card-meta">
                <span>${product.seller}</span>
                <span class="dot"></span>
                <span class="rating">${STAR_SVG}${product.rating}</span>
            </div>
            <p class="card-desc">${product.deskripsiSingkat}</p>
            <div class="card-price-row">
                <div>
                    ${hargaCoret}
                    <div class="price">${formatRupiah(product.harga)}</div>
                </div>
                <span class="badge ${badgeClass(product.status)}">${product.status}</span>
            </div>
            <div class="card-actions">
                <a class="btn btn-secondary btn-sm" href="detail.html">Lihat Detail</a>
                ${tombol}
            </div>
        </div>
    </article>`;
}

function renderCatalog() {
    const keyword = document.querySelector("#searchInput").value.trim().toLowerCase();
    const container = document.querySelector("#gameGrid");
    const emptyState = document.querySelector("#emptyState");

    const hasil = products.filter((product) => {
        const cocokKategori = activeCategory === "Semua" || product.kategori === activeCategory;
        const cocokKata = (product.judul + " " + product.game + " " + product.kategori)
            .toLowerCase()
            .includes(keyword);
        return cocokKategori && cocokKata;
    });

    container.innerHTML = hasil.map(buildCardHTML).join("");
    emptyState.hidden = hasil.length > 0;

    container.querySelectorAll("[data-add]").forEach((button) => {
        button.addEventListener("click", () => addToCart(button.dataset.add));
    });
}

/* ---------- Keranjang (sama seperti Week 3) ---------- */

function addToCart(productId) {
    if (cart.includes(productId)) {
        document.querySelector("#keranjang").scrollIntoView({ behavior: "smooth" });
        return;
    }
    cart.push(productId);
    saveCart();
    renderCart();
    document.querySelector("#keranjang").scrollIntoView({ behavior: "smooth" });
}

function removeFromCart(productId) {
    cart = cart.filter((id) => id !== productId);
    saveCart();
    renderCart();
}

function renderCart() {
    const list = document.querySelector("#cartItems");
    const totalEl = document.querySelector("#cartTotal");
    const countEl = document.querySelector("#cartCount");
    const checkoutBtn = document.querySelector("#checkoutButton");

    countEl.textContent = cart.length;

    if (cart.length === 0) {
        list.innerHTML = '<div class="cart-empty">Keranjang masih kosong. Tambahkan akun dari katalog.</div>';
        totalEl.textContent = "Rp 0";
        checkoutBtn.disabled = true;
        return;
    }

    let total = 0;
    list.innerHTML = cart.map((id) => {
        const product = products.find((p) => p.id === id);
        if (!product) return "";
        total += product.harga;
        return `
        <div class="cart-item">
            <div>
                <div class="item-name">${product.judul}</div>
                <div class="item-meta">${product.game} · ${product.seller}</div>
                <button class="cart-remove" data-remove="${product.id}">Hapus</button>
            </div>
            <div class="item-price">${formatRupiah(product.harga)}</div>
        </div>`;
    }).join("");

    totalEl.textContent = formatRupiah(total);
    checkoutBtn.disabled = false;

    list.querySelectorAll("[data-remove]").forEach((button) => {
        button.addEventListener("click", () => removeFromCart(button.dataset.remove));
    });
}

/* ---------- Form pemesanan ---------- */

function fillProductOptions() {
    const select = document.querySelector("#productSelect");
    select.innerHTML = products
        .filter((p) => p.status !== "Terjual")
        .map((p) => `<option value="${p.id}">${p.judul} — ${formatRupiah(p.harga)}</option>`)
        .join("");
}

/* ---------- Pendaftaran event ---------- */

document.addEventListener("DOMContentLoaded", () => {
    // Muat data pertama kali dari API
    loadProducts();

    document.querySelector("#searchInput").addEventListener("input", renderCatalog);

    document.querySelectorAll(".filter-chip").forEach((chip) => {
        chip.addEventListener("click", () => {
            document.querySelectorAll(".filter-chip").forEach((c) => c.classList.remove("active"));
            chip.classList.add("active");
            activeCategory = chip.dataset.filter;
            renderCatalog();
        });
    });

    document.querySelector("#cartToggle").addEventListener("click", () => {
        document.querySelector("#keranjang").scrollIntoView({ behavior: "smooth" });
    });

    // Tombol coba lagi & simulasi error untuk mendemonstrasikan error handling
    document.querySelector("#retryButton").addEventListener("click", () => loadProducts());
    document.querySelector("#simulateError").addEventListener("click", () => loadProducts("api/tidak-ada.json"));

    document.querySelector("#checkoutButton").addEventListener("click", () => {
        const total = document.querySelector("#cartTotal").textContent;
        const alert = document.querySelector("#orderAlert");
        alert.className = "alert alert-success show";
        alert.textContent = `Pesanan diteruskan ke pembayaran rekber sebesar ${total}. Dana akan ditahan TriverseStore sampai kamu mengonfirmasi akun diterima.`;
        cart = [];
        saveCart();
        renderCart();
    });

    document.querySelector("#orderForm").addEventListener("submit", (event) => {
        event.preventDefault();

        const name = document.querySelector("#buyerName").value.trim();
        const email = document.querySelector("#buyerEmail").value.trim();
        const productId = document.querySelector("#productSelect").value;
        const alert = document.querySelector("#orderAlert");
        const product = products.find((p) => p.id === productId);

        if (name.length < 3 || !email.includes("@")) {
            alert.className = "alert alert-error show";
            alert.textContent = "Periksa lagi formulirnya: nama minimal 3 karakter dan email harus valid.";
            return;
        }

        const kode = "TS-" + Date.now().toString(36).toUpperCase();
        alert.className = "alert alert-success show";
        alert.textContent = `Terima kasih, ${name}. Pesanan ${product.judul} (${formatRupiah(product.harga)}) dibuat dengan kode rekber ${kode}. Instruksi pembayaran dikirim ke ${email}.`;
        event.target.reset();
    });
});
