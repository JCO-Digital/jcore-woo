<?php
/**
 * Helper functions for the plugin.
 *
 * @package Jcore\Woo
 */

namespace Jcore\Woo;

/**
 * Register script wrapper.
 *
 * @param string $name Script name.
 * @param string $file Filename.
 * @param array  $dependencies Dependencies.
 * @param string $version Optional version number.
 */
function script_register( string $name, string $file, array $dependencies = array(), string $version = '' ): void {
	$info = get_file_info( $file, $version );

	if ( false !== $info ) {
		wp_register_script(
			$name,
			$info['uri'],
			$dependencies,
			$info['version'],
			true
		);
	}
}

/**
 * Register style wrapper.
 *
 * @param string $name Style name.
 * @param string $file Filename.
 * @param array  $dependencies Dependencies.
 * @param string $version Optional version number.
 */
function style_register( string $name, string $file, array $dependencies = array(), string $version = '' ): void {
	$info = get_file_info( $file, $version );

	if ( false !== $info ) {
		wp_register_style(
			$name,
			$info['uri'],
			$dependencies,
			$info['version']
		);
	}
}

/**
 * Get file info for script/style registration.
 *
 * @param string $file Filename.
 * @param string $version Optional version number.
 *
 * @return bool|string[]
 */
function get_file_info( string $file, string $version = '' ): array|bool {
	if ( ! empty( $version ) ) {
		$version .= '-';
	}
	$location = array(
		'path' => join_path( untrailingslashit( JCORE_WOO_PLUGIN_PATH ), $file ),
		'uri'  => join_path( untrailingslashit( JCORE_WOO_PLUGIN_URI ), $file ),
	);
	if ( file_exists( $location['path'] ) ) {
		$version .= filemtime( $location['path'] );

		return array(
			'uri'     => $location['uri'],
			'path'    => $location['path'],
			'version' => $version,
		);
	}
	return false;
}

/**
 * A function that joins together all parts of a path.
 *
 * @param string $path Base path.
 * @param string ...$parts Path parts to be joined.
 *
 * @return string
 */
function join_path( string $path, string ...$parts ): string {
	foreach ( $parts as $part ) {
		$path .= '/' . trim( $part, '/ ' );
	}

	return $path;
}

/**
 * Can be used to render a template file.
 *
 * @param string $template The template file name. E.g. "my-template".
 * @param array  $data An array of data to be passed to the template. Will be available as $rek_my_variable.
 *
 * @return string
 */
function render_template( string $template, array $data = array() ): string {
	$final_path = sprintf( '%s/views/%s.php', untrailingslashit( JCORE_WOO_PLUGIN_PATH ), $template );
	if ( ! file_exists( $final_path ) ) {
		return '';
	}
	ob_start();
	extract( $data, EXTR_PREFIX_ALL, 'jcore_woo' ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
	require $final_path;
	return ob_get_clean();
}

/**
 * Set product in single products correctly.
 *
 * @param \Timber\Post $post Timber post object.
 *
 * @return void
 */
function timber_set_product( $post ) {
	global $product;

	if ( $post->post_type === 'product' ) {
		$product = wc_get_product( $post->ID );
	}
}

/**
 * Render jcore tease-product in WooCommerce product block.
 *
 * @param string $html    The html of the product tease.
 * @param object $data    Parameters saved in gutenberg.
 * @param object $product The product object.
 *
 * @return string|bool
 */
function custom_render_product_block( string $html, object $data, object $product ): string|bool {
	$context = \Timber::context();

	$context['post']    = \Timber::get_Post( $product->get_id() );
	$context['product'] = $product;
	$context['grid']    = $data;

	return \Timber::compile( 'woo/partials/tease-product-gridblock.twig', $context );
}

/**
 *  Add custom actions to the order actions
 *
 * @param array $actions The available order actions for the order.
 * @param \WC_Order $order The WooCommerce Order.
 *
 * @return array
 */
function edit_order_actions( array $actions, \WC_Order $order ): array {
	if ( $order->has_status( wc_get_is_paid_statuses() ) ) {
		$actions['view_thankyou'] = __( 'Display thank you page', 'jcore' );
	}

	return $actions;
}

/**
 * Add functionality to resend_order_completed_email action
 *
 * @param \WC_Order $order The WooCommerce Order.
 *
 * @return void
 */
function view_order_thank_you_page( \WC_Order $order ): void {
	$url = $order->get_checkout_order_received_url();
	if ( wp_safe_redirect( $url ) ) {
		exit;
	}
}
