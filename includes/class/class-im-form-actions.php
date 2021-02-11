<?php
/**
 * ImbaChat-Widget
 *
 * Form actions handler
 *
 * @class    IM_FORMS
 * @version  1.0.0
 * @category Class
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * IM_AJAX class
 */

class IM_FORMS{

    public static function init() {
        self::form_events();
    }

    public static function form_events(){
        $events = [
            'deactivation_reason' => true
        ];
        foreach ($events as $k=>$event) {
            add_action( 'admin_post_imbachat_' . $k, array( __CLASS__, $k ) );
        }
    }

    /**
     * Form plugin deactivation reason.
     *
     * @since  2.5.9
     */
    public static function deactivation_reason() {
        $data = [
            'dev_id' => get_option('IMCH_dev_id', ''),
            'reason' => $_REQUEST['IM_deactivation_reason']
        ];
        IM_Curl::curl('deactivation_stat', 'POST', $data);
        return wp_redirect($_REQUEST['deactivation_url'], 302);
    }
}

IM_FORMS::init();