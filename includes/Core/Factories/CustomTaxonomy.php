<?php

/**
 * Registers and creates a custom taxonomy.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core\Factories;

use WP_Post;

/**
 * CustomTaxonomy Class.
 *
 * @since 1.2.0
 */
final class CustomTaxonomy {
	
	/**
	 * Name of custom post-type.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $post_type;
	
	/**
	 * Name of custom taxonomy.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $taxonomy_name;
	
	/**
	 * All arguments.
	 *
	 * @var array
	 * @since 1.2.0
	 */
	private array $taxonomy_args = array();
	
	/**
	 * Creates a custom taxonomy based-on entry data.
	 *
	 * @param string $post_type     Custom post-type name.
	 * @param string $taxonomy_name Custom taxonomy name.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	public function create( string $post_type, string $taxonomy_name ): void {
		
		$this->post_type     = $post_type;
		$this->taxonomy_name = strtolower( $taxonomy_name );
		
		$this->set_arguments()->register();
		$this->custom_post_type_link_taxonomy();
	}
	
	/**
	 * Registers a custom taxonomy and then hooks it to `init` action.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	private function register(): void {
		
		add_action( 'init', function () {
			
			/**
			 * Registers taxonomy for a custom post-type.
			 *
			 * @var string       $taxonomy      Taxonomy key.
			 * @var string|array $object_type   Object type or array of object types with which the taxonomy should be associated.
			 * @var string|array $taxonomy_args Array or query string of arguments for registering a taxonomy.
			 * @since 1.2.0
			 */
			register_taxonomy(
				$this->post_type . '_' . $this->taxonomy_name,
				$this->post_type,
				$this->taxonomy_args,
			);
		}, 10, 0 );
	}
	
	/**
	 * Sets all parameters into array for creating a custom-post-type.
	 *
	 * @return CustomTaxonomy
	 * @since 1.2.0
	 */
	private function set_arguments(): CustomTaxonomy {
		
		$singular_name = 'singular';
		$popular_name  = ucfirst( $this->taxonomy_name );
		
		if ( $this->taxonomy_name === 'publishers' || $this->taxonomy_name === 'authors' ) {
			$singular_name = str_replace( 's', '', $popular_name );
		}
		
		$this->taxonomy_args = array(
			'labels'                => array(
				'name'              => _x( $popular_name, 'taxonomy general name', 'tabdeal-books-info' ),
				'singular_name'     => _x( $singular_name, 'taxonomy singular name', 'tabdeal-books-info' ),
				'menu_name'         => __( $popular_name, 'tabdeal-books-info' ),
				'all_items'         => __( 'All ' . $singular_name, 'tabdeal-books-info' ),
				'edit_item'         => __( 'Edit ' . $singular_name, 'tabdeal-books-info' ),
				'view_item'         => __( 'View ' . $singular_name, 'tabdeal-books-info' ),
				'update_item'       => __( 'Update ' . $singular_name, 'tabdeal-books-info' ),
				'add_new_item'      => __( 'Add New ' . $singular_name, 'tabdeal-books-info' ),
				'new_item_name'     => __( 'New ' . $singular_name . ' Name', 'tabdeal-books-info' ),
				'parent_item'       => __( 'Parent ' . $singular_name, 'tabdeal-books-info' ),
				'parent_item_colon' => __( 'Parent ' . $singular_name, 'tabdeal-books-info' ),
				'search_items'      => __( 'Search ' . $singular_name, 'tabdeal-books-info' ),
				'back_to_items'     => __( '← Back to ' . $popular_name, 'tabdeal-books-info' ),
				'not_found'         => __( 'No ' . $popular_name . ' tags found.', 'tabdeal-books-info' ),
			),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'update_count_callback' => '_update_post_term_count',
			'rewrite'               => array(
				'slug'       => $this->taxonomy_name,
				'with_front' => false,
			),
		);
		
		return $this;
	}
	
	/**
	 * Links custom taxonomies to custom post-type and then hooks it to `post_type_link` filter.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	private function custom_post_type_link_taxonomy(): void {
		
		/**
		 * Links taxonomy to custom post-type.
		 *
		 * @var string  $post_link The post's permalink.
		 * @var WP_Post $post      The post in question.
		 * @since 1.2.0
		 */
		add_filter(
			'post_type_link',
			function ( string $post_link, WP_Post $post ) {
				
				
				$taxonomy_type = $this->post_type . '_' . $this->taxonomy_name;
				$taxonomy      = get_the_terms( $post->ID, $taxonomy_type );
				
				if ( $post->post_type !== $this->post_type ) {
					return $post_link;
				}
				
				if ( $taxonomy ) {
					$post_link = str_replace(
						'%' . $this->post_type . '_' . $this->taxonomy_name . '%',
						array_pop( $taxonomy )->slug,
						$post_link
					);
				}
				
				return $post_link;
			},
			10,
			2
		);
	}
}
