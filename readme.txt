=== Easy Logo Carousel ===
Contributors: headwall
Tags: logo, carousel, marquee, ticker, block
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

An auto-scrolling, continuously looping marquee of logo images, built as a pure-CSS Gutenberg block with no frontend JavaScript library.

== Description ==

Easy Logo Carousel adds a single Gutenberg block — **Logo Carousel** — that
displays a continuous, looping strip of logos selected from your Media Library.
It's the classic "trusted by…" / partner logo ticker, done leanly.

The frontend is a **pure CSS marquee**. No jQuery, no Swiper, no carousel
library is enqueued — just a small stylesheet and the rendered markup, so it
stays fast and dependency-free.

Features:

* Familiar Media Library picker (multi-select).
* Continuous, seamless scrolling.
* Per-block settings: scroll speed, pause on hover, logo height, gap, greyscale.
* "Repeat logo set" control to keep the loop seamless with few or small logos.
* Respects the visitor's `prefers-reduced-motion` setting.
* Responsive images with `srcset` and lazy loading.
* No frontend JavaScript.

== Installation ==

1. Upload the `easy-logo-carousel` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Add the **Logo Carousel** block to any post or page and select your logos.

== Frequently Asked Questions ==

= I see a gap before the loop repeats. How do I fix it? =

The seamless loop needs enough logos to fill the width of the strip. Open the
block's **Advanced** panel and increase **Repeat logo set** until the gap is
gone. This is most often needed when you have only a few logos, or small ones,
on a wide layout.

= Does it load any JavaScript on the front end? =

No. The scrolling is done entirely in CSS.

= Can I style it myself? =

Yes — the markup exposes stable CSS classes and custom properties. See the
styling guide in the plugin's `docs/` folder.

== Changelog ==

= 0.1.0 =
* Initial release: Logo Carousel block with pure-CSS marquee, Media Library
  picker, and controls for speed, pause-on-hover, logo height, gap, greyscale
  and repeat count.
