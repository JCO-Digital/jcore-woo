<?php
/**
 * Registers the assets for the plugin.
 *
 * @package Jcore\Woo
 */

namespace Jcore\Woo;

/**
 * Handles registering the plugin styles and scripts.
 * These can be enqueued by the plugin as needed.
 *
 * @return void
 */
function register_plugin_assets(): void {
		style_register(
			'jcore-woo-frontend',
			'dist/css/index.css',
		);
		style_register(
			'jcore-woo-admin',
			'dist/css/admin.css',
			array( 'wp-components' )
		);
		script_register(
			'jcore-woo-backend',
			'dist/js/admin.js'
		);
}
