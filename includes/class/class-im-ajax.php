<?php
/**
 * ImbaChat-Widget
 *
 * AJAX Event Handler
 *
 * @class    IMBACHAT_IM_AJAX
 * @version  1.0.0
 * @category Class
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * IMBACHAT_IM_AJAX class
 */

class IMBACHAT_IM_AJAX{

    public static function init() {
        self::ajax_events();
    }

    public static function ajax_events(){
        $events = [
            'deactivation_notice' => true,
            'send_rate' => true
        ];
        foreach ($events as $k=>$event) {
            add_action( 'wp_ajax_imbachat_' . $k, array( __CLASS__, $k ) );
        }
    }

    /**
     * AJAX plugin deactivation notice.
     *
     * @since  2.5.9
     */
    public static function deactivation_notice() {

        check_ajax_referer( 'deactivation-notice', 'security' );

        ob_start();
        include_once IMBACHAT__PLUGIN_DIR . 'includes/admin/views/html-notice-deactivation.php';

        $content = ob_get_clean();
        wp_send_json( $content ); // WPCS: XSS OK.
    }

    public static function send_rate() {
        unset($_REQUEST['action']);
        $_REQUEST['dev_id'] = get_option('IMCH_dev_id', '');
        $_REQUEST['additionally'] = json_encode(['reason' => sanitize_text_field($_REQUEST['reason'])]);
        unset($_REQUEST['reason']);
        IMBACHAT_IM_Curl::curl('plugin_rate', 'POST', $_REQUEST);
        delete_transient( 'im-feedback-modal' );
        wp_send_json(array('status'=>true,'request_vars'=>$_REQUEST), 200);
    }
}

IMBACHAT_IM_AJAX::init();