<h1 class="IMCH_title">ImbaChat Links</h1>

<form id="link_imba_form" class="IMCH_form" method="post">
    <input hidden id="IMCH_dev_id" value="<?php echo get_option('IMCH_dev_id', '')?>">
    <input hidden id="IMCH_host" value="<?php echo $_SERVER['HTTP_HOST']?>">
    <div>
        <h3>Create your ImbaChat account or if you have already registered write your email to link into widget setting`s page</h3>
        <div class="IMCH_form__field">
            <label class="IMCH_form__label" for="email">Your email address</label>
            <input id="email" name="im_email" class="IMCH_form__input" value="<?= get_option( 'admin_email' ) ?>">
        </div>
        <div class="IMCH_form__field">
            <button class="IMCH_form__button" type="submit" id="submit_imba">Submit</button>
        </div>
    </div>
</form>
<div id="links_block">
</div>
<script>

    jQuery(function($){
        $("#link_imba_form").submit( async function (e) {
            e.preventDefault();
            let result;
            let user_mail = '';
            await $.ajax(
                {
                    url: 'https://imbachat.com/api/v1/get/user',
                    type: 'POST',
                    data: {
                        email: $("#email").val()
                    },
                    success: function (data) {
                        if (data.user) {
                            result = true;
                            user_mail = data.user.email
                        }
                        else
                            result = false;
                    },
                    error: function () {
                        result = false;
                    }
                }
            )

            let dev_id = $("#IMCH_dev_id").val() ? $("#IMCH_dev_id").val() : null
            console.log(dev_id)
            await $.ajax({
                url: 'https://api.imbachat.com/developers/api/v1/sync',
                type: 'POST',
                data: {
                    email: user_mail,
                    'dev_id': dev_id,
                    cms: 'ImbaChat-WordPress',
                    host: $("#IMCH_host").val()
                },
                success: function (data) {
                    console.log(data)
                },
                error: function () {
                    result = false;
                }
            })
            if (result)
                get_links_to_imbachat()
        });

        function get_links_to_imbachat (){
            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php")?>',
                type: 'POST',
                data: {
                    action: 'get_links_to_imbachat',
                    param: 'test'
                },
                success: function (response) {
                    let data = JSON.parse(response);
                    let imbachat_link = data.imbachat;
                    let dashboard_link = data.imachat_dashboard;
                    console.log(data)
                    $("#links_block").html(
                        '<div class="IMCH_form__field">\n' +
                        '        <button class="IMCH_form__button" onclick="go_to(\''+imbachat_link+'\')">Visit ImbaChat.com admin panel</button>\n' +
                        '    </div>\n' +
                        '    <div class="IMCH_form__field">\n' +
                        '        <button class="IMCH_form__button" onclick="go_to(\''+dashboard_link+'\')">Visit ImbaChat dashboard panel</button>\n' +
                        '    </div>'
                    )
                }
            })
        }
    });
    function go_to(link) {
        window.open(link);
    }
</script>
<style>
    .IMCH_title{
        color: #2196F3;
        margin-bottom: 40px;
    }
    .IMCH_form__field {
        padding-top: 10px;
        margin-left: 20px;
    }
    .IMCH_form__label {
        font-size: 20px;
        color: #828282;
    }
    .IMCH_form__input {
        display: block;
        height: 40px;
        border-radius: 4px;
        margin-bottom: 10px;
        margin-top: 12px;
        padding-left: 15px;
        font-size: 16px;
        width: 450px;
    }
    .IMCH_form__button{
        background: #4597f3;
        color: white;
        outline: 0px;
        border: 0px;
        border-radius: 3px;
        font-size: 20px;
        cursor: pointer;
    }
</style>