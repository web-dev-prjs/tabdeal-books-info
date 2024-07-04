<?php

/**
 * Admin dashboard template.
 *
 * @package tabdeal-books-info
 * @since   1.0.0
 */

// Security Note: Blocks direct access to the PHP files.
defined( 'ABSPATH' ) || exit;

use TBI\Core\Factories\CustomTable;
use TBI\Utilities\Component;

/**
 * @since 1.3.0
 */
$books = CustomTable::get_results(
	'SELECT * FROM %i',
	CustomTable::get_table_prefix() . 'books_info'
);

/**
 * Renders a table includes books info based-on `book` post-type.
 *
 * @var array $books An array of books.
 * @since 1.3.0
 */
echo Component::render_books_info( $books );
