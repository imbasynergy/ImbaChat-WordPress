<?php
/**
 * ImbaChat Control Hooks Class
 *
 *
 *
 * @class    IM_CTRL_HOOKS
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IM_CTRL_HOOKS Class
 */

class IM_CTRL_HOOKS {

    public static function init(){
        self::control_filters();
        self::control_actions();
    }

    public static function control_filters(){
        $forbidden_filters = apply_filters('imbachat_allowed_filters', []);
    }

    public static function control_actions(){
        $forbidden_actions = apply_filters('imbachat_allowed_filters', []);
    }

}

IM_CTRL_HOOKS::init();