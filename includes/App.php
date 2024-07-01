<?php

/**
 * Invokes the require modules, respectively.
 *
 * @package tabdeal-books-info
 */

namespace TBI;

use Exception;


/**
 * App class.
 *
 * @since 1.0.0
 */
final class App {
	
	/**
	 * Registers modules.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function run(): void {
		
		// Insert all modules of plugin.
		App::register_modules(
			require_once TBI_PATH . 'configs/modules.php'
		);
	}
	
	/**
	 * Loop through the classes, initialize them, and call the build method if it exists.
	 *
	 * @param array $modules
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private static function register_modules( array $modules ): void {
		
		foreach ( $modules as $module ) {
			try {
				if ( ! class_exists( $module ) ) {
					throw new Exception(
						"Tabdeal Books Info Plugin: Something went wrong, The \"$module\" does not exist",
						404
					);
				} else {
					( new $module() )->build();
				}
			} catch ( Exception $e ) {
				App::custom_notice( $e );
			}
		}
	}
	
	/**
	 * Represent a notice in the html format.
	 *
	 * @param Exception $exception A exception.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private static function custom_notice( Exception $exception ): void {
		
		add_action(
			'admin_notices',
			function () use ( $exception ) {
				
				$markup = '<div class="%1$s"><p><strong>%2$s</strong></p></div>';
				
				printf(
					$markup,
					esc_attr( "notice notice-error settings-error is-dismissible" ),
					esc_html( "{$exception->getMessage()} with error code: {$exception->getCode()})" ),
				);
			},
			100,
			0
		);
	}
}
