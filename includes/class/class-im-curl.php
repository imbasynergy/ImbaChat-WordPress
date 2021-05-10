<?php
/**
 * ImbaChat Curl Class
 *
 * Load Admin Assets.
 *
 * @class    IM_Curl
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IM_Curl Class
 */
if (function_exists('curl_version')) :

    class IM_Curl {
        public function __construct(){
        }

        /**
         * @param $action
         * @param $method
         * @param $data
         */
        public static function curl($action, $method, $data){

            $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "curl (class-im-curl.php)\n";
    file_put_contents($file,$log);

            try {

                $url = 'https://develop.im.awsweb.imbachat.com/developers/api/v1/'.$action;

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 5);


//        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//        curl_setopt($curl, CURLOPT_USERPWD, 'calls:calls123321');

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                if ($method == 'POST') {
                    curl_setopt($curl, CURLOPT_POST, true);
                }
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);



                $curlout = curl_exec($curl);
                curl_close($curl);
            } catch (Exception $exception) {

            }
        }
    }

new IM_Curl();
endif;