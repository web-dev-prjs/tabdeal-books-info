<?php

/**
 * All plugin components.
 *
 * @package tabdeal-books-info
 */

namespace TBI\Utilities;

/**
 * Component class.
 *
 * @since 1.3.0
 */
final class Component {
	
	/**
	 * Creates a table template in HTML format.
	 *
	 * @param null|array $args An array includes fields data.
	 *
	 * @return string A table as HTML format.
	 * @since 1.3.0
	 */
	public static function render_books_info( null|array $args ): string {
		
		$markup = '<div class="wrap">';
		
		$markup .= '<section id="books_detail_container" class="bg-body m-auto p-3 rounded-3">';
		$markup .= '<table class="table table-striped table-hover table-dark table-group-divider align-middle text-center overflow-auto">';
		$markup .= '<thead>';
		
		$markup .= '<tr>';
		$markup .= '<th scope="col" colspan="4" class="bg-body-secondary text-muted text-center font-semibold fs-5 py-3">';
		$markup .= esc_html__( 'Books Info Table', 'tabdeal-books-info' );
		$markup .= '</th>';
		$markup .= '</tr>';
		
		$markup .= '<tr>';
		$markup .= '<th scope="col">#</th>';
		$markup .= '<th scope="col">';
		$markup .= esc_html__( 'ISBN', 'tabdeal-books-info' );
		$markup .= '</th>';
		$markup .= '<th scope="col">';
		$markup .= esc_html__( 'Post ID', 'tabdeal-books-info' );
		$markup .= '</th>';
		$markup .= '<th scope="col"></th>';
		$markup .= '</tr>';
		
		$markup .= ' </thead>';
		$markup .= '<tbody class="table-group-divider">';
		
		if ( is_array( $args ) ):
			
			$counter = 1;
			while ( sizeof( $args ) ) :
				$book = array_shift( $args );
				
				$markup .= '<tr>';
				$markup .= '<th scope="row">' . $counter . '</th>';
				$markup .= '<td>' . $book->ISBN . '</td>';
				$markup .= '<td>' . $book->post_id . '</td>';
				$markup .= '<td>';
				
				$markup .= '<button type="button" class="btn btn-outline-info more-detail-btn"';
				$markup .= ' data-id="' . $book->ISBN . '" data-bs-toggle="modal" data-bs-target="#bookDetailModal">';
				$markup .= esc_html__( 'More Details', 'tabdeal-books-info' );
				$markup .= '</button>';
				
				$markup .= '</td>';
				$markup .= '</tr>';
				
				$counter ++;
			endwhile;
		
		endif;
		
		$markup .= '</tbody>';
		$markup .= '</table>';
		$markup .= '</section>';
		
		// Modal
		$markup .= '<div class="modal fade modal-dialog modal-dialog-centered modal-dialog-scrollable"';
		$markup .= ' id="bookDetailModal" tabindex="-1" aria-labelledby="bookDetailModalLabel" aria-hidden="true">';
		$markup .= '<div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-semibold" id="bookDetailModalLabel">Book Details</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>';
		$markup .= '</div>';
		
		$markup .= '</div>';
		$markup .= '</div>';
		
		return $markup;
	}
	
	/**
	 * Creates a book-vote template in HTML format.
	 *
	 * @param int $post_id The post identification.
	 *
	 * @return string A template in the HTML format.
	 * @since 1.4.0
	 */
	public static function render_book_vote( int $post_id ): string {
		
		if ( ! is_singular( 'book' ) ) {
			return '';
		}
		
		$_likes_count    = get_post_meta( $post_id, '_likes_count', true );
		$_dislikes_count = get_post_meta( $post_id, '_dislikes_count', true );
		
		ob_start();
		
		$markup = '<hr />';
		$markup .= '<div class="tbi__likes-dislikes" data-id="' . $post_id . '">';
		$markup .= '<p class="tbi__likes-dislikes__title">';
		$markup .= esc_html__( 'Like this book?', 'tabdeal-books-info' );
		$markup .= '</p>';
		$markup .= '<ul class="tbi__likes-dislikes__box">';
		$markup .= '<li class="tbi__likes-dislikes__item">';
		$markup .= '<a id="tbi__like_book" href="#"></a>';
		$markup .= '<span id="tbi__likes_count">';
		$markup .= $_likes_count ? : 0;
		$markup .= '</span>';
		$markup .= '</li>';
		$markup .= '<li class="tbi__likes-dislikes__item">';
		$markup .= '<a id="tbi__dislike_book" href="#"></a>';
		$markup .= '<span id="tbi__dislikes_count">';
		$markup .= $_dislikes_count ? : 0;
		$markup .= '</span>';
		$markup .= '</li>';
		$markup .= '</ul>';
		$markup .= '</div>';
		
		echo $markup;
		
		return ob_get_clean();
	}
	
	/**
	 * Creates a book-like template in HTML format.
	 *
	 * @param int $post_id The post identification.
	 *
	 * @return string A template in the HTML format.
	 * @since 1.4.1
	 */
	public static function render_book_like( int $post_id ): string {
		
		$post_likes = '';
		
		if ( ! is_singular( 'book' ) ) {
			return $post_likes;
		}
		
		$likes_count = get_post_meta( $post_id, '_likes_count', true );
		
		$post_likes .= '<div class="tbi__book-likes">&nbsp;--&nbsp;';
		$post_likes .= '<div class="tbi__book-likes__box">';
		$post_likes .= '<span class="tbi__book-likes__title">';
		$post_likes .= __( 'Likes:', 'tabdeal-books-info' );
		$post_likes .= '</span>';
		$post_likes .= '<span class="tbi__book_likes__count">';
		$post_likes .= $likes_count ? : 0;
		$post_likes .= '</span>';
		$post_likes .= '</div></div>';
		
		return $post_likes;
	}
}
