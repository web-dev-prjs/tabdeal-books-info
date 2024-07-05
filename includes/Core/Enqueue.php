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
		
		/**
		 * Hooks all frontend (client) styles and scripts.
		 *
		 * @since 1.3.0
		 */
		$this->wp_enqueue();
		
		/**
		 * Hooks all backend (admin) styles and scripts.
		 *
		 * @since 1.0.0
		 */
		$this->admin_enqueue();
	}
	
	/**
	 * Enqueue all our styles and scripts in client side.
	 *
	 * @return void
	 * @since 1.3.0
	 */
	private function wp_enqueue(): void {
		
		add_action(
			'wp_enqueue_scripts',
			function () {
				
				if ( ! is_singular( 'book' ) ) {
					return;
				}
				
				/*
				 |---------------------------------------------------
				 | Registers and enqueues all plugin client styles.
				 |---------------------------------------------------
				 */
				wp_enqueue_style(
					TBI_PREFIX . '-wp-styles',
					TBI_ASSETS . "css/styles.wp.css",
					array(),
					TBI_VERSION
				);
				
				/*
				 |---------------------------------------------------
				 | Registers and enqueues all plugin client scripts.
				 |---------------------------------------------------
				 */
				wp_enqueue_script(
					TBI_PREFIX . '-wp-scripts',
					TBI_ASSETS . "js/scripts.wp.js",
					array( 'jquery' ),
					TBI_VERSION,
					true,
				);
			}
		);
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
		 *
		 * @since 1.0.0
		 */
		add_action(
			'admin_enqueue_scripts',
			function ( string $hook_suffix ) {
				
				if ( 'toplevel_page_tbi_dashboard' !== $hook_suffix ) {
					return;
				}
				
				/*
				 |---------------------------------------------------
				 | Registers and enqueues all plugin admin styles.
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
				 | Registers and enqueues all plugin admin scripts.
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
