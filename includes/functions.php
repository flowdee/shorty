<?php
/**
 * Functions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

function shorty_inline_shortcodes( $wpautop, $shortcode_id ) {

    $inline = get_post_meta( $shortcode_id, 'shorty_shortcode_inline', true);

    if ( '1' == $inline )
        $wpautop = false;

    return $wpautop;
}
add_filter( 'shorty_wpautop_shortcode_content', 'shorty_inline_shortcodes', 10, 2 );