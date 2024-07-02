<?php

/**
 * Actives the plugin.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core;

use TBI\Core\Factories\CustomTable;

/**
 * Activate class.
 *
 * @since 1.0.0
 */
final class Activate {
	
	/**
	 * Runs in the activation time.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function activate(): void {
		
		/*
		 |-----------------------------------------------------------
		 | Removes rewrite rules and then recreate rewrite rules.
		 |-----------------------------------------------------------
		 */
		flush_rewrite_rules();
		
		/*
		 |--------------------------------
		 | Creates books-info table.
		 | @since 1.1.0
		 |--------------------------------
		 */
		CustomTable::create(
			'books_info',
			'
			ID bigint UNSIGNED NOT NULL AUTO_INCREMENT,
	        ISBN tinytext NOT NULL,
	        post_id bigint UNSIGNED NOT NULL,
	        PRIMARY KEY  (ID)
	        '
		);
	}
}
