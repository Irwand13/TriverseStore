<?php
// Expects $pageTitle and optional $pageDescription before it is included.
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? config('name');
$pageDescription = $pageDescription ?? config('tagline');
$fullTitle = $pageTitle === config('name') ? $pageTitle : $pageTitle . ' | ' . config('name');
?>
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($fullTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <meta name="theme-color" content="#0d1a1c">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
  <script>document.documentElement.classList.add('js')</script>
  <link rel="stylesheet" href="assets/css/app.css">
</head>
<body class="bg-background text-foreground font-sans antialiased min-h-screen flex flex-col">
<a href="#main" class="skip-link">Lewati ke konten</a>
