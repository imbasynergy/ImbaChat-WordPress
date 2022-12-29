<?php

if (isset($_GET['error'])) {
    function alert() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php $imb_host=sanitize_text_field($_SERVER['HTTP_HOST'])!='' ? sanitize_text_field($_SERVER['HTTP_HOST']) : preg_replace('#https?://(www.)?#','',site_url());
                _e("Possible mistakes: <br>
    1. Check the widget in the admin settings, the current host must be saved (Api setting > Integration Settings > Host (URL without http://) > $imb_host );<br>
    2. Widget id does not exist or does not belong to you;<br>
    3. Connection error. API Imbachat.com could not connect to your site, please check your server settings.", "imbachat") ?></p>
        </div>
        <?php
    }

    add_action( 'show_error', 'alert', 10, 3 );
    if ($_GET['error'] === "true") do_action('show_error');
}
if (isset($_GET['online_sup_error'])) {
    function alert_support_error() {
        $str_link="https://imbachat.com/en/admin/widgets/".esc_attr(get_option('IMCH_dev_id'))."/chat-settings?token=".esc_attr(get_option('IMCH_secret_key'));
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e("Configure  online support function here ". "<a target=\"_blank\" href=\"{$str_link}\">admin panel</a>", "imbachat") ?></p>
        </div>
        <?php
    }
    
    add_action( 'show_support_error', 'alert_support_error', 10, 3 );
    if ($_GET['online_sup_error'] === "1") do_action('show_support_error');
}
function imbachat_request($imbachat_request,$imbachat_function){
    ?><h4> <?php _e("$imbachat_request request: ", "imbachat"); ?> </h4><code>
    <?php $host = 'https://api.imbachat.com';
            $header_wp_imba=$imbachat_function($host);
            $imba_out=print_r($header_wp_imba,true);
            echo htmlspecialchars($imba_out);

    ?>
    </code> 
     <?php
}

?>
<div class="notice notice-error is-dismissible curl hide">
            <p><?php _e("Function curl_exec not available. To connect, you need to enable the function curl_exec. Contact your hosting administrator or enable it yourself in the settings php.ini", "imbachat") ?></p>
</div>
<div class="notice notice-error is-dismissible host hide">
            <p><?php _e("Error request api.imbachat.com. Contact the technical support of your website hosting provider. If you can't solve the problem, then write to imbachat support. ", "imbachat") ?></p>
</div>
<div class="notice notice-error is-dismissible errormessage hide">
            <p><?php _e("Error answer.", "imbachat") ?> <b class="error__answer"></b> <?php _e("Try to create an account with email", "imbachat") ?> <?php echo esc_html( get_option('admin_email') ) ?> <a target="_blank" href="https://imbachat.com/register">here</a></p>
</div>
<div class="notice notice-error is-dismissible notanswer hide">
            <p><?php _e("Error not answer api.", "imbachat") ?>  <?php _e("Check your https. Read more ", "imbachat") ?>  <a target="_blank" href="https://imbachat.com/en/blog/post/connection-error-api-imbachatcom-could-not-connect-your-site-please-check-your-server-settings">here</a></p>
</div>
<div class="wrap cmb2-options-page option-<?php echo esc_attr( $cmb_options->option_key ); ?>">
    <?php if ( get_admin_page_title() ) : ?>
        <h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
    <?php endif; ?>
    <h2 class="nav-tab-wrapper">
        <?php foreach ( $tabs as $option_key => $tab_title ) : ?>
            <a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
        <?php endforeach; ?>
    </h2>
    <form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo $cmb_options->cmb->cmb_id; ?>" enctype="multipart/form-data" encoding="multipart/form-data">
        <input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
        <?php $cmb_options->options_page_metabox(); ?>
        <div class="imba_container">
            <?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
            <?php submit_button( esc_attr( 'Create a widget' ), 'primary', 'create_widget' ); ?>
        </div>
        <div>
            <div style="display: flex;align-items: center"><h4 style="display: inline-block;margin-right: 10px;"><?php _e("Check for connectivity ", "imbachat") ?> </h4><img class="wait" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/ajax-loader.gif'; ?>" style="height: 32px;"><img class="error hide" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/error.png'; ?>" style="height: 32px;"> <img class="done hide" src="<?php echo IMBACHAT_ADMIN_DIR.'/assets/images/done.png'; ?>" style="height: 32px;"></div><?php echo apply_filters('admin_test_api',''); ?>
            <?php if ( is_plugin_active('user-role-editor/user-role-editor.php') ) : ?>
                <h4><?php _e("You have installed plugin User Role Editor. ", "imbachat") ?><?php _e("Set up the plugin according to the ", "imbachat") ?> <a target="_blank" href="https://imbachat.com/en/blog/post/how-set-user-roles-user-role-editor-plugin">instructions.</a></h4>
            <?php endif; ?>
            <?php if ( is_plugin_active('members/members.php') ) : ?>
                <h4><?php _e("You have installed plugin Members. ", "imbachat") ?><?php _e("Set up the plugin according to the ", "imbachat") ?> <a target="_blank" href="https://imbachat.com/en/blog/post/how-set-user-roles-user-role-editor-plugin">instructions.</a></h4>
            <?php endif; ?>
            <h4 class="widgets hide"><?php _e("Available widgets:", "imbachat") ?> <b class="widget"></b></h4>
            <h4 class="emails hide"><?php _e("Account email:", "imbachat") ?> <?php echo esc_html(get_option('admin_email')) ?></h4>
            <h4 class="curl hide" style="color:red;">
                        <?php _e("Function curl_exec not available. To connect, you need to enable the function curl_exec. Contact your hosting administrator or enable it yourself in the settings php.ini", "imbachat") ?>
            </h4>
            <section class="host hide" style="color:red;">
                        <h4><?php _e("Error ping imbachat.com. Host imbachat.com could not be reached. Try to connect later", "imbachat") ?></h4>
                        <?php imbachat_request("HEAD","get_headers"); ?>
                        <?php imbachat_request("GET","wp_remote_get"); ?>
                        <?php imbachat_request("POST","wp_remote_post"); ?>
                        <h4><?php _e("Server:", "imbachat") ?></h4>
                        <code><?php print_r($_SERVER); ?></code>
            </section>
            <h4 class="errormessage hide" style="color:red;">
                        <?php _e("Error answer.", "imbachat") ?> <b class="error__answer"></b> <?php _e("Try to create an account with email", "imbachat") ?> <?php echo esc_html(get_option('admin_email')) ?> <a target="_blank" href="https://imbachat.com/register">here</a>
            </h4>
            <h4 class="notanswer hide" style="color:red;">
                        <?php _e("Error not answer api.", "imbachat") ?>  <?php _e("Check your https. Read more ", "imbachat") ?>  <a target="_blank" href="https://imbachat.com/en/blog/post/connection-error-api-imbachatcom-could-not-connect-your-site-please-check-your-server-settings">here</a>
            </h4>
            <h4><?php _e("If you:", "imbachat") ?></h4>
            <h4><?php _e("— Don't understand how to install and use the plugin", "imbachat") ?></h4>
            <h4><?php _e("— Find a bug", "imbachat") ?></h4>
            <h4><?php _e("— Have any other questions about the plugin", "imbachat") ?></h4>
            <h4><?php _e("Please, write to us at support@imbachat.com and we will help you. Also, you can create a ticket in our WordPress support", "imbachat") ?>
                <a href=" https://wordpress.org/support/plugin/imbachat-widget/"><?php _e("forum", "imbachat") ?></a> <?php _e("We respond within 48 h. Please wait for an answer.", "imbachat") ?></h4>

        </div>
    </form>
</div>
<?php
        wp_register_script( 'admin-html-imbachat-settings-script', '',);
        wp_enqueue_script( 'admin-html-imbachat-settings-script' );
        wp_add_inline_script( 'admin-html-imbachat-settings-script', "
        document.addEventListener('DOMContentLoaded', () => {
            let create_new_btn = document.getElementById('create_widget');
            create_new_btn.addEventListener('click', (e) => {
                e.preventDefault();
                let form = e.target.closest('form');
                let input_widget_id = form.querySelector('input[name=\"widget_id\"]');
                input_widget_id.value = -1;
                alert('"._e("In case of an error, make sure that the project is not on locallhost, and the ip address of the API server is not blacklisted", "imbachat")."');
                form.submit();
            })
        })

        jQuery( function( $ ){ 
            $.ajax({
                url: '".admin_url( "admin-ajax.php" )."',
                type: 'POST',
                data: 'action=imbachat_test_api',
                beforeSend: function( xhr ) {
                    
                },
                success: function( data ) {
                    data=decodeURIComponent(escape(data))
                    if(data=='') {
                        $('.notanswer').removeClass( 'hide' );
                        $('.error').removeClass( 'hide' );
                        $('.wait').addClass( 'hide' );
                        return false;
                    }
                    if(data.includes('error')){
                        if(data.includes('curl_exec')){
                            $('.curl').removeClass( 'hide' );
                            $('.error').removeClass( 'hide' );
                            $('.wait').addClass( 'hide' );
                            return false;
                        }
                        else if(data.includes('host')){
                            $('.host').removeClass( 'hide' );
                            $('.error').removeClass( 'hide' );
                            $('.wait').addClass( 'hide' );
                            return false;
                        }
                    }
                    let otcurljson = JSON.parse(data);
                    if (otcurljson.errorMsg != undefined){
                        $('.errormessage').removeClass( 'hide' );
                        $('.error').removeClass( 'hide' );
                        $('.wait').addClass( 'hide' );
                        $('.error__answer').text(otcurljson.errorMsg);
                        return false;
                    }
                    let str='';
                    if(otcurljson.widgets.length>0){
                        for (var i = 0; i < otcurljson.widgets.length; i++) {
                            if(i==0) str +=  otcurljson.widgets[i].id;
                            else str += \", \" + otcurljson.widgets[i].id;
                        }
                    }
                    else str='No widgets available. Click create a widget';
                    $('.widget').text(str);
                    $('.widgets').removeClass( 'hide' );
                    $('.emails').removeClass( 'hide' );
                    $('.done').removeClass( 'hide' );
                    $('.wait').addClass( 'hide' );
                },
                error: function( data ) {
                    console.log(data);
                },
            });
        });


        ");
    ?>