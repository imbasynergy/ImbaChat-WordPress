<?php
/**
 * ImbaChat Filters Class
 *
 * Load Admin Assets.
 *
 * @class    IM_Curl
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IM_Filter Class
 */

class IM_Filter {

    public static function init(){
        self::add_filters();
    }

    public static function add_filters(){
        $filters = [
//            'open_dialog' => 3
        ];

        $wc_filters = [
            'wcfm_after_product_catalog_enquiry_button' => 'single_product_write_vendor',
            'woocommerce_blocks_product_grid_item_html' => 'category_products_write_vendor',
            'woocommerce_loop_add_to_cart_link' => 'loop_products_write_vendor'
        ];
        if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
            foreach ($wc_filters as $k=>$wc_filter) {
                add_filter($k, array(__CLASS__, $wc_filter), 10, 3);
            }
        }

        $wf_filters = [
            'wpforo_member_menu_filter' => 'wpforo_profile_message_tab'
        ];
        if(in_array('wpforo/wpforo.php', apply_filters('active_plugins', get_option('active_plugins')))){
            foreach ($wf_filters as $k=>$wf_filter) {
                add_filter($k, array(__CLASS__, $wf_filter), 10, 3);
            }
        }

        foreach ($filters as $k => $v) {
            add_filter('imbachat_'.$k.'_filter', array(__CLASS__, $k), 9, $v);
        }
    }

    public static function wpforo_profile_message_tab($menu, $user_id)
    {
        $menu = '<a class="wpf-profile-menu " href="javascript:void(0)" onclick="open_dialog('.$user_id.')"><i class="fas fa-comments"></i> <span class="wpf-profile-menu-label">Send message</span></a>';
        echo $menu;
    }

    public static function loop_products_write_vendor($html, $product, $args) {
        $product_id = $product->get_data()['id'];
        if (!$product_id)
            return $html;
        $vendor_id = wcfm_get_vendor_id_by_post($product_id);
        $chat_btn = '';
        if ($vendor_id) {
            $chat_btn = do_shortcode('[ic_open_dialog id="'.$vendor_id.'" class="button imba_margin-1" name="Ask a Question"]');
        }
        $html = $html.$chat_btn;
        return $html;
    }

    public static function category_products_write_vendor($html, $data, $product)
    {
        $product_id = $product->get_data()['id'];
        if (!$product_id)
            return $html;
        $vendor_id = wcfm_get_vendor_id_by_post($product_id);
        $chat_btn = '';
        if ($vendor_id) {
            $chat_btn = do_shortcode('[ic_open_dialog id="'.$vendor_id.'" class="" name="Chat with vendor"]');
        }
        $html = str_replace($data->button, $data->button.$chat_btn, $html);

        return $html;
    }

    public static function open_dialog($parameter, $user_from, $user_to){
        return array('status' => 'default');
    }

    public static function single_product_write_vendor(){
        $product = wc_get_product();
        if (!$product)
            return;
        $product_id = $product->get_data()['id'];
        if (!$product_id)
            return;
        $vendor_id = wcfm_get_vendor_id_by_post($product_id);
        if ($vendor_id) {
            echo do_shortcode('[ic_open_dialog id="'.$vendor_id.'" class="" name="Chat with vendor"]');
        }
    }
}

IM_Filter::init();