<?php

////////////
/// The section below is for connecting plugin files.
////////////
require_once( IMBACHAT__PLUGIN_DIR . '/controllers/IMCH_USERS_Controller.php' ); //endpoint api plugin
require_once( IMBACHAT__PLUGIN_DIR . '/includes/imbachat_functions.php' );// file contains functions processing shortcodes
require_once( IMBACHAT__PLUGIN_DIR . '/widgets/ic_widgets.php' );// This file does not carry real functionality, it was intended to create a plugin widget in WP
require_once( IMBACHAT__PLUGIN_DIR . '/includes/assign_hooks.php' );// With the update of the plugin, functions from this plugin have moved to classes
require_once( IMBACHAT__PLUGIN_DIR . '/includes/admin_hooks.php' );// Here flash notifications are made for various situations, some are not relevant.
require_once (IMBACHAT__PLUGIN_DIR . '/admin/sync/sync.php');// 2 functions for curl requests to the api.imbachat.com server, one is needed for creating widgets, the other for collecting statistics
require_once( IMBACHAT__PLUGIN_DIR . '/includes/buddyPressInt.php' );// similar to assign_hooks.php file
//require_once( IMBACHAT__PLUGIN_DIR . '/includes/wcfm_market_int.php' );// similar to assign_hooks.php file
include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-db.php');// A class for working with a database, the where, insert and update functions are described
include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-bp-messages-component.php');//Class for inserting a Widget as a window into the messages tab on the BuddyPress profile page
include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-filters.php');// Filter handling class for wordpress, buddypress, WCFM, etc.
include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-control-hooks.php');// An unnecessary file, the intent of this file is implemented differently.
include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-actions.php');// Processing class
include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-rest-filter.php');// Class for inserting filters into the plugin REST API

if ( is_admin() ) {
    //////////
    /// in this if files are connected to work in the imbachat widget in the wp admin panel
    //////////

    //CMB2 - this is an additional plugin located in the CMB2 folder
    //It is needed to build forms in the Amdink Word press
    // https://github.com/CMB2/CMB2 && https://cmb2.io/ this is the documentation for it
    if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
        require_once dirname( __FILE__ ) . '/cmb2/init.php';
    } elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
        require_once dirname( __FILE__ ) . '/CMB2/init.php';
    }
    require_once IMBACHAT__PLUGIN_DIR . '/admin/admin.php';
    include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-cmd-options.php'); // Class for working with CMB2 (slightly missed the file name)
    include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-ajax.php');// Class for creating hooks for handling ajax requests
    include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-admin-assets.php');// asset files for admin panel
    include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-curl.php');
    include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-form-actions.php'); //admin_post hooks
    include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-blocks.php');// Blocks on page edit page in wordpress
    include_once (IMBACHAT__PLUGIN_DIR . '/includes/class/class-im-notice.php');// Subscribing to wordpress notification hooks
}
if (class_exists('IMBACHAT_BP_Message_component')) {
    IMBACHAT_BP_Message_component::instance();
}
add_action('wp_loaded', function (){
    if (is_admin())
    {
        wp_register_style( 'admin.css', IMBACHAT_IC_PLUGIN_URL.'/admin/assets/css/admin.css');
        wp_enqueue_style( 'admin.css');
    } else {
        wp_register_script('IMCH_script', IMBACHAT_IC_PLUGIN_URL.'/view/imbachat.js','','', true);
        wp_enqueue_script( 'IMCH_script');

    }
    imbachat_permission_role_editor();
});
function imbachat_load_jquery() {
    if ( ! wp_script_is( 'jquery', 'enqueued' )) {
        wp_enqueue_script( 'jquery');
    }
}
add_action( 'wp_enqueue_scripts', 'imbachat_load_jquery', 1 );
add_action('plugins_loaded', 'imbachat_imbachat');
function imbachat_imbachat(){
    // If you change the value inside the function, then the function will work and some kind of sql query will be made, at the moment this is the creation of a table.
    IMBACHAT_IM_DB::check_for_upd("1.1");
    /// below shortcodes
    add_shortcode( 'ic_open_dialog', 'imbachat_open_dialog_with' );
    add_shortcode( 'ic_create_group', 'imbachat_create_group_with' );
    add_shortcode( 'ic_join_group', 'imbachat_join_group' );
    add_shortcode( 'ic_open_chat', 'imbachat_open_chat' );
    add_shortcode( 'ic_close_chat', 'imbachat_close_chat' );
    add_shortcode( 'ic_wise_chat', 'imbachat_wise_chat');
    if (get_option('IMCH_login','') == '' || get_option('IMCH_password','') == '' || get_option('IMCH_secret_key','') == '')
    {
        if (get_option('IMCH_dev_id', '') == '')
            $dev_id = null;
        else
            $dev_id = get_option('IMCH_dev_id');
    }
}
add_action('wp_footer', function()
{
    // Connecting the imbachat widget script
    $dev_id = get_option('IMCH_dev_id');
    $json_data = imbachat_getJsSettingsString();
    require_once( IMBACHAT__PLUGIN_DIR . '/view/script.php' );
});
add_action('plugins_loaded', 'imbachat_imbachat_init_lang');
function imbachat_imbachat_init_lang(){
    $mo_file_path = dirname(__FILE__) . '/lang/imbachat-'. get_locale() . '.mo';
	load_textdomain( 'imbachat', $mo_file_path );
}

add_filter( 'cron_schedules', 'imbachat_cron_add_five_min' );
function imbachat_cron_add_five_min( $schedules ) {
    $schedules['five_min'] = array(
        'interval' => 60 * 1,
        'display' => 'Раз в 1 минут'
    );
    return $schedules;
}

// adds a new krona task
add_action( 'admin_head', 'imbachat_cron_activation' );
function imbachat_cron_activation() {
    if( ! wp_next_scheduled( 'imba_wp_stat' ) ) {
        wp_schedule_event( time(), 'daily', 'imba_wp_stat');
    }
}


// add a function to the specified hook
add_action( 'imba_wp_stat', 'imbachat_do_imba_wp_stat' );
function imbachat_do_imba_wp_stat(){
    //if (function_exists( 'curl_version' )){
        try {

            if (get_option('IMCH_dev_id') == '' || get_option('IMCH_dev_id' == '276'))
            {

                sync_with_imba_api(-1, sanitize_text_field($_SERVER['HTTP_HOST'])!='' ? sanitize_text_field($_SERVER['HTTP_HOST']) : preg_replace('#https?://(www.)?#','',site_url()), get_option( 'admin_email' ));
            }

            $apl=get_option('active_plugins');
            $apl = json_encode($apl);
            $plugin_data = get_file_data(IMBACHAT_PLUGIN_FILE, [
                'Version' => 'Version',
            ], 'plugin');

            

            $post_data = [
                'host' => sanitize_text_field($_SERVER['HTTP_HOST']),
                'lang' => get_locale(),
                'name' => sanitize_text_field($_SERVER['SERVER_NAME']),
                'plugins' => $apl,
                'admin_mail' => sanitize_email(get_option( 'admin_email' )),
                'template' => sanitize_text_field(get_option( 'template' )),
                'widget_id' => sanitize_text_field(get_option('IMCH_dev_id')),
                'plugin_version' => sanitize_text_field($plugin_data['Version'])
            ];
            $args = array(
                'body'        => $post_data,
                'timeout'     => '10',
                'redirection' => '5',
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(),
                'cookies'     => array(),
            );
            $url = 'https://api.imbachat.com/imbachat/api/wp_stat';
            $response = wp_remote_post( $url, $args );
        } catch (Exception $exception){

        }
    //}
}
//shortcode change new role
add_shortcode( 'ic_change_role', 'imbachat_change_role_imbachat' );
function imbachat_change_role_imbachat($val){
	$new_role = $val['role'];
	$user_id = get_current_user_id();
    $user = get_user_by('id', $user_id);
    if (!in_array((string)current($user->roles), ['administrator'])) $result = wp_update_user(array('ID'=>$user_id, 'role'=>$new_role));
}
function imbachat_getJsSettingsString($opt = []) {

    $user_id = get_current_user_id();
    $token = imbachat_getJWT();
    $extend_settings = array_merge(
        [
            // Preset default values
            // "language" => self::property('language'),
            "user_id" => $user_id,
            "token" => $token,
            // "resizable" => self::property('resizable'),
            // "draggable" => self::property('draggable'),
            // "theme" => self::property('theme'),
            // "position" => self::property('position'),
            // "useFaviconBadge" => self::property('useFaviconBadge'),
            // "updateTitle" => self::property('updateTitle'),
        ]);
    // Final widget settings
    return json_encode($extend_settings);
}

function imbachat_getJWT(){
    // Create token header as a JSON string
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $pass = get_option('IMCH_secret_key');
    $data = array();
    $data['exp'] = (int)date('U')+3600*7;
    $data['user_id'] = get_current_user_id();

    if(isset($data['user_id']))
    {
        $data['user_id'] = (int)$data['user_id'];
    }

    // Create token payload as a JSON string
    $payload = json_encode($data);

    // Encode Header to Base64Url String
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

    // Encode Payload to Base64Url String
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    // Create Signature Hash
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $pass, true);

    // Encode Signature to Base64Url String
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    // Create JWT
    return trim($base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature);
}


function imbachat_get_adminJWT($url = null){
    // Create token header as a JSON string
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $pass = get_option('IMCH_secret_key');
    $data = array();
    $data['exp'] = (int)date('U')+3600*7;
    //$data['user_id'] = get_current_user_id();
    $data['user_id'] = get_support_immachat_user_id();
    if($data['user_id']==false) return false;
    
    $data['user_role'] = 'admin';
    if ($url)
        $data['back_to'] = $url;

    /*if(isset($data['user_id']))
    {
        $data['user_id'] = (int)$data['user_id'];
    }*/

    // Create token payload as a JSON string
    $payload = json_encode($data);

    // Encode Header to Base64Url String
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

    // Encode Payload to Base64Url String
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    // Create Signature Hash
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $pass, true);

    // Encode Signature to Base64Url String
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    // Create JWT
    return trim($base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature);
}
//add role capabilities
function imbachat_permission_role_editor() {
    $role = get_role( 'administrator' );
    $imba_role_names = wp_roles()->get_names();
    if(!$role->capabilities['imbachat_activation_role'] or !$role->capabilities['imbachat_available_chat'] or !$role->capabilities['imbachat_send_message']){
        foreach ($imba_role_names as $imba_role_name_key => $imba_role_name ) {
            $role = get_role( $imba_role_name_key );
            $role->add_cap( 'imbachat_activation_role' );
            $role->add_cap( 'imbachat_send_message' );
            $role->add_cap( 'imbachat_send_sketchboard' );
            $role->add_cap( 'imbachat_send_files' );
            $role->add_cap( 'imbachat_send_geo' );
            $role->add_cap( 'imbachat_audio_calls' );
            $role->add_cap( 'imbachat_video_calls' );
            $role->add_cap( 'imbachat_audio_message' );
            $role->add_cap( 'imbachat_video_message' );
            $role->add_cap( 'imbachat_audio_message_enable' );
            $role->add_cap( 'imbachat_available_chat' );
     }
    }
}