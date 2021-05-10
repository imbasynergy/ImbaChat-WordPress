<?php
/**
 * ImbaChat DataBase Class
 *
 *
 * @class    IM_Curl
 * @version  1.0.0
 * @category Admin
 * @author   SprayDev
 */

class IM_DB {

    protected $imdb;

    public function __construct()
    {
        global $wpdb;
        $this->imdb = $wpdb;
    }

    public static function check_for_upd($version)
    {

        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "check_for_upd (class-im-db.php)\n";
    file_put_contents($file,$log);

        if (get_option('imbachat_db_version') == $version) {
            return;
        }
        global $wpdb;

        $table_name = $wpdb->prefix . 'imbachat_hooks';

        $charset_collate = $wpdb->get_charset_collate();
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		tag tinytext NOT NULL,
		description text NOT NULL,
		function tinytext NOT NULL,
		type varchar(50) NOT NULL,
		forbidden smallint NOT NULL
	) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

            update_option( 'imbachat_db_version', $version );
        }
    }

    public function where($table_name, $conditions)
    {

        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "where (class-im-db.php)\n";
    file_put_contents($file,$log);


        $table_name = $this->imdb->prefix . $table_name;
        $sql = "select * from $table_name where ";
        $condition = '';
        $last_cond = array_splice($conditions, -1, 1);
        foreach ($conditions as $field => $value) {
            $condition .= "$field = '$value' AND ";
        }
        $condition .= key($last_cond)." = '".$last_cond[key($last_cond)]."'";
        $query = $this->imdb->get_results($sql.$condition);

        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "\n$query\n";
    file_put_contents($file,$log);


        return $query;
    }

    public function get_all($table_name)
    {
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "get_all (class-im-db.php)\n";
    file_put_contents($file,$log);

        $table_name = $this->imdb->prefix . $table_name;
        $sql = "select * from $table_name";
        $query = $this->imdb->get_results($sql);
        return $query;
    }

    public function insert($table_name, $values)
    {
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "insert (class-im-db.php)\n";
    file_put_contents($file,$log);

        $table_name = $this->imdb->prefix . $table_name;
        $this->imdb->insert($table_name, $values);
    }

    public function update($table_name, $data, $where)
    {
        $file = get_template_directory().'/custom_log.txt';
    $log = file_get_contents($file);
    $log.= "update (class-im-db.php)\n";
    file_put_contents($file,$log);
    
        $table = $this->imdb->prefix . $table_name;

        if ( ! is_array( $data ) || ! is_array( $where ) )
            return false;

        $SET = $WHERE = [];

        // SET
        foreach ( $data as $field => $value ) {
            $field = sanitize_key( $field );

            if ( is_null( $value ) ) {
                $SET[] = "`$field` = NULL";
                continue;
            }

            $SET[] = $this->imdb->prepare( "`$field` = %s", $value );
        }

        // WHERE
        foreach ( $where as $field => $value ) {
            $field = sanitize_key( $field );

            if ( is_null( $value ) ) {
                $WHERE[] = "`$field` IS NULL";
                continue;
            }

            if( is_array($value) ){
                foreach( $value as & $val ){
                    $val = $this->imdb->prepare( "%s", $val );
                }
                unset( $val );

                $WHERE[] = "`$field` IN (". implode(',', $value) .")";
            }
            else
                $WHERE[] = $this->imdb->prepare( "`$field` = %s", $value );
        }

        $sql = "UPDATE `$table` SET ". implode( ', ', $SET ) ." WHERE ". implode( ' AND ', $WHERE );

        return $this->imdb->query( $sql );
    }
}