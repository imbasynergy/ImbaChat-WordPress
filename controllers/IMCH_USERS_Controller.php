<?php
add_action( 'rest_api_init', 'IMCH_prefix_register_my_rest_routes' );
function IMCH_prefix_register_my_rest_routes() {
    $controller = new IMCH_USERS_Controller();
    $controller->register_routes();
}

class IMCH_USERS_Controller extends WP_REST_Controller {

    function __construct(){
        $this->namespace = 'imbachat/v1';
    }
    function register_routes(){

        register_rest_route( $this->namespace, "/getusers/(?P<ids>[\w\,/]+)", [
            [
                'methods'             => 'GET',
                'callback'            => [ $this, 'get_users' ]
            ]
        ] );
        register_rest_route( $this->namespace, "/authuser", [
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'auth_user' ]
            ]
        ] );
        register_rest_route( $this->namespace, "/searchusers/(?P<string>[\w]+)", [
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'search_users' ]
            ]
        ] );
        register_rest_route( $this->namespace, "/sync", [
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'sync' ]
            ]
        ] );
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

    public function get_users( WP_REST_Request $request )
    {
        //var_dump(get_user_by( 'id', 1 ));
        $this->testAuthOrDie();
        $ids = explode(",", $request['ids']);
        $users = [];
        foreach ($ids as $id){
            $user_m = get_user_by( 'id', $id );
            $user = [];
            $user['name'] = $user_m->user_nicename;
            $user['user_id'] =  $user_m->ID;
            $user['user_mail'] =  $user_m->user_email;
            if ( in_array( 'administrator', (array) $user_m->roles ) ) {
                $user['chat_role'] = 'admin';
            } else {
                $user['chat_role'] = 'user';
            }
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
        // авторизация не удалась
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
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $this->testAuthOrDie();
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, 3306);
        $res = $mysqli->query("SELECT * FROM ".$table_prefix."users WHERE user_nicename LIKE '%".$mysqli->real_escape_string($request['string'])."%'");
        $users = array();
        while ($row = $res->fetch_assoc()) {
            $user = array();
            $user['name'] = $row['user_nicename'];
            $user['user_id'] = $row['ID'];
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

    public function getApiVersion(){

        // $this->testAuthOrDie();
        return [
            "version" => 1.0,
            "type" => "Wordpress plugin"
        ];
    }
}