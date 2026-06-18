# Styling guide

_For designers who want CSS control over the strip._

The block ships a small, intentionally light stylesheet so it inherits your
theme. Everything below is stable and safe to target from your theme or from
the block's **Advanced → Additional CSS class(es)** field.

## Markup structure

```html
<div class="wp-block-easy-logo-carousel-marquee is-paused-on-hover"
     style="--elc-duration:60s;--elc-gap:48px;--elc-logo-height:48px;">
  <div class="elc-marquee">
    <ul class="elc-track is-grayscale">
      <li class="elc-item"><img … /></li>
      <li class="elc-item"><img … /></li>
      <!-- repeated/cloned copies, the extras marked aria-hidden -->
    </ul>
  </div>
</div>
```

## CSS classes

| Class | Element |
| ----- | ------- |
| `.wp-block-easy-logo-carousel-marquee` | Outer block wrapper. |
| `.is-paused-on-hover` | Added to the wrapper when "Pause on hover" is on. |
| `.elc-marquee` | The clipped viewport (`overflow: hidden`). |
| `.elc-track` | The flex row that scrolls. |
| `.elc-track.is-grayscale` | Added when "Greyscale logos" is on. |
| `.elc-item` | One logo's list item. |

## CSS custom properties

These are set inline from the block's settings, so you can read or override
them in your own CSS:

| Property | Meaning |
| -------- | ------- |
| `--elc-duration` | Time for one half of the track to scroll (drives the animation). |
| `--elc-gap` | Gap between logos. |
| `--elc-logo-height` | Logo height. |

The animation itself is the `elc-scroll` keyframe (`translateX(0)` →
`translateX(-50%)`).

## Examples

**Fade the left and right edges**

```css
.wp-block-easy-logo-carousel-marquee .elc-marquee {
	-webkit-mask-image: linear-gradient(to right, transparent, #000 8%, #000 92%, transparent);
	        mask-image: linear-gradient(to right, transparent, #000 8%, #000 92%, transparent);
}
```

**Give the strip a background band**

```css
.wp-block-easy-logo-carousel-marquee {
	background: #f6f7f9;
	padding-block: 1.5rem;
}
```

**Tweak the greyscale dim level**

```css
.wp-block-easy-logo-carousel-marquee .elc-track.is-grayscale .elc-item img {
	opacity: 0.6;
}
```

## Accessibility & motion

- Cloned copies beyond the first set are marked `aria-hidden="true"`, so screen
  readers announce each logo only once.
- Under `@media (prefers-reduced-motion: reduce)` the animation is disabled and
  the logos wrap into a static, centred row. Keep this behaviour intact for
  motion-sensitive visitors.

For block attributes and PHP hooks, see the [developer guide](developers.md).
