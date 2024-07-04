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
	 * Creates a table template as HTML format.
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
}
