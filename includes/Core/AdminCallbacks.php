<?php

/**
 * Defines the whole of admin callbacks.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core;

/**
 * AdminCallbacks class.
 *
 * @since 1.0.0
 */
final class AdminCallbacks {
	
	/**
	 * Renders the dashboard template.
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public static function render_dashboard(): mixed {
		
		return require_once TBI_TEMPLATES . 'admin/dashboard.callback.php';
	}
}
