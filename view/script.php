<?php do_action('IC_scripts');?>
<script>
    function imbachatWidget(){
        if(!window.ImbaChat){
            return setTimeout(imbachatWidget, 50);
        }
        params = <?php echo $json_data; ?>;
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
    imbachatWidget();
</script>