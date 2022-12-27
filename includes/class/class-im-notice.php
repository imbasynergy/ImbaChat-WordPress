<?php
/**
 * ImbaChat Notice Class
 *
 * Custom blocks.
 *
 * @class    IMBACHAT_IM_Notice
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IMBACHAT_IM_Notice Class
 */

class IMBACHAT_IM_Notice{

    public static function init(){
        self::show_notices();
    }

    public static function show_notices(){
        add_action( 'admin_notices', array(__CLASS__, 'im_feedback_rate_notice') );
    }

    public static function im_feedback_rate_notice(){
        /* Check transient, if available display notice */
        if( get_transient( 'im-feedback-modal' ) && time() - get_transient('im-feedback-modal') > 2*60*60 ){
            include_once IMBACHAT__PLUGIN_DIR . 'includes/admin/views/html-notice-rate.php';
        }
    }
}
IMBACHAT_IM_Notice::init();