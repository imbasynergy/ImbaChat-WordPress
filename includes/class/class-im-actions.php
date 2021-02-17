<?php
/**
 * ImbaChat Actions Class
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
 * IM_Actions Class
 */

class IM_Actions {

    public static function init(){
        self::add_actions();
    }

    public static function add_actions(){
        $filters = [
            'wp_login' => false,
            'wp_logout' => false,
            'wp_footer' => false,
        ];

        $wp_foro_actions = [
            'wpforo_member_info_buttons' => 'wpforo_member_info_imbachat_button'
        ];
        if(in_array('wpforo/wpforo.php', apply_filters('active_plugins', get_option('active_plugins')))){
            foreach ($wp_foro_actions as $k=>$wf_filter) {
                add_filter($k, array(__CLASS__, $wf_filter), 10, 3);
            }
        }
        foreach ($filters as $k => $v) {
            add_action($k, array(__CLASS__, 'imbachat_'.$k), 100, 2);
        }
    }

    public static function wpforo_member_info_imbachat_button($member)
    {
        echo '<a class="wpf-member-profile-button" href="#" onclick="open_dialog('.$member['ID'].')"><i class="fas fa-sms"></i></a>';
    }

    public static function imbachat_wp_login($username = '', $user = false)
    {
        if (!class_exists('OneSignal_Public')) {
            return;
        }
        if ($user->user_email) {
            set_transient('imbachat_'.$user->user_email, 1, 0);
        }
    }

    public static function imbachat_wp_logout($username = '', $user = false)
    {
        if (!class_exists('OneSignal_Public')) {
            return;
        }
        set_transient('imbachat_wp_logout', 1, 0);
    }

    public static function imbachat_wp_footer()
    {
        if (!class_exists('OneSignal_Public')) {
            return;
        }
        $current_user = wp_get_current_user();
        if (  get_transient( 'imbachat_'.$current_user->user_email ) ){
            $onesignal_wp_settings = OneSignal::get_onesignal_settings();
            $rest_key = $onesignal_wp_settings['app_rest_api_key'];
            echo "<script>
OneSignal.push(function() {
   OneSignal.setEmail('".$current_user->user_email."', {
      emailAuthHash: '".hash_hmac('sha256', $current_user->user_email, $rest_key)."'
  })           
});
</script>";
            delete_transient('imbachat_' . $current_user->user_email);
            return;
        }
        if (get_transient( 'imbachat_wp_logout' )) {
            echo "<script>
OneSignal.push(function() {
  OneSignal.logoutEmail();
});
</script>";
            delete_transient('imbachat_wp_logout');
            return;
        }
    }
}

IM_Actions::init();
