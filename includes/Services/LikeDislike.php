<?php

/**
 * Handles liking and unliking for the `book` post-type.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Services;

use TBI\Utilities\Component;

/**
 * LikeUnlike class.
 *
 * @since 1.4.0
 */
final class LikeDislike {
	
	/**
	 * Builds actions of this class in while the plugin will activate.
	 *
	 * @return void
	 * @since 1.4.0
	 */
	public function build(): void {
		
		$this->register();
	}
	
	/**
	 * Registers a book-vote and a book-like in HTML format.
	 *
	 * @return void
	 * @since 1.4.0
	 */
	private function register(): void {
		
		/**
		 * @since 1.4.1
		 */
		add_filter(
			'render_block_core/post-author-name',
			
			/**
			 * Adds the book-likes HTML format in the below title via `render_block_{block-name}` hook filter.
			 *
			 * @param string $block_content The post author-name block.
			 *
			 * @return string The post author-name block along with likes count of book.
			 * @see   wp-includes/class-wp-block.php in line number 525.
			 * @since 1.4.1
			 */
			function ( string $block_content ): string {
				
				return $this->book_like_html( $block_content );
			}
		);
		
		/**
		 * @since 1.4.0
		 */
		add_filter(
			'the_content',
			
			/**
			 * Adds the book-vote HTML format to the `the-content` hook filter.
			 *
			 * @param string $content The post content.
			 *
			 * @return string The Content.
			 * @since 1.4.0
			 */
			function ( string $content ): string {
				
				return $this->book_vote_html( $content );
			}
		);
		
		/*
		 |---------------------------------------
		 | AJAX functionality to save book vote.
		 |---------------------------------------
		 */
		
		/**
		 * @since 1.4.0
		 */
		add_action(
			'wp_enqueue_scripts',
			
			/**
			 * Localizes custom path for saving book votes via AJAX technique.
			 *
			 * @return void
			 * @since 1.4.0
			 */
			function () {
				
				if ( ! is_singular( 'book' ) ) {
					return;
				}
				
				wp_localize_script(
					TBI_PREFIX . '-wp-scripts',
					TBI_PREFIX . 'SaveBookVote',
					array(
						'sbv_nonce'    => wp_create_nonce( 'save_book_vote' ),
						'sbv_ajax_url' => admin_url( 'admin-ajax.php?action=save_book_vote' )
					)
				);
			}
		);
		
		foreach ( array( 'wp_ajax_save_book_vote', 'wp_ajax_nopriv_save_book_vote' ) as $action ) {
			/**
			 * @since 1.4.0
			 */
			add_action(
				$action,
				
				/**
				 * Adds the functionality to the `wp_ajax` and `wp_ajax_nopriv` hook action.
				 *
				 * @return void
				 * @since 1.4.0
				 */
				function () {
					
					$this->save_book_vote();
				}
			);
		}
	}
	
	/**
	 * Adds the book-like markup in HTML format to the `book` post-types.
	 *
	 * @param string $block_content The post author-name block.
	 *
	 * @return string The post author-name block along with likes count of book.
	 * @since 1.4.1
	 */
	private function book_like_html( string $block_content ): string {
		
		return $block_content . Component::render_book_like( get_the_ID() );
	}
	
	/**
	 * Adds the book-vote markup in HTML format to the `book` post-types.
	 *
	 * @param string $content The post content.
	 *
	 * @return string The book-vote HTML format.
	 * @since 1.4.0
	 */
	private function book_vote_html( string $content ): string {
		
		return $content . Component::render_book_vote( get_the_ID() );
	}
	
	/**
	 * Saves the book votes via AJAX technique.
	 *
	 * @return void
	 * @since 1.4.0
	 */
	private function save_book_vote(): void {
		
		check_ajax_referer( 'save_book_vote', 'sbvNonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error(
				'Please log in to like this book.',
				'not_logged_in',
				false
			);
		}
		
		$post_id    = $_POST['postID'];
		$vote_count = (int) $_POST["voteCount"];
		
		preg_match( '/like|dislike/', $_POST["voteMode"], $vote_mode );
		
		$user_id       = get_current_user_id();
		$user_vote_key = "_post-{$post_id}_voted";
		
		$vote_key = ( 'like' === $vote_mode[0] ) ? '_likes_count' : '_dislikes_count';
		
		$prev_vote_count  = get_post_meta( $post_id, $vote_key, true );
		$user_voted_value = get_user_meta( $user_id, $user_vote_key, true );
		
		if ( $user_voted_value ) {
			if ( $vote_mode[0] !== $user_voted_value ) {
				wp_send_json_error(
					'You have already voted this book.',
					'already_voted',
					false
				);
			}
			
			$vote_value = empty( $prev_vote_count )
				? ( $vote_count - 1 ) : ( $prev_vote_count - 1 );
			
			$vote_status = delete_user_meta( $user_id, $user_vote_key );
		} else {
			$vote_value = empty( $prev_vote_count )
				? ( $vote_count + 1 ) : ( $prev_vote_count + 1 );
			
			$vote_status = add_user_meta(
				$user_id,
				$user_vote_key,
				$vote_mode[0]
			);
		}
		
		update_post_meta( $post_id, $vote_key, $vote_value );
		
		wp_send_json_success(
			array(
				'postID'    => $post_id,
				'voteValue' => $vote_value,
			),
			$vote_key,
			$vote_status
		);
	}
}
