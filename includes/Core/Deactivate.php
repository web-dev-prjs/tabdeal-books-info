<?php

/**
 * Deactivates the plugin.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core;

/**
 * Deactivate class.
 *
 * @since 1.0.0
 */
final class Deactivate {

	/**
	 * Runs in the deactivation time.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function deactivate(): void {

		/*
		 |-----------------------------------------------------------
		 | Removes rewrite rules and then recreate rewrite rules.
		 |-----------------------------------------------------------
		 */
		flush_rewrite_rules();
	}
}
