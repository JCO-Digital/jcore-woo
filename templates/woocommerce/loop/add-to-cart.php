<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$aria_describedby      = isset( $args['aria-describedby_text'] );
$aria_describedby_text = $aria_describedby ? sprintf( 'aria-describedby="woocommerce_loop_add_to_cart_link_describedby_%s"', esc_attr( $product->get_id() ) ) : '';

$context                          = Timber::context();
$context['product']               = $product;
$context['args']                  = $args;
$context['aria_describedby']      = $aria_describedby;
$context['aria_describedby_text'] = $aria_describedby_text;

Timber::render( 'woo/loop/add_to_cart.twig', $context );
