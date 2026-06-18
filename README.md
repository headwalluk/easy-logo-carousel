# Easy Logo Carousel

![Version](https://img.shields.io/badge/version-1.0.0-brightgreen.svg)
![WordPress](https://img.shields.io/badge/WordPress-6.5%2B-21759b.svg?logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb4.svg?logo=php&logoColor=white)
![License](https://img.shields.io/badge/license-GPLv2%2B-blue.svg)

A lightweight Gutenberg block that displays an auto-scrolling, continuously
looping marquee of logo images picked from the Media Library — the classic
"trusted by…" logo strip.

The frontend is a **pure CSS marquee**: no jQuery, no Swiper, no carousel
library is loaded. Just a small stylesheet and the rendered markup.

**Who it's for:** site builders who want a tidy logo strip in a few clicks,
designers who want full CSS control, and developers who want a clean, hookable
block to extend.

## Features

- Pick logos with the familiar Media Library picker (multi-select).
- Continuous, seamless scrolling — no arrows, dots or drag.
- Per-block controls: scroll speed, pause-on-hover, logo height, gap, greyscale.
- "Repeat logo set" control to keep the loop seamless with few or small logos.
- Respects `prefers-reduced-motion` (falls back to a static row).
- Responsive images via `wp_get_attachment_image()` (`srcset`, lazy loading).
- Zero frontend JavaScript.

## Documentation

| Guide | For |
| ----- | --- |
| [Usage guide](docs/usage.md) | Site builders & content editors — adding the block and what each setting does. |
| [Styling guide](docs/styling.md) | Designers — markup structure, CSS classes and custom properties for full visual control. |
| [Developer guide](docs/developers.md) | Developers — architecture, block attributes, filters, and the build process. |

## Requirements

- WordPress 6.5+
- PHP 8.0+

## Installation

1. Copy the `easy-logo-carousel` folder into `wp-content/plugins/`.
2. Activate **Easy Logo Carousel** in **Plugins**.
3. Add the **Logo Carousel** block to any post or page.

The compiled assets in `build/` are committed, so no build step is required to
run the plugin. To work on the source, see the [Developer guide](docs/developers.md).

## License

GPLv2 or later — see [LICENSE](LICENSE).
