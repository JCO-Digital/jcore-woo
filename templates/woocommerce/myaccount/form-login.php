<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$context = Timber::context();

$context['woo_username']      = ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; // @codingStandardsIgnoreLine
$context['woo_email']         = ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; // @codingStandardsIgnoreLine
$context['notices']           = ( function_exists( 'wc_print_notices' ) ) ? wc_print_notices( true ) : '';
$context['enable_register']   = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );
$context['generate_username'] = 'yes' === get_option( 'woocommerce_registration_generate_username' );
$context['generate_password'] = 'yes' === get_option( 'woocommerce_registration_generate_password' );

do_action( 'woocommerce_before_customer_login_form' );

Timber::render( 'woo/login.twig', $context );

do_action( 'woocommerce_after_customer_login_form' );
