<?php
add_action( 'rest_api_init', 'IMCH_prefix_register_my_rest_routes' );
function IMCH_prefix_register_my_rest_routes() {
	$file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "IMCH_prefix_register_my_rest_routes (ImbaChatUser.php)\n";
    file_put_contents($file,$log);

	$controller = new IMCH_USERS_Controller();
	$controller->register_routes();
}

class IMCH_USERS_Controller extends WP_REST_Controller {

	function __construct(){
		$this->namespace = 'imbachat/v1';
    }
    function register_routes(){
    	$file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "register_routes (ImbaChatUser.php)\n";
    file_put_contents($file,$log);

		register_rest_route( $this->namespace, "/getusers/(?P<ids>[\w\,/]+)", [
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'get_users' ]
			]
		] );
    }
    public function get_users( WP_REST_Request $request )
    {
        return $request['ids'];
    }
}