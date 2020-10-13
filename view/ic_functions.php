<script>
    function open_dialog(id){
        imbaApi.openDialog(id)
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

    function ic_create_dialog(test) {
        let inputs = $("#ic_create_group_cont input");
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

    function ic_join_group(pipe) {
        imbaApi.addToRoom({
            pipe:pipe,
            'is_public': 1,
            type:imbaApi.room_type.conference,
        })
    }
</script>