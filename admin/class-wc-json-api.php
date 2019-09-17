<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://sitmaster.kz/
 * @since      1.0.0
 *
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/includes
 * @author     Vitaliy Nikonov <nikonov.vitas@gmail.com>
 */
class Wc_Json_Api {
    public function __construct() {
    }

    public static function instance() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_routes' ), 10 );
    }
    public static function register_rest_routes() {
        register_rest_route( 'importopencardfeed/v1','hello',array(
            'methods'  => 'GET',
            'callback' => array(__CLASS__, 'hello')
        ));
        register_rest_route( 'importopencardfeed/v1','find/(?<sku>\w+)',array(
            'methods'  => 'GET',
            'callback' => array(__CLASS__, 'get_product_by_sku')
        ));
    }

    public static function hello($request) {
        $response = new WP_REST_Response(array('name' => 'importopencardfeed'));
        $response->set_status(200);
        return $response;
    }
    public static function get_product_by_sku($request) {
        $product = self::find($request['sku']);
        if($product){
            $response = new WP_REST_Response(self::find($request['sku']));
            $response->set_status(200);
        } else {
            $response = new WP_Error( 'not_found', 'there is no product', array('status' => 404) );

        }    
        return $response;
    }
    private static function find($sku) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'importopencardfeed_products';
        $products = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE sku = '".$sku."'");
        return $products;
    }
}