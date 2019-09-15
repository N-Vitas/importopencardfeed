<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://sitmaster.kz/
 * @since      1.0.0
 *
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Importopencardfeed
 * @subpackage Importopencardfeed/includes
 * @author     Vitaliy Nikonov <nikonov.vitas@gmail.com>
 */
class Importopencardfeed_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'importopencardfeed',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
