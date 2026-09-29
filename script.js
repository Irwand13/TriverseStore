const root = document.documentElement;
const themeButton = document.querySelector('.theme-toggle');
const themeIcon = document.querySelector('.theme-icon');
const savedTheme = localStorage.getItem('triverse-theme');
const prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;

function setTheme(theme) {
  const isLight = theme === 'light';
  root.dataset.theme = isLight ? 'light' : 'dark';
  themeIcon.textContent = isLight ? '🌙' : '☀️';
  themeButton.setAttribute('aria-pressed', String(isLight));
  themeButton.setAttribute('aria-label', isLight ? 'Aktifkan mode gelap' : 'Aktifkan mode terang');
}

setTheme(savedTheme || (prefersLight ? 'light' : 'dark'));
themeButton.addEventListener('click', () => {
  const nextTheme = root.dataset.theme === 'light' ? 'dark' : 'light';
  setTheme(nextTheme);
  localStorage.setItem('triverse-theme', nextTheme);
});

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
