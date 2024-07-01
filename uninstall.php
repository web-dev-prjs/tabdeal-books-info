<?php

/**
 * Uses for when uninstalling this plugin.
 * Such as removing related tables from a database, or any other required actions.
 *
 * @package tabdeal-books-info
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

/**
 * Uninstall class.
 *
 * @since 1.0.0
 */
final class uninstall {
	
	/**
	 * Runs in the uninstallation time.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function run(): void {
		
		/*
		 |-----------------------------------------------------------
		 | Removes rewrite rules and then recreate rewrite rules.
		 |-----------------------------------------------------------
		 */
		flush_rewrite_rules();
		
		/*
		 |-----------------------------------------------------------
		 | Clear any cached data that has been removed.
		 |-----------------------------------------------------------
		 */
		wp_cache_flush();
	}
}

// It will trigger at the deleting time.
uninstall::run();