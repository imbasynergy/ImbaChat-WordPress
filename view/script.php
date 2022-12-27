<?php 
$exit=true;
$user['user_id']=get_current_user_id(); 
$permi=apply_filters( 'rest_request_before_callbacks', $user, ['imbachat_callback' => 'get_users'], $_REQUEST ); 
if (isset($permi["permissions"]["available_chat"]) && (int)$permi["permissions"]["available_chat"] == 0) $exit=false; 
?>
<?php if ($exit) : ?>
<?php 
wp_register_script( 'imbachat_widget',"https://api.imbachat.com/imbachat/v1/".esc_attr($dev_id)."/widget");
wp_enqueue_script( 'imbachat_widget' );
?>
<?php $imbachat_json_decode =json_decode($json_data);  ?>
<?php if ($imbachat_json_decode->user_id!=0) : ?>
    <?php 
    wp_add_inline_script( 'IMCH_script'  , "
    function imbachatWidget(){
        if(!window.ImbaChat){
            return setTimeout(imbachatWidget, 50);
        }
        window.ImbaChat.load(".$json_data.").then(() =>{
            let img = jQuery('.ic_bp_button').find('img')[0];
            jQuery('.ic_bp_button').text( gettext('imbachat','wp_chat_with_user'))
            jQuery('.ic_bp_button').prepend(img)
        })
    }
    ",'before');
    ?>
<?php else:  ?>
    <?php 
    wp_add_inline_script( 'IMCH_script'  , "
    function imbachatWidget(){
        if(!window.ImbaChat){
            return setTimeout(imbachatWidget, 50);
        }
        window.ImbaChat.load().then(() =>{
            let img = jQuery('.ic_bp_button').find('img')[0];
            jQuery('.ic_bp_button').text( gettext('imbachat','wp_chat_with_user'))
            jQuery('.ic_bp_button').prepend(img)
        })
    }
    ",'before');
    ?>
<?php endif;  ?>
<?php endif;  ?>
<?php 
if ($exit){
wp_register_style( 'imbachat.css', IMBACHAT_IC_PLUGIN_URL.'/assets/css/imbachat.css');
wp_enqueue_style( 'imbachat.css');
wp_register_style( 'fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
wp_enqueue_style( 'fontawesome');
}
?>