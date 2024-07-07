<?php

/**
 * Initializes the whole of the plugin.
 *
 * @package tabdeal-books-info
 */

// Security Note: Blocks direct access to the PHP files.
defined( 'ABSPATH' ) || exit;

$requirements = array(
	'configs/constants', // All constants of plugin.
	'vendor/autoload'    // Autoload all classes of plugin.
);

foreach ( $requirements as $requirement ) {
	// Insert all require files.
	if ( ! file_exists( TBI_PATH . "$requirement.php" ) ) {
		/**
		 * @since 1.4.2
		 */
		if ( 'vendor/autoload' === $requirement ) {
			add_action( 'all_admin_notices', function () {
				
				$message = '<div class="notice notice-error">';
				$message .= '<p>Dependencies for Tabdeal-Books-Info need to be installed.<br />';
				$message .= ' Run <code>composer install --no-dev</code>';
				$message .= ' from the <code>%s</code> directory.</p></div>';
				
				printf( $message, esc_html( __DIR__ ) );
			} );
			
			return;
		}
	}
	
	require_once TBI_PATH . "$requirement.php";
}

// Activate the plugin.
register_activation_hook(
	TBI_FILE,
	array( TBI_NAMESPACE . 'Core\Activate', 'activate' )
);

// Deactivate the plugin.
register_deactivation_hook(
	TBI_FILE,
	array( TBI_NAMESPACE . 'Core\Deactivate', 'deactivate' )
);

// Load the plugin text-domain
load_plugin_textdomain(
	TBI_NAME,
	false,
	dirname( TBI_BASENAME ) . '/language'
);

if ( class_exists( TBI_NAMESPACE . 'App' ) ) {
	( new ( TBI_NAMESPACE . 'App' ) )->run(); // Builds the plugin modules.
}
