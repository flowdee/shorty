<?php
/**
 * Post Type
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Register Custom Post Type
function shorty_init_post_type() {

    $labels = array(
        'name'                => _x( 'Shortcodes', 'Post Type General Name', 'shorty' ),
        'singular_name'       => _x( 'Shortcode', 'Post Type Singular Name', 'shorty' ),
        'menu_name'           => __( 'Shorty', 'shorty' ),
        'name_admin_bar'      => __( 'Shortcode', 'shorty' ),
        'parent_item_colon'   => __( 'Parent Shortcode:', 'shorty' ),
        'all_items'           => __( 'All Shortcodes', 'shorty' ),
        'add_new_item'        => __( 'Add New Shortcode', 'shorty' ),
        'add_new'             => __( 'Add New', 'shorty' ),
        'new_item'            => __( 'New Shortcode', 'shorty' ),
        'edit_item'           => __( 'Edit Shortcode', 'shorty' ),
        'update_item'         => __( 'Update Shortcode', 'shorty' ),
        'view_item'           => __( 'View Shortcode', 'shorty' ),
        'search_items'        => __( 'Search Shortcode', 'shorty' ),
        'not_found'           => __( 'Not found', 'shorty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'shorty' ),
    );
    $args = array(
        'label'               => __( 'Shortcode', 'shorty' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 100,
        'menu_icon'           => 'dashicons-clipboard',
        'show_in_admin_bar'   => false,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'shortcode', $args );

}
add_action( 'init', 'shorty_init_post_type', 0 );