/* ============================================================
   TriverseStore — Lapisan Interaksi (Week 3 · Sprint 02)
   Alur sesuai materi: aksi pengguna -> event -> JavaScript
   memanipulasi DOM -> tampilan berubah tanpa memuat ulang.
   - W3.1 Selector & manipulasi DOM (querySelector/All, innerHTML)
   - W3.2 Event handling: click, input, submit
   - W3.3 Satu interaksi utuh: keranjang belanja
   ============================================================ */

const STAR_SVG = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>';

/* ---------- Helper ---------- */

// Format angka menjadi Rupiah, mis. 850000 -> "Rp 850.000"
function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString("id-ID");
}

// Kelas badge mengikuti status produk
function badgeClass(status) {
    if (status === "Tersedia") return "badge-available";
    if (status === "Stok Terbatas") return "badge-limited";
    return "badge-sold";
}

/* ---------- State ---------- */

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

/* ---------- W3.1: Render katalog dengan manipulasi DOM ---------- */

// Membangun satu kartu produk (markup sama persis dengan Week 2)
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

// Memfilter data lalu menampilkannya ke container katalog
function renderCatalog() {
    const keyword = document.querySelector("#searchInput").value.trim().toLowerCase();
    const container = document.querySelector("#gameGrid");
    const emptyState = document.querySelector("#emptyState");

    const hasil = PRODUCTS.filter((product) => {
        const cocokKategori = activeCategory === "Semua" || product.kategori === activeCategory;
        const cocokKata = (product.judul + " " + product.game + " " + product.kategori)
            .toLowerCase()
            .includes(keyword);
        return cocokKategori && cocokKata;
    });

    // Manipulasi DOM: isi container dengan HTML kartu hasil filter
    container.innerHTML = hasil.map(buildCardHTML).join("");
    emptyState.hidden = hasil.length > 0;

    // Pasang event click pada tombol "+ Keranjang" yang baru dirender
    container.querySelectorAll("[data-add]").forEach((button) => {
        button.addEventListener("click", () => addToCart(button.dataset.add));
    });
}

/* ---------- W3.3: Interaksi utuh — keranjang belanja ---------- */

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
        const product = PRODUCTS.find((p) => p.id === id);
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

/* ---------- Form pemesanan (mengisi pilihan produk) ---------- */

function fillProductOptions() {
    const select = document.querySelector("#productSelect");
    select.innerHTML = PRODUCTS
        .filter((p) => p.status !== "Terjual")
        .map((p) => `<option value="${p.id}">${p.judul} — ${formatRupiah(p.harga)}</option>`)
        .join("");
}

/* ---------- Pendaftaran event (W3.2) ---------- */

document.addEventListener("DOMContentLoaded", () => {
    renderCatalog();
    renderCart();
    fillProductOptions();

    // Event "input": pencarian langsung saat pengguna mengetik
    document.querySelector("#searchInput").addEventListener("input", renderCatalog);

    // Event "click": chip filter kategori
    document.querySelectorAll(".filter-chip").forEach((chip) => {
        chip.addEventListener("click", () => {
            document.querySelectorAll(".filter-chip").forEach((c) => c.classList.remove("active"));
            chip.classList.add("active");
            activeCategory = chip.dataset.filter;
            renderCatalog();
        });
    });

    // Event "click": tombol keranjang di header menggulir ke panel keranjang
    document.querySelector("#cartToggle").addEventListener("click", () => {
        document.querySelector("#keranjang").scrollIntoView({ behavior: "smooth" });
    });

    // Event "click": tombol checkout meniru alur pembayaran rekber
    document.querySelector("#checkoutButton").addEventListener("click", () => {
        const total = document.querySelector("#cartTotal").textContent;
        const alert = document.querySelector("#orderAlert");
        alert.className = "alert alert-success show";
        alert.textContent = `Pesanan diteruskan ke pembayaran rekber sebesar ${total}. Dana akan ditahan TriverseStore sampai kamu mengonfirmasi akun diterima.`;
        cart = [];
        saveCart();
        renderCart();
    });

    // Event "submit": form pemesanan dengan validasi bawaan browser + JavaScript
    document.querySelector("#orderForm").addEventListener("submit", (event) => {
        event.preventDefault();

        const name = document.querySelector("#buyerName").value.trim();
        const email = document.querySelector("#buyerEmail").value.trim();
        const productId = document.querySelector("#productSelect").value;
        const alert = document.querySelector("#orderAlert");
        const product = PRODUCTS.find((p) => p.id === productId);

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
