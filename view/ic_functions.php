<script>
    function open_dialog(id, jwt = ''){
        imbaApi.openDialog(id, 0, jwt)
    }

    function ic_create_dialog(test) {
        let inputs = jQuery("#ic_create_group_cont input");
        let data = {}
        inputs.each((index, item, array) => {
            data[item.id] = item.value
        })
        imbaApi.addToRoom({
            pipe:data['ic_group_pipe'],
            title:data['ic_group_title'],
            'is_public': 1,
            type:imbaApi.room_type.conference,
        })
    }

    function ic_join_group(pipe, title = '') {
        imbaApi.addToRoom({
            pipe:pipe,
            title:title,
            'is_public': 1,
            type:imbaApi.room_type.conference,
        })
    }

    function showChat() {
        if(imbaApi)
        {
            imbaApi.openChat();
            return false;
        }
    }

    function closeChat() {
        if(imbaApi)
        {
            imbaApi.closeChat();
            return false;
        }
    }
</script>
