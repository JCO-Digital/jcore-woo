<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}

$context = Timber::context();

// WC context.
$context['needs_payment']            = WC()->cart->needs_payment();
$context['customer_billing_country'] = WC()->customer->get_billing_country();
// Globals.
$context['available_gateways']           = $available_gateways;
$context['no_available_gateways_notice'] = wc_print_notice( apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ), 'notice', array(), true ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
$context['order_button_text']            = $order_button_text;
$context['theme_button_class']           = esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' );

Timber::render( 'woo/checkout/payment.twig', $context );

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
