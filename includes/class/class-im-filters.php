<?php
/**
 * ImbaChat Filters Class
 *
 * Filters
 *
 * @class    IMBACHAT_IM_Filter
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IMBACHAT_IM_Filter Class
 */

class IMBACHAT_IM_Filter {

    public static function init(){
        self::add_filters();
        self::add_wp_filters();
        self::add_wc_filters();
        self::add_wf_filters();
    }

    public static function add_wp_filters(){
        $imdb = new IMBACHAT_IM_DB();
        $wp_filters = [
            'the_content' => [
                'function' => 'imbachat_the_content_filter',
                'description' => 'Add button "Chat with Author" to all posts'
            ]
        ];
//        update_option('imbachat_filters', array_merge($wp_filters, get_option('imbachat_filters') == '' ? [] : get_option('imbachat_filters')));
        foreach ($wp_filters as $k => $v) {
            if (!$imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $v['function'], 'type' => 'filter'])) {
                $imdb->insert('imbachat_hooks', [
                        'tag' => $k,
                        'function' => $v['function'],
                        'type' => 'filter',
                        'description' => $v['description']]
                );
            } else {
                $filter = $imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $v['function'], 'type' => 'filter']);
                if ($filter[0]->forbidden == 1) {
                    continue;
                }
            }
            add_filter($k, array(__CLASS__, $v['function']), 10, 3);
        }
    }

    public static function add_wc_filters()
    {
        $imdb = new IMBACHAT_IM_DB();
        $wc_filters = [
            'wcfm_after_product_catalog_enquiry_button' => [
                'function' => 'single_product_write_vendor',
                'description' => 'Add button "Chat with vendor" to every single product'
            ],
            'woocommerce_blocks_product_grid_item_html' => [
                'function' => 'category_products_write_vendor',
                'description' => 'Add button "Chat with vendor" to every product in category filter'
            ],
            'woocommerce_loop_add_to_cart_link' => [
                'function' => 'loop_products_write_vendor',
                'description' => 'Add button "Chat with vendor" to every product in list of products'
            ]
        ];
        if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
            foreach ($wc_filters as $k=>$wc_filter) {
                if (!$imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $wc_filter['function'], 'type' => 'filter'])) {
                    $imdb->insert('imbachat_hooks', [
                            'tag' => $k,
                            'function' => $wc_filter['function'],
                            'type' => 'filter',
                            'description' => $wc_filter['description']]
                    );
                } else {
                    $filter = $imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $wc_filter['function'], 'type' => 'filter']);
                    if ($filter[0]->forbidden == 1) {
                        continue;
                    }
                }
                add_filter($k, array(__CLASS__, $wc_filter['function']), 10, 3);
            }
        }
    }

    public static function add_wf_filters()
    {
        $imdb = new IMBACHAT_IM_DB();
        $wf_filters = [
            'wpforo_member_menu_filter' => [
                'function' => 'wpforo_profile_message_tab',
                'description' => 'Add button "Send Message" at profile page in WP foro'
            ]
        ];
        if(in_array('wpforo/wpforo.php', apply_filters('active_plugins', get_option('active_plugins')))){
            foreach ($wf_filters as $k=>$wf_filter) {
                if (!$imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $wf_filter['function'], 'type' => 'filter'])) {
                    $imdb->insert('imbachat_hooks', [
                            'tag' => $k,
                            'function' => $wf_filter['function'],
                            'type' => 'filter',
                            'description' => $wf_filter['description']]
                    );
                } else {
                    $filter = $imdb->where('imbachat_hooks', ['tag' => $k, 'function' => $wf_filter['function'], 'type' => 'filter']);
                    if ($filter[0]->forbidden == 1) {
                        continue;
                    }
                }
                add_filter($k, array(__CLASS__, $wf_filter['function']), 10, 3);
            }
        }
    }

    public static function add_filters(){
        $filters = [
//            'open_dialog' => 3
        ];

        foreach ($filters as $k => $v) {
            add_filter('imbachat_'.$k.'_filter', array(__CLASS__, $k), 9, $v);
        }
    }

    public static function imbachat_the_content_filter($content)
    {
        if (is_single() && get_post_type() == 'post')
        {
            $user_id = get_the_author_meta( 'ID' );
            if ($user_id > 0)
            {
                $btn_name_imbachat=__("Chat with author", "imbachat");
                $content_with_button = do_shortcode('[ic_open_dialog id="'.$user_id.'" class="" name="'.$btn_name_imbachat.'"]').$content;
                return $content_with_button;
            } else
                return $content;
        }
        return $content;
    }

    public static function wpforo_profile_message_tab($menu, $user_id)
    {
        $btn_name_imbachat=__("Send message", "imbachat");
        //$menu = '<a class="wpf-profile-menu " href="javascript:void(0)" onclick="open_dialog('.$user_id.')"><i class="fas fa-comments"></i> <span class="wpf-profile-menu-label">'.$btn_name_imbachat.'</span></a>';
        echo '<a class="wpf-profile-menu " href="javascript:void(0)" onclick="open_dialog('.esc_js($user_id).')"><i class="fas fa-comments"></i> <span class="wpf-profile-menu-label">'.esc_html($btn_name_imbachat).'</span></a>';
    }

    public static function loop_products_write_vendor($html, $product, $args) {
        $product_id = $product->get_data()['id'];
        if (!$product_id)
            return $html;
        if (!function_exists('wcfm_get_vendor_id_by_post')) {
            $this_post = get_post( $product_id );
            $vendor_id = $this_post->post_author;
        }else{
            $vendor_id = wcfm_get_vendor_id_by_post($product_id);
        }
        $chat_btn = '';
        if ($vendor_id) {
            $btn_name_imbachat=__("Ask a Question", "imbachat");
            $chat_btn = do_shortcode('[ic_open_dialog id="'.$vendor_id.'" class="button imba_margin-1" name="'.$btn_name_imbachat.'"]');
        }
        $html = $html.$chat_btn;
        return $html;
    }

    public static function category_products_write_vendor($html, $data, $product)
    {
        $product_id = $product->get_data()['id'];
        if (!$product_id)
            return $html;
        if (!function_exists('wcfm_get_vendor_id_by_post')) {
            $this_post = get_post( $product_id );
            $vendor_id = $this_post->post_author;
        }else{
            $vendor_id = wcfm_get_vendor_id_by_post($product_id);
        }
        $chat_btn = '';
        if ($vendor_id) {
            $btn_name_imbachat=__("Chat with vendor", "imbachat");
            $chat_btn = do_shortcode('[ic_open_dialog id="'.$vendor_id.'" class="" name="'.$btn_name_imbachat.'"]');
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
        if (!function_exists('wcfm_get_vendor_id_by_post')) {
            $this_post = get_post( $product_id );
            $vendor_id = $this_post->post_author;
        }else{
            $vendor_id = wcfm_get_vendor_id_by_post($product_id);
        }
        if ($vendor_id) {
            $btn_name_imbachat=__("Chat with vendor", "imbachat");
            echo do_shortcode('[ic_open_dialog id="'.$vendor_id.'" class="" name="'.$btn_name_imbachat.'"]');
        }
    }
}

IMBACHAT_IM_Filter::init();