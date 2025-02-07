<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
$show_terms = apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' );
$context    = Timber::context();

$context['show_terms']    = $show_terms;
$context['terms_checked'] = apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) );

Timber::render( 'woo/order/terms.twig', $context );
