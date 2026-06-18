<?php
/**
 * Server-side render for the Easy Logo Carousel marquee block.
 *
 * @package EasyLogoCarousel
 *
 * @var array    $attributes The block attributes.
 * @var string   $content    The block default content (unused).
 * @var WP_Block $block      The block instance.
 */

defined( 'ABSPATH' ) || die();

$elc_images = ( isset( $attributes['images'] ) && is_array( $attributes['images'] ) )
	? $attributes['images']
	: array();

// Nothing to show without images.
if ( empty( $elc_images ) ) {
	return '';
}

$elc_speed          = isset( $attributes['speed'] ) ? (int) $attributes['speed'] : 30;
$elc_logo_height    = isset( $attributes['logoHeight'] ) ? (int) $attributes['logoHeight'] : 48;
$elc_gap            = isset( $attributes['gap'] ) ? (int) $attributes['gap'] : 48;
$elc_pause_on_hover = ! empty( $attributes['pauseOnHover'] );
$elc_grayscale      = ! empty( $attributes['grayscale'] );

/**
 * Build the markup for one copy of the logo set.
 *
 * @param array $images Image records ( id, url, alt ).
 * @param bool  $hidden Whether this copy is the decorative duplicate.
 * @return string List-item markup.
 */
$elc_render_items = static function ( array $images, bool $hidden ): string {
	$html = '';

	foreach ( $images as $image ) {
		$image_id = isset( $image['id'] ) ? (int) $image['id'] : 0;
		$img_html = '';

		// Prefer the attachment ID so we get responsive srcset + lazy loading.
		if ( $image_id > 0 ) {
			$img_html = wp_get_attachment_image(
				$image_id,
				'medium',
				false,
				array(
					'loading'  => 'lazy',
					'decoding' => 'async',
				)
			);
		}

		// Fall back to a stored URL if the attachment has gone missing.
		if ( '' === $img_html && ! empty( $image['url'] ) ) {
			$img_html = sprintf(
				'<img src="%1$s" alt="%2$s" loading="lazy" decoding="async" />',
				esc_url( $image['url'] ),
				esc_attr( isset( $image['alt'] ) ? $image['alt'] : '' )
			);
		}

		if ( '' === $img_html ) {
			continue;
		}

		$html .= sprintf(
			'<li class="elc-item"%1$s>%2$s</li>',
			$hidden ? ' aria-hidden="true"' : '',
			$img_html
		);
	}

	return $html;
};

$elc_wrapper_classes = array();
if ( $elc_pause_on_hover ) {
	$elc_wrapper_classes[] = 'is-paused-on-hover';
}

$elc_wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => implode( ' ', $elc_wrapper_classes ),
		'style' => sprintf(
			'--elc-duration:%1$ds;--elc-gap:%2$dpx;--elc-logo-height:%3$dpx;',
			$elc_speed,
			$elc_gap,
			$elc_logo_height
		),
	)
);

$elc_track_class = 'elc-track' . ( $elc_grayscale ? ' is-grayscale' : '' );

// Two identical copies of the set give a seamless -50% loop.
$elc_track_html = $elc_render_items( $elc_images, false ) . $elc_render_items( $elc_images, true );

// All component parts are individually escaped above.
printf(
	'<div %1$s><div class="elc-marquee"><ul class="%2$s">%3$s</ul></div></div>',
	$elc_wrapper_attributes, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() returns escaped attributes.
	esc_attr( $elc_track_class ),
	$elc_track_html // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Built from escaped wp_get_attachment_image() / esc_* output.
);
