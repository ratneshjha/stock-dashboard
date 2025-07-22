<?php
/**
 * Register the "Business Category" custom taxonomy.
 *
 * @package MithilaBusinessDirectory
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Register the "Business Category" custom taxonomy.
 */
function mbd_register_taxonomy() {
    $labels = array(
        'name'              => _x( 'Business Categories', 'taxonomy general name', 'mithila-business-directory' ),
        'singular_name'     => _x( 'Business Category', 'taxonomy singular name', 'mithila-business-directory' ),
        'search_items'      => __( 'Search Business Categories', 'mithila-business-directory' ),
        'all_items'         => __( 'All Business Categories', 'mithila-business-directory' ),
        'parent_item'       => __( 'Parent Business Category', 'mithila-business-directory' ),
        'parent_item_colon' => __( 'Parent Business Category:', 'mithila-business-directory' ),
        'edit_item'         => __( 'Edit Business Category', 'mithila-business-directory' ),
        'update_item'       => __( 'Update Business Category', 'mithila-business-directory' ),
        'add_new_item'      => __( 'Add New Business Category', 'mithila-business-directory' ),
        'new_item_name'     => __( 'New Business Category Name', 'mithila-business-directory' ),
        'menu_name'         => __( 'Business Categories', 'mithila-business-directory' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'business-category' ),
        'show_in_rest'      => true, // This is important for Gutenberg/Kadence integration.
    );

    register_taxonomy( 'mbd_business_category', array( 'mbd_business' ), $args );
}
add_action( 'init', 'mbd_register_taxonomy' );
