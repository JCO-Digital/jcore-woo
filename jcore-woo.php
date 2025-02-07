<?php
/**
 * Plugin Name: Jcore Woo
 * Requires Plugins: woocommerce
 * Plugin URI: https://github.com/jco-digital/jcore-woo
 * Description: WooCommerce integration with JCORE
 * Version: 0.1.0
 * Author: J&Co Digital Oy
 * Author URI: https://jco.fi
 * Domain Path: /languages
 * Text Domain: jcore-woo
 *
 * @package Jcore/Woo
 */

namespace Jcore\Woo;

// Composer autoloader.
if ( is_file( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Constants for the plugin.
require_once __DIR__ . '/consts.php';

// Helper functions for the plugin.
require_once __DIR__ . '/includes/helpers.php';

// Plugin notices.
require_once __DIR__ . '/includes/notices.php';

// Generic handlers for different field types.
require_once __DIR__ . '/includes/fields.php';

// Handles registering the plugin styles and scripts.
require_once __DIR__ . '/includes/assets.php';

// All hooks of the plugin are defined here.
require_once __DIR__ . '/includes/hooks.php';

// Gutenberg blocks.
require_once __DIR__ . '/includes/blocks.php';

// WooCommerce integration.
require_once __DIR__ . '/includes/woocommerce.php';
