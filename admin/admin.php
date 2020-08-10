<?php

add_action('admin_menu', function(){
    add_menu_page( 'ImbaChat Widget', 'ImbaChat', 'manage_options', 'imbachat-options', 'add_my_setting', '', 30 );
} );
function add_my_setting(){
    ?>
    <div class="wrap">
        <h2><?php echo get_admin_page_title() ?></h2>
        <div>
            <h3>Instruction after installing plugin</h3>
            <p>Firstly, you need to pass registration <a href="https://imbachat.com/register">here</a>,
                if you are already done this before, follow the next steps</p>
            <div style="float: left">
                <ul>
                    <li>1. Go to <a href="https://imbachat.com/user">user dashboard</a> at our site</li>
                    <li>2. Click at "Widgets" here <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/settings_dashboard.PNG' ?>"></li>
                    <li>3. Click "Setting"</li>
                    <li>4. "Integrate option" choose WordPress</li>
                    <li>5. "Host" write your site url without http:// (for example: your-site-domain-url.com)</li>
                    <li>6. Go to "Extended api settings" section <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/EAS.PNG' ?>"></li>
                    <li>7. "Users info URL" fill like http://your-site-domain-url.com/wp-json/imbachat/v1/getusers/</li>
                    <li>8. "Symbol to split arguments with user id" fill with ','</li>
                </ul>
                Finally, go to Word-Press admin panel->Settings->ImbaChat Settins and fill all fields with information
                from section "Data by security" at your widget's settings panel at ImbaChat.com.
                Your "Developer ID" is here, after "Widget setting #" <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/devId.PNG' ?>">
            </div>
        </div>
    </div>
    <?php

}?>
