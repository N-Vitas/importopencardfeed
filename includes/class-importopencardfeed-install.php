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
class Importopencardfeed_Install {
    public static function get_tables() {
		global $wpdb;

		$tables = array(
			"{$wpdb->prefix}importopencardfeed_settings",
			"{$wpdb->prefix}importopencardfeed_products",
		);
		return $tables;
    }
    public static function install() {
		global $wpdb;
		
		$collate = $wpdb->get_charset_collate();

		$scheme = "
		CREATE TABLE {$wpdb->prefix}importopencardfeed_settings (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`name` varchar(100) NULL default '',
			`crontime` varchar(255) DEFAULT '' NOT NULL,
			`run` tinyint(1) NULL default 0,
			`url` varchar(255) DEFAULT '' NOT NULL,
			PRIMARY KEY  (id)
		) $collate;
		CREATE TABLE {$wpdb->prefix}importopencardfeed_products (	
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`sku` varchar(100) NULL default '',
			`virtual` tinyint(1) NULL default 0,
			`downloadable` tinyint(1) NULL default 0,
			`min_price` decimal(10,2) NULL default NULL,
			`max_price` decimal(10,2) NULL default NULL,
			`onsale` tinyint(1) NULL default 0,
			`stock_quantity` double NULL default NULL,
			`stock_status` varchar(100) NULL default 'instock',
			`rating_count` bigint(20) NULL default 0,
			`average_rating` decimal(3,2) NULL default 0.00,
			`total_sales` bigint(20) NULL default 0,
			PRIMARY KEY  (`id`),
			KEY `virtual` (`virtual`),
			KEY `downloadable` (`downloadable`),
			KEY `stock_status` (`stock_status`),
			KEY `stock_quantity` (`stock_quantity`),
			KEY `onsale` (`onsale`),
			KEY min_max_price (`min_price`, `max_price`)
		) $collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $scheme );
	}

	public static function install_data() {
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
				"url" => "http://localhost/", 
			) 
		);
	}

	public static function drop_tables() {
		global $wpdb;

		$tables = self::get_tables();

		foreach ( $tables as $table ) {
			$wpdb->query( "DROP TABLE IF EXISTS {$table}" );
		}
	}
}