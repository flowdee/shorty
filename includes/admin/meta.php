<?php
/**
 * Meta
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/*
 * Add metabox
 */
function shorty_add_meta_box() {

    add_meta_box('shorty_shortcode_details',
        __( 'Shortcode Details', 'shorty' ),
        'shorty_load_meta_box',
        'shortcode',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'shorty_add_meta_box', 1);

/*
 * Output HTML
 */
function shorty_load_meta_box() {

    global $post;

    // Get values
    $inline = get_post_meta($post->ID, 'shorty_shortcode_inline', true);

    ?>
    <input type="hidden" name="shorty_meta_noncename" id="shorty_meta_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />

    <p>
        <input type="checkbox" id="shorty_shortcode_inline" name="shorty_shortcode_inline" value="1" class="widefat" <?php if ( $inline == "1" ) echo "checked"; ?>/>
        <label for="shorty_shortcode_inline"><?php _e( 'Inline Shortcode', 'shorty'); ?></label>
        <br />
        <small><?php _e( 'Removing paragraphs around the output.', 'shorty'); ?></small>
    </p>

    <?php
}

/*
 * Save data
 */
function shorty_save_meta( $post_id, $post ) {

    if ( !isset ($_POST['shorty_meta_noncename']))
        return $post->ID;

    // verify this came from the our screen and with proper authorization, because save_post can be triggered at other times
    if ( ! wp_verify_nonce( $_POST['shorty_meta_noncename'], plugin_basename(__FILE__) ) ) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( ! current_user_can( 'edit_post', $post->ID ) ) {
        return $post->ID;
    }

    // OK, we're authenticated: we need to find and save the data
    $shorty_meta = array();

    if ( isset ( $_POST['shorty_shortcode_inline'] ) )
        $shorty_meta['shorty_shortcode_inline'] = $_POST['shorty_shortcode_inline'];

    //Add values of coupons meta as custom fields
    foreach ( $shorty_meta as $key => $value ) {

        if ( $post->post_type == 'revision' ) {
            return; //Don't store custom data twice
        }
        if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else {
            add_post_meta($post->ID, $key, $value); // If the custom field doesn't have a value
        }
        if (!$value) {
            delete_post_meta($post->ID, $key); // Delete if blank
        }
    }
}

add_action('save_post', 'shorty_save_meta', 1, 2); // save the custom fields