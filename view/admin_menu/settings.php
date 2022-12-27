<h1 class="IMCH_title"><?php _e("ImbaChat settings", "imbachat") ?></h1>
<h3><?php _e("Current widget id", "imbachat") ?>Current widget id - <?php echo esc_attr( get_option('IMCH_dev_id') ); ?></h3>
<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" style="padding-top: 15px">
    <input type="hidden" name="action" value="sync_with_imbachat">
    <div class="IMCH_form__field">
        <label class="IMCH_form__label"><?php _e("Widget id", "imbachat") ?></label>
        <input class="IMCH_form__input" value="<?php echo esc_attr( get_option('IMCH_dev_id') ); ?>" name="IMCH_dev_id" placeholder="" type="text" required>
    </div>
    <div class="IMCH_form__field">
        <button class="IMCH_form__button" type="submit" data-qa="connect_widget"><?php _e("Connect to the widget", "imbachat") ?></button>
    </div>
</form>
<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" style="padding-top: 15px;padding-bottom: 15px">
    <input type="hidden" name="action" value="sync_with_imbachat">
    <div class="IMCH_form__field">
        <input class="IMCH_form__input" name="IMCH_dev_id" placeholder="" value="-1" type="hidden" required>
    </div>
    <div class="IMCH_form__field">
        <button class="IMCH_form__button" type="submit" data-qa="create_widget"><?php _e("Create a widget", "imbachat") ?></button>
    </div>
</form>
<div>
    <h3><?php _e("If our plugin helped you to make better website, please leave a review in our", "imbachat") ?> <a href="https://wordpress.org/plugins/imbachat-widget/"><?php _e("wordpress plugin`s official page.", "imbachat") ?></a> <?php _e("Thank you for using our chat!", "imbachat") ?></h3>
</div>
<div>
    <h3><?php _e("If you have some problems or extra questions about our plugin, you can create a ticket in our") ?> <a href="https://wordpress.org/support/plugin/imbachat-widget/"><?php _e("support forum", "imbachat") ?></a></h3>
</div>
<?php
        wp_register_style( 'admin-menu-settings-style', '',);
        wp_enqueue_style( 'admin-menu-settings-style' );
        wp_add_inline_style( 'admin-menu-settings-style', "
        .IMCH_title{
            color: #2196F3;
            margin-bottom: 10px;
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
            padding: 0 !important;
            width: 450px;
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
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        ");
    ?>