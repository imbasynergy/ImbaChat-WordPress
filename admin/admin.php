<?php
require_once(IMBACHAT__PLUGIN_DIR . '/admin/settings.php');

//Menu items
add_action('admin_menu', function(){
    add_menu_page( 'ImbaChat Widget',
        'ImbaChat',
        8,
        'imbachat-settings',
        '',
        IC_PLUGIN_URL.'/admin/assets/images/Vector.svg',
        30 );
} );

add_action( 'admin_menu' , function (){
    global $submenu;
    if (get_option('IMCH_secret_key')&&get_option('IMCH_dev_id'))
    {
        $links = [
            'imbachat' => 'https://imbachat.com/visitor/login-user?token='.get_option('IMCH_secret_key'),
            'imachat_dashboard' => 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/auth/'.IMCH_getJWT(),
            'imbachat_onlinesup' => 'https://api.imbachat.com/imbasupport/v1/'.get_option('IMCH_dev_id').'/token_auth?jwt='.IMCH_get_adminJWT(get_admin_url())
        ];
        $submenu['imbachat-settings'][9997] = array( __('Support Forum', "imbachat"), 'manage_options', "https://wordpress.org/support/plugin/imbachat-widget/", '', 'imba-open-if-no-js menu-top', '', 'target' );
        $submenu['imbachat-settings'][9998] = array( __('Admin Panel', "imbachat"), 'manage_options', $links['imbachat'], '', 'imba-open-if-no-js menu-top', '', 'target' );
        $submenu['imbachat-settings'][9999] = array( __('Chat Moderation', "imbachat"), 'manage_options', $links['imachat_dashboard'], '', 'imba-open-if-no-js menu-top', '', 'div' );
        $submenu['imbachat-settings'][9997] = array( __('Online Support', "imbachat"), 'manage_options', $links['imbachat_onlinesup'], '', 'imba-open-if-no-js menu-top', '', 'div' );
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
}

add_action('admin_menu', function(){
    if (isset($_GET['page']))
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

            } );
        }
    }
    add_submenu_page(
        'imbachat-settings',
        'Get Started with Imba Chat',
        'Get Started',
        8,
        'imbachat-setup-help',
        'imbachat_setup_help',
        0 );
} );

//Request method
add_action( 'admin_post_sync_with_imbachat', 'sync_with_imbachat' );
add_action( 'admin_post_interactive_submit', 'interactive_submit' );
add_action( 'wp_ajax_get_links_to_imbachat', 'get_links_to_imbachat' );
add_action( 'wp_ajax_save_users_settings', 'save_users_settings' );

?>
