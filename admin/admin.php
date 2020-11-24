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

//add_action('admin_menu', function(){
//    add_submenu_page(
//        'imbachat-options',
//        'ImbaChat Links',
//        'Chat Dashboard links',
//        8,
//        'imbachat-links',
//        'imbachat_links',
//        32 );
//} );

add_action('admin_menu', function(){
    if (get_option('IMCH_GET_STARTED', 0) != 1)
    {
        if ($_GET['page'] == 'imbachat-setup-help')
        {
            add_action( 'admin_enqueue_scripts', function (){
                wp_enqueue_media();
                wp_register_script('imbachat-admin-script',IC_PLUGIN_URL . '/assets/js/mpform.js', array(), '1.0.0', true);
                wp_enqueue_script('imbachat-admin-script');
                wp_register_script('imbachat-admin-mp-slct-script',IC_PLUGIN_URL . '/assets/js/mpform_select.js', array(), '1.0.0', true);
                wp_enqueue_script('imbachat-admin-mp-slct-script');
                wp_register_style('imbachat-admin-style',IC_PLUGIN_URL . '/assets/css/mpform.css', array(), '1.0.0', 'all');
                wp_enqueue_style('imbachat-admin-style');
                wp_register_style('imbachat-admin-fontawesome-style',IC_PLUGIN_URL . '/assets/fontawesome/css/all.css', array(), '1.0.0', 'all');
                wp_enqueue_style('imbachat-admin-fontawesome-style');

            } );
        }
        add_submenu_page(
            'imbachat-options',
            'Get Started with Imba Chat',
            'Get Started',
            8,
            'imbachat-setup-help',
            'imbachat_setup_help',
            0 );
    }
} );

//Метод запроса
add_action( 'admin_post_sync_with_imbachat', 'sync_with_imbachat' );
add_action( 'admin_post_interactive_submit', 'interactive_submit' );
add_action( 'wp_ajax_get_links_to_imbachat', 'get_links_to_imbachat' );

?>
