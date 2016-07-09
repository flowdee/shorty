<?php
/**
 * Shortcodes
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Register shortcodes
function shorty_register_shortcodes() {

    $shortcodes = shorty_get_shortcodes();

    if ( $shortcodes && sizeof($shortcodes) != 0 ) {

        foreach ( $shortcodes as $shortcode ) {

            if (empty($shortcode['slug']) || empty($shortcode['content']))
                continue;

            $slug = $shortcode['slug'];
            $content = $shortcode['content'];

            // Return final shortcode content
            $function = function() use ($content) {
                return do_shortcode($content);
            };

            // Finish
            add_shortcode( $slug, $function );
        }
    }
}

add_action('init', 'shorty_register_shortcodes');

// Loop setup shortcodes
function shorty_get_shortcodes() {

    $shortcodes = array();

    // Args
    $args = array( 'post_type' => array( 'shortcode' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );

    $shortcodes_setup = get_posts( $args );
    foreach ( $shortcodes_setup as $shortcode ) : setup_postdata( $shortcode );

        $wpautop = apply_filters( 'shorty_wpautop_shortcode_content', true, $shortcode->ID );

        $content = ( true === $wpautop ) ? wpautop( $shortcode->post_content ) : $shortcode->post_content;

        $shortcodes[] = array(
            'id' => $shortcode->ID,
            'slug' => apply_filters( 'shorty_get_shortcode_slug', $shortcode->post_name ),
            'title' => $shortcode->post_title,
            'content' => apply_filters( 'shorty_get_shortcode_content', $content )
        );

    endforeach;

    wp_reset_postdata();

    return $shortcodes;
}

/*
 * Replace hyphens with underscores to avoid wp shortcode rendering issues
 */
function shorty_replace_hyphens_with_underscores( $slug ) {

    $slug = str_replace( '-', '_', $slug );

    return $slug;
}

add_filter( 'shorty_get_shortcode_slug', 'shorty_replace_hyphens_with_underscores' );
add_filter( 'shorty_admin_display_shortcode', 'shorty_replace_hyphens_with_underscores' );

// Add prefix
function shorty_add_prefix( $slug ) {

    global $shorty_options;

    $slug = ( !empty($shorty_options['prefix']) ) ? $shorty_options['prefix'] . $slug : $slug;

    return $slug;
}

//add_filter( 'shorty_add_shortcode_slug', 'shorty_add_prefix' );
//add_filter( 'shorty_admin_display_shortcode', 'shorty_add_prefix' );