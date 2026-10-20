// Mobile menu: toggle, and close with the Escape key.
(function () {
  var button = document.getElementById('menu-toggle');
  var menu = document.getElementById('mobile-menu');
  if (!button || !menu) return;

  function setOpen(open) {
    menu.classList.toggle('hidden', !open);
    button.setAttribute('aria-expanded', String(open));
  }
  button.addEventListener('click', function () {
    setOpen(button.getAttribute('aria-expanded') !== 'true');
  });
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') { setOpen(false); button.focus(); }
  });
})();

// Animasi muncul saat elemen masuk layar. Jika gagal, semua elemen ditampilkan setelah 2,5 detik.
(function () {
  var items = document.querySelectorAll('[data-reveal]');
  function show(el) { el.classList.add('is-visible'); }
  if (!('IntersectionObserver' in window)) { items.forEach(show); return; }
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) { show(entry.target); io.unobserve(entry.target); }
    });
  }, { rootMargin: '0px 0px -8% 0px' });
  items.forEach(function (el) { io.observe(el); });
  setTimeout(function () { items.forEach(show); }, 2500);
})();
