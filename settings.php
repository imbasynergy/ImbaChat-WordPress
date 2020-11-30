<?php

require_once( IMBACHAT__PLUGIN_DIR . '/controllers/IMCH_USERS_Controller.php' );
require_once( IMBACHAT__PLUGIN_DIR . '/includes/imbachat_functions.php' );
require_once( IMBACHAT__PLUGIN_DIR . '/widgets/ic_widgets.php' );
require_once( IMBACHAT__PLUGIN_DIR . '/includes/assign_hooks.php' );
require_once (IMBACHAT__PLUGIN_DIR . '/admin/sync/sync.php');

wp_register_style( 'imbachat.css', IC_PLUGIN_URL.'/assets/css/imbachat.css');
wp_enqueue_style( 'imbachat.css');
wp_register_style( 'fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
wp_enqueue_style( 'fontawesome');

require_once( IMBACHAT__PLUGIN_DIR . '/includes/buddyPressInt.php' );

require_once( IMBACHAT__PLUGIN_DIR . '/includes/wcfm_market_int.php' );

if ( is_admin() ) {
    require_once IMBACHAT__PLUGIN_DIR . '/admin/admin.php';
}
require_once IMBACHAT__PLUGIN_DIR . '/view/users_table.php';
add_action('plugins_loaded', 'imbachat');

function imbachat(){
    add_shortcode( 'ic_open_dialog', 'ic_open_dialog_with' );
    add_shortcode( 'ic_create_group', 'ic_create_group_with' );
    add_shortcode( 'ic_join_group', 'ic_join_group' );
    add_shortcode( 'ic_open_chat', 'ic_open_chat' );
    add_shortcode( 'ic_close_chat', 'ic_close_chat' );
    add_shortcode( 'ic_wise_chat', 'ic_wise_chat');
    add_shortcode('users_main_page', 'get_users_for_auth');
    if (get_option('IMCH_login','') == '' || get_option('IMCH_password','') == '' || get_option('IMCH_secret_key','') == '')
    {
        if (get_option('IMCH_dev_id', '') == '')
            $dev_id = null;
        else
            $dev_id = get_option('IMCH_dev_id');
        //sync_with_imba_api($dev_id, $_SERVER['HTTP_HOST'], get_option( 'admin_email' ));
    }

    wp_register_script('IMCH_script', IC_PLUGIN_URL.'/view/imbachat.js','','', true);
    wp_enqueue_script( 'IMCH_script');
    //wp_enqueue_script('my-amazing-script');
}
add_action('wp_footer', function()
{
    if (get_option('IMCH_dev_id') == '')
    {
        $IMCH_dev_id = '276';
        $IMCH_login = 'dev9299352';
        $IMCH_password = 'ahxf5jju40kplc0ybyuk2h';
        $IMCH_secret_key = 'ksd234hy0wq0o3n0onealqn';
        update_option('IMCH_dev_id', $IMCH_dev_id);
        update_option('IMCH_login', $IMCH_login);
        update_option('IMCH_password', $IMCH_password);
        update_option('IMCH_secret_key', $IMCH_secret_key);
    }

    $dev_id = get_option('IMCH_dev_id');
    $json_data = IMCH_getJsSettingsString();
    require_once( IMBACHAT__PLUGIN_DIR . '/view/script.php' );
});

// добавляет новую крон задачу
add_action( 'wp', 'imba_cron_activation' );
function imba_cron_activation() {
    wp_clear_scheduled_hook( 'imba_wp_stat' );
    if( ! wp_next_scheduled( 'imba_wp_stat' ) ) {
        wp_schedule_event( time(), 'daily', 'imba_wp_stat');
    }
}

// добавляем функцию к указанному хуку
add_action( 'imba_wp_stat', 'do_imba_wp_stat' );
function do_imba_wp_stat(){
    try {

        $apl=get_option('active_plugins');
        $apl = json_encode($apl);

        $post_data = [
            'host' => $_SERVER['HTTP_HOST'],
            'lang' => get_locale(),
            'name' => $_SERVER['SERVER_NAME'],
            'plugins' => $apl,
            'admin_mail' => get_option( 'admin_email' ),
            'template' => get_option( 'template' ),
            'widget_id' => sanitize_text_field(get_option('IMCH_dev_id'))
        ];
        $url = 'https://api.imbachat.com/imbachat/api/wp_stat';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);

//                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//                curl_setopt($curl, CURLOPT_USERPWD, $auth_password);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        //curl_setopt($curl, CURLOPT_POSTFIELDS, "users=".$arr);


        $curlout = curl_exec($curl);
        curl_close($curl);
    } catch (Exception $exception){

    }
}

function IMCH_getJsSettingsString($opt = []) {

    $user_id = get_current_user_id();
    $token = IMCH_getJWT();
    $extend_settings = array_merge(
        [
            // Предустановленные значения по умолчанию
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
    // Итоговые настройки виджета
    return json_encode($extend_settings);
}

function IMCH_getJWT(){
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
