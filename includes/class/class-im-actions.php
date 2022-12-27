<?php
/**
 * ImbaChat Actions Class
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
 * IMBACHAT_IM_Actions Class
 */

class IMBACHAT_IM_Actions {

    public static function init(){
        self::add_actions();
        self::add_bp_actions();
        self::add_wcfm_actions();
    }

    public static function add_bp_actions()
    {
        $imdb = new IMBACHAT_IM_DB();
        $actions = [
            'bp_member_header_actions' => [
                'function' => 'bp_member_header_actions_function',
                'description' => 'Add button "Message" to header section of profile`s page'
            ],
            'bp_directory_members_item' => [
                'function' => 'bp_directory_members_item_function',
                'description' => 'Add button "Message" to every member in member`s list'
            ],
            'bp_group_header_actions' => [
                'function' => 'bp_group_header_actions_function',
                'description' => 'Add button "Join group" to header section of group`s page'
            ],
        ];

        foreach ($actions as $k=>$bp_action) {
            if (!$imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $bp_action['function'], 'type' => 'action'])) {
                $imdb->insert('imbachat_hooks', [
                        'tag' => $k,
                        'function' => $bp_action['function'],
                        'type' => 'action',
                        'description' => $bp_action['description']]
                );
            } else {
                $action = $imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $bp_action['function'], 'type' => 'action']);
                if ($action[0]->forbidden == 1) {
                    continue;
                }
            }
            add_action($k, array(__CLASS__, $bp_action['function']), 10, 3);
        }
    }

    public static function bp_member_header_actions_function(){
        if ( is_user_logged_in() ) {
            $user_id = bp_displayed_user_id();
            if ($user_id != get_current_user_id())
                echo do_shortcode('[ic_open_dialog id="'. esc_attr($user_id) .'" class="ic_bp_button" name="Message"]');
        }
    }

    public static function bp_directory_members_item_function(){
        if ( is_user_logged_in() ) {
            $user_id = bp_get_member_user_id();
            if ($user_id != get_current_user_id())
                echo do_shortcode('[ic_open_dialog id="'. esc_attr($user_id) .'" class="ic_bp_button" name="Message"]');
        }
    }

    public static function bp_group_header_actions_function(){
        $group = groups_get_group(bp_get_group_id());
        $pipe = $group->status.'_'.$group->id;
        $user_id = get_current_user_id();

        if (groups_is_user_member($user_id, $group->id) || $group->status == 'public')
        {
            require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
            $button = array(
                'id'                => 'Join_Group_Chat',
                'component'         => 'groups',
                'must_be_logged_in' => true,
                'block_self'        => false,
                'wrapper_class'     => 'group-button ' . $group->status,
                'wrapper_id'        => 'groupbutton-' . $group->id,
                'parent_element'    => 'div',
                'button_element'    => 'button',
                'button_attr'       => [
                    'onClick' => 'ic_join_group("'.$pipe.'", "'.$group->name.'")',
                    'id' => 'ic_join_group_btn'
                ],
//        'link_href'         => wp_nonce_url( trailingslashit( bp_get_group_permalink( $group ) . 'leave-group' ), 'groups_leave_group' ),
                'link_text'         => '',
                'link_class'        => 'group-button',
            );
            bp_button($button);
        }
    }

    public static function add_actions(){
        $imdb = new IMBACHAT_IM_DB();
        $filters = [
            'wp_login' => false,
            'wp_logout' => false,
            'wp_footer' => false,
        ];

        $wp_foro_actions = [
            'wpforo_member_info_buttons' => [
                'function' => 'wpforo_member_info_imbachat_button',
                'description' => 'Add icon "Send message" under author`s avatar in'
            ]
        ];
        if(in_array('wpforo/wpforo.php', apply_filters('active_plugins', get_option('active_plugins')))){
            foreach ($wp_foro_actions as $k=>$wf_filter) {
                if (!$imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $wf_filter['function'], 'type' => 'action'])) {
                    $imdb->insert('imbachat_hooks', [
                            'tag' => $k,
                            'function' => $wf_filter['function'],
                            'type' => 'action',
                            'description' => $wf_filter['description']]
                    );
                } else {
                    $action = $imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $wf_filter['function'], 'type' => 'action']);
                    if ($action[0]->forbidden == 1) {
                        continue;
                    }
                }
                add_action($k, array(__CLASS__, $wf_filter['function']), 10, 3);
            }
        }
        foreach ($filters as $k => $v) {
            add_action($k, array(__CLASS__, 'imbachat_'.$k), 100, 2);
        }
    }

    public static function wpforo_member_info_imbachat_button($member)
    {
        echo '<a class="wpf-member-profile-button" href="#" onclick="open_dialog('.esc_js($member['ID']).')"><i class="fas fa-sms"></i></a>';
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

    public static function add_wcfm_actions()
    {
        $actions = [
            'after_wcfmmp_store_header_actions' => 'imbachat_after_wcfmmp_store_header_action'
        ];
        foreach ($actions as $key => $action) {
            add_action($key, $action);
        }
    }

    public static function imbachat_after_wcfmmp_store_header_action()
    {
        $wcfm_store_url = wcfm_get_option( 'wcfm_store_url', 'store' );
        $store_name = apply_filters( 'wcfmmp_store_query_var', get_query_var( $wcfm_store_url ) );
        if ( !empty( $store_name ) ) {
            $store_user = get_user_by( 'slug', $store_name );
        }
        $userId = $store_user->ID;
        if ($userId != get_current_user_id())
            echo do_shortcode('[ic_open_dialog id="'.esc_attr($userId).'" class="ic_bp_button"]');
    }
}

IMBACHAT_IM_Actions::init();
