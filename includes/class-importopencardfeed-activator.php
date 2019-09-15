<?php

/**
 * Fired during plugin activation
 *
 * @link       http://sitmaster.kz/
 * @since      1.0.0
 *
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/includes
 * @author     Vitaliy Nikonov <nikonov.vitas@gmail.com>
 */
class Importopencardfeed_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::install_importopencardfeed();
	}
	
	public static function install_importopencardfeed() {
		require_once plugin_dir_path( __FILE__ ) . 'class-importopencardfeed-install.php';
		Importopencardfeed_Install::install();
		Importopencardfeed_Install::install_data();
	}
}