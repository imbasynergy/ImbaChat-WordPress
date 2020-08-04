<?php
/*
Plugin Name: ImbaChat Widget
*/

define( 'IMBACHAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define('IMBACHAT_ADMIN_DIR', plugin_dir_url(__FILE__ ).'admin');

define( 'IC_PLUGIN', __FILE__ );

define( 'IC_PLUGIN_URL',
    untrailingslashit( plugins_url( '', IC_PLUGIN ) ) );

require_once IMBACHAT__PLUGIN_DIR . '/settings.php';