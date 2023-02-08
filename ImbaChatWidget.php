<?php
/*
 * Plugin Name: 3.0 ImbaChat
 * Plugin URI: https://wordpress.org/plugins/imbachat-widget/
 * Description: This is free plugin for integration Wordpress CMS with chat service imbachat.com. It allows to add chat widget between users on your website for free.
 * Version: 3.0.9
 * Author: Imbasynergy
 * Author URI: https://imbachat.com/en/wordpress-chat
 * License: GPLv2 or later
*/


/////////////
/// Defining paths as absolute from the server root folder, as well as building a URL for a plugin
/// Some may not even be used.
/////////////
define( 'IMBACHAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define('IMBACHAT_ADMIN_DIR', plugin_dir_url(__FILE__ ).'admin');

define('IMBACHAT_PLUGIN_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ));

define( 'IMBACHAT_PLUGIN', __FILE__ );

define('IMBACHAT_PLUGIN_FILE', __FILE__);

define( 'IMBACHAT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( 'IMBACHAT_IC_PLUGIN_URL',
    untrailingslashit( plugins_url( '', IMBACHAT_PLUGIN ) ) );

/**
 * imbachat_activation_func
 * This function refers to the plugin activation hook
 * It is intended so that a form for feedback appears in the admin panel 2 hours after activation.
 */
function imbachat_activation_func() {
    set_transient( 'im-feedback-modal', time() );
}
function imbachat_install_database() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'imbachat_hooks';

    $charset_collate = $wpdb->get_charset_collate();
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		tag tinytext NOT NULL,
		description text NOT NULL,
		function tinytext NOT NULL,
		type varchar(50) NOT NULL,
		forbidden smallint NOT NULL
	) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        add_option( 'imbachat_db_version', '1.1' );
    }
}
////////////////
/// Commented below because the code below did not work
////////////////

//function imbachat_delete_table(){
//    global $wpdb;
//    $table_name = $wpdb->prefix . 'imbachat_hooks';
//    error_log('deleting');
//    $sql = "DROP TABLE IF EXISTS $table_name";
//    $wpdb->query($sql);
//}
//
//register_deactivation_hook(__FILE__, 'imbachat_delete_table');

//This subscription is the activation of the function about the feedback form
register_activation_hook( __FILE__, 'imbachat_activation_func' );
//This subscription is created in the site database, one table for all subscriptions that are in the plugin
register_activation_hook( __FILE__, 'imbachat_install_database' );

register_uninstall_hook(__FILE__, 'imbachat_uninstall_feedback');
function imbachat_uninstall_feedback() {
    $body = array(
        'email'        => get_option( 'admin_email' ),
        'locale'     => get_user_locale()
    );
    $args = array(
        'body'        => $body,
        'timeout'     => '10',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => array(),
        'cookies'     => array(),
    );
    $response = wp_remote_post( 'https://imbachat.com/v1/feedback', $args );
}

//Connecting the main file, which contains all the functionality of the plugin
require_once IMBACHAT__PLUGIN_DIR . '/settings.php';