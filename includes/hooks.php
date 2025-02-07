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
		// WooCommerce hooks.
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		// Fix for cross_sell_display with Timber do_action adding context to action automatically.
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 5, 4 );

		add_filter( 'woocommerce_blocks_product_grid_item_html', 'Jcore\Woo\custom_render_product_block', 10, 3 );
		add_filter( 'woocommerce_order_actions', 'Jcore\Woo\edit_order_actions', 10, 2 );
		add_action( 'woocommerce_order_action_view_thankyou', 'Jcore\Woo\view_order_thank_you_page' );

		add_filter( 'wc_get_template', 'Jcore\Woo\override_woocommerce_templates', 10, 2 );
		add_filter( 'wc_get_template_part', 'Jcore\Woo\override_woocommerce_template_parts', 10, 3 );
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

add_action(
	'after_setup_theme',
	'Jcore\Woo\add_woocommerce_support'
);

add_filter(
	'timber/locations',
	function ( $locations ) {
		$locations[] = array( trailingslashit( JCORE_WOO_PLUGIN_PATH ) . 'views' );

		return $locations;
	}
);
