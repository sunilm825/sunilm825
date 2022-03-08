<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */

if ( ! function_exists( 'viitorcloud_setup' ) ) :
	function viitorcloud_setup() {	
		add_theme_support( 'title-tag' );	
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce' );
		register_nav_menus( array(
			'header_menu'      		=> __( 'Header Menu', 'viitorcloud' ),
			'quick_link_menu'       => __( 'Quick Link Menu', 'viitorcloud' ),
			'service_menu'       	=> __( 'Service Menu', 'viitorcloud' ),
		) );
	}
	endif;
	add_action( 'after_setup_theme', 'viitorcloud_setup' );

	include get_template_directory() . '/inc/custom-functions.php';
	include get_template_directory() . '/inc/aq_resizer.php';
	include get_template_directory() . '/inc/custom-posttypes.php';
	include get_template_directory() . '/inc/custom-breadcrumb.php';
