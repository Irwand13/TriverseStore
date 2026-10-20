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
