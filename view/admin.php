<h1 class="IMCH_title"><?php _e("ImbaChat settings", "imbachat") ?></h1>
<form class="IMCH_form" name="IMCH_setting_setup" method="POST" action="<?php echo esc_attr($_SERVER['PHP_SELF'])?>?page=imbachat">
    <?php
    if(function_exists('wp_nonce_field')){
        wp_nonce_field('IMCH_setting_setup');
    }
    ?>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label"><?php _e("Widget id", "imbachat") ?></label>
        <input class="IMCH_form__input" name="IMCH_dev_id" value="<?php echo esc_attr(get_option('IMCH_dev_id'))?>" type="text">
    </div>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label"><?php _e("API login", "imbachat") ?></label>
        <input class="IMCH_form__input" name="IMCH_login" value="<?php echo esc_attr(get_option('IMCH_login'))?>" type="text">
    </div>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label"><?php _e("API password", "imbachat") ?></label>
        <input class="IMCH_form__input" name="IMCH_password" value="<?php echo esc_attr(get_option('IMCH_password'))?>" type="text">
    </div>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label"><?php _e("Secret key", "imbachat") ?></label>
        <input class="IMCH_form__input" name="IMCH_secret_key" value="<?php echo esc_attr(get_option('IMCH_secret_key'))?>" type="text">
    </div>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label"><?php _e("BuddyPress integration", "imbachat") ?></label>
        <input class="IMCH_form__input" name="IMCH_buddypress" <?php echo esc_attr(get_option('IMCH_buddypress'))==1 ? 'checked' : '' ?> value="1" type="checkbox">
    </div>
    <div class="IMCH_form__field">
        <label class="IMCH_form__label"><?php _e("Market integration", "imbachat") ?></label>
        <input class="IMCH_form__input" name="IMCH_market" <?php echo esc_attr(get_option('IMCH_market'))==1 ? 'checked' : '' ?> value="1" type="checkbox">
    </div>
    <button class="IMCH_form__button" name="IMCH_setting_setup" type="submit"><?php _e("Save") ?></button>
</form>
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