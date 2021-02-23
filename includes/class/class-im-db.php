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

    public function where($table_name, $conditions)
    {
        $table_name = $this->imdb->prefix . $table_name;
        $sql = "select * from $table_name where ";
        $condition = '';
        $last_cond = array_splice($conditions, -1, 1);
        foreach ($conditions as $field => $value) {
            $condition .= "$field = '$value' AND ";
        }
        $condition .= key($last_cond)." = '".$last_cond[key($last_cond)]."'";
        $query = $this->imdb->get_results($sql.$condition);
        return $query;
    }

    public function get_all($table_name)
    {
        $table_name = $this->imdb->prefix . $table_name;
        $sql = "select * from $table_name";
        $query = $this->imdb->get_results($sql);
        return $query;
    }

    public function insert($table_name, $values)
    {
        $table_name = $this->imdb->prefix . $table_name;
        $this->imdb->insert($table_name, $values);
    }

    public function update($table_name, $data, $where)
    {
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