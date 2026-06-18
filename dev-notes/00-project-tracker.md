# Easy Logo Carousel - Project Tracker

**Version:** 0.1.0 (pre-release)
**Last Updated:** 18 June 2026
**Current Phase:** Milestone 1 (MVP block scaffold)
**Overall Progress:** ~80% of MVP — block builds, activates, PHPCS clean; manual browser test pending

---

## Overview

A lightweight Gutenberg block that renders an auto-scrolling, continuously
looping marquee of logo images selected from the Media Library (same picker
UX as the core Gallery block). The frontend is a **pure CSS marquee** — no
JavaScript carousel library is shipped. Built to replace the older
"intercept-the-Gallery-block-in-the-child-theme + Swiper" technique with a
clean, self-contained, reusable block.

---

## Key Decisions

1. ✅ **Engine: pure CSS marquee.** Continuous ticker (conveyor-belt), not a
   stepped/paginated slider. No arrows, no dots, no drag. Chosen for leanness:
   ~1KB CSS, zero frontend JS, trivial `prefers-reduced-motion` handling.
2. ✅ **Pause-on-hover is a per-block toggle** (CSS `animation-play-state`).
3. ✅ **Dynamic (server-rendered) block.** `render.php` outputs markup via
   `wp_get_attachment_image()` for free `srcset`/lazy-loading, and duplicates
   the logo set enough times to guarantee a seamless loop at any logo count.
   Block stores an array of attachment IDs (Gallery-style).
4. ✅ **Future-proofing:** if interactive features are ever wanted, an Embla
   (~10KB) variant can be added later without changing how images are stored.
5. ✅ **Build tooling: `@wordpress/scripts`** (dev-time only). Diverges from
   bullfix-erp's no-build approach; shipped artifact remains CSS + rendered
   HTML. `build/` IS committed so the plugin runs without an npm step.
6. ✅ **Git: initialised now** (local repo). Push to GitHub later.
7. ✅ **Translations:** handled by Paul's dedicated tool later — do NOT run
   `wp i18n make-pot`. Strings stay wrapped in i18n functions meanwhile.

**Naming / prefixes** (mirrors bullfix-erp discipline):
- Namespace: `Easy_Logo_Carousel`
- Text domain: `easy-logo-carousel`
- Constants: `ELC_`
- Functions: `elc_`
- Block name: `easy-logo-carousel/marquee`

---

## Active TODO Items

- [ ] Manual browser test on https://devx.headwall.tech (seamless loop, hover
      pause, reduced-motion, grayscale)
- [ ] Re-enable `isp-tick.sh` security cron at end of dev session
- [x] ~~Known limitation: seamless loop assumes the logo set fills the
      viewport.~~ RESOLVED: added an Advanced "Repeat logo set" control
      (1–8, default 2, pure CSS). Render builds two halves of `repeat` sets and
      animates -50%; `speed` is now seconds-per-set so the velocity stays
      constant as `repeat` changes. Only the first set is exposed to AT.

## Dev Process Notes

- `devx.headwall.tech` is public; the `isp-tick.sh` security cron resets file
  permissions and **breaks `npm install` (chmod EPERM)**. Before a build:
  pause `isp-tick.sh` and `chown` the plugin tree to the dev user; re-enable
  the cron afterwards.
- Build command: `npm install` then `npm run build` (or `npm start` to watch).

---

## Milestones

### Milestone 1: MVP Block Scaffold ⏳

**Status:** In Progress (code complete, browser test pending)
**Priority:** High
**Started:** 18 June 2026

**Goal:** A working, registerable block that lets an editor pick logos from the
Media Library and renders a continuous CSS marquee on the frontend.

**Rationale:**
- Validate the dynamic-block + pure-CSS-marquee approach end to end before
  adding polish.
- Keep the shipped footprint tiny and dependency-free on the frontend.

#### Implementation Checklist

**Phase 1: Plugin Bootstrap**
- [x] `easy-logo-carousel.php` — plugin header, `ABSPATH` guard, constants
      (`ELC_VERSION`, `ELC_DIR`, `ELC_URL`), `require_once` includes
- [x] `constants.php` — block name
- [x] `phpcs.xml` — WordPress ruleset, short-array allowed, prefixes
      (`elc`, `ELC`, `Easy_Logo_Carousel`), exclude `build/`, `node_modules/`
- [x] `.gitignore` — `node_modules/`, OS cruft (`build/` committed)

**Phase 2: Build Toolchain**
- [x] `package.json` with `@wordpress/scripts` (`build`, `start` scripts)
- [x] `npm install` and confirm `wp-scripts build` runs clean

**Phase 3: Block (editor)**
- [x] `src/block.json` — apiVersion 3, attributes, `render` → `render.php`
- [x] `src/index.js` — `registerBlockType`
- [x] `src/edit.js` — `MediaPlaceholder` + `MediaUpload`/`MediaUploadCheck`
      picker (multi-select), `InspectorControls` for speed, pause-on-hover,
      logo height, gap, grayscale
- [x] `src/editor.scss` / `src/style.scss` — the marquee CSS

**Phase 4: Block (frontend render)**
- [x] `render.php` — emit duplicated logo track via `wp_get_attachment_image()`
- [x] `includes/class-plugin.php` — `register_block_type( build dir )`
- [x] `prefers-reduced-motion` fallback (static wrapped row, no animation)

**Phase 5: Quality & i18n**
- [x] `phpcs` clean (4/4, exit 0)
- [x] Plugin activates cleanly (`wp plugin activate easy-logo-carousel`)
- [ ] Strings stay wrapped in i18n functions; `.pot` generation deferred to
      Paul's dedicated translation tool (do NOT run `wp i18n make-pot`)
- [ ] Manual test on https://devx.headwall.tech (add block, pick logos, verify
      seamless loop + hover pause + reduced-motion + grayscale)

---

### Milestone 2: Polish & Options 📋

**Status:** Not Started
**Priority:** Medium

**Goal:** Per-block controls that cover the common logo-strip needs.

**Candidate tasks (to prioritise after MVP):**
- [ ] Scroll direction (LTR / RTL)
- [ ] Logos-per-view hint / responsive sizing
- [ ] Optional link-per-logo
- [ ] Grayscale + hover-to-colour
- [ ] Background/gap/height controls, alignment (wide/full)
- [ ] Block variations (e.g. "Logo strip", "Partner ticker")

---

## Technical Debt

_None yet._

---

## Notes for Development

- Reference plugin for house style: `../bullfix-erp/` (WPCS via `phpcs.xml`,
  underscored namespace, `class-*.php` via explicit `require_once`, prefixed
  constants, `/languages` text domain). Build tooling is the deliberate
  exception for this block plugin.
- Host tooling: `wp` (WP 7.0), `phpcs`/`phpcbf`, Node 22 / npm 11, PHP 8.4.
- Dev site: https://devx.headwall.tech
