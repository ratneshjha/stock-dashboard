<?php
/**
 * Register the "Business" custom post type.
 *
 * @package MithilaBusinessDirectory
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Register the "Business" custom post type.
 */
function mbd_register_post_type() {
    $labels = array(
        'name'               => _x( 'Businesses', 'post type general name', 'mithila-business-directory' ),
        'singular_name'      => _x( 'Business', 'post type singular name', 'mithila-business-directory' ),
        'menu_name'          => _x( 'Businesses', 'admin menu', 'mithila-business-directory' ),
        'name_admin_bar'     => _x( 'Business', 'add new on admin bar', 'mithila-business-directory' ),
        'add_new'            => _x( 'Add New', 'business', 'mithila-business-directory' ),
        'add_new_item'       => __( 'Add New Business', 'mithila-business-directory' ),
        'new_item'           => __( 'New Business', 'mithila-business-directory' ),
        'edit_item'          => __( 'Edit Business', 'mithila-business-directory' ),
        'view_item'          => __( 'View Business', 'mithila-business-directory' ),
        'all_items'          => __( 'All Businesses', 'mithila-business-directory' ),
        'search_items'       => __( 'Search Businesses', 'mithila-business-directory' ),
        'parent_item_colon'  => __( 'Parent Businesses:', 'mithila-business-directory' ),
        'not_found'          => __( 'No businesses found.', 'mithila-business-directory' ),
        'not_found_in_trash' => __( 'No businesses found in Trash.', 'mithila-business-directory' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'business' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'show_in_rest'       => true, // This is important for Gutenberg/Kadence integration.
    );

    register_post_type( 'mbd_business', $args );
}
add_action( 'init', 'mbd_register_post_type' );
