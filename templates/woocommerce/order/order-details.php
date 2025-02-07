<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

// phpcs:disable WooCommerce.Commenting.CommentHooks.MissingHookComment

defined( 'ABSPATH' ) || exit;

if ( isset( $order_id ) && $order_id > 0 ) {
	$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
}

if ( ! $order ) {
	return;
}

$context                       = Timber::context();
$context['order']              = $order;
$context['order_items']        = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$context['show_purchase_note'] = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$context['downloads']          = $order->get_downloadable_items();

// We make sure the order belongs to the user. This will also be true if the user is a guest, and the order belongs to a guest (userID === 0).
$context['show_customer_details'] = $order->get_user_id() === get_current_user_id();

// Backwards compatibility for Woo < 8.5.0.
if ( ! isset( $show_downloads ) ) {
	$show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();
}
$context['show_downloads'] = $show_downloads;

if ( $context['show_downloads'] ) { // TODO: Replace this if jcore gets order-downloads.
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $context['downloads'],
			'show_title' => true,
		)
	);
}

if ( $order->get_customer_note() ) {
	$context['customer_note'] = wp_kses( nl2br( wptexturize( $order->get_customer_note() ) ), array() );
}

Timber::render( 'woo/order/order-details.twig', $context );
