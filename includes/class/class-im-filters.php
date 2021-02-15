<?php
/**
 * ImbaChat Filters Class
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
 * IM_Filter Class
 */

class IM_Filter {

    public static function init(){
//        self::add_filters();
    }

    public static function add_filters(){
        $filters = [
            'open_dialog' => 3
        ];

        foreach ($filters as $k => $v) {
            add_filter('imbachat_'.$k.'_filter', array(__CLASS__, $k), 9, $v);
        }
    }

    public static function open_dialog($parameter, $user_from, $user_to){
        return array('status' => 'default');
    }
}

IM_Filter::init();