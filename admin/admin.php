<?php
require_once(IMBACHAT__PLUGIN_DIR . '/admin/settings.php');

//Menu items
add_action('admin_menu', function(){
    add_menu_page( 'ImbaChat Widget',
        'ImbaChat',
        'edit_pages',
        'imbachat-settings',
        '',
        IMBACHAT_IC_PLUGIN_URL.'/admin/assets/images/Vector.svg',
        30 );
} );

add_action( 'admin_menu' , function (){
    global $submenu;
    if (get_option('IMCH_secret_key')&&get_option('IMCH_dev_id'))
    {
        $links = [
            'imbachat' => 'https://imbachat.com/visitor/login-user?token='.get_option('IMCH_secret_key'),
            'imachat_dashboard' => (imbachat_get_adminJWT(get_admin_url())) ? 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/auth/'.imbachat_get_adminJWT(get_admin_url()) : 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/signIn',
            //'imbachat_onlinesup' => 'https://api.imbachat.com/imbasupport/v1/'.get_option('IMCH_dev_id').'/token_auth?jwt='.imbachat_get_adminJWT(get_admin_url()),
            'imbachat_step' => 'https://imbachat.com/visitor/login-user?token='.get_option('IMCH_secret_key').'&step=1'
        ];
        $submenu['imbachat-settings'][9997] = array('Support Forum', 'manage_options', "https://wordpress.org/support/plugin/imbachat-widget/", '', '', '', 'target' );
        $submenu['imbachat-settings'][9998] = array('Admin Panel', 'manage_options', $links['imbachat'], '', 'imba-admin-panel', '', 'target');
        $submenu['imbachat-settings'][9999] = array('Chat Moderation & Online Support', 'manage_options', $links['imachat_dashboard'], '', 'imba-chat-moderation', '', 'div' );
        //$submenu['imbachat-settings'][9997] = array('Online Support', 'manage_options', $links['imbachat_onlinesup'], '', 'imba-online-support', '', 'div' );
        $submenu['imbachat-settings'][9996] = array('Step by step setup', 'manage_options', $links['imbachat_step'], '', 'imba-online-step', '', 'div' );

    }
} );

add_action( 'admin_footer', 'make_maricache_blank' );
function make_maricache_blank()
{
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.imba-open-if-no-js').children().attr('target','_blank');
        });
    </script>
    <?php

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.imba-admin-panel').attr('target','_blank');
            $('.imba-chat-moderation').attr('target','_blank');
            $('.imba-online-support').attr('target','_blank');
        });
    </script>
    <?php
}

add_action('admin_menu', function(){
    if (isset($_GET['page']))
    {
        if ($_GET['page'] == 'imbachat-setup-help')
        {
            add_action( 'admin_enqueue_scripts', function (){
                wp_enqueue_media();
                wp_register_script('imbachat-admin-script',IMBACHAT_IC_PLUGIN_URL . '/assets/js/mpform.js', array(), '1.0.0', true);
                wp_enqueue_script('imbachat-admin-script');
                wp_register_script('imbachat-admin-mp-slct-script',IMBACHAT_IC_PLUGIN_URL . '/assets/js/mpform_select.js', array(), '1.0.0', true);
                wp_enqueue_script('imbachat-admin-mp-slct-script');
                wp_register_style('imbachat-admin-style',IMBACHAT_IC_PLUGIN_URL . '/assets/css/mpform.css', array(), '1.0.0', 'all');
                wp_enqueue_style('imbachat-admin-style');

            } );
        }
    }
    add_submenu_page(
        'imbachat-settings',
        'Get Started with Imba Chat',
        'Get Started',
        'edit_pages',
        'imbachat-setup-help',
        'imbachat_setup_help',
        0 );
} );

//Request method
add_action( 'admin_post_sync_with_imbachat', 'sync_with_imbachat' );
add_action( 'admin_post_imbachat_interactive_submit', 'imbachat_interactive_submit' );
add_action( 'wp_ajax_get_links_to_imbachat', 'get_links_to_imbachat' );
add_action( 'wp_ajax_imbachat_save_users_settings', 'imbachat_save_users_settings' );
add_action( 'wp_ajax_imbachat_test_api', 'imbachat_test_api' );

?>
