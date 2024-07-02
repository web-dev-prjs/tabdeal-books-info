<?php

/**
 * Defines the custom tables into database to using in the plugin.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core\Factories;

/**
 * CustomTable class.
 *
 * @since 1.1.0
 */
final class CustomTable {
	
	/**
	 * The plugin slug.
	 *
	 * @var string
	 * @since 1.1.0
	 */
	private static string $plugin_slug = 'tabdeal_books_info';
	
	/**
	 * Creates a custom-table into database.
	 *
	 * @param string $name    Name of custom-table.
	 * @param string $columns A set of require columns, and defining the PRIMARY-KEY of the table.
	 *
	 * @return void
	 * @since 1.1.0
	 */
	public static function create( string $name, string $columns ): void {
		
		global $wpdb;
		
		$table_name = $wpdb->prefix . $name;
		
		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
			return;
		}
		
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE $table_name ($columns) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		dbDelta( $sql );
	}
	
	/**
	 * Removes a custom-table into database.
	 *
	 * @param string $name Name of custom-table.
	 *
	 * @return void
	 * @since 1.1.0
	 */
	public static function remove( string $name ): void {
		
		global $wpdb;
		
		$table_name = $wpdb->prefix . $name;
		
		$sql = "DROP TABLE IF EXISTS $table_name;";
		
		$wpdb->query( $sql );
		
		delete_option( CustomTable::$plugin_slug . '_db_version' );
	}
}
