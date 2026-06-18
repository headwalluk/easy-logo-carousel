# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Easy Logo Carousel is a WordPress plugin providing a single Gutenberg block — **Logo Carousel** (`easy-logo-carousel/marquee`) — that renders an auto-scrolling, continuously looping marquee of Media Library logos. The frontend is a **pure CSS marquee**: no jQuery, no Swiper, no carousel library is ever enqueued.

- **Namespace:** `Easy_Logo_Carousel`
- **Text Domain:** `easy-logo-carousel`
- **PHP:** 8.0+ (do NOT use `declare(strict_types=1)` — breaks WordPress interop)
- **WordPress:** 6.5+
- **Block type:** dynamic (server-rendered via `src/render.php`)
- **Has a build system:** `@wordpress/scripts` compiles `src/` → `build/` (unlike most Headwall plugins). The shipped frontend is still just CSS + rendered HTML.

## Commands

```bash
npm install        # once
npm run build      # compile src/ -> build/  (commit build/ afterwards)
npm start          # watch mode while developing
npm run lint:js    # lint JS
phpcs              # check WordPress coding standards
phpcbf             # auto-fix coding standards violations
```

Always `npm run build` and re-commit `build/` after changing anything in `src/` — the compiled `build/` is committed so the plugin runs with no npm step on the target site. Always run `phpcs` before committing. Config is in `phpcs.xml` (WordPress standards; prefixes: `elc`, `ELC`, `Easy_Logo_Carousel`; `build/`, `node_modules/`, `dev-notes/` excluded).

## Architecture

### Entry Point & Bootstrap

`easy-logo-carousel.php` is the main file. It defines constants (`ELC_FILE`, `ELC_BASENAME`, `ELC_DIR`, `ELC_URL`, `ELC_NAME`, `ELC_VERSION`), requires `constants.php` and the class files, then `elc_plugin_run()` creates `Plugin` and calls `run()`.

### Core Classes

- **`Plugin`** (`includes/class-plugin.php`) — Registers the block on `init` from the `build/` directory (`register_block_type( ELC_DIR . 'build' )`) and instantiates the updater.
- **`Github_Updater`** (`includes/class-github-updater.php`) — Serves plugin updates from the GitHub repo's Releases. Toggle with the `elc_updater_enabled` filter (return false on staging/dev). Caches the latest-release lookup via `ELC_UPDATER_CACHE_KEY` for `ELC_UPDATER_CACHE_TTL`.

### The Block

- **`src/block.json`** — block metadata + the attribute schema. This is the **single source of truth for attribute defaults**.
- **`src/index.js`** — `registerBlockType` (dynamic block, so no `save`).
- **`src/edit.js`** — editor UI: `MediaPlaceholder`/`MediaUpload` picker, `InspectorControls`, and an Advanced panel with "Repeat logo set".
- **`src/render.php`** — server-side frontend render. Images go through `wp_get_attachment_image()` for `srcset` + lazy loading.
- **`src/style.scss`** (front + editor) / **`src/editor.scss`** (editor-only preview tweaks).

### How the marquee loops

The track is two identical halves, each `repeat` copies of the logo set; CSS animates `translateX(0)` → `translateX(-50%)`, so the reset is pixel-identical. The loop only looks seamless while one half is at least as wide as the viewport — hence the `repeat` control. Animation duration is `speed × repeat`, so `speed` (seconds **per logo set**) keeps a constant velocity regardless of `repeat`. Only the first set is exposed to assistive tech; all copies are `aria-hidden`. Under `prefers-reduced-motion`, the animation is disabled and logos wrap into a static row.

### Constants

`constants.php` holds `ELC_BLOCK_NAME` and the `ELC_UPDATER_*` constants. `ELC_FILE`/`ELC_BASENAME`/`ELC_DIR`/`ELC_URL`/`ELC_VERSION` are defined in the bootstrap.

### Filters

- `elc_logo_image_size` — `( string $size, array $attributes )`, the registered image size (default `medium`).
- `elc_marquee_html` — `( string $html, array $attributes )`, the final block markup before output.
- `elc_updater_enabled` — `( bool $enabled )`, disable GitHub update checks.

## Key Conventions

- **Never add a frontend JS carousel library.** The marquee is pure CSS by design.
- Attribute defaults live in `src/block.json`; `render.php` mirrors them defensively for direct/legacy calls.
- Render images server-side via `wp_get_attachment_image()` — do not hand-build `<img>` except as the missing-attachment fallback.
- The single `echo` in `render.php` outputs pre-escaped HTML (block wrapper attrs + `wp_get_attachment_image()` + `esc_*`); keep the documented `phpcs:ignore` and don't double-escape.
- `speed` is **seconds per logo set**; keep `duration = speed × repeat` so velocity is repeat-independent.
- No `declare(strict_types=1)`.
- Rebuild and commit `build/` after any `src/` change.

## Translations

Strings are wrapped with the `easy-logo-carousel` text domain (in `src/edit.js` and `src/block.json`; `render.php` has none). **Do NOT run `wp i18n make-pot`** — translations are produced with Paul's dedicated tool. Just keep new strings wrapped correctly.

## Releases

The plugin self-updates from GitHub Releases. To cut a release:

1. Bump the version in **four** places: the plugin header in `easy-logo-carousel.php`, the `ELC_VERSION` constant, the `readme.txt` `Stable tag`, and `CHANGELOG.md`.
2. `npm run build` and commit (so `build/` is current).
3. `git tag vX.Y.Z && git push --tags`.

`.github/workflows/release.yml` then builds `easy-logo-carousel.zip` (stable name, used by the updater) plus a versioned zip. Its staging directory is **`dist/`**, deliberately NOT `build/` — `build/` holds the committed compiled assets and must survive into the zip. `.distignore` ships `build/` and strips `src/`/`dist/`/dev files.

## Dev Environment (Headwall host)

`devx.headwall.tech` is public, so a security cron `isp-tick.sh` resets file permissions and **breaks `npm install` with `chmod EPERM`**. Before building: pause `isp-tick.sh` and `chown` the plugin tree to the dev user; re-enable the cron afterwards.

## Commit Messages

```
type: brief description

- Detail 1
- Detail 2
```

Types: `feat:` `fix:` `refactor:` `chore:` `docs:` `style:` `test:`

## Reference Files

- `dev-notes/00-project-tracker.md` — current milestones, decisions and roadmap (internal; not shipped).
- `docs/usage.md`, `docs/styling.md`, `docs/developers.md` — end-user / designer / developer guides.
- `README.md` (GitHub) and `readme.txt` (WordPress).
