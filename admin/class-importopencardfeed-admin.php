<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://sitmaster.kz/
 * @since      1.0.0
 *
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/admin
 * @author     Vitaliy Nikonov <nikonov.vitas@gmail.com>
 */
class Importopencardfeed_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// Добавление в меню админки
		add_action("admin_menu", array($this,"options_page"));
	}
	public function options_page() {
		add_menu_page(
			'Импорт товаров с файла feed', // Заголовок страницы
			__( 'Синхронизация','importopencardfeed' ), // Название в пункте меню
			'manage_options',
			__FILE__,
			array($this, "render"),
			'dashicons-update-alt',
			50
		);
		
	}
	public function render() {
		global $wpdb;
		$setting = $wpdb->get_row( "SELECT id, name, crontime, run, url FROM {$wpdb->prefix}importopencardfeed_settings WHERE id = 1" );
		require plugin_dir_path( dirname(__FILE__)) . 'admin/partials/importopencardfeed-admin-display.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Importopencardfeed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Importopencardfeed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/importopencardfeed-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Importopencardfeed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Importopencardfeed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/importopencardfeed-admin.js', array( 'jquery' ), $this->version, false );

	}

}
