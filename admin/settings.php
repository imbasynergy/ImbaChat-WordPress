<?php
function add_my_setting(){

    $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "add_my_setting (setting.php)\n";
    file_put_contents($file,$log);
?>
<div class="wrap">
    <h1><?php echo _(get_admin_page_title(), "imbachat") ?></h1>
    <div class="instruction">
        <h3>Instruction after installing plugin</h3>
        <p>There is 2 ways to configure ImbaChat widget on your website.</p>
        <ul>
            <li>
                <p> <?php _e(" 1.	You need to pass registration", "imbachat") ?> <a href="https://imbachat.com/register">here</a> <?php _e(" and create a widget in the Dashboard: ", "imbachat") ?> </p>
                <p><?php _e('Integrate option" choose WordPress', "imbachat") ?></p>
                <p><?php _e('"Host" write your site url without http:// (for example: your-site-domain-url.com)', "imbachat") ?></p>
                <p><?php _e('Write the widget id into “Widget id” field in the ImbaChat settings in the admin panel of your website. After that click “Connect to the widget”', "imbachat") ?></p>
                <div class="image-ins">
                    <img width="1024" src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/way_1.png' ?>">
                </div>
            </li>
            <li>
                <p><?php _e("2.	If you don't have a widget yet, click 'Create a widget' at the same page. Connection between your website and ImbaChat server will be automatically configured.", "imbachat") ?></p>
                <div class="image-ins">
                    <img src="<?= IMBACHAT_ADMIN_DIR.'/assets/images/way_2.png' ?>">
                </div>
            </li>
        </ul>
        <div class="instruction">
            <h3><?php _e("Also, if you have BuddyPress, WCFM Marketplace or SweetDate themes, integration with ImbaChat will be automatically configured as well.", "imbachat") ?></h3>
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

    //Menu imbachat settings
    function imbachat_settings(){

        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "imbachat_settings (setting.php)\n";
    file_put_contents($file,$log);

        add_option('IMCH_dev_id', '0');
        add_option('IMCH_login', '0');
        add_option('IMCH_password', '0');
        add_option('IMCH_secret_key', '0');
        if (isset($_REQUEST['IMCH_dev_id']))
        {
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

    function imbachat_admin_panel()
    {
        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/imba_frame.php';
    }

    function imbachat_links()
    {

        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/links.php';
    }

    function get_links_to_imbachat(){
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "get_links_to_imbachat (setting.php)\n";
    file_put_contents($file,$log);

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
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "imbachat_setup_help (setting.php)\n";
    file_put_contents($file,$log);

        add_option('IMCH_LANG', '');

        $db_link = null;
        if (get_option('IMCH_dev_id'))
            $db_link = 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/auth/'.IMCH_getJWT();

        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/get_started.php';
    }

    function imbachat_users_settings()
    {
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "imbachat_users_settings (setting.php)\n";
    file_put_contents($file,$log);

        function filter_fields($item, $fields = [
            'first_name',
            'last_name',
            'user_login',
            'display_name',
            'user_email',
            'fullname' => [
                'first_name',
                'last_name'
            ]
        ])
        {
            $result = array();
            foreach ($fields as $k=>$field)
            {
                if (gettype($field) == 'array')
                {
                    $result_str = '';
                    foreach ($field as $sub_field)
                    {
                        $result_str .= $item->$sub_field.' ';
                    }
                    $result[$k] = $result_str;
                }
                elseif (isset($item->$field))
                {
                    $result[$field] = $item->$field;
                }
            }
            return $result;
        }
        $user = new WP_User_Query( array(
            'search'         => get_current_user_id(),
            'search_columns' => array(
                'ID',
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
                'first_name',
                'second_name',
                'display_name'
            ),
        ) );

        $users = array();
        $fields = array();
        foreach ($users_found = $user->get_results() as $item)
        {
            $fields = filter_fields($item);
        }
        $not_show_ic_flashes = 1;
        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/ic_flashes.php';
        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/users_settings.php';
    }

    //post functions
    function sync_with_imbachat(){
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "sync_with_imbachat (setting.php)\n";
    file_put_contents($file,$log);

        $dev_id = $_REQUEST['IMCH_dev_id'];
        sync_with_imba_api($dev_id, $_SERVER['HTTP_HOST']!='' ? $_SERVER['HTTP_HOST'] : preg_replace('#https?://(www.)?#','',site_url()), get_option( 'admin_email' ));
        wp_redirect(admin_url( 'admin.php' ).'?page=imbachat-settings&success=1', 302);
    }

    function interactive_submit()
    {
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "interactive_submit (setting.php)\n";
    file_put_contents($file,$log);

        update_option('IMCH_LANG', $_REQUEST['language']);
        wp_redirect(admin_url( 'admin.php' ).'?page=imbachat-settings', 302);
    }

    //ajax functions
    function save_users_settings()
    {
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "save_users_settings (setting.php)\n";
    file_put_contents($file,$log);
    
        $params = $_REQUEST['param'];
        if (isset($params['user_field']))
        {
            update_option('im_user_field', $params['user_field']);

            update_option('im_user_search_type', $params['search_type']);
        }
        echo(json_encode( array('status'=>true,'request_vars'=>$_REQUEST) ));
        wp_die();
    }

    ?>
