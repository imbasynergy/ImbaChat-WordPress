<?php

function sync_with_imba_api($dev_id, $host, $mail)
{
    $post_data = [
        'host' => $host,
        'cms' => 'ImbaChat-WordPress',
        'dev_id' => sanitize_text_field($dev_id),
        'email' => sanitize_email($mail),
        'lang' => get_option('IMCH_LANG') ? get_option('IMCH_LANG') : 'en-US',
        'url' => get_site_url(),
    ];
    $args = array(
        'body'        => $post_data,
        'timeout'     => '10',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => array(),
        'cookies'     => array(),
    );
    $url = 'https://api.imbachat.com/developers/api/v1/sync';
    $response = wp_remote_post( $url, $args );
    if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
        echo "error_connect";
     } 
     $dev_json=json_decode(wp_remote_retrieve_body($response));
     $dev_id_temp=$dev_json->dev_id;
     if ($dev_id_temp == $dev_id or ($dev_id==-1 and $dev_id_temp>0)) {
        imbachat_send_wp_stat();
        return "success";
    }else{
        return "error_connect";
    }
}

function get_support_immachat_user_id()
{

    $post_data = [
        'secret' => get_option('IMCH_secret_key'),
    ];
    $args = array(
        'body'        => $post_data,
        'timeout'     => '10',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => array(),
        'cookies'     => array(),
    );
    $url = 'https://api.imbachat.com/imbachat/v1/'.sanitize_text_field(get_option('IMCH_dev_id')).'/get_user_support';
    $response = wp_remote_post( $url, $args );
    if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
        echo "error_connect";
     } 
     $dev_json=json_decode(wp_remote_retrieve_body($response));
     if ($dev_json->success == true) {
        return $dev_json->id;
    }else{
        return false;
    }
}


function imbachat_send_wp_stat(){

    $apl=sanitize_text_field(get_option('active_plugins'));
    $apl = json_encode($apl);
    $plugin_data = get_file_data(IMBACHAT_PLUGIN_FILE, [
         'Version' => 'Version',
    ], 'plugin');

    $post_data = [
        'host' => sanitize_text_field($_SERVER['HTTP_HOST']),
        'lang' => get_locale(),
        'name' => sanitize_text_field($_SERVER['SERVER_NAME']),
        'plugins' => $apl,
        'admin_mail' => sanitize_email(get_option( 'admin_email' )),
        'template' => sanitize_text_field(get_option( 'template' )),
        'widget_id' => sanitize_text_field(get_option('IMCH_dev_id')),
        'plugin_version' => sanitize_text_field($plugin_data['Version'])
    ];
    $args = array(
        'body'        => $post_data,
        'timeout'     => '10',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => array(),
        'cookies'     => array(),
    );
    $url = 'https://api.imbachat.com/imbachat/api/wp_stat';
    $response = wp_remote_post( $url, $args );
}