<?php

/**
 * Defines admin page of the plugin.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core;


/**
 * Dashboard class.
 *
 * @since 1.0.0
 */
final class Dashboard {
	
	/**
	 * Stores admin pages.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private array $admin_pages = array();
	
	/**
	 * Builds actions of this class in while the plugin will activate.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function build(): void {
		
		$this->add_admin_page()->register_admin_pages();
	}
	
	/**
	 * Adds admin pages.
	 *
	 * @return Dashboard
	 * @since 1.0.0
	 */
	private function add_admin_page(): Dashboard {
		
		$this->admin_pages = array(
			array(
				'position'   => 110,
				'page_title' => 'Books Info',
				'menu_title' => 'Books Info',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-book-alt',
				'menu_slug'  => TBI_PREFIX . '_dashboard',
				'callback'   => array(
					TBI_NAMESPACE . 'Core\AdminCallbacks',
					'render_dashboard'
				)
			)
		);
		
		return $this;
	}
	
	/**
	 * Registers admin pages.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function register_admin_pages(): void {
		
		add_action( 'admin_menu', function () {
			
			foreach ( $this->admin_pages as $main_page ) {
				add_menu_page(
					$main_page['page_title'],
					$main_page['menu_title'],
					$main_page['capability'],
					$main_page['menu_slug'],
					$main_page['callback'],
					$main_page['icon_url'],
					$main_page['position']
				);
			}
		} );
	}
}
