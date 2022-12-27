<?php
/**
 * ImbaChat Admin Assets
 *
 * Load Admin Assets.
 *
 * @class    IMBACHAT_IM_Admin_Assets
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IMBACHAT_IM_Admin_Assets Class
 */
class IMBACHAT_IM_Admin_Assets {

    /**
     * Hook in tabs.
     */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
    }

    /**
     * Enqueue styles.
     */
    public function admin_styles() {
        global $wp_scripts;

        $screen         = get_current_screen();
        $screen_id      = $screen ? $screen->id : '';

        // Register admin styles.
        wp_register_style( 'imbachat-deactivate-modal', IMBACHAT_PLUGIN_URL . '/assets/css/admin/deactivate.css', array() );
        wp_register_style( 'imbachat-rate-notice', IMBACHAT_PLUGIN_URL . '/assets/css/admin/rate.css', array() );

        // Sitewide menu CSS.
        wp_enqueue_style( 'imbachat-rate-notice' );
        wp_enqueue_style( 'imbachat-deactivate-modal' );
    }

    /**
     * Enqueue scripts.
     */
    public function admin_scripts() {

        $screen    = get_current_screen();
        $screen_id = $screen ? $screen->id : '';

        // Plugins page.
        if ( in_array( $screen_id, array( 'plugins' ) ) ) {
            wp_register_script( 'im-plugins', IMBACHAT_PLUGIN_URL . '/assets/js/admin/plugins.js', array( 'jquery' ) );
            wp_enqueue_script( 'im-plugins' );
            wp_localize_script(
                'im-plugins',
                'im_plugins_params',
                array(
                    'ajax_url'           => admin_url( 'admin-ajax.php' ),
                    'deactivation_nonce' => wp_create_nonce( 'deactivation-notice' ),
                )
            );
        }
    }
}

new IMBACHAT_IM_Admin_Assets();
