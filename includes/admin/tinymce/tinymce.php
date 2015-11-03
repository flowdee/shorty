<?php
/*
 * Add button
 */
function shorty_tinymce_plugin($plugin_array) {
    $plugin_array['shorty'] = SHORTY_PLUGIN_URL . '/includes/admin/tinymce/assets/editor.js';
    return $plugin_array;
}

add_filter('mce_external_plugins', 'shorty_tinymce_plugin');

/*
 * Register new button in the editor
 */
function shorty_register_mce_button($buttons) {
    array_push($buttons, 'shorty');
    return $buttons;
}

add_filter('mce_buttons', 'shorty_register_mce_button');

/*
 * Register Ajax calls
 */
function shorty_ajax_get_shortcodes() {

    // Prepare
    $array = array();
    $posts = shorty_get_shortcodes();

    // Build required structure
    foreach ($posts as $post) {
        $array[] = array('value' => $post['slug'], 'text' => $post['title']);
    }

    // Return json
    echo json_encode($array);
    exit;
}

add_action('wp_ajax_shorty_get_shortcodes', 'shorty_ajax_get_shortcodes');