<?php
/**
 * ImbaChat Blocks Class
 *
 * Custom blocks.
 *
 * @class    IMBACHAT_IM_Blocks
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IMBACHAT_IM_Blocks Class
 */

class IMBACHAT_IM_Blocks {

    public static function init(){
        self::addBlocks();
        self::addCategories();
    }

    public static function addBlocks(){
        $blocks = [
            'public_chat' => true,
            'embedding_chat' => true
        ];

        foreach ($blocks as $k => $block) {
            add_action( 'enqueue_block_editor_assets', array( __CLASS__, $k ) );
            add_action( 'wp_enqueue_scripts', array( __CLASS__, $k.'_frontend' ) );
        }
    }

    public static function addCategories(){
        $categories = [
            'imbachat_chats' => "ImbaChat Chats"
        ];

        foreach ($categories as $k => $category){
            add_filter( 'block_categories',array( 'IM_Blocks', 'imbachat_chats_block_category' ), 10, 2);
        }
    }

    function imbachat_chats_block_category($categories, $post){
        return array_merge(
            $categories,
            array(
                array(
                    'slug' => 'imbachat-chats',
                    'title' => 'ImbaChat Chats',
                ),
            )
        );
    }

    public static function public_chat(){

        wp_enqueue_script(
            'imbachat-public-chat-block-editor',
            IMBACHAT_PLUGIN_URL . '/assets/js/blocks/public_chat.js',
            array( 'wp-blocks', 'wp-element' )
        );

        wp_enqueue_style(
            'imbachat-public-chat-block-editor',
            IMBACHAT_PLUGIN_URL . '/assets/css/blocks/public_chat.css',
            array()
        );
    }
    public static function public_chat_frontend(){
        wp_enqueue_style(
            'imbachat-public-chat-block-editor',
            IMBACHAT_PLUGIN_URL . '/assets/css/blocks/public_chat.css',
            array()
        );
    }

    public static function embedding_chat(){

        wp_enqueue_script(
            'imbachat-embedding-chat-block-editor',
            IMBACHAT_PLUGIN_URL . '/assets/js/blocks/embedding_chat.js',
            array( 'wp-blocks', 'wp-element' )
        );

        wp_enqueue_style(
            'imbachat-public-chat-block-editor',
            IMBACHAT_PLUGIN_URL . '/assets/css/blocks/public_chat.css',
            array()
        );
    }
    public static function embedding_chat_frontend(){
        wp_enqueue_style(
            'imbachat-public-chat-block-editor',
            IMBACHAT_PLUGIN_URL . '/assets/css/blocks/public_chat.css',
            array()
        );
    }
}

IMBACHAT_IM_Blocks::init();
