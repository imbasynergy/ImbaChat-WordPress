<?php
/**
 * ImbaChat Curl Class
 *
 * Load Admin Assets.
 *
 * @class    IMBACHAT_IM_Curl
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IMBACHAT_IM_Curl Class
 */
if (function_exists('curl_version')) :

    class IMBACHAT_IM_Curl {
        public function __construct(){
        }

        /**
         * @param $action
         * @param $method
         * @param $data
         */
        public static function curl($action, $method, $data){
            try {
                $args = array(
                    'body'        => $data,
                    'timeout'     => '10',
                    'redirection' => '5',
                    'httpversion' => '1.0',
                    'blocking'    => true,
                    'headers'     => array(),
                    'cookies'     => array(),
                );
                $url = 'https://api.imbachat.com/developers/api/v1/'.$action;;
                $response = wp_remote_post( $url, $args );
                return json_decode(wp_remote_retrieve_body($response));
            } catch (Exception $exception) {
                return false;
            }
        }
    }

new IMBACHAT_IM_Curl();
endif;