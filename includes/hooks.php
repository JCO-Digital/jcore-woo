<?php
/**
 * Hooks for the plugin.
 *
 * @package Jcore\Woo
 */

namespace Jcore\Woo;

// Initializes all classes.
add_action(
	'plugins_loaded',
	static function () {
	}
);

add_action(
	'init',
	'Jcore\Woo\register_plugin_assets'
);


add_action(
	'admin_notices',
	'Jcore\Woo\handle_notices'
);
