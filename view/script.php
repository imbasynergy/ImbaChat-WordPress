<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://api.imbachat.com/imbachat/v1/<?php echo $dev_id; ?>/widget"></script>
<script>
    function imbachatWidget(){
        if(!window.ImbaChat){
            return setTimeout(imbachatWidget, 50);
        }
        window.ImbaChat.load(<?php echo $json_data; ?>)
    }
    imbachatWidget();
    /*window.tabSignal.on("imbaChat.newMessagesUpdate", function(event){
        if(event.newMessagesSum>0){
            $('.new-message').css('display', 'flex');
            //$('div>.new-message').show();
            $('.counter').show();
            $('.counter').html(event.newMessagesSum);
        } else {
            $('div>.counter').hide()
            $('.new-message').css('display', 'none');

        }
    });*/
</script>