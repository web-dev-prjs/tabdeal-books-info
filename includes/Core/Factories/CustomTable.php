<?php

/**
 * Defines the custom tables into database to using in the plugin.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core\Factories;

use mysqli_result;

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
	 * Gets the table prefix of database.
	 *
	 * @return string Table prefix.
	 * @since 1.2.0
	 */
	public static function get_table_prefix(): string {
		
		global $wpdb;
		
		return $wpdb->prefix;
	}
	
	/**
	 * Retrieves value of a specify column based-on sql-query from database.
	 *
	 * @param string       $sql  A sql-query.
	 * @param string|array $args A variable or an array of variables.
	 *
	 * @return null|string
	 * @since 1.2.0
	 */
	public static function get_var( string $sql, string|array $args ): null|string {
		
		global $wpdb;
		
		$query = $wpdb->prepare( "$sql;", $args );
		
		return $wpdb->get_var( $query );
	}
	
	/**
	 * Gets results based-on sql-query from database.
	 *
	 * @param string       $sql  A sql-query.
	 * @param string|array $args A variable or an array of variables.
	 *
	 * @return null|array|object
	 * @since 1.2.0
	 */
	public static function get_results( string $sql, string|array $args ): array|null|object {
		
		global $wpdb;
		
		$query = $wpdb->prepare( "$sql;", $args );
		
		return $wpdb->get_results( $query, OBJECT_K );
	}
	
	/**
	 * Updates a row based-on sql-query into custom-table in database.
	 *
	 * @param string $table_name Name of custom-table.
	 * @param array  $data       Data to update (in column => value pairs)
	 * @param array  $where      A named array of WHERE clauses (in column => value pairs).
	 *
	 * @return bool|int|mysqli_result|null
	 * @since 1.2.0
	 */
	public static function update_row( string $table_name, array $data, array $where ): bool|int|mysqli_result|null {
		
		global $wpdb;
		
		$table_name = $wpdb->prefix . $table_name;
		
		return $wpdb->update( $table_name, $data, $where );
	}
	
	/**
	 * Inserts a row based-on sql-query into custom-table in database.
	 *
	 * @param string $table_name Name of custom-table.
	 * @param array  $data       Data to update (in column => value pairs)
	 *
	 * @return bool|int|mysqli_result|null
	 * @since 1.2.0
	 */
	public static function insert_row( string $table_name, array $data ): bool|int|mysqli_result|null {
		
		global $wpdb;
		
		$table_name = $wpdb->prefix . $table_name;
		
		return $wpdb->insert( $table_name, $data );
	}
	
	/**
	 * Removes a custom-table into database.
	 *
	 * @param string $table_name Name of custom-table.
	 *
	 * @return void
	 * @since 1.1.0
	 */
	public static function remove( string $table_name ): void {
		
		global $wpdb;
		
		$table_name = $wpdb->prefix . $table_name;
		
		$sql = "DROP TABLE IF EXISTS $table_name;";
		
		$wpdb->query( $sql );
		
		delete_option( CustomTable::$plugin_slug . '_db_version' );
	}
	
	/**
	 * Creates a custom-table into database.
	 *
	 * @param string $table_name Name of custom-table.
	 * @param string $columns    A set of require columns, and defining the PRIMARY-KEY of the table.
	 *
	 * @return void
	 * @since 1.1.0
	 */
	public static function create( string $table_name, string $columns ): void {
		
		global $wpdb;
		
		$table_name = $wpdb->prefix . $table_name;
		
		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
			return;
		}
		
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE $table_name ($columns) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		dbDelta( $sql );
	}
}
