<?php

/**
 * Defines the plugin const variables.
 *
 * @package tabdeal-books-info
 */

// Security Note: Blocks direct access to the PHP files.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$plugin_data = get_plugins()[ TBI_BASENAME ]; // Get all data plugin.

const TBI_PREFIX = 'tbi';  // Define plugin prefix.

define( 'TBI_NAME', $plugin_data['Name'] );        // Define plugin name.
define( 'TBI_VERSION', $plugin_data['Version'] );  // Define plugin version.

define( 'TBI_NAMESPACE', strtoupper( TBI_PREFIX ) . '\\' );  // Define plugin namespace.

const TBI_ASSETS    = TBI_URL . 'assets/';      // Define plugin assets url.
const TBI_TEMPLATES = TBI_PATH . 'templates/';  // Define a plugin templates-folder path.
