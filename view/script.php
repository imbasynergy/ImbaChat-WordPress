<?php 
$exit=true;
$user['user_id']=get_current_user_id(); 
$permi=apply_filters( 'rest_request_before_callbacks', $user, ['imbachat_callback' => 'get_users'], $_REQUEST ); 
if (isset($permi["permissions"]["available_chat"]) && (int)$permi["permissions"]["available_chat"] == 0) $exit=false; 
?>
<?php if ($exit) : ?>
<script src="https://api.imbachat.com/imbachat/v1/<?php echo $dev_id; ?>/widget"></script>
<script>
    function imbachatWidget(){
        if(!window.ImbaChat){
            return setTimeout(imbachatWidget, 50);
        }
        window.ImbaChat.load(<?php echo $json_data; ?>).then(() =>{
            let img = jQuery('.ic_bp_button').find('img')[0];
            jQuery('.ic_bp_button').text( gettext('imbachat','wp_chat_with_user'))
            jQuery('.ic_bp_button').prepend(img)
        })
    }
</script>
<?php endif;  ?>
<?php 
if ($exit){
wp_register_style( 'imbachat.css', IC_PLUGIN_URL.'/assets/css/imbachat.css');
wp_enqueue_style( 'imbachat.css');
wp_register_style( 'fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
wp_enqueue_style( 'fontawesome');
}
?>