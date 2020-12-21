<?php
add_action( 'admin_footer', 'curl_not_exists_flash' );
function curl_not_exists_flash( $data ){
    if (!function_exists( 'curl_version' )){
        $title = 'danger';
        $body = 'curl';
        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/ic_flashes.php';
    }
}

add_action( 'admin_footer', 'redirect_from_online_sup' );
function redirect_from_online_sup( $data ){
    if (isset($_GET['page']))
    {
        if ($_GET['page'] == 'imbachat-admin-panel')
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
