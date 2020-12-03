<?php
/*
 * Plugin Name: ImbaChat
 * Plugin URI: https://wordpress.org/plugins/imbachat-widget/
 * Description: This is free plugin for integration Wordpress CMS with chat service imbachat.com. It allows to add chat widget between users on your website for free.
 * Version: 2.4.7
 * Author: Imbasynergy
 * Author URI: https://imbasynergy.com/en
 * License: GPLv2 or later
*/

define( 'IMBACHAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define('IMBACHAT_ADMIN_DIR', plugin_dir_url(__FILE__ ).'admin');

define( 'IC_PLUGIN', __FILE__ );

define('IMBACHAT_PLUGIN_FILE', __FILE__);

define( 'IC_PLUGIN_URL',
    untrailingslashit( plugins_url( '', IC_PLUGIN ) ) );

require_once IMBACHAT__PLUGIN_DIR . '/settings.php';