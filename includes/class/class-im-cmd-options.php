<?php
/**
 * ImbaChat CMD Class
 *
 * Create options page
 *
 * @class    IM_CMD
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * IM_Curl Class
 */
class IM_CMD {

    protected static $menu_settings = [
        'imbachat-users-settings' => [
            'title' => 'Users Settings',
            'option_key' => 'imbachat-users-settings',
            'menu_title' => 'Users Settings',
            'parent_slug' => 'imbachat-settings',
            'capability' => 8,
            'position' => 0,
            'admin_menu_hook' => 'admin_menu',
            'priority' => 10,
            'object_types' => array( 'options-page' ),
            'id'           => 'imbachat-users-settings',
            'save_button' => 'Save Changes!',
            'message_cb'              => array(__CLASS__, 'imbachat_users_settings_message_callback'),
            'tab_group'               => 'imbachat_options', // Tab-group identifier, enables options page tab navigation.
            'tab_title'               => 'User Settings', // Falls back to 'title' (above).
//         'autoload'                => false, // Defaults to true, the options-page option will be autloaded.
        ],
        'imbachat-hooks-settings' => [
            'title' => 'Integration Settings',
            'option_key' => 'imbachat-hooks-settings',
            'menu_title' => 'Integration Settings',
            'parent_slug' => 'imbachat-settings',
            'capability' => 8,
            'position' => 0,
            'admin_menu_hook' => 'admin_menu',
            'priority' => 11,
            'object_types' => array( 'options-page' ),
            'id'           => 'imbachat-hooks-settings',
            'save_button' => 'Save Changes!',
            'message_cb'              => array(__CLASS__, 'imbachat_hooks_settings_message_callback'),
            'tab_group'               => 'imbachat_options', // Tab-group identifier, enables options page tab navigation.
            'tab_title'               => 'Integration Settings', // Falls back to 'title' (above).
        ]
    ];

    public static function init()
    {
        static::add_menus();
    }

    public static function add_menus()
    {
        $menus = [
            'imbachat-users-settings' => [
                'function' => 'imbachat_users_settings'
            ],
            'imbachat-hooks-settings' => [
                'function' => 'imbachat_hooks_settings',
                'fields' => ['integrations']
            ]
        ];

        foreach ($menus as $index => $menu) {
            add_action( 'cmb2_admin_init', array(__CLASS__, $menu['function']) );
            add_action( 'admin_post_' . $index, array( __CLASS__, $menu['function'].'_on_save' ) );
            if (isset($menu['fields'])) {
                foreach ($menu['fields'] as $field) {
                    add_filter("cmb2_override_{$field}_meta_value", array(__CLASS__, $menu['function'].'_override_get_'.$field), 10, 4);
                }
            }
        }
    }

    public static function imbachat_hooks_settings_override_get_integrations($data, $object_id, $args, $field)
    {
        $imdb = new IM_DB();
        $filters = $imdb->where('imbachat_hooks', [
            'forbidden' => 0
        ]);
        $enabled_filters = array_map(function ($filter){
            return $filter->id;
        }, $filters);
        return $enabled_filters;
    }

    public static function imbachat_hooks_settings()
    {
        $settings = self::$menu_settings['imbachat-hooks-settings'];
        $metabox = new_cmb2_box( $settings);

        $imdb = new IM_DB();
        $filters = $imdb->get_all('imbachat_hooks');

        $options = [];
        foreach ($filters as $filter) {
            $options[$filter->id] = $filter->description;
        }


        $metabox->add_field(array(
            'name'    => 'Integrations',
            'desc'    => 'Turn it off to disable option!',
            'id'      => 'integrations',
            'type'    => 'multicheck',
            'select_all_button' => false,
            'options' => $options,
        ) );
    }

    public static function imbachat_hooks_settings_on_save()
    {
        $imdb = new IM_DB();
        $filters = array_map(function ($filter){
            return $filter->id;
        }, $imdb->get_all('imbachat_hooks'));
        $params = isset($_POST['integrations']) ? $_POST['integrations'] : [];
        $disable_filters = array_filter($filters, function ($filter) use ($params){
            return !in_array($filter, $params);
        });
        $enable_filters = array_filter($filters, function ($filter) use ($params){
            return in_array($filter, $params);
        });
        $imdb->update('imbachat_hooks', ['forbidden' => '1'], ['id' => array_values($disable_filters)]);
        $imdb->update('imbachat_hooks', ['forbidden' => '0'], ['id' => array_values($enable_filters)]);

    }


    public static function imbachat_users_settings_on_save()
    {
        update_option('im_user_field', $_POST['user_field']);
        update_option('im_user_search_type', $_POST['search_type']);
    }
    public static function imbachat_users_settings()
    {
        $settings = self::$menu_settings['imbachat-users-settings'];
        $cmb_users = new_cmb2_box($settings);

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

        $fields = array();
        foreach ($users_found = $user->get_results() as $item)
        {
            $fields = static::filter_fields($item);
        }

        $options = [];
        foreach ($fields as $k=>$field){
            $options[$k] = "$k = $field";
        }
        $cmb_users->add_field( array(
            'name'             => esc_html__( 'Username format', 'cmb2' ),
            'desc'             => esc_html__( 'Select how to display user name', 'cmb2' ),
            'id'               => 'user_field',
            'type'             => 'select',
            'show_option_none' => true,
            'default'          => get_option('im_user_field'),
            'options'          => $options,
        ) );
        $cmb_users->add_field( array(
            'name'             => esc_html__( 'Search type', 'cmb2' ),
            'desc'             => esc_html__( 'User`s search type', 'cmb2' ),
            'id'               => 'search_type',
            'type'             => 'select',
            'default'          => get_option('im_user_search_type'),
            'show_option_none' => true,
            'options'          => array(
                1 => 'Partial Match',
                2 => 'Full Match',
                3 => 'Partial match, but from the beginning'
            ),
        ) );
    }

    public static function imbachat_hooks_settings_message_callback($cmb, $args)
    {
        if ( ! empty( $args['should_notify'] ) ) {

            $args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'cmb2' ), $cmb->prop( 'title' ) );


            add_settings_error( $args['setting'], $args['code'], $args['message'], 'updated' );
        }
    }

    public static function imbachat_users_settings_message_callback($cmb, $args)
    {
        if ( ! empty( $args['should_notify'] ) ) {

            if ( $args['is_updated'] ) {

                // Modify the updated message.
                $args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'cmb2' ), $cmb->prop( 'title' ) );
            }
            add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
        }
    }

    protected static function filter_fields($item, $fields = [
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

}

IM_CMD::init();