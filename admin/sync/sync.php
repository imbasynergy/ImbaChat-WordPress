<?php

function sync_with_imba_api($dev_id, $host, $mail)
{
    if (function_exists( 'curl_version' ))
    {
        try {
            $post_data = [
                'host' => $host,
                'cms' => 'ImbaChat-WordPress',
                'dev_id' => $dev_id,
                'email' => $mail,
                'lang' => get_option('IMCH_LANG') ? get_option('IMCH_LANG') : 'en-US',
                'url' => get_site_url(),
            ];
            $url = 'https://api.imbachat.com/developers/api/v1/sync';
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);


//        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//        curl_setopt($curl, CURLOPT_USERPWD, $auth_password);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

            //curl_setopt($curl, CURLOPT_POSTFIELDS, "users=".$arr);


            $curlout = curl_exec($curl);
            curl_close($curl);
            send_wp_stat();
        } catch (Exception $exception) {

        }
    }
}


function send_wp_stat(){
    if (function_exists( 'curl_version' )){
        try {
            $apl=get_option('active_plugins');
            $apl = json_encode($apl);
            $plugin_data = get_file_data(IMBACHAT_PLUGIN_FILE, [
                'Version' => 'Version',
            ], 'plugin');

            $post_data = [
                'host' => $_SERVER['HTTP_HOST'],
                'lang' => get_locale(),
                'name' => $_SERVER['SERVER_NAME'],
                'plugins' => $apl,
                'admin_mail' => get_option( 'admin_email' ),
                'template' => get_option( 'template' ),
                'widget_id' => sanitize_text_field(get_option('IMCH_dev_id')),
                'plugin_version' => $plugin_data['Version']
            ];
            $url = 'https://api.imbachat.com/imbachat/api/wp_stat';
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);

//                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//                curl_setopt($curl, CURLOPT_USERPWD, $auth_password);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

            //curl_setopt($curl, CURLOPT_POSTFIELDS, "users=".$arr);


            $curlout = curl_exec($curl);
            curl_close($curl);
        } catch (Exception $exception){

        }
    }
}