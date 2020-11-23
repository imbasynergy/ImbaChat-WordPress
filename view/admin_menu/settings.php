<h1 class="IMCH_title">ImbaChat settings</h1>
<h3>Current widget id - <?= get_option('IMCH_dev_id') ?></h3>
<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" style="padding-top: 15px">
    <input type="hidden" name="action" value="sync_with_imbachat">
    <div class="IMCH_form__field">
        <label class="IMCH_form__label">Widget id</label>
        <input class="IMCH_form__input" name="IMCH_dev_id" placeholder="" type="text" required>
    </div>
    <button class="IMCH_form__button" type="submit">Connect to the widget</button>
</form>
<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" style="padding-top: 15px">
    <input type="hidden" name="action" value="sync_with_imbachat">
    <div class="IMCH_form__field">
        <input class="IMCH_form__input" name="IMCH_dev_id" placeholder="" value="-1" type="hidden" required>
    </div>
    <button class="IMCH_form__button" type="submit">Create a widget</button>
</form>
<div>
    <h3>If our plugin helped you to make better website, please leave a review in our <a href="https://wordpress.org/plugins/imbachat-widget/">wordpress plugin`s official page.</a> Thank you for using our chat!</h3>
</div>
<div>
    <h3>If you have some problems or extra questions about our plugin, you can create a ticket in our <a href="https://wordpress.org/support/plugin/imbachat-widget/">support forum</a></h3>
</div>
<style>
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