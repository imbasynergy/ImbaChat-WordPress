<?php
require_once(IMBACHAT__PLUGIN_DIR . '/admin/settings.php');

//Пункты меню
add_action('admin_menu', function(){
    add_menu_page( 'ImbaChat Widget',
        'ImbaChat',
        8,
        'imbachat-options',
        'add_my_setting',
        '',
        30 );
    add_submenu_page(
        'imbachat-options',
        'ImbaChat Documentation',
        'Documentation',
        8,
        'imbachat-options',
        'add_my_setting',
        30 );
} );

add_action('admin_menu', function(){
    add_submenu_page(
        'imbachat-options',
        'ImbaChat Settings',
        'ImbaChat Settings',
        8,
        'imbachat-settings',
        'imbachat_settings',
        31 );
} );

add_action('admin_menu', function(){
    add_submenu_page(
        'imbachat-options',
        'ImbaChat Links',
        'Chat Dashboard links',
        8,
        'imbachat-links',
        'imbachat_links',
        32 );
} );

//Метод запроса
add_action( 'admin_post_sync_with_imbachat', 'sync_with_imbachat' );
add_action( 'wp_ajax_get_links_to_imbachat', 'get_links_to_imbachat' );

?>
