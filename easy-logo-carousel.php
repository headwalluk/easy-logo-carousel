<?php
/**
 * Plugin Name:       Easy Logo Carousel
 * Plugin URI:        https://headwall-hosting.com/
 * Description:       A lightweight Gutenberg block for an auto-scrolling, continuously looping marquee of logo images from the Media Library. Pure CSS, no frontend JavaScript library.
 * Version:           0.1.0
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Author:            Paul Faulkner
 * Author URI:        https://headwall-hosting.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       easy-logo-carousel
 * Domain Path:       /languages
 *
 * @package EasyLogoCarousel
 */

defined( 'ABSPATH' ) || die();

const ELC_NAME    = 'easy-logo-carousel';
const ELC_VERSION = '0.1.0';

define( 'ELC_DIR', plugin_dir_path( __FILE__ ) );
define( 'ELC_URL', plugin_dir_url( __FILE__ ) );

// Load constants and plugin classes.
require_once ELC_DIR . 'constants.php';
require_once ELC_DIR . 'includes/class-plugin.php';

/**
 * Boot the plugin.
 */
function elc_run() {
	$plugin = new Easy_Logo_Carousel\Plugin();
	$plugin->run();
}
elc_run();
