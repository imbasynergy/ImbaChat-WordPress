<?php

if (isset($_GET['error'])) {
    function alert() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e('Connection error. API Imbachat.com could not connect to your site, please check your server settings'); ?></p>
        </div>
        <?php
    }

    add_action( 'show_error', 'alert', 10, 3 );
    do_action('show_error');
}
?>

<div class="wrap cmb2-options-page option-<?php echo $cmb_options->option_key; ?>">
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
            <h4><?php _e("In case of an error, make sure that the project is not on locallhost, and the ip address of the API server is not blacklisted", "imbachat") ?></h4>
            <h4><?php _e("If you:", "imbachat") ?></h4>
            <h4><?php _e("— Don't understand how to install and use the plugin", "imbachat") ?></h4>
            <h4><?php _e("— Find a bug", "imbachat") ?></h4>
            <h4><?php _e("— Have any other questions about the plugin", "imbachat") ?></h4>
            <h4><?php _e("Please, write to us at support@imbachat.com and we will help you. Also, you can create a ticket in our WordPress support", "imbachat") ?>
                <a href=" https://wordpress.org/support/plugin/imbachat-widget/"><?php _e("forum", "imbachat") ?></a> <?php _e("We respond within 48 h. Please wait for an answer.", "imbachat") ?></h4>

        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let create_new_btn = document.getElementById('create_widget');
        create_new_btn.addEventListener('click', (e) => {
            e.preventDefault();
            let form = e.target.closest('form');
            let input_widget_id = form.querySelector('input[name="widget_id"]');
            input_widget_id.value = -1;
            alert('<?php _e("In case of an error, make sure that the project is not on locallhost, and the ip address of the API server is not blacklisted", "imbachat") ?>');
            form.submit();
        })
    })
</script>