<?php

add_action('after_wcfmmp_store_header_actions', function (){
    $wcfm_store_url = wcfm_get_option( 'wcfm_store_url', 'store' );
    $store_name = apply_filters( 'wcfmmp_store_query_var', get_query_var( $wcfm_store_url ) );
    if ( !empty( $store_name ) ) {
        $store_user = get_user_by( 'slug', $store_name );
    }
    $userId = $store_user->ID;
    if ($userId != get_current_user_id())
        echo do_shortcode('[ic_open_dialog id="'.$userId.'"]');
});