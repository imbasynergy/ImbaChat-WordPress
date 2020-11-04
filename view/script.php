<script src="https://api.imbachat.com/imbachat/v1/<?php echo $dev_id; ?>/widget"></script>
<script>
    function imbachatWidget(){
        if(!window.ImbaChat){
            return setTimeout(imbachatWidget, 50);
        }
        window.ImbaChat.load(<?php echo $json_data; ?>)
    }
</script>