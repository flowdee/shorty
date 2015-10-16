<?php
/**
 * Settings
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


if (!class_exists('SHORTY_SETTINGS')) {

    class SHORTY_SETTINGS
    {
        private $options;

        public function __construct()
        {
            // Variables
            global $shorty_options;
            $this->options =& $shorty_options;

            // Initialize
            add_action('admin_menu', array(&$this, 'add_admin_menu'));
            add_action('admin_init', array(&$this, 'init_settings'));
        }

        function add_admin_menu()
        {
            add_submenu_page(
                'edit.php?post_type=shortcode',
                __('Shorty Settings', 'shorty'),
                __('Settings', 'shorty'),
                'manage_options',
                'shorty-settings',
                array(&$this, 'options_page')
            );
        }

        function init_settings()
        {
            register_setting('shorty_settings', 'shorty_settings');

            // SECTION: General
            add_settings_section(
                'shorty_general',
                false,
                false,
                'shorty_settings'
            );

            add_settings_field(
                'shorty_settings_prefix',
                __('Prefix', 'shorty'),
                array(&$this, 'prefix_render'),
                'shorty_settings',
                'shorty_general',
                array( 'label_for' => 'shorty_settings_prefix' )
            );
        }

        function prefix_render()
        {
            $prefix = (!empty($this->options['prefix'])) ? $this->options['prefix'] : '';

            ?>
            <input type='text' name='shorty_settings[prefix]' id="shorty_settings_prefix"
                   value='<?php echo $prefix; ?>' /> <small><?php _e('e.g. "myproject_"', 'shorty'); ?></small>
            <p>
                <small><?php _e('<strong>Note:</strong> After updating the prefix you would have to update every shortcode placed within your posts/pages.', 'shorty'); ?></small>
            </p>
            <?php
        }

        function options_page()
        {

            ?>
            <form action='options.php' method='post'>

                <h2><?php _e('Shorty Settings', 'shorty'); ?></h2>

                <?php
                settings_fields('shorty_settings');
                do_settings_sections('shorty_settings');
                submit_button();
                ?>

            </form>
            <?php
        }
    }
}

new SHORTY_SETTINGS();

?>