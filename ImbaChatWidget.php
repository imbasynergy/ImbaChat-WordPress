<?php
/*
Plugin Name: ImbaChat Widget
*/

define( 'IMBACHAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( IMBACHAT__PLUGIN_DIR . '/controllers/IC_USERS_Controller.php' );

add_action('imbachat', function()
{
    if(!is_user_logged_in())
        return;
    $dev_id = get_option('IC_dev_id');
    $json_data = getJsSettingsString();
    require_once( IMBACHAT__PLUGIN_DIR . '/view/script.php' );
});

add_action('admin_menu',function ()
{
    add_options_page('ImbaChatWidget', 'IC Widget Settings', 8, 'imbachat',function ()
    {
        add_option('IC_dev_id', '');
        add_option('IC_login', '');
        add_option('IC_password', '');
        add_option('IC_secret_key', '');
        if(isset($_POST['IC_setting_setup'])){
            // if(function_exists['current_user_can'] && !current_user_can('manage_options'))
            //     die ( _e('Hacker?', 'IC'));
            // if(function_exists('check_admin_referer'))
            //     check_admin_referer('IC_setting_setup');
            $IC_dev_id = $_POST['IC_dev_id'];
            $IC_login = $_POST['IC_login'];
            $IC_password = $_POST['IC_password'];
            $IC_secret_key = $_POST['IC_secret_key'];

            update_option('IC_dev_id', $IC_dev_id);
            update_option('IC_login', $IC_login);
            update_option('IC_password', $IC_password);
            update_option('IC_secret_key', $IC_secret_key);


        }
        require_once( IMBACHAT__PLUGIN_DIR . '/view/admin.php' );
    });
});
 

function getJsSettingsString($opt = []) {

    $user_id = get_current_user_id();
    $token = getJWT();
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
function getJWT(){
    // Create token header as a JSON string
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $pass = get_option('IC_secret_key');
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