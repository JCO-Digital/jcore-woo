<?php
/**
 * WooCommerce functions.
 *
 * @package Jcore\Woo
 */

namespace Jcore\Woo;

/**
 * Add WooCommerce theme support.
 *
 * @return void
 */
function add_woocommerce_support(): void {

	if ( ! defined( 'WOOCOMMERCE_SETTINGS' ) ) {
		define(
			'WOOCOMMERCE_SETTINGS',
			array(
				'zoom'     => true,
				'lightbox' => true,
				'slider'   => true,
			)
		);
	}

	add_theme_support(
		'woocommerce',
		array(
			'product_grid'   => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 10,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
			'product_blocks' => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 10,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
		)
	);

	if ( class_exists( 'woocommerce' ) ) {
		if ( WOOCOMMERCE_SETTINGS['zoom'] ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}
		if ( WOOCOMMERCE_SETTINGS['lightbox'] ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
		if ( WOOCOMMERCE_SETTINGS['slider'] ) {
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}
}

/**
 * Add custom template path to WooCommerce.
 *
 * @param string $located The path to the template.
 * @param string $template_name The name of the template.
 *
 * @return string
 */
function override_woocommerce_templates( string $located, string $template_name ): string {
	$plugin_path = trailingslashit( JCORE_WOO_PLUGIN_PATH ) . 'templates/woocommerce/';
	// Check if the template exists in the theme.
	$theme_template = locate_template( array( 'woocommerce/' . $template_name, $template_name ) );
	// If the template does not exist in the theme, use the plugin template.
	if ( empty( $theme_template ) && file_exists( $plugin_path . $template_name ) ) {
		$located = $plugin_path . $template_name;
	}

	return $located;
}

/**
 * Add custom template part path to WooCommerce.
 *
 * @param string $located The path to the template part.
 * @param string $slug Template slug.
 * @param string $name Template name.
 *
 * @return string
 */
function override_woocommerce_template_parts( string $located, string $slug, string $name ): string {
	$plugin_path = trailingslashit( JCORE_WOO_PLUGIN_PATH ) . 'templates/woocommerce/';

	if ( $name ) {
		$template = "{$slug}-{$name}.php";
	} else {
		$template = "{$slug}.php";
	}
	// Check if the template part exists in the theme.
	$theme_template = locate_template(
		array(
			'woocommerce/' . untrailingslashit( $template ),
		)
	);

	// If the template part does not exist in the theme, use the plugin template part.
	if ( empty( $theme_template ) && file_exists( $plugin_path . $template ) ) {
		$located = $plugin_path . $template;
	}

	return $located;
}
