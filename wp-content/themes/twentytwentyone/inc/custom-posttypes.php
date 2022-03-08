<?php
/* Creating a function to create our CPT */
 
function custom_post_type_products() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Products', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Product', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Product', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Parent Product', 'twentythirteen' ),
        'all_items'           => __( 'All Products', 'twentythirteen' ),
        'view_item'           => __( 'View Product', 'twentythirteen' ),
        'add_new_item'        => __( 'Add New Product', 'twentythirteen' ),
        'add_new'             => __( 'Add New', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Product', 'twentythirteen' ),
        'update_item'         => __( 'Update Product', 'twentythirteen' ),
        'search_items'        => __( 'Search Product', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'Product', 'twentythirteen' ),
        'description'         => __( 'Product news and reviews', 'twentythirteen' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title','thumbnail','editor', 'excerpt'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
		'rewrite' 			  => array('slug' => 'our-products','with_front' => false),
		'menu_icon'  		  => 'dashicons-admin-tools',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'products', $args );
 
}
add_action( 'init', 'custom_post_type_products', 0 );

/*
* Creating a function to create our CPT
*/
 
function custom_post_type_testimonials() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Testimonials', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Testimonials', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Parent Testimonial', 'twentythirteen' ),
        'all_items'           => __( 'All Testimonials', 'twentythirteen' ),
        'view_item'           => __( 'View Testimonial', 'twentythirteen' ),
        'add_new_item'        => __( 'Add New Testimonial', 'twentythirteen' ),
        'add_new'             => __( 'Add New', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Testimonial', 'twentythirteen' ),
        'update_item'         => __( 'Update Testimonial', 'twentythirteen' ),
        'search_items'        => __( 'Search Testimonial', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'Testimonials', 'twentythirteen' ),
        'description'         => __( 'Testimonial news and reviews', 'twentythirteen' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
		'rewrite' 			  => array('slug' => 'testimonials','with_front' => false),
		'menu_icon'  		  => 'dashicons-testimonial',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'testimonials', $args );
 
}


add_action( 'init', 'custom_post_type_testimonials', 0 ); 
?>