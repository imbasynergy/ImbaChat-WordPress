<?php
/*
 * Plugin Name: ImbaChat
 * Plugin URI: https://wordpress.org/plugins/imbachat-widget/
 * Description: This is free plugin for integration Wordpress CMS with chat service imbachat.com. It allows to add chat widget between users on your website for free.
 * Version: 2.6.5
 * Author: Imbasynergy
 * Author URI: https://imbachat.com/en/wordpress-chat
 * License: GPLv2 or later
*/

define( 'IMBACHAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define('IMBACHAT_ADMIN_DIR', plugin_dir_url(__FILE__ ).'admin');

define('IM_PLUGIN_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ));

define( 'IC_PLUGIN', __FILE__ );

define('IMBACHAT_PLUGIN_FILE', __FILE__);

define( 'IC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( 'IC_PLUGIN_URL',
    untrailingslashit( plugins_url( '', IC_PLUGIN ) ) );

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

//function imbachat_delete_table(){
//    global $wpdb;
//    $table_name = $wpdb->prefix . 'imbachat_hooks';
//    error_log('deleting');
//    $sql = "DROP TABLE IF EXISTS $table_name";
//    $wpdb->query($sql);
//}
//
//register_deactivation_hook(__FILE__, 'imbachat_delete_table');
register_activation_hook( __FILE__, 'imbachat_activation_func' );
register_activation_hook( __FILE__, 'imbachat_install_database' );
require_once IMBACHAT__PLUGIN_DIR . '/settings.php';