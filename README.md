# Triverse Store

A game top-up, account marketplace, game catalog and newsroom prototype. Built with HTML5, CSS3, Tailwind CSS, PHP and a small amount of vanilla JavaScript.

**Status:** all games and articles are fictional sample data stored in PHP files. There is no database, login, checkout, payment or API integration yet, and nothing on the site pretends otherwise.

## Run it

Requires PHP 8.0 or newer and an internet connection (for Tailwind and Google Fonts, see below).

```bash
cd TriverseStore
php -S localhost:8000
```

Open http://localhost:8000/index.php. Alternatively, copy the folder into the `htdocs` (XAMPP) or `www` (Laragon) directory.

## Pages

| File | Purpose |
|---|---|
| `index.php` | Introduction, featured game, latest listings, category index, selected games, news preview |
| `topup.php` | Games available for top up, with the lowest sample price |
| `topup-game.php` | `?id=<slug>`: choose an amount, enter game ID (and server ID if needed), review the order. POST form validated in PHP; ends in a preview |
| `marketplace.php` | Account listings with search, game, category, price range and sort filters |
| `account-detail.php` | `?id=<slug>`: listing details, included items, status, privacy note |
| `catalog.php` | Game catalog. Search (`?q=`) and category filter (`?category=`), with an empty state |
| `game-detail.php` | `?id=<slug>`: artwork, metadata, description, related games |
| `news.php` | Article list with category filter |
| `news-detail.php` | `?id=<slug>`: full article |

## Structure

```
includes/   head.php, navbar.php, footer.php, game-card.php, not-found.php, functions.php
data/       games.php, accounts.php, topup.php, news.php   sample data, separate from templates
config/     app.php                   site name and tagline
assets/     css/style.css, js/app.js, images/
```

`includes/functions.php` holds every helper: `e()` (wrapper for `htmlspecialchars`), data loading, slug validation, search, and the cover-art generator. Pages contain markup and little logic.

## Design notes

- **Concept:** a catalog-and-newsroom, not a landing page. Left-aligned layout, hairline rules, and index-style lists (categories, article rows) instead of repeated card grids.
- **Palette:** deep harbour teal background, one accent (marigold) used only for the primary action, the active navigation state, and cover highlights.
- **Type:** Chakra Petch for headings, Figtree for text. Tokens are CSS variables at the top of `assets/css/style.css`.
- **Artwork:** no external images. `cover_art()` draws an original SVG cover from each record's palette and motif. To use real artwork, put a file in `assets/images/` and add `'image' => 'file.jpg'` to the record. If the file is missing, the SVG cover is used.

## Security basics

All dynamic output goes through `e()`. The `id`, `q` and `category` query parameters are validated: slugs must match `[a-z0-9-]`, categories must exist in the data, search text is trimmed and length-limited, and non-text values are ignored. Unknown ids return a real 404 page.

## Limitation: Tailwind via CDN

`includes/head.php` loads Tailwind with the Play CDN script (pinned to 3.4.17). It compiles styles in the browser, adds load time and needs internet access, so it is suitable for a prototype only. Before real deployment, build a static stylesheet with the Tailwind CLI. Fonts also load from Google Fonts and fall back to system fonts if blocked.

## Verified

Checked with PHP 8.3 CLI and its built-in server: syntax of every PHP file; HTTP status of every page; catalog search and category filtering; empty state; invalid and malformed ids returning 404 (including `../` and array parameters); HTML escaping of a script payload in search; no PHP warnings; every local link and asset on the main pages resolves. Top-up form: valid and invalid submissions for games with and without a server ID, tampered and array values, escaping of a script payload, and entered values kept after an error. Marketplace filters (game, category, price range including swapped min/max, sort, search) return the expected listings, and junk or array parameters fall back to defaults.

**Not verified:** appearance and responsive layout in a real browser, and the Tailwind CDN rendering (no browser or CDN access was available when this was built). Please check these yourself at phone, tablet and desktop widths.

## Later stages

Database (`config/` plus a PDO connection, then replace `games()` and `articles()` in `functions.php`), authentication, payments, and a Laravel migration (data files become migrations and seeders, `includes/` become Blade layouts).

**Marketplace notes:** listing data never contains login credentials, and the pages say that account handover and disputes will be defined with the order system. There is no buy or sell control yet. **Top-up notes:** the flow ends at an order preview. Nothing is saved, sent to a provider or charged, and the page says so. Packages, currencies, prices and ID formats are fictional sample data in `data/topup.php`. The form checks the chosen amount against the game's own list, so a tampered value is rejected. There is no payment method, order history or status tracking yet.
