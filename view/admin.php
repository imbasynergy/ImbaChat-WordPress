<h1 class="IMCH_title">ImbaChatWidget settings</h1>
<form class="IMCH_form" name="IMCH_setting_setup" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>?page=imbachat">
    <?php
        if(function_exists('wp_nonce_field')){
            wp_nonce_field('IMCH_setting_setup');
        }
    ?>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label">Developer id</label>
        <input class="IMCH_form__input" name="IMCH_dev_id" value="<?php echo get_option('IMCH_dev_id')?>" type="text">
    </div>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label">Developer login</label>
        <input class="IMCH_form__input" name="IMCH_login" value="<?php echo get_option('IMCH_login')?>" type="text">
    </div>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label">Developer password</label>
        <input class="IMCH_form__input" name="IMCH_password" value="<?php echo get_option('IMCH_password')?>" type="text">
    </div>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label">Secret key</label>
        <input class="IMCH_form__input" name="IMCH_secret_key" value="<?php echo get_option('IMCH_secret_key')?>" type="text">
    </div>
    <button class="IMCH_form__button" name="IMCH_setting_setup" type="submit">Save</button>
</form>
<style>
    .IMCH_title{
        color: #2196F3;
        margin-bottom: 40px;
    }
    .IMCH_form__field {
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
        width: 300px;
        margin-top: 20px;
        background: #4597f3;
        color: white;
        outline: 0px;
        border: 0px;
        border-radius: 3px;
        font-size: 20px;
        height: 40px;
        cursor: pointer;
    }
</style>