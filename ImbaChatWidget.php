<?php
/*
Plugin Name: ImbaChat Widget
*/

define( 'IMBACHAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( IMBACHAT__PLUGIN_DIR . '/controllers/IMCH_USERS_Controller.php' );

add_action('imbachat', function()
{
    if(!is_user_logged_in())
        return;
    $dev_id = get_option('IMCH_dev_id');
    $json_data = IMCH_getJsSettingsString();
    require_once( IMBACHAT__PLUGIN_DIR . '/view/script.php' );
    /*wp_enqueue_script( 'IMCH_script', 'https://api.imbachat.com/imbachat/v1/'.$dev_id.'/widget');
    wp_add_inline_script( 'IMCH_script', "function imbachatWidget(){
        if(!window.ImbaChat){
            return setTimeout(imbachatWidget, 50);
        }
        params = ".$json_data.";
        params['onInitSuccess'] = () =>{
            imbaChat.openChat()
            imbaChat.addToRoom({
                pipe:'c100',
                title:'Conf 100',
                'is_public': 1,
                type:imbaChat.room_type.conference,
                'users_ids':[
                    {
                        user_id:params.user_id
                    }
                ]
            })
        }
        window.ImbaChat.load(params)
    }
    imbachatWidget();");*/
});

add_action('admin_menu',function ()
{
    add_options_page('ImbaChatWidget', 'ImbaChat Settings', 8, 'imbachat',function ()
    {

        add_option('IMCH_dev_id', '');
        add_option('IMCH_login', '');
        add_option('IMCH_password', '');
        add_option('IMCH_secret_key', '');
        if(isset($_POST['IMCH_setting_setup']) && check_admin_referer( 'IMCH_setting_setup' ) && current_user_can('administrator')){

            $IMCH_dev_id = sanitize_text_field($_POST['IMCH_dev_id']);
            $IMCH_login = sanitize_text_field($_POST['IMCH_login']);
            $IMCH_password = $_POST['IMCH_password'];
            $IMCH_secret_key = sanitize_text_field($_POST['IMCH_secret_key']);

            update_option('IMCH_dev_id', $IMCH_dev_id);
            update_option('IMCH_login', $IMCH_login);
            update_option('IMCH_password', $IMCH_password);
            update_option('IMCH_secret_key', $IMCH_secret_key);

        }
        require_once( IMBACHAT__PLUGIN_DIR . '/view/admin.php' );
    });
});

add_shortcode( 'ic_open_dialog', 'ic_open_dialog_with' );

function ic_open_dialog_with( $atts, $content = null, $code = '' ) {

    if ( is_feed() ) {
        return '[ic_open_dialog]';
    }

    if ( 'ic_open_dialog' == $code ) {
        $atts = shortcode_atts(
            array(
                'id' => 0,
            ),
            $atts, 'ic'
        );

        $id = (int) $atts['id'];
    }
    require_once( IMBACHAT__PLUGIN_DIR . '/view/ic_functions.php' );
    return '<button onclick="open_dialog('.$id.')">click me</button>';
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