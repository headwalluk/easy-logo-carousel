# Developer guide

_For developers who want to hook, extend or build the plugin._

## Architecture at a glance

Easy Logo Carousel is a single **dynamic block**:

- Registered name: `easy-logo-carousel/marquee`.
- The editor (`src/edit.js`) stores the selected logos and settings as block
  attributes.
- The frontend markup is rendered server-side by `src/render.php`, so images
  always resolve through `wp_get_attachment_image()` (responsive `srcset` and
  lazy loading) and the seamless loop can be assembled in PHP.
- The frontend ships only CSS — there is no view-layer JavaScript.

```
easy-logo-carousel.php      Bootstrap: constants + require, boots Plugin.
includes/class-plugin.php   Registers the block from build/ on `init`.
src/                        Block source (compiled by @wordpress/scripts).
  block.json                Block metadata + attribute schema.
  index.js / edit.js        Editor registration and UI.
  render.php                Server-side frontend render.
  style.scss / editor.scss  Frontend and editor styles.
build/                      Compiled output (committed; runs without npm).
```

## Block attributes

| Attribute | Type | Default | Notes |
| --------- | ---- | ------- | ----- |
| `images` | array | `[]` | Objects of `{ id, url, alt }`. `id` is the source of truth; `url`/`alt` are a fallback for missing attachments. |
| `speed` | number | `30` | Seconds for one logo set to scroll past. |
| `repeat` | number | `2` | Copies of the set per half-track. Higher fills wider viewports. |
| `pauseOnHover` | boolean | `true` | Adds `.is-paused-on-hover` to the wrapper. |
| `logoHeight` | number | `48` | Logo height in px (`--elc-logo-height`). |
| `gap` | number | `48` | Gap between logos in px (`--elc-gap`). |
| `grayscale` | boolean | `false` | Adds `.is-grayscale` to the track. |

## How the seamless loop works

The track is rendered as two identical halves, each containing `repeat` copies
of the logo set, and the CSS animates `translateX(0)` → `translateX(-50%)`.
Because `-50%` lands exactly on the start of the second half, the reset is
pixel-identical. The loop only looks continuous while one half is at least as
wide as the viewport — hence the `repeat` control. The animation duration is
`speed × repeat` seconds, which keeps the per-logo velocity constant regardless
of `repeat`.

## Filters

### `elc_logo_image_size`

Change the registered image size used for each logo (default `medium`).

```php
add_filter(
	'elc_logo_image_size',
	function ( $size, $attributes ) {
		return 'large';
	},
	10,
	2
);
```

### `elc_marquee_html`

Filter the complete block markup just before it is output.

```php
add_filter(
	'elc_marquee_html',
	function ( $html, $attributes ) {
		// Wrap the strip, inject a heading, etc.
		return '<div class="my-logo-band">' . $html . '</div>';
	},
	10,
	2
);
```

## Extending in the editor

Because this is a standard block, you can extend it with the usual APIs —
for example, register block styles or variations from your own plugin/theme:

```js
wp.blocks.registerBlockStyle( 'easy-logo-carousel/marquee', {
	name: 'bordered',
	label: 'Bordered',
} );
```

## Build process

Source lives in `src/` and compiles to `build/` with
[`@wordpress/scripts`](https://www.npmjs.com/package/@wordpress/scripts).

```bash
npm install      # once
npm run build    # production build
npm start        # watch mode while developing
npm run lint:js  # lint JS
```

The compiled `build/` directory is committed so the plugin runs without a build
step on the target site. Rebuild and commit `build/` whenever you change
anything in `src/`.

PHP follows the WordPress Coding Standards; run `phpcs` (and `phpcbf` to
autofix) against the included `phpcs.xml` ruleset.
