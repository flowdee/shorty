<?php
/*
Plugin Name: Shorty - The Shortcode Manager
Plugin URL: https://wordpress.org/plugins/shorty/
Description: Hey! I'm Shorty, the WordPress Shortcode Manager and your shortcode buddy.
Version: 1.2.3
Author: flowdee
Author URI: https://coder.flowdee.de
Contributors: flowdee
Text Domain: shorty
Domain Path: languages
*/

if ( !defined( 'SHORTY_PLUGIN_DIR' ) ) {
    define( 'SHORTY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'SHORTY_PLUGIN_URL' ) ) {
    define( 'SHORTY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'SHORTY_PLUGIN_FILE' ) ) {
    define( 'SHORTY_PLUGIN_FILE', __FILE__ );
}

/*******************************************
 * global variables
 *******************************************/
global $wpdb;

//$shorty_options = get_option( 'shorty_settings' );

/*******************************************
 * plugin text domain for translations
 *******************************************/
function shorty_load_textdomain() {
    load_plugin_textdomain( 'shorty', false, dirname( plugin_basename( SHORTY_PLUGIN_FILE ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'shorty_load_textdomain' );

/*******************************************
 * plugin admin meta
 *******************************************/
function shorty_plugin_row_meta( $input, $file ) {
    if ( $file != 'shorty/shorty.php' )
        return $input;

    $links = array(
        '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=shortcode&page=shorty-settings') ) .'">' . __('Settings', 'shorty') . '</a>',
        '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=shortcode') ) .'">' . __('Manage Shortcodes', 'shorty') . '</a>'
    );

    $input = array_merge( $input, $links );

    return $input;
}

add_filter( 'plugin_row_meta', 'shorty_plugin_row_meta', 10, 2 );

/*******************************************
 * file includes
 *******************************************/

// global includes
include( SHORTY_PLUGIN_DIR . 'includes/functions.php' );
include( SHORTY_PLUGIN_DIR . 'includes/shortcodes.php' );

// admin only includes
if( is_admin() ) {
    //include( SHORTY_PLUGIN_DIR . 'includes/admin/class.settings.php' );
    include( SHORTY_PLUGIN_DIR . 'includes/admin/manage-posts.php' );
    include( SHORTY_PLUGIN_DIR . 'includes/admin/post-type.php' );
    include( SHORTY_PLUGIN_DIR . 'includes/admin/tinymce/tinymce.php' );
    include( SHORTY_PLUGIN_DIR . 'includes/admin/meta.php' );
}