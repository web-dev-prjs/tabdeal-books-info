<?php

/**
 * Enqueues styles and scripts.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core;

/**
 * Enqueue class.
 *
 * @since 1.0.0
 */
final class Enqueue {
	
	/**
	 * Builds actions of this class in while the plugin will activate.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function build(): void {
		
		// Hooks all backend (admin) styles and scripts.
		$this->admin_enqueue();
	}
	
	/**
	 * Enqueue all our styles and scripts inside admin dashboard.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function admin_enqueue(): void {
		
		/**
		 * @param string $hook_suffix The current admin page.
		 */
		add_action(
			'admin_enqueue_scripts',
			function ( string $hook_suffix ) {
				if ( 'toplevel_page_tbi_dashboard' !== $hook_suffix ) {
					return;
				}
				
				/*
				 |---------------------------------------------------
				 | Registers and enqueues all plugin styles.
				 |---------------------------------------------------
				 */
				wp_register_style(
					TBI_PREFIX . '-admin-bootstrap-min-styles',
					TBI_ASSETS . "css/bootstrap.min.css",
					array(),
					'5.3.3'
				);
				
				wp_enqueue_style(
					TBI_PREFIX . '-admin-styles',
					TBI_ASSETS . "css/styles.admin.css",
					array( TBI_PREFIX . '-admin-bootstrap-min-styles' ),
					TBI_VERSION
				);
				
				/*
				 |---------------------------------------------------
				 | Registers and enqueues all plugin scripts.
				 |---------------------------------------------------
				 */
				wp_register_script(
					TBI_PREFIX . '-admin-bootstrap-min-scripts',
					TBI_ASSETS . "js/bootstrap.min.js",
					array( 'jquery' ),
					'5.3.3',
					true,
				);
				
				wp_register_script(
					TBI_PREFIX . '-admin-bootstrap-bundle-min-scripts',
					TBI_ASSETS . "js/bootstrap.bundle.min.js",
					array( 'jquery' ),
					'5.3.3',
					true,
				);
				
				wp_enqueue_script(
					TBI_PREFIX . '-admin-scripts',
					TBI_ASSETS . "js/scripts.admin.js",
					array(
						'jquery',
						TBI_PREFIX . '-admin-bootstrap-min-scripts',
						TBI_PREFIX . '-admin-bootstrap-bundle-min-scripts'
					),
					TBI_VERSION,
					true,
				);
			}
		);
	}
}
