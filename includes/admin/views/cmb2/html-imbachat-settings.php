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
            <h3><?php _e("In case of an error, make sure that the project is not on locallhost, and the ip address of the API server is not blacklisted", "imbachat") ?></h3>
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