<?php
/**
 * ImbaChat REST CONTROLLER Class
 *
 * REST API
 *
 * @class    IM_API
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IM_API Class
 */

class IM_API {

    public static function init(){
       static::init_after_callbacks();
    }

    public static function init_after_callbacks()
    {
        $api_filters = [
            'get_users' => 1
        ];

        foreach ($api_filters as $key => $api_filter) {
//            add_filter( 'rest_request_before_callbacks', array(__CLASS__, 'imbachat_after_api_'.$key), 10, 3 );
        }
    }

    public static function imbachat_after_api_get_users($response, $handler, $request)
    {
        /**
         * Here is example how you can control user's permissions.
         * This example of giving permissions by user role
         * admin - allowed to use all features of ImbaChat
         * user - allowed to write message and nothing else
         **/
        /**
         * Dont change code bellow
         **/
        //////////////////////////////////////////////////////
        if (!isset($handler['imbachat_callback'])) {
            return $response;
        }
        if ($handler['imbachat_callback'] != 'get_users') {
            return $response;
        }
        //////////////////////////////////////////////////////

        $user_id = $response['user_id'];

        $user = get_user_by('id', $user_id);
        if ( in_array( 'administrator', (array) $user->roles ) ) {
            $role = 'admin';
        } else {
            $role = 'user';
        }

        if ($role == 'admin') {
            $permissions = [
                'send_message' => 1,
                'send_files' => 1,
                'send_geo' => 1,
                'audio_calls' => 1,
                'video_calls' => 1,
                'audio_message' => 1,
                'video_message' => 1
            ];
        } else {
            $permissions = [
                'send_message' => 1,
                'send_files' => 0,
                'send_geo' => 0,
                'audio_calls' => 0,
                'video_calls' => 0,
                'audio_message' => 0,
                'video_message' => 0
            ];
        }
        return [
            'permissions' => $permissions
        ];
    }

}

IM_API::init();