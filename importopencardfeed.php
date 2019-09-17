<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://sitmaster.kz/
 * @since             1.0.0
 * @package           Importopencardfeed
 *
 * @wordpress-plugin
 * Plugin Name:       ImportOpenCardFeed
 * Plugin URI:        http://sitmaster.kz/
 * Description:       Этот плагин позволяет с интервалом импортировать товары с другого сайта по формату xml файла Yandex Market
 * Version:           1.0.0
 * Author:            Vitaliy Nikonov
 * Author URI:        http://sitmaster.kz/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       importopencardfeed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IMPORTOPENCARDFEED_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-importopencardfeed-activator.php
 */
function activate_importopencardfeed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-importopencardfeed-activator.php';
	Importopencardfeed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-importopencardfeed-deactivator.php
 */
function deactivate_importopencardfeed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-importopencardfeed-deactivator.php';
	Importopencardfeed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_importopencardfeed' );
register_deactivation_hook( __FILE__, 'deactivate_importopencardfeed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-importopencardfeed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_importopencardfeed() {
	$plugin = new Importopencardfeed();
	$plugin->run();

}

add_action('init', 'run_importopencardfeed');