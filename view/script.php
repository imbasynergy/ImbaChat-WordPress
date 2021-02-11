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