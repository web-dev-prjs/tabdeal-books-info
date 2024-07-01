<?php

/**
 * Actives the plugin.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core;

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
	}
}
