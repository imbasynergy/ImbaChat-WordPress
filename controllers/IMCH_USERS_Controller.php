<?php
add_action( 'rest_api_init', 'IMCH_prefix_register_my_rest_routes' );
require_once (IMBACHAT__PLUGIN_DIR . '/libs/JWT/autoload.php');
function IMCH_prefix_register_my_rest_routes() {
    $controller = new IMCH_USERS_Controller();
    $controller->register_routes();
}
use \Firebase\JWT\JWT;

class IMCH_USERS_Controller extends WP_REST_Controller {

    function __construct(){
        $this->namespace = 'imbachat/v1';
    }
    function register_routes(){

        // Getting information about users, separated by commas /getusers/1,2,3,4,5
        // Here 2 filters are applied, one to restrict access to the widget rest_request_before_callbacks
        // the second for the ability to change the name displayed in the chat rest_imbachat_get_user_name_query
        register_rest_route( $this->namespace, "/getusers/(?P<ids>[\w\,/]+)", [
            [
                'methods'             => 'GET',
                'callback'            => [ $this, 'get_users' ]
            ]
        ] );
        //This route is purely for receiving widget data in the system, made it for verification. when authorization fails, it was once
        register_rest_route( $this->namespace, "/getauthdata", [
            [
                'methods'             => 'GET',
                'callback'            => [ $this, 'get_auth_data' ]
            ]
        ] );
        // not needed endpoint
        register_rest_route( $this->namespace, "/gettoken", [
            [
                'methods'             => 'GET',
                'callback'            => [ $this, 'getJWT' ]
            ]
        ] );
        // Route for authorization, used only by the imbasupport project
        register_rest_route( $this->namespace, "/authuser", [
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'auth_user' ]
            ]
        ] );
        // Search for users by name
        register_rest_route( $this->namespace, "/searchusers/(?P<string>[\w]+)", [
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'search_users' ]
            ]
        ] );
        // processes a request from api.imbachat to update the widget id in case of a plugin request
        register_rest_route( $this->namespace, "/sync", [
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'sync' ]
            ]
        ] );
        // Getting user friends, apply to buddypress plugin
        register_rest_route( $this->namespace, "/user/friends/(?P<user_id>[\w]+)", [
            [
                'methods'             => 'get',
                'callback'            => [ $this, 'user_friends' ]
            ]
        ] );
        // Notifications with OneSignal
        register_rest_route( $this->namespace, "/notifications", [
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'notifications' ]
            ]
        ] );
        register_rest_route( $this->namespace, "/setguestimbachat", [
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'set_guest' ]
            ]
        ] );
    }

    public function set_guest(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $imbachat_guest = $params['guest_enable'];
        add_option('IMCH_guest', $imbachat_guest);
        update_option('IMCH_guest', $imbachat_guest);
            echo json_encode([
                "success" => true,
                "guest" => $imbachat_guest
            ]);
           
    }

    public function notifications(WP_REST_Request $request)
    {
        $params = $request->get_params();
        $title = $params['title'];
        $body = $params['body'];
        $onesignal_wp_settings = OneSignal::get_onesignal_settings();
        $rest_key = $onesignal_wp_settings['app_rest_api_key'];
        $app_id = $onesignal_wp_settings['app_id'];
        $content = array(
            "en" => $body
        );
        $headings = array(
            "en" => $title
        );

        $fields = array(
            'app_id' => $app_id,
            'email' => $params['email_to'],
            'filters' => array(
                array("field" => "email", "value" => $params['email_to']),
            ),
            'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $headings
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $args = array(
            'body'        => $fields,
            'timeout'     => '10',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic '.$rest_key),
            'cookies'     => array(),
        );
        $url = 'https://onesignal.com/api/v1/notifications';
        $response = wp_remote_post( $url, $args );



        //$return["allresponses"] = $response;
        $return["allresponses"] = json_decode(wp_remote_retrieve_body($response));
        $return = json_encode( $return);

        print("\n\nJSON received:\n");
        print($return);
        print("\n");
    }

    protected function testAuthOrDie()
    {
        $login = get_option('IMCH_login');
        $password = get_option('IMCH_password');
        if(!isset($_SERVER['PHP_AUTH_USER'])
            || ($_SERVER['PHP_AUTH_PW']!=$password)
            || strtolower($_SERVER['PHP_AUTH_USER'])!=$login)
        {
            header('WWW-Authenticate: Basic realm="Backend"');
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode([
                "code" => 401,
                "version" => $this->getApiVersion()['version'],
                "error" => 'Authenticate required!',
                'debug' => ''
            ]);
            die();
        }
    }

    protected function testAuthJWTOrDie($jwt)
    {
        $login = get_option('IMCH_login');
        $password = get_option('IMCH_password');
        $imba_id = get_option('IMCH_dev_id');

        $key = $login.':'.$password;
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            if ($decoded)
            {
                if (isset($decoded->imba_id))
                {
                    if ($imba_id != $decoded->imba_id)
                    {
                        echo json_encode([
                            "code" => 401,
                            "version" => $this->getApiVersion()['version'],
                            "error" => 'Authenticate required!',
                            'debug' => ''
                        ]);
                        die();
                    }
                }
            }
        } catch (\Exception $ex)
        {
            echo json_encode([
                "code" => 401,
                "version" => $this->getApiVersion()['version'],
                "error" => 'Authenticate required!',
                'debug' => ''
            ]);
            die();
        }

    }

    public function get_auth_data( WP_REST_Request $request )
    {
        $jwt = $request['jwt_token'];
        $this->testAuthJWTOrDie($jwt);


        return [
            'IMCH_login' => get_option('IMCH_login'),
            'IMCH_password' => get_option('IMCH_password'),
            'IMCH_dev_id' => get_option('IMCH_dev_id'),
            'IMCH_secret_key' => get_option('IMCH_secret_key')
        ];
    }

    public function get_users( WP_REST_Request $request )
    {
        $jwt = $request['jwt_token'];
        if (!$jwt)
            $this->testAuthOrDie();
        else
            $this->testAuthJWTOrDie($jwt);
        $ids = explode(",", $request['ids']);
        $users = [];
        foreach ($ids as $id){
            $user_m = get_user_by( 'id', $id );
            $user = [];
            $field_user = 'user_nicename';
            if (get_option('im_user_field'))
            {
                if (get_option('im_user_field') != '')
                {
                    $field_user = get_option('im_user_field');
                }
            }

            if ($field_user == 'fullname' && ($user_m->first_name || $user_m->last_name))
            {
                $user['name'] = $user_m->first_name.' '.$user_m->last_name;
            }
            elseif ($user_m->$field_user)
            {
                $user['name'] = $user_m->$field_user;
            }
            else
                $user['name'] = $user_m->user_nicename;

            $filtered_name = apply_filters( "rest_imbachat_get_user_name_query", false, ['name' => $user['name'], 'id' => $id] );
            if ($filtered_name) {
                $user['name'] = $filtered_name;
            }
            $user['user_id'] =  $user_m->ID;

            $avatar = get_avatar_url($id);
            if (!preg_match('#^//www[.]gravatar[.]com#', $avatar))
                $user['avatar_url'] = $avatar;

            $user['user_mail'] =  $user_m->user_email;
            if ( in_array( 'administrator', (array) $user_m->roles ) ) {
                $user['chat_role'] = 'admin';
            } else {
                $user['chat_role'] = 'user';
            }
            $permissions = apply_filters( 'rest_request_before_callbacks', $user, ['imbachat_callback' => 'get_users'], $request );
            if (isset($permissions['permissions'])) {
                $user['permissions'] = $permissions['permissions'];
            }
            else
                $user['permissions'] = false;
            $users[] = $user;
        }
        return $users;
    }

    public function auth_user( WP_REST_Request $request )
    {
        $this->testAuthOrDie();
        $creds = array();
        $creds['user_login'] = sanitize_text_field($_POST['username']);
        $creds['user_password'] = $_POST['password'];

        $user_m = wp_signon($creds);
        // authorization failed
        if ( $user_m->errors ) {
            return [
                "code" => 403,
                "error" => $user_m->get_error_message(),
                'debug' => ''
            ];
        }
        $user = array();
        $user['name'] = $user_m->user_nicename;
        $user['user_id'] =  $user_m->ID;
        $admin = get_user_by('id', $user_m->ID);
        if ( in_array( 'administrator', (array) $admin->roles ) ) {
            $user['user_role'] = 'admin';
        }
        return $user;
    }
    public function search_users( WP_REST_Request $request )
    {
        $this->testAuthOrDie();
        $string = $request['string'];
        $search_field = str_replace('_', ' ', $string);
        $string = '*'.$search_field.'*';
        if (get_option('im_user_search_type'))
        {
            if (get_option('im_user_search_type') == '1')
                $string = '*'.esc_attr($search_field).'*';
            elseif (get_option('im_user_search_type') == '2')
                $string = esc_attr($search_field);
            elseif (get_option('im_user_search_type') == '3')
                $string = '*'.esc_attr($search_field).'*';
        }
        $users = new WP_User_Query( array(
            'search'         => $string,
            'search_columns' => array(
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
                'first_name',
                'last_name',
                'display_name'
            ),
        ) );
        $users_found = $users->get_results();
        $users = array();
        foreach ($users_found as $item)
        {
            $user = array();

            if (strlen("$item->first_name $item->last_name") > 3)
                $fullname = "$item->first_name $item->last_name";
            else
                $fullname = $item->user_nicename;

            $user['name'] = $fullname;
            $user['user_id'] = $item->ID;
            $users[] = $user;
        }
        return $users;
    }

    public function sync(WP_REST_Request $request)
    {
        $in_password = $request['in_password'];
        $out_password = $request['out_password'];
        $dev_id = null;
        if (isset($request['dev_id']))
        {
            $dev_id = $request['dev_id'];
        }
        $out_array = explode(':', $out_password);
        if (count($out_array) == 2)
        {
            if ($dev_id)
                update_option('IMCH_dev_id', $dev_id);

            update_option('IMCH_login', $out_array[0]);
            update_option('IMCH_password', $out_array[1]);
            update_option('IMCH_secret_key', $in_password);
        }

        return [
            'IMCH_login' => get_option('IMCH_login'),
            'IMCH_password' => get_option('IMCH_password'),
            'IMCH_secret_key' => get_option('IMCH_secret_key')
        ];
    }

    public function user_friends(WP_REST_Request $request)
    {
        $user_id = $request['user_id'];
        $users = [];

        if (function_exists('friends_get_friend_user_ids')) {
            $friends = friends_get_friend_user_ids($user_id);
            foreach ($friends as $friend){
                $user_m = get_user_by( 'id', $friend );
                $user = [];
                $field_user = 'user_nicename';
                if (get_option('im_user_field'))
                {
                    if (get_option('im_user_field') != '')
                    {
                        $field_user = get_option('im_user_field');
                    }
                }

                if ($field_user == 'fullname' && ($user_m->first_name || $user_m->last_name))
                {
                    $user['name'] = $user_m->first_name.' '.$user_m->last_name;
                }
                elseif ($user_m->$field_user)
                {
                    $user['name'] = $user_m->$field_user;
                }
                else
                    $user['name'] = $user_m->user_nicename;
                $user['user_id'] =  $user_m->ID;

                $avatar = get_avatar_url($friend);
                if (!preg_match('#^//www[.]gravatar[.]com#', $avatar))
                    $user['avatar_url'] = $avatar;

                $user['user_mail'] =  $user_m->user_email;
                if ( in_array( 'administrator', (array) $user_m->roles ) ) {
                    $user['chat_role'] = 'admin';
                } else {
                    $user['chat_role'] = 'user';
                }
                $users[] = $user;
            }
            return $users;
        } else {
            echo json_encode([
                "code" => 422,
                "version" => $this->getApiVersion()['version'],
                "error" => 'Friends are not available!',
                'debug' => ''
            ]);
            die();
        }
    }

    public function getApiVersion(){

        // $this->testAuthOrDie();
        return [
            "version" => 1.0,
            "type" => "Wordpress plugin"
        ];
    }

}