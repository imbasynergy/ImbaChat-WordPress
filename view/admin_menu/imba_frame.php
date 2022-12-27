<?php
        wp_register_style( 'admin-imba-frame-style', '',);
        wp_enqueue_style( 'admin-imba-frame-style' );
        wp_add_inline_style( 'admin-imba-frame-style', "
        .update-nag { display: none !important; }
        ");
    ?>
<iframe style="width: 100%; height: calc(100vh - 40px);" src="<?php echo 'https://imbachat.com/visitor/login-user?token='.esc_attr( get_option('IMCH_secret_key') ).'&iframe=iframe_for_plugin&mail='.esc_attr( get_option( 'admin_email' ) ) ?>">

</iframe>
