<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

$context = Timber::context();

foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

	/**
	 * Filter the product name.
	 *
	 * @since 2.1.0
	 * @param string $product_name Name of the product in the cart.
	 * @param array $cart_item The product in the cart.
	 * @param string $cart_item_key Key for the product in the cart.
	 */
	$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

	if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		if ( ! $product_permalink ) {
			$product_name_in_list = wp_kses_post( $product_name . '&nbsp;' );
		} else {
			$product_name_in_list = wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
		}

		if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
			$backorder_notification = wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
		} else {
			$backorder_notification = false;
		}

		if ( $_product->is_sold_individually() ) {
			$min_quantity = 1;
			$max_quantity = 1;
		} else {
			$min_quantity = 0;
			$max_quantity = $_product->get_max_purchase_quantity();
		}

		$product_quantity = woocommerce_quantity_input(
			array(
				'input_name'   => "cart[{$cart_item_key}][qty]",
				'input_value'  => $cart_item['quantity'],
				'max_value'    => $max_quantity,
				'min_value'    => $min_quantity,
				'product_name' => $product_name,
			),
			$_product,
			false
		);

		$cart_products[] = array(
			'cart_item'              => $cart_item,
			'cart_item_key'          => $cart_item_key,
			'link'                   => $product_permalink,
			'cart_item_class'        => apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ),
			'product_remove'         => apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				'woocommerce_cart_item_remove_link',
				sprintf(
					'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
					esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
					/* translators: %s is the product name */
					esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
					esc_attr( $product_id ),
					esc_attr( $_product->get_sku() )
				),
				$cart_item_key
			),
			'thumbnail'              => apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ),
			'name'                   => $product_name_in_list,
			'meta_data'              => wc_get_formatted_cart_item_data( $cart_item ),
			'backorder_notification' => $backorder_notification,
			'price'                  => apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ), // PHPCS: XSS ok.
			'quantity'               => apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ), // PHPCS: XSS ok.
			'subtotal'               => apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ), // PHPCS: XSS ok.
		);
	}
}

$context['cart_products'] = $cart_products;

do_action( 'woocommerce_before_cart' );

Timber::render( 'woo/cart.twig', $context );

do_action( 'woocommerce_after_cart' );
