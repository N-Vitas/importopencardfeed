<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://sitmaster.kz/
 * @since      1.0.0
 *
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/includes
 * @author     Vitaliy Nikonov <nikonov.vitas@gmail.com>
 */
class Importopencardfeed {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Importopencardfeed_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'IMPORTOPENCARDFEED_VERSION' ) ) {
			$this->version = IMPORTOPENCARDFEED_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'importopencardfeed';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Importopencardfeed_Loader. Orchestrates the hooks of the plugin.
	 * - Importopencardfeed_i18n. Defines internationalization functionality.
	 * - Importopencardfeed_Admin. Defines all hooks for the admin area.
	 * - Importopencardfeed_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-importopencardfeed-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-importopencardfeed-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-importopencardfeed-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-importopencardfeed-public.php';

		$this->loader = new Importopencardfeed_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Importopencardfeed_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Importopencardfeed_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Importopencardfeed_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Importopencardfeed_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->postProcess($_POST);
		}
	}

	public function postProcess($post) {
		if (isset($post['action']) && $post['action'] == 'importopencardfeed') {
			$this->run_import($post);
		}
	}
	public function run_import($post) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'importopencardfeed_settings';
		if(isset($post["run"])) {
			$run = @$post["run"];
		} else {
			$run = 0;
		}
		// Готово, теперь используем функции класса wpdb
		$wpdb->update( 
			$table_name, 
			array(  
				"crontime" => $post["crontime"], 
				"run" => $run, 
				"url" => $post["url"], 
			),
			array( 'id' => 1 ),
			array( '%s', '%d', '%s'),
			array( '%d' )
		);
		if (isset($post["run"])) {
			wp_schedule_single_event( time() + 60, 'query_import_hook' );
			if (!wp_next_scheduled( 'query_import_hook' ) ) {
				error_log( 'send_test_email_in_background:START' );
				wp_schedule_event ( time(), $post["crontime"], 'query_import_hook');
				error_log( 'send_test_email_in_background:END' );
			} else {
				wp_schedule_event ( time(), $post["crontime"], 'query_import_hook');
			}
		} else {
			wp_unschedule_event( wp_next_scheduled( 'query_import_hook' ), 'query_import_hook' );
		}
		add_action( 'query_import_hook', 'query_import' );
	}
	function query_import() {
		update_option('admin_email','nikonov.vitas@gmail.com'.time());
		global $wpdb;
		$table_name = $wpdb->prefix . 'importopencardfeed_products';
		// Готово, теперь используем функции класса wpdb
		$wpdb->insert( 
			$table_name, 
			array(  
				'sku' => 'sdfgsfd',
				'virtual' => 0,
				'downloadable' => 0,
				'min_price' => 3456,
				'max_price' => 34563,
				'onsale' => 0,
				'stock_quantity' => NULL,
				'stock_status' => 'instock',
				'rating_count' => 0,
				'average_rating' => 0.00,
				'total_sales' => 0,	
			)
		);
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Importopencardfeed_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}