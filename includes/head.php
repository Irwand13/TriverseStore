<?php
// Expects $pageTitle and optional $pageDescription before it is included.
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? config('name');
$pageDescription = $pageDescription ?? config('tagline');
$fullTitle = $pageTitle === config('name') ? $pageTitle : $pageTitle . ' | ' . config('name');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($fullTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <meta name="theme-color" content="#0d1a1c">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
  <!-- Prototype only: Tailwind through the Play CDN. See README. Design tokens live in assets/css/style.css. -->
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script>
    tailwind.config = { theme: { extend: {
      colors: { canvas: 'var(--canvas)', panel: 'var(--panel)', rule: 'var(--rule)', ink: 'var(--ink)', muted: 'var(--muted)', accent: 'var(--accent)' },
      fontFamily: { display: ['"Chakra Petch"', 'system-ui', 'sans-serif'], sans: ['Figtree', 'system-ui', 'sans-serif'] }
    } } };
  </script>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-canvas text-ink font-sans antialiased min-h-screen flex flex-col">
<a href="#main" class="skip-link">Skip to content</a>
