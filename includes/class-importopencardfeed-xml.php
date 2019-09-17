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
class Importopencardfeed_Xml {
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $xml    The object used to upload products.
	 */
	private $xml;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
    public function __construct() {
		if ( defined( 'IMPORTOPENCARDFEED_VERSION' ) ) {
			$this->version = IMPORTOPENCARDFEED_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'importopencardfeed';
		$this->load_dependencies();
	}
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Importopencardfeed_Settings. Orchestrates the hooks of the plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-importopencardfeed-settings.php';
	}
    public function load_product_xml() {
        set_time_limit(0);
        $this->xml = simplexml_load_file(Importopencardfeed_Settings::get_feed_url());
        // $this->xml = simplexml_load_file(wp_get_upload_dir()['basedir'].'/import.xml');
        if ($this->is_load()) {
            $this->import();
            $this->success();
        } else {
            $this->error();
        }
    }

    private function is_load() {
        return $this->xml ? true : false;
    }
	/**
	 * Load the required import offer.
     * @attributes id int
     * @attributes attributes boolean
     * @param url string
     * @param price float
     * @param currencyId string
     * @param categoryId string
     * @param picture string
     * @param delivery boolean
     * @param name string
     * @param vendor string
     * @param vendorCode string
     * @param description string
	 * @since    1.0.0
	 * @access   private
	 */
    private function import() {
        foreach($this->xml->shop->offers->offer as $offer){
            if(isset($offer->vendorCode) &&  isset($offer->price) && isset($offer->delivery))
            $this->new_wp_product($offer->vendorCode, $offer->price, $offer->delivery);
            $this->update_woocommerce($offer->vendorCode, $offer->price, $offer->delivery);
        }
    }
    private function debug($obj) {
        echo '<pre style="
        position: absolute;
        top: 100px;
        right: 100px;
        z-index: 999;
        width: 20%;
        height: 400px;
        background: #fff;
        overflow: auto;
    ">';
        var_dump($obj);
        echo '</pre>';
    }

    protected function new_wp_product($sku, $price, $delivery) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'importopencardfeed_products';
        // Готово, теперь используем функции класса wpdb
        if ($this->find($sku)) {
            return $wpdb->update( 
                $table_name, 
                array(  
                    'sku' => $sku,
                    'min_price' => $price,
                    'max_price' => $price,
                    'stock_status' => $delivery ? 'instock' : 'outofstock',
                ),
                array('sku' => $sku,)
            );
        } else {
            return $wpdb->insert( 
                $table_name, 
                array(  
                    'sku' => $sku,
                    'virtual' => 0,
                    'downloadable' => 0,
                    'min_price' => $price,
                    'max_price' => $price,
                    'onsale' => 0,
                    'stock_quantity' => NULL,
                    'stock_status' => $delivery ? 'instock' : 'outofstock',
                    'rating_count' => 0,
                    'average_rating' => 0.00,
                    'total_sales' => 0,	
                )
            );
        }
    }
    private function find($sku) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'importopencardfeed_products';
        $products = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE sku = '".$sku."'");
        return $products;
    }
    private function update_woocommerce($sku, $price, $delivery) {
        $product_id = wc_get_product_id_by_sku($sku);
        if($product_id) {
            $product = wc_get_product($product_id);
            $product->set_regular_price($price);
            $product->set_sale_price($price);
            $product->set_stock_status($delivery ? 'instock' : 'outofstock');
            $product->save();
        }
    }
    private function error() {
        add_action(
            'admin_notices',
            function() {
                ?>
                <div class="notice notice-error">
                    <p>                       
                        <strong>
                            <p>Что то пошло не так. Ошибка выполнения синхронизации</p>
                        </strong>
                    </p>
                </div>
                <?php
            }
        );
    }
    private function success() {
        add_action(
            'admin_notices',
            function() {
                ?>
                <div class="notice notice-success">
                    <p>
                        <strong>
                            <p>Выполнено успешно</p>
                        </strong>
                    </p>
                </div>
                <?php
            }
        );
    }
}