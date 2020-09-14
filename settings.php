<?php

require_once( IMBACHAT__PLUGIN_DIR . '/controllers/IMCH_USERS_Controller.php' );
require_once( IMBACHAT__PLUGIN_DIR . '/includes/imbachat_functions.php' );
require_once( IMBACHAT__PLUGIN_DIR . '/widgets/ic_widgets.php' );

wp_register_style( 'imbachat.css', IC_PLUGIN_URL.'/assets/css/imbachat.css');
wp_enqueue_style( 'imbachat.css');
wp_register_style( 'fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
wp_enqueue_style( 'fontawesome');

if (get_option('IMCH_buddypress') == 1)
    require_once( IMBACHAT__PLUGIN_DIR . '/includes/buddyPressInt.php' );

if (get_option('IMCH_market') == 1)
    require_once( IMBACHAT__PLUGIN_DIR . '/includes/wcfm_market_int.php' );

if ( is_admin() ) {
    require_once IMBACHAT__PLUGIN_DIR . '/admin/admin.php';
}

add_action('plugins_loaded', 'imbachat');

function imbachat(){
    add_shortcode( 'ic_open_dialog', 'ic_open_dialog_with' );
    add_shortcode( 'ic_open_chat', 'ic_open_chat' );
    add_shortcode( 'ic_close_chat', 'ic_close_chat' );
}

add_action('wp_footer', function()
{
    if (get_option('IMCH_dev_id' == ''))
    {
        $IMCH_dev_id = '209';
        $IMCH_login = 'dev1322560';
        $IMCH_password = 'cscblppfmjhjz36pbzbij';
        $IMCH_secret_key = 'igrhel0er7py4xwnizo31';
        update_option('IMCH_dev_id', $IMCH_dev_id);
        update_option('IMCH_login', $IMCH_login);
        update_option('IMCH_password', $IMCH_password);
        update_option('IMCH_secret_key', $IMCH_secret_key);
    }
    $dev_id = get_option('IMCH_dev_id');
    $json_data = IMCH_getJsSettingsString();
    //echo '<div class="countMessages new-message"><span class="counter">0</span><i class="fa fa-envelope-o" aria-hidden="true"></i></div>';
    require_once( IMBACHAT__PLUGIN_DIR . '/view/script.php' );
});

add_action('admin_menu',function ()
{
    add_options_page('ImbaChatWidget', 'ImbaChat Settings', 8, 'imbachat',function ()
    {

        add_option('IMCH_dev_id', '');
        add_option('IMCH_login', '');
        add_option('IMCH_password', '');
        add_option('IMCH_secret_key', '');
        add_option('IMCH_buddypress', '');
        add_option('IMCH_market', '');
        if(isset($_POST['IMCH_setting_setup']) && check_admin_referer( 'IMCH_setting_setup' ) && current_user_can('administrator')){

            $IMCH_dev_id = sanitize_text_field($_POST['IMCH_dev_id']);
            $IMCH_login = sanitize_text_field($_POST['IMCH_login']);
            $IMCH_password = $_POST['IMCH_password'];
            $IMCH_secret_key = sanitize_text_field($_POST['IMCH_secret_key']);
            $IMCH_buddypress = $_POST['IMCH_buddypress'];
            $IMCH_market = $_POST['IMCH_market'];

            update_option('IMCH_dev_id', $IMCH_dev_id);
            update_option('IMCH_login', $IMCH_login);
            update_option('IMCH_password', $IMCH_password);
            update_option('IMCH_secret_key', $IMCH_secret_key);
            update_option('IMCH_buddypress', $IMCH_buddypress);
            update_option('IMCH_market', $IMCH_market);

        }
        require_once( IMBACHAT__PLUGIN_DIR . '/view/admin.php' );
    });
});

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
