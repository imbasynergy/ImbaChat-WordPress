<?php
add_action( 'admin_footer', 'curl_not_exists_flash' );
function curl_not_exists_flash( $data ){
    if (!function_exists( 'curl_version' )){
        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/ic_flashes.php';
    }
}
