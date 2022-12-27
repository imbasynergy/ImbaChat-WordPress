<?php
add_action( 'admin_footer', 'imbachat_curl_not_exists_flash' );
function imbachat_curl_not_exists_flash( $data ){
    if (!function_exists( 'curl_version' )){
        $title = 'danger';
        $body = 'curl';
        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/ic_flashes.php';
    }
}

add_action( 'admin_footer', 'imbachat_redirect_from_online_sup' );
function imbachat_redirect_from_online_sup( $data ){
    if (isset($_GET['page']))
    {
        if ($_GET['page'] == 'imbachat-settings')
        {
            if (isset($_GET['online_sup_error']))
                if ($_GET['online_sup_error'] == 1)
                {
                    $title = 'warning';
                    $body = 'online_sup';
                    require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/ic_flashes.php';
                }
        }
    }
}
add_action( 'admin_footer', 'imbachat_success_sync_with_imba' );
function imbachat_success_sync_with_imba( $data ){
    if (isset($_GET['page']))
    {
        if ($_GET['page'] == 'imbachat-settings')
        {
            if (isset($_GET['success']))
            {
                if ($_GET['success'] == 1)
                {
                    $title = 'success';
                    $body = 'sunc_success';
                    require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/ic_flashes.php';
                }
            }
            if (isset($_GET['need_connect']))
            {
                if ($_GET['need_connect'] == 1)
                {
                    $title = 'danger';
                    $body = 'need_sync';
                    require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/ic_flashes.php';
                }
            }
        }
    }
}

add_action( 'wp_loaded', 'imbachat_admin_panel_need_connect' );
function imbachat_admin_panel_need_connect( $data ){
    if (isset($_GET['page']))
    {
        if ($_GET['page'] == 'imbachat-admin-panel')
        {
            if (!get_option('IMCH_secret_key') || get_option('IMCH_secret_key') == '')
            {
                wp_redirect(admin_url( 'admin.php' ).'?page=imbachat-settings&need_connect=1', 302);
            }
        }
    }
}
