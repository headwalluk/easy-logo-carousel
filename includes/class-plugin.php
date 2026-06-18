<?php
/**
 * Plugin core.
 *
 * @package EasyLogoCarousel
 */

namespace Easy_Logo_Carousel;

defined( 'ABSPATH' ) || die();

/**
 * Registers the marquee block and supporting hooks.
 */
class Plugin {

	/**
	 * Hook the plugin into WordPress.
	 */
	public function run(): void {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	/**
	 * Register the block from its compiled block.json metadata.
	 *
	 * The build directory contains block.json plus the compiled scripts,
	 * styles and the render.php template referenced by it.
	 */
	public function register_block(): void {
		register_block_type( ELC_DIR . 'build' );
	}
}
