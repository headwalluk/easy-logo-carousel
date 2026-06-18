<?php
/**
 * Plugin-wide constants and default values.
 *
 * Attribute defaults live in src/block.json (the single source of truth for the
 * block). The values here are for PHP-side reference and future growth.
 *
 * @package EasyLogoCarousel
 */

defined( 'ABSPATH' ) || die();

// Registered block name.
const ELC_BLOCK_NAME = 'easy-logo-carousel/marquee';

// GitHub updater: the repository releases are pulled from, the cache key for
// the latest-release lookup, and how long that lookup is cached.
const ELC_UPDATER_GITHUB_REPO = 'headwalluk/easy-logo-carousel';
const ELC_UPDATER_CACHE_KEY   = 'elc_github_release';
const ELC_UPDATER_CACHE_TTL   = 6 * HOUR_IN_SECONDS;
