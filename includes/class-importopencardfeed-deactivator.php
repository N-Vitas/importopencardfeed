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
class Importopencardfeed_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		self::uninstall_importopencardfeed();
	}
	public static function uninstall_importopencardfeed() {
		require_once plugin_dir_path( __FILE__ ) . 'class-importopencardfeed-install.php';
		Importopencardfeed_Install::drop_tables();
		wp_clear_scheduled_hook('importopencardfeed_hook');
	}

}

