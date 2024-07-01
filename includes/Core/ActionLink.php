<?php

/**
 * Defines the setting links of the plugin in the plugin page.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core;

/**
 * ActionLink class.
 *
 * @since 1.0.0
 */
final class ActionLink {
	
	/**
	 * Builds the settings links plugin.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function Build(): void {
		
		$this->action_links();
	}
	
	/**
	 * Add custom links to the plugin links array.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function action_links(): void {
		
		add_filter(
			"plugin_action_links_" . TBI_BASENAME,
			/**
			 * @param array $links List of plugin links array.
			 *
			 * @return array List of plugin link array.
			 */
			function ( array $links ): array {
				
				$action_links = '<a href="plugin-editor.php?plugin=';
				$action_links .= TBI_BASENAME . '&Submit=Select';
				$action_links .= '" style="color: chocolate;">';
				$action_links .= esc_html__( 'Edit', 'tabdeal-books-info' ) . '</a> | ';
				$action_links .= '<a href="admin.php?page=';
				$action_links .= TBI_PREFIX . '_dashboard" style="color: forestgreen;">';
				$action_links .= esc_html__( 'Settings', 'tabdeal-books-info' ) . '</a>';
				
				array_unshift( $links, $action_links );
				
				return $links;
			}
		);
	}
}
