imbachatWidget();
jQuery(document).ready(function () {
    jQuery("#ic_join_group_btn").html(imbaChatLangJson["wp_join_group"])
})
function open_dialog(id, jwt = '', button = false){
    let spinner = document.createElement('div')
    if (button)
    {
        button.setAttribute('disabled', 'disabled')
        button.classList.toggle('imba_button_load');
        spinner.classList.toggle('imba_loader')
        button.prepend(spinner);
    }
    imbaApi.openDialog(id, 0, jwt)
        .then(() => {
            if (button)
            {
                button.classList.toggle('imba_button_load');
                spinner.remove()
                button.removeAttribute('disabled')
            }
        })
        .catch(() => {
            if (button)
            {
                button.classList.toggle('imba_button_load');
                spinner.remove()
                button.removeAttribute('disabled')
            }
        })
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