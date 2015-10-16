<?php
/*
 * Uninstall
 */

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
exit();

// Remove settings
delete_option( 'shorty_settings' );