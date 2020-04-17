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
            $users[] = $user;
        }
        return $users;
	}

	public function auth_user( WP_REST_Request $request )
	{
		$this->testAuthOrDie();
		$creds = array();
		$creds['user_login'] = sanitize_text_field($_POST['login']);
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
        return $user;
	}
	public function search_users( WP_REST_Request $request )
	{
		$this->testAuthOrDie();
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, 3306);
        $res = $mysqli->query("SELECT * FROM imbademo_wordpress_users WHERE user_nicename LIKE '%".$mysqli->real_escape_string($request['string'])."%'");
        $users = array();
        while ($row = $res->fetch_assoc()) {
            $user = array();
            $user['name'] = $row['user_nicename'];
            $user['user_id'] = $row['ID'];
            $users[] = $user;
        }
        return $users;
	}
	public function getApiVersion(){
      
        // $this->testAuthOrDie();
        return [
            "version" => 1.0,
            "type" => "Wordpress plugin"
        ];
    }
}