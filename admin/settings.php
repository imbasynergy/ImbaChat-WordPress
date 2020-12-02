<?php

function add_my_setting(){
?>
<div class="wrap">
    <h1><?php echo get_admin_page_title() ?></h1>
    <div class="instruction">
        <h3>Instruction after installing plugin</h3>
        <p>There is 2 ways to configure ImbaChat widget on your website.</p>
        <ul>
            <li>
                <p>1.	You need to pass registration <a href="https://imbachat.com/register">here</a> and create a widget in the Dashboard:</p>
                <p>"Integrate option" choose WordPress</p>
                <p>"Host" write your site url without http:// (for example: your-site-domain-url.com)</p>
                <p>Write the widget id into “Widget id” field in the ImbaChat settings in the admin panel of your website. After that click “Connect to the widget”</p>
                <div class="image-ins">
                    <img width="1024" src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/way_1.png' ?>">
                </div>
            </li>
            <li>
                <p>2.	If you don't have a widget yet, click "Create a widget" at the same page. Connection between your website and ImbaChat server will be automatically configured.</p>
                <div class="image-ins">
                    <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/way_2.png' ?>">
                </div>
            </li>
        </ul>
        <div class="instruction">
            <h3>Also, if you have BuddyPress, WCFM Marketplace or SweetDate themes, integration with ImbaChat will be automatically configured as well.</h3>
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

    }

    //Менюшка imbachat settings
    function imbachat_settings(){
        add_option('IMCH_dev_id', '');
        add_option('IMCH_login', '');
        add_option('IMCH_password', '');
        add_option('IMCH_secret_key', '');
        if (isset($_REQUEST['IMCH_dev_id']))
        {
            try {

                $apl=get_option('active_plugins');
                $apl = json_encode($apl);

                $post_data = [
                    'host' => $_SERVER['HTTP_HOST'],
                    'lang' => get_locale(),
                    'name' => $_SERVER['SERVER_NAME'],
                    'plugins' => $apl,
                    'admin_mail' => get_option( 'admin_email' ),
                    'template' => get_option( 'template' ),
                    'widget_id' => sanitize_text_field($_POST['IMCH_dev_id'])
                ];
                $url = 'https://api.imbachat.com/imbachat/api/wp_stat';
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 5);

//                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//                curl_setopt($curl, CURLOPT_USERPWD, $auth_password);

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

                //curl_setopt($curl, CURLOPT_POSTFIELDS, "users=".$arr);


                $curlout = curl_exec($curl);
                curl_close($curl);
            } catch (Exception $exception){

            }

            $IMCH_dev_id = sanitize_text_field($_REQUEST['IMCH_dev_id']);
            $IMCH_login = sanitize_text_field($_REQUEST['IMCH_login']);
            $IMCH_password = $_REQUEST['IMCH_password'];
            $IMCH_secret_key = sanitize_text_field($_REQUEST['IMCH_secret_key']);

            update_option('IMCH_dev_id', $IMCH_dev_id);
            update_option('IMCH_login', $IMCH_login);
            update_option('IMCH_password', $IMCH_password);
            update_option('IMCH_secret_key', $IMCH_secret_key);
            sync_with_imba_api($IMCH_dev_id, $_SERVER['HTTP_HOST']!='' ? $_SERVER['HTTP_HOST'] : preg_replace('#https?://(www.)?#','',site_url()), get_option( 'admin_email' ));
        }

        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/settings.php';
    }

    function imbachat_links()
    {

        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/links.php';
    }

    function get_links_to_imbachat(){
        if (get_option('IMCH_secret_key'))
        {
            $links = [
                'imbachat' => 'https://imbachat.com/visitor/login-user?token='.get_option('IMCH_secret_key'),
                'imachat_dashboard' => 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/auth/'.IMCH_getJWT()
            ];
            echo json_encode($links);
            die;
        }
    }

    function imbachat_setup_help(){

        add_option('IMCH_LANG', '');

        $db_link = null;
        if (get_option('IMCH_dev_id'))
            $db_link = 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/auth/'.IMCH_getJWT();

        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/get_started.php';
    }

    //post функции
    function sync_with_imbachat(){

        $dev_id = $_REQUEST['IMCH_dev_id'];
        sync_with_imba_api($dev_id, $_SERVER['HTTP_HOST']!='' ? $_SERVER['HTTP_HOST'] : preg_replace('#https?://(www.)?#','',site_url()), get_option( 'admin_email' ));
        wp_redirect(admin_url( 'admin.php' ).'?page=imbachat-settings', 302);
    }

    function interactive_submit()
    {
        update_option('IMCH_LANG', $_REQUEST['language']);
        wp_redirect(admin_url( 'admin.php' ).'?page=imbachat-settings', 302);
    }

    ?>