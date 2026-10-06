/* ============================================
   TRIVERSE STORE — JavaScript
   Theme Toggle, Password Toggle, Page Navigation, Cursor Glow
   ============================================ */

// ==========================================
// THEME TOGGLE
// ==========================================
const root = document.documentElement;
const savedTheme = localStorage.getItem('triverse-theme');
const prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;

function setTheme(theme) {
  const isLight = theme === 'light';
  root.dataset.theme = isLight ? 'light' : 'dark';

  const themeIcon = document.querySelector('.theme-icon');
  if (themeIcon) {
    themeIcon.textContent = isLight ? '🌙' : '☀️';
  }
}

// Apply saved theme on load
setTheme(savedTheme || (prefersLight ? 'light' : 'dark'));

function toggleTheme() {
  const nextTheme = root.dataset.theme === 'light' ? 'dark' : 'light';
  setTheme(nextTheme);
  localStorage.setItem('triverse-theme', nextTheme);
}

// ==========================================
// PASSWORD TOGGLE
// ==========================================
function togglePassword() {
  const pwInput = document.getElementById('password');
  if (!pwInput) return;
  const isPassword = pwInput.type === 'password';
  pwInput.type = isPassword ? 'text' : 'password';
}

// ==========================================
// SHOW CATALOG (After login / guest)
// ==========================================
function showCatalog() {
  const heroSplit = document.querySelector('.hero-split');
  const mainContent = document.getElementById('mainContent');

  if (heroSplit) {
    heroSplit.style.display = 'none';
  }
  if (mainContent) {
    mainContent.classList.add('visible');
    // Smooth scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
}

// ==========================================
// LOGIN FORM HANDLER
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', (e) => {
      e.preventDefault();
      showCatalog();
    });
  }

  // Switch between Login and Register (placeholder)
  const switchLink = document.getElementById('switchToRegister');
  if (switchLink) {
    switchLink.addEventListener('click', (e) => {
      e.preventDefault();
      const formTitle = document.querySelector('.form-title');
      const formDesc = document.querySelector('.form-desc');
      const formBadge = document.querySelector('.form-badge');
      const loginBtn = document.getElementById('loginBtn');
      const authRedirect = document.querySelector('.auth-redirect');

      if (switchLink.dataset.mode === 'login') {
        // Switch to Login
        if (formBadge) formBadge.textContent = 'AKSES KATALOG';
        if (formTitle) formTitle.textContent = 'Masuk ke Triverse';
        if (formDesc) formDesc.textContent = 'Kelola wishlist dan koleksi game kamu.';
        if (loginBtn) loginBtn.innerHTML = '<span>→]</span> Masuk';
        if (authRedirect) authRedirect.innerHTML = 'Belum punya akun? <a href="#" id="switchToRegister" onclick="switchForm(\'register\')">Daftar gratis</a>';
        switchLink.dataset.mode = 'register';
      } else {
        // Switch to Register
        if (formBadge) formBadge.textContent = 'MULAI SEKARANG';
        if (formTitle) formTitle.textContent = 'Buat akun baru';
        if (formDesc) formDesc.textContent = 'Daftar gratis dan mulai jelajahi katalog game.';
        if (loginBtn) loginBtn.innerHTML = '<span>🎮</span> Daftar';
        if (authRedirect) authRedirect.innerHTML = 'Sudah punya akun? <a href="#" id="switchToRegister" onclick="switchForm(\'login\')">Masuk</a>';
        switchLink.dataset.mode = 'login';
      }
    });
  }
});

function switchForm(mode) {
  const formTitle = document.querySelector('.form-title');
  const formDesc = document.querySelector('.form-desc');
  const formBadge = document.querySelector('.form-badge');
  const loginBtn = document.getElementById('loginBtn');
  const authRedirect = document.querySelector('.auth-redirect');

  if (mode === 'register') {
    if (formBadge) formBadge.textContent = 'MULAI SEKARANG';
    if (formTitle) formTitle.textContent = 'Buat akun baru';
    if (formDesc) formDesc.textContent = 'Daftar gratis dan mulai jelajahi katalog game.';
    if (loginBtn) loginBtn.innerHTML = '<span>🎮</span> Daftar';
    if (authRedirect) authRedirect.innerHTML = 'Sudah punya akun? <a href="#" onclick="switchForm(\'login\'); return false;">Masuk</a>';
  } else {
    if (formBadge) formBadge.textContent = 'AKSES KATALOG';
    if (formTitle) formTitle.textContent = 'Masuk ke Triverse';
    if (formDesc) formDesc.textContent = 'Kelola wishlist dan koleksi game kamu.';
    if (loginBtn) loginBtn.innerHTML = '<span>→]</span> Masuk';
    if (authRedirect) authRedirect.innerHTML = 'Belum punya akun? <a href="#" onclick="switchForm(\'register\'); return false;">Daftar gratis</a>';
  }
}

// ==========================================
// ACTIVE NAV LINK HIGHLIGHT
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
  const navLinks = document.querySelectorAll('.nav-link');
  const sections = document.querySelectorAll('.section[id]');

  if (navLinks.length && sections.length) {
    const observerOptions = {
      rootMargin: '-20% 0px -80% 0px',
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          navLinks.forEach(link => link.classList.remove('active'));
          const activeLink = document.querySelector(`.nav-link[href="#${entry.target.id}"]`);
          if (activeLink) activeLink.classList.add('active');
        }
      });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
  }
});

// ==========================================
// CUSTOM CURSOR GLOW
// ==========================================
if (window.matchMedia('(hover: hover) and (pointer: fine)').matches &&
    !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const cursor = document.createElement('div');
  cursor.className = 'cursor-glow';
  cursor.setAttribute('aria-hidden', 'true');
  document.body.append(cursor);

  window.addEventListener('pointermove', (event) => {
    cursor.style.left = `${event.clientX}px`;
    cursor.style.top = `${event.clientY}px`;
  }, { passive: true });

  document.addEventListener('pointerover', (event) => {
    if (event.target.closest('a, button, input, select')) cursor.classList.add('is-hovering');
  });
  document.addEventListener('pointerout', (event) => {
    if (event.target.closest('a, button, input, select')) cursor.classList.remove('is-hovering');
  });
}
