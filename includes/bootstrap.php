<?php
/**
 * Bootstrap file for WooCommerce.
 *
 * @package Jcore\Woo
 */

$context            = Timber::context();
$context['sidebar'] = Timber::get_widgets( 'shop-sidebar' );
$templates          = array();

if ( is_singular( 'product' ) ) {
	$context['post']    = Timber::get_post();
	$product            = wc_get_product( $context['post']->ID );
	$context['product'] = $product;

	// Get related products.
	$related_limit               = wc_get_loop_prop( 'columns' );
	$related_ids                 = wc_get_related_products( $context['post']->id, $related_limit );
	$upsell_ids                  = $product->get_upsell_ids();
	$context['columns']          = $related_limit;
	$context['related_products'] = Timber::get_posts( $related_ids );
	$context['upsell_products']  = Timber::get_posts( $upsell_ids );

	// Restore the context and loop back to the main query loop.
	wp_reset_postdata();

	$templates[] = 'woo/single-product.twig';
} else {
	$context['columns']  = wc_get_loop_prop( 'columns' );
	$products            = Timber::get_posts();
	$context['products'] = $products;

	if ( is_product_taxonomy() ) {
		$queried_object  = get_queried_object();
		$term_id         = $queried_object->term_id;
		$term_taxonomy   = $queried_object->taxonomy;
		$context['term'] = Timber::get_term();
	}

	$templates[] = 'woo/archive.twig';
}

get_header();
Timber::render( $templates, $context );
get_footer();
