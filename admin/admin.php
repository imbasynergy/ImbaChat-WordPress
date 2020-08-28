<?php

add_action('admin_menu', function(){
    add_menu_page( 'ImbaChat Widget', 'ImbaChat', 8, 'imbachat-options', 'add_my_setting', '', 30 );
} );
function add_my_setting(){
    ?>
    <div class="wrap">
        <h1><?php echo get_admin_page_title() ?></h1>
        <div class="instruction">
            <h3>Instruction after installing plugin</h3>
            <p>Firstly, you need to pass registration <a href="https://imbachat.com/register">here</a>,
                if you are already done this before, follow the next steps</p>
            <div style="">
                <ul class="list">
                    <li>1. Go to <a href="https://imbachat.com/user">user dashboard</a> at our site</li>
                    <li>2. Click at "Widgets" here <div class="image-ins">
                            <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/settings_dashboard.jpg' ?>">
                        </div></li>
                    <li>3. Click "Setting"</li>
                    <li>4. "Integrate option" choose WordPress</li>
                    <li>5. "Host" write your site url without http:// (for example: your-site-domain-url.com)</li>
                    <li>6. Go to "Extended api settings" section <div class="image-ins">
                            <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/EAS.PNG' ?>">
                        </div></li>
                    <li>7. "Users info URL" fill like http://your-site-domain-url.com/wp-json/imbachat/v1/getusers/</li>
                    <li>8. "Symbol to split arguments with user id" fill with ','</li>
                </ul>
                <p>
                    Finally, go to Word-Press admin panel -> "Settings" -> "ImbaChat Settings" and fill all fields with information
                    from section "Data by security" at your widget's settings panel at ImbaChat.com.</p>
                <p>Your "Widget ID" is here, after "Widget setting #"</p>
                <div class="image-ins">
                    <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/information.gif' ?>">
                </div>
            </div>
        </div>
        <div class="instruction">
            <h3>Also you can integrate our plugin with Buddypress plugin and wcfm plugin</h3>
            <p>For that you need to fill correct checkbox at your admin panel panel->Settings->ImbaChat Settins "BuddyPress integration" or "Market integration"</p>
        </div>
    </div>
    <style>
        .instruction p{
            font-size: 20px;
            padding: 10px 0px 10px 0px;
        }
        .list li{
            font-size: 20px;
            padding: 10px 0px 10px 0px;
        }
        .image-ins{
            padding: 10px 0px 10px 0px;
        }
    </style>
    <?php

}?>
