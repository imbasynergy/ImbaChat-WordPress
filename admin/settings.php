<?php

function imbachat_add_my_setting(){
?>
<div class="wrap">
    <h1><?php echo _e(get_admin_page_title(), "imbachat") ?></h1>
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
                    <img width="1024" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/way_1.png' ?>">
                </div>
            </li>
            <li>
                <p><?php _e("2.	If you don't have a widget yet, click 'Create a widget' at the same page. Connection between your website and ImbaChat server will be automatically configured.", "imbachat") ?></p>
                <div class="image-ins">
                    <img src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/way_2.png' ?>">
                </div>
            </li>
        </ul>
        <div class="instruction">
            <h3><?php _e("Also, if you have BuddyPress, WCFM Marketplace or SweetDate themes, integration with ImbaChat will be automatically configured as well.", "imbachat") ?></h3>
        </div>
    </div>
    <?php
        wp_register_style( 'admin-settings-inline-style', '',);
        wp_enqueue_style( 'admin-settings-inline-style' );
        wp_add_inline_style( 'admin-settings-inline-style', "
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
        ");
    ?>
    <?php

    }

    //Menu imbachat settings
    function imbachat_settings(){
        add_option('IMCH_dev_id', '');
        add_option('IMCH_login', '');
        add_option('IMCH_password', '');
        add_option('IMCH_secret_key', '');
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
            sync_with_imba_api($IMCH_dev_id, sanitize_text_field($_SERVER['HTTP_HOST'])!='' ? sanitize_text_field($_SERVER['HTTP_HOST']) : preg_replace('#https?://(www.)?#','',site_url()), sanitize_email(get_option( 'admin_email' )));
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
                'imachat_dashboard' => (imbachat_get_adminJWT(get_admin_url())) ? 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/auth/'.imbachat_get_adminJWT(get_admin_url()) : 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/signIn'
            ];
            echo json_encode($links);
            die;
        }
    }

    function imbachat_setup_help(){

        add_option('IMCH_LANG', '');

        $db_link = null;
        if (get_option('IMCH_dev_id'))
            $db_link = (imbachat_get_adminJWT(get_admin_url())) ? 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/auth/'.imbachat_get_adminJWT(get_admin_url()) : 'https://dashboard.imbachat.com/#/'.get_option('IMCH_dev_id').'/signIn';

        require_once IMBACHAT__PLUGIN_DIR . '/view/admin_menu/get_started.php';
    }

    function imbachat_users_settings()
    {

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

        $dev_id = sanitize_text_field($_REQUEST['IMCH_dev_id']);
        sync_with_imba_api($dev_id, sanitize_text_field($_SERVER['HTTP_HOST'])!='' ? sanitize_text_field($_SERVER['HTTP_HOST']) : preg_replace('#https?://(www.)?#','',site_url()), sanitize_email(get_option( 'admin_email' )));
        wp_redirect(admin_url( 'admin.php' ).'?page=imbachat-settings&success=1', 302);
    }

    function imbachat_interactive_submit()
    {
        update_option('IMCH_LANG', sanitize_text_field($_REQUEST['language']));
        wp_redirect(admin_url( 'admin.php' ).'?page=imbachat-settings', 302);
    }

    //ajax functions
    function imbachat_save_users_settings()
    {
        //$params = $_REQUEST['param'];
        if (isset($_REQUEST['param']['user_field']))
        {
            update_option('im_user_field', sanitize_text_field($_REQUEST['param']['user_field']));

            update_option('im_user_search_type', sanitize_text_field($_REQUEST['param']['search_type']));
        }
        echo(json_encode( array('status'=>true,'request_vars'=>$_REQUEST) ));
        wp_die();
    }
    //test api
    function imbachat_test_api(){
        
        //ping to server imbachat
        $host = 'https://api.imbachat.com';
        $header_wp_imba=get_headers($host);
        if(stripos($header_wp_imba[0], '200 OK')===false) {
            echo("error host could not be reached");
            wp_die();
        }

        //send api

        try {
            $url = 'https://api.imbachat.com/imbachat/v1/widget/imba_get_widgets';
            $body = array(
                'email' => get_option('admin_email')
            );
            $args = array(
                'body'        => $body,
                'timeout'     => '10',
                'redirection' => '5',
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(),
                'cookies'     => array(),
            );
            $response = wp_remote_post( $url, $args );
            if ( is_wp_error( $response ) ) {
                $error_message = $response->get_error_message();
                echo "error host could not be reached:". wp_kses($error_message);
             } 
            $curlout =  wp_remote_retrieve_body($response);
            echo wp_kses_data($curlout);
             wp_die();
        } catch (Exception $exception) {
            echo 'error_connect';
        }
    
        wp_die();
    }

    ?>
