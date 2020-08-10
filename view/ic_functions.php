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
</script>