<?php

/**
 * Registers and creates a custom meta-box.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Core\Factories;

use WP_Post;

/**
 * CustomMetaBox Class.
 *
 * @since 1.2.0
 */
class CustomMetaBox {
	
	/**
	 * Name of custom meta-box.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_name;
	
	/**
	 * Title of custom meta-box.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_title;
	
	/**
	 * The context within the screen where the box should display.
	 * Post edit screen contexts include 'normal', 'side', and 'advanced'. Default:'advanced'.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_context;
	
	/**
	 * The priority within the context where the box should show.
	 * Accepts 'high', 'core', 'default', or 'low'. Default 'default'.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_priority;
	
	/**
	 * Custom meta-box nonce name.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_nonce;
	
	/**
	 * Custom meta-box action name.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_action;
	
	/**
	 * Placeholder for input tag.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_placeholder;
	
	/**
	 * Name of store table in database.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_store_table;
	
	/**
	 * Name of column table in database.
	 *
	 * @var string
	 * @since 1.2.0
	 */
	private string $meta_box_table_column;
	
	/**
	 * Creates custom meta-box based-on entry data.
	 *
	 * @param array $meta_box_args An array of custom meta-box arguments.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	public function create( array $meta_box_args ): void {
		
		// Initial meta box variables.
		$this->meta_box_name         = $meta_box_args['name'];
		$this->meta_box_title        = $meta_box_args['title'];
		$this->meta_box_context      = $meta_box_args['context'];
		$this->meta_box_priority     = $meta_box_args['priority'];
		$this->meta_box_placeholder  = $meta_box_args['placeholder'];
		$this->meta_box_store_table  = $meta_box_args['store_table'];
		$this->meta_box_table_column = $meta_box_args['table_column'];
		
		// Initials meta box NONCE and ACTION
		$this->meta_box_nonce  = "_custom_meta_box_nonce_$this->meta_box_name";
		$this->meta_box_action = "_custom_meta_box_action_$this->meta_box_name";
		
		$this->register();
	}
	
	/**
	 * Registers a custom taxonomy and then hooks it to `init`.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	private function register(): void {
		
		/**
		 * Adds the meta box container.
		 *
		 * @since 1.2.0
		 */
		add_action( 'add_meta_boxes',
			/**
			 * @var string $post_type Post type.
			 * @since 1.2.0
			 */
			function ( string $post_type ) {
				
				add_meta_box(
					$this->meta_box_name,
					$this->meta_box_title,
					array( $this, 'render_custom_meta_box' ),
					$post_type,
					$this->meta_box_context,
					$this->meta_box_priority,
				);
			}, 10, 2 );
		
		/**
		 * Save the meta when the post is saved.
		 *
		 * @since 1.2.0
		 */
		add_action( 'save_post',
			
			/**
			 * @var int $post_id The ID of the post being saved.
			 * @since 1.2.0
			 */
			function ( int $post_id, WP_Post $post ) {
				
				/*
				 * Check if nonce is set and verify that the nonce is valid.
				 */
				if (
					! isset( $_POST[ $this->meta_box_nonce ] ) ||
					! wp_verify_nonce( $_POST[ $this->meta_box_nonce ], $this->meta_box_action ) ) {
					return;
				}
				
				/*
				 * If this is an autosave, our form has not been submitted,
				 * so we don't want to do anything.
				 */
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
					return;
				}
				
				/*
				 * Check the user's permission.
				 */
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
				
				$meta_box_value      = $this->get_meta_field_value( $post_id );
				$sanitize_meta_field = sanitize_text_field( $_POST[ $this->meta_box_name ] );
				
				if ( is_null( $meta_box_value ) ) {
					CustomTable::insert_row(
						$this->meta_box_store_table,
						array(
							'post_id'                    => $post_id,
							$this->meta_box_table_column => $sanitize_meta_field
						)
					);
				}
				
				if ( ! is_null( $meta_box_value ) && $meta_box_value !== $sanitize_meta_field ) {
					CustomTable::update_row(
						$this->meta_box_store_table,
						array(
							$this->meta_box_table_column => $sanitize_meta_field
						),
						array(
							'post_id' => $post_id,
						)
					);
				}
			}, 10, 2 );
	}
	
	/**
	 * Retrieves the meta field value via post ID.
	 *
	 * @param int $post_id Identify of the post.
	 *
	 * @return null|string The specify table column value, otherwise nothing.
	 * @since 1.2.0
	 */
	private function get_meta_field_value( int $post_id ): null|string {
		
		return CustomTable::get_var(
			'SELECT ' .
			$this->meta_box_table_column .
			' FROM ' .
			CustomTable::get_table_prefix() .
			$this->meta_box_store_table .
			' WHERE post_id=%d',
			$post_id
		);
	}
	
	/**
	 * Render meta-box content.
	 *
	 * @param WP_Post $post The post object.
	 *
	 * @return void
	 * @since 1.2.0
	 */
	public function render_custom_meta_box( WP_Post $post ): void {
		
		// Adds a nonce field to check for it later.
		wp_nonce_field( $this->meta_box_action, $this->meta_box_nonce );
		
		// Retrieves an existing value from the database.
		$meta_box_value = $this->get_meta_field_value( $post->ID );
		
		$markup = '<div class="' . TBI_PREFIX . '"-"' . $this->meta_box_name . '">';
		$markup .= '<label for="' . esc_attr( $this->meta_box_name ) . '">';
		$markup .= '</label>';
		$markup .= '<input type="text"';
		$markup .= ' name="' . esc_attr( $this->meta_box_name );
		$markup .= '" id="' . esc_attr( $this->meta_box_name );
		$markup .= '" placeholder="' . esc_attr( $this->meta_box_placeholder ) . '" ';
		$markup .= '" value="' . esc_attr( $meta_box_value );
		$markup .= '" />';
		$markup .= '</div>';
		
		echo $markup;
	}
}
