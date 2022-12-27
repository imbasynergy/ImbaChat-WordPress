<?php
/**
 * ImbaChat REST CONTROLLER Class
 *
 * REST API
 *
 * @class    IMBACHAT_IM_API
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IMBACHAT_IM_API Class
 */

class IMBACHAT_IM_API {

    public static function init(){
       static::init_after_callbacks();
    }

    public static function init_after_callbacks()
    {
        $api_filters = [
            'get_users' => 1
        ];

        foreach ($api_filters as $key => $api_filter) {
            add_filter( 'rest_request_before_callbacks', array(__CLASS__, 'imbachat_after_api_'.$key), 10, 3 );
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
        /*if ( in_array( 'administrator', (array) $user->roles ) ) {
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
        }*/
        if( !function_exists('is_plugin_active') ) {
			
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			
		}
        $imbachat_send_message=true;
        $imbachat_send_sketchboard=true;
        $imbachat_send_files=true;
        $imbachat_send_geo=true;
        $imbachat_audio_calls=true;
        $imbachat_video_calls=true;
        $imbachat_audio_message=true;
        $imbachat_video_message=true;
        $imbachat_available_chat=true;
        if(array_key_exists('guest',wp_roles()->roles)){
            if(isset(wp_roles()->roles['guest']["capabilities"]["imbachat_available_chat"]) && wp_roles()->roles['guest']["capabilities"]["imbachat_available_chat"]) $imbachat_available_chat = true;
            else $imbachat_available_chat = false;
        }
        elseif(is_user_logged_in()==true) {
            $imbachat_available_chat = true;
        }
        elseif(is_user_logged_in()==false) {
            $wp_roles = new WP_Roles();
            if(isset($wp_roles->roles['guest']["capabilities"]["imbachat_available_chat"]) && $wp_roles->roles['guest']["capabilities"]["imbachat_available_chat"]) $imbachat_available_chat = true;
            else if(get_option('IMCH_guest')=="1") $imbachat_available_chat = true;
            else $imbachat_available_chat = false;
        }
        if( user_can( $user_id ,'imbachat_activation_role' ) && (is_plugin_active('user-role-editor/user-role-editor.php') || is_plugin_active('members/members.php')) ) {
            $imbachat_send_message = user_can( $user_id ,'imbachat_send_message');
            $imbachat_send_sketchboard = user_can( $user_id ,'imbachat_send_sketchboard');
            $imbachat_send_files = user_can( $user_id ,'imbachat_send_files');
            $imbachat_send_geo = user_can( $user_id ,'imbachat_send_geo');
            $imbachat_audio_calls = user_can( $user_id ,'imbachat_audio_calls');
            $imbachat_video_calls = user_can( $user_id ,'imbachat_video_calls');
            $imbachat_audio_message = user_can( $user_id ,'imbachat_audio_message');
            $imbachat_video_message = user_can( $user_id ,'imbachat_video_message');
            $imbachat_audio_message_enable = user_can( $user_id ,'imbachat_audio_message_enable');
            $imbachat_available_chat = user_can( $user_id ,'imbachat_available_chat');
		}
        $permissions = [
            'send_message' =>  $imbachat_send_message,
            'send_sketchboard' => $imbachat_send_sketchboard,
            'send_files' => $imbachat_send_files,
            'send_geo' => $imbachat_send_geo,
            'audio_calls' => $imbachat_audio_calls,
            'video_calls' => $imbachat_video_calls,
            'audio_message' => $imbachat_audio_message,
            'video_message' => $imbachat_video_message,
            'audio_message_enable' => $imbachat_audio_message,
            'available_chat' => $imbachat_available_chat
        ];
        return [
            'permissions' => $permissions
        ];
    }

}

IMBACHAT_IM_API::init();