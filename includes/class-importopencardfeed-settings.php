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
class Importopencardfeed_Settings {


	public static function install_settings() {
		global $wpdb;
		/*
		 * Частота обновления
		 * hourly - ежечасно;
		 * twicedaily - дважды в день;
		 * daily - ежедневно.
		*/
		$table_name = $wpdb->prefix . 'importopencardfeed_settings';
		// Готово, теперь используем функции класса wpdb
		$wpdb->replace( 
			$table_name, 
			array( 
				'id'      => 1,
				"name" => "Настройки синхронизации", 
				"crontime" => "hourly", 
				"run" => 0, 
				"url" => "https://baumarkt.kz/index.php?route=extension/feed/yandex_market", 
			) 
		);
    }

    public static function is_run() {
		$settings = self::get_settings();
        return $settings->run ? true : false;
    }
    public static function get_cron_time() {
		$settings = self::get_settings();
        return $settings->crontime;
    }
    public static function get_feed_url() {
		$settings = self::get_settings();
        return $settings->url;
    }
    private static function get_settings() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'importopencardfeed_settings';
        $ssetings = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id = 1");
        return $ssetings;
    }
}