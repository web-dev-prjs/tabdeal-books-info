<?php

/**
 * The plugin bootstrap file.
 *
 * @package    tabdeal-books-info
 * @copyright  Copyright (c) 2024, omidhosseini.
 * @wordpress-plugin
 * Plugin Name: Tabdeal Books Info
 * Plugin URI: https://github.com/web-dev-prjs/tabdeal-books-info
 * Description: A sample plugin of books information. (Tabdeal interview)
 * Version: 1.4.2
 * Requires at least: 6.5
 * Requires PHP: 8.2
 * Author: Omid Hosseini
 * Author URI: https://github.com/itsomidho
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://github.com/web-dev-prjs/tabdeal-books-info
 * Text Domain: tabdeal-books-info
 * Domain Path: /i18n/languages/
 */

// Security Note: Blocks direct access to the PHP files.
defined( 'ABSPATH' ) || exit;

/*
 |-----------------------------------------------
 | TBI is abbreviation of Tabdeal Books Info.
 |-----------------------------------------------
 */
const TBI_FILE = __FILE__;

define( 'TBI_URL', plugin_dir_url( TBI_FILE ) );        // Define plugin URL.
define( 'TBI_PATH', plugin_dir_path( TBI_FILE ) );      // Define plugin path folder.
define( 'TBI_BASENAME', plugin_basename( TBI_FILE ) );  // Define plugin basename.

require_once __DIR__ . '/init.php';
