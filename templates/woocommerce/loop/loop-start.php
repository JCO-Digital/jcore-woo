<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

use Timber\Timber;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$context            = Timber::context();
$context['columns'] = wc_get_loop_prop( 'columns' );

Timber::render( 'woo/loop/loop-start.twig', $context );
