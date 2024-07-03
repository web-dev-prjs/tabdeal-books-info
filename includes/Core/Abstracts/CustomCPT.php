<?php

/**
 * Registers and creates a custom post-type.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core\Abstracts;

use TBI\Core\Factories\CustomMetaBox;
use TBI\Core\Factories\CustomTaxonomy;

/**
 * CustomCPT abstract Class.
 *
 * @since 1.2.0
 */
abstract class CustomCPT {
	
	/**
	 * Name of custom post-type.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $post_type;
	
	/**
	 * All custom post-type arguments.
	 *
	 * @var array
	 * @since 1.2.0
	 */
	private array $args = array();
	
	/**
	 * Defines custom post-type data.
	 *
	 * @var array
	 * @since 1.2.0
	 */
	protected array $cpt_data = array();
	
	/**
	 * All meta-boxes arguments.
	 *
	 * @var array
	 * @since 1.2.0
	 */
	protected array $meta_boxes_data = array();
	
	/**
	 * Creates a custom-post-type based-on entry data.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	public function build(): void {
		
		$this->set_arguments()->register();
		
		if ( sizeof( $this->meta_boxes_data ) ) {
			$this->add_custom_meta_boxes();
		}
	}
	
	/**
	 * Registers a custom-post-type and then hooks it to `init`.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	private function register(): void {
		
		add_action( 'init', function () {
			
			/**
			 * Registers taxonomy for a custom post-type.
			 *
			 * @var string|array $cpt_args  Array or string of arguments for registering a custom post-type.
			 * @var string       $post_type Custom post-type name.
			 * @since 1.2.0
			 */
			register_post_type( $this->post_type, $this->args );
		}, 10, 2 );
	}
	
	/**
	 * Sets all parameters into array for creating a custom-post-type.
	 *
	 * @return CustomCPT
	 * @since 1.2.0
	 */
	private function set_arguments(): CustomCPT {
		
		$lower_popular_name  = strtolower( $this->cpt_data['popular_name'] );
		$lower_singular_name = strtolower( $this->cpt_data['singular_name'] );
		
		$this->post_type  = $lower_singular_name;
		$uc_popular_name  = ucfirst( $lower_popular_name );
		$us_singular_name = ucfirst( $lower_singular_name );
		
		$labels = array(
			'name'               => __( $uc_popular_name, 'tabdeal-books-info' ),
			'singular_name'      => __( $us_singular_name, 'tabdeal-books-info' ),
			'all_items'          => _x( "All $uc_popular_name", 'Post Type General Name', 'tabdeal-books-info' ),
			'add_new'            => _x( "Add New $us_singular_name", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'add_new_item'       => _x( "Add New $us_singular_name", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'edit_item'          => _x( "Edit $us_singular_name", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'new_item'           => _x( "New $us_singular_name", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'view_item'          => _x( "View $us_singular_name", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'search_items'       => _x( "Search $us_singular_name", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'not_found'          => _x( "No $us_singular_name found", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'not_found_in_trash' => _x( "No $us_singular_name found in Trash", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'parent_item_colon'  => _x( "Parent $us_singular_name:", 'Post Type Singular Name', 'tabdeal-books-info' ),
			'menu_name'          => __( $uc_popular_name, 'tabdeal-books-info' ),
			'name_admin_bar'     => __( $us_singular_name, 'tabdeal-books-info' ),
			'attributes'         => _x( "$uc_popular_name attributes", 'Post Type General Name', 'tabdeal-books-info' ),
		);
		
		$this->args = array(
			'supports'            => $this->cpt_data['supports'],
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => _x( "Add $uc_popular_name Section", 'Post Type General Name', 'tabdeal-books-info' ),
			'show_ui'             => $this->cpt_data['show_ui'],
			'show_in_menu'        => $this->cpt_data['show_in_menu'],
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => $this->cpt_data['position'],
			'menu_icon'           => $this->cpt_data['icon'],
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'can_export'          => true,
			'public'              => true,
			'has_archive'         => false,
			'capability_type'     => $this->cpt_data['capability_type'],
			'query_var'           => true,
			'show_in_rest'        => $this->cpt_data['show_in_rest'],
			'rest_base'           => $this->post_type,
			'rewrite'             => array( 'slug' => $lower_popular_name ),
			'taxonomies'          => array( '' ),
		);
		
		if ( sizeof( $this->cpt_data['taxonomies'] ) ) {
			foreach ( $this->cpt_data['taxonomies'] as $taxonomy_name ) {
				( new CustomTaxonomy )->create(
					$this->post_type,
					$taxonomy_name
				);
			}
		}
		
		return $this;
	}
	
	/**
	 * Registers custom meta-boxes for the custom post-type.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	private function add_custom_meta_boxes(): void {
		
		foreach ( $this->meta_boxes_data as $meta_box_data ) {
			$custom_meta_box = new CustomMetaBox();
			
			$custom_meta_box->create(
				array(
					'name'         => $meta_box_data['name'],
					'title'        => $meta_box_data['title'],
					'context'      => $meta_box_data['context'],
					'priority'     => $meta_box_data['priority'],
					'placeholder'  => $meta_box_data['placeholder'],
					'store_table'  => $meta_box_data['store_table'],
					'table_column' => $meta_box_data['table_column']
				)
			);
		}
	}
}
