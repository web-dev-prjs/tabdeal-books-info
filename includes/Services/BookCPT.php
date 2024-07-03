<?php

/**
 * Creates a new custom post-type as `book`, and adds a custom meta-box as `ISBN` to it.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Services;

use TBI\Core\Abstracts\CustomCPT;

/**
 * BookCPT class.
 *
 * @since 1.2.0
 */
final class BookCPT extends CustomCPT {
	
	protected array $cpt_data = array(
		'popular_name'    => 'Books',
		'singular_name'   => 'Book',
		'position'        => 21,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'show_in_rest'    => true,
		'taxonomies'      => array(
			'publishers',
			'authors'
		),
		'supports'        => array(
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
			'comments',
			'revisions',
			'custom-fields'
		),
		'icon'            => 'dashicons-book',
		'capability_type' => 'post'
	);
	
	protected array $meta_boxes_data = array(
		// Adds the `ISBN` meta-box to the `book` post-type.
		array(
			'name'         => 'isbn_field',
			'title'        => 'ISBN of Book',
			'context'      => 'side',
			'priority'     => 'default',
			'placeholder'  => 'Enter ISBN number',
			'store_table'  => 'books_info',
			'table_column' => 'ISBN',
		)
	);
}
