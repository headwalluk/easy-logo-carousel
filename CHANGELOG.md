# Changelog

All notable changes to Easy Logo Carousel are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.0] - 2026-06-18

Initial release.

### Added

- **Logo Carousel** block (`easy-logo-carousel/marquee`) — an auto-scrolling,
  continuously looping marquee of Media Library logos.
- Pure CSS marquee with no frontend JavaScript library.
- Media Library picker (multi-select) and a Block Toolbar "Edit images" button.
- Inspector controls: scroll speed (seconds per logo set), pause on hover,
  logo height, gap and greyscale.
- Advanced "Repeat logo set" control so the loop stays seamless with few or
  small logos.
- `prefers-reduced-motion` fallback to a static, wrapped row.
- Responsive images via `wp_get_attachment_image()` (`srcset`, lazy loading).
- Developer filters: `elc_logo_image_size` and `elc_marquee_html`.
- GitHub self-updater: serves plugin updates from the repository's Releases
  (toggleable via the `elc_updater_enabled` filter), plus a tag-triggered
  GitHub Actions workflow that builds and publishes the release zips.
- Translations for en_GB, fr_FR, de_DE and es_ES (generated with wp-translate).

[0.1.0]: https://github.com/headwalluk/easy-logo-carousel/releases/tag/v0.1.0
