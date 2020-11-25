<?php

function sync_with_imba_api($dev_id, $host, $mail)
{
    try {
        $post_data = [
            'host' => $host,
            'cms' => 'ImbaChat-WordPress',
            'dev_id' => $dev_id,
            'email' => $mail,
            'lang' => get_option('IMCH_LANG') ? get_option('IMCH_LANG') : 'en-US',
        ];
        $url = 'https://api.imbachat.com/developers/api/v1/sync';
        //https://develop.im.awsweb.imbachat.com/backend/system/eventlogs
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
    } catch (Exception $exception){

    }
}