<h1 class="IC_title">ImbaChatWidget settings</h1>
<form class="IC_form" name="IC_setting_setup" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>?page=imbachat">
    <?php
        if(function_exists('vp_nonce_field')){
            vp_nonce_field('IC_setting_setup');
        }
    ?>
    <div class="IC_form__field">
        <label class="IC_form__label">Developer id</label>
        <input class="IC_form__input" name="IC_dev_id" value="<?php echo get_option('IC_dev_id')?>" type="text">
    </div>
    <div class="IC_form__field">
        <label class="IC_form__label">Developer login</label>
        <input class="IC_form__input" name="IC_login" value="<?php echo get_option('IC_login')?>" type="text">
    </div>
    <div class="IC_form__field">
        <label class="IC_form__label">Developer password</label>
        <input class="IC_form__input" name="IC_password" value="<?php echo get_option('IC_password')?>" type="text">
    </div>
    <div class="IC_form__field">
        <label class="IC_form__label">Secret key</label>
        <input class="IC_form__input" name="IC_secret_key" value="<?php echo get_option('IC_secret_key')?>" type="text">
    </div>
    <button class="IC_form__button" name="IC_setting_setup" type="submit">Save</button>
</form>
<style>
    .IC_title{
        color: #2196F3;
        margin-bottom: 40px;
    }
    .IC_form__field {
        margin-left: 20px;
    }
    .IC_form__label {
        font-size: 20px;
        color: #828282;
    }
    .IC_form__input {
        display: block;
        height: 40px;
        border-radius: 4px;
        margin-bottom: 10px;
        margin-top: 12px;
        padding-left: 15px;
        font-size: 16px;
        width: 450px;
    }
    .IC_form__button{
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