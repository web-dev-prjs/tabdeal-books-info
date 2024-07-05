/* jshint esversion:8 */

/*
 |----------------------
 | @since 1.4.0
 |----------------------
 */

jQuery(document).ready(function ($) {
    
    /**
     * Handles liking and disliking of the `book` post-type.
     *
     * @since 1.4.0
     */
    class LikeDislike {
        
        /**
         * The `likes_book` ID attribute of HTML element.
         *
         * @since 1.4.0
         */
        #likeBook;
        
        /**
         * The `likes_count` ID attribute of HTML element.
         *
         * @since 1.4.0
         */
        #likesCount;
        
        /**
         * The `dislikes_book` ID attribute of HTML element.
         *
         * @since 1.4.0
         */
        #dislikeBook
        
        /**
         * The `dislikes_count` ID attribute of HTML element.
         *
         * @since 1.4.0
         */
        #dislikesCount
        
        /**
         * The `likes-dislikes` class attribute of HTML element.
         *
         * @since 1.4.0
         */
        #likesDislikes
        
        /**
         * Initializes requirements.
         *
         * @returns void
         * @since 1.4.0
         */
        constructor() {
            
            this.#likeBook = $("#like_book");
            this.#dislikeBook = $("#dislike_book");
            this.#likesDislikes = $(".likes-dislikes");
            
            this.#addEvent();
        }
        
        /**
         * Adds events over the `like_book` and `dislike_book` IDs.
         *
         * @returns void
         * @since 1.4.0
         */
        #addEvent() {
            
            this.#likeBook.on("click", (e) => {
                
                e.preventDefault();
                
                this.#likesCount = $("#likes_count");
                
                this.#saveBookVote(e.target.id, this.#likesCount.text());
                
                console.log(e.target.id, voteCount);
            });
            
            this.#dislikeBook.on("click", (e) => {
                
                e.preventDefault();
                
                this.#dislikesCount = $("#dislikes_count");
                
                this.#saveBookVote(e.target.id, this.#dislikesCount.text());
            });
        }
        
        /**
         * Saves book vote via AJAX technique.
         *
         * @param {string} voteMode Mode of vote.
         * @param {string} voteCount Count of vote.
         *
         * @return {boolean}
         * @since 1.4.0
         */
        #saveBookVote(voteMode, voteCount) {
            
            let request;
            
            // Abort any pending request
            if (request) {
                request.abort();
            }
            
            request = $.ajax({
                url: tbiSaveBookVote.sbv_ajax_url,
                type: "POST",
                timeout: 5000,
                dataType: "json",
                data: {
                    action: "save_book_vote",
                    sbvNonce: tbiSaveBookVote.sbv_nonce,
                    voteMode: voteMode,
                    voteCount: voteCount,
                    postID: this.#likesDislikes.attr("data-id")
                }
            });
            
            request.then((response, textStatus, jqXHR) => {
                
                ("like_book" === voteMode)
                    ? this.#likesCount.text(response.data.voteValue)
                    : this.#dislikesCount.text(response.data.voteValue);
                
                if (!response.success) {
                    alert(response.data);
                }
                
                console.log({
                    "Response": response,
                    "Status": textStatus,
                });
            });
            
            request.fail((jqXHR, textStatus, errorThrown) => {
                
                console.log({
                    "Error": errorThrown,
                    "Status": textStatus
                });
            });
            
            return false; // Prevents reloading the page.
        }
    }
    
    // Initialize the class.
    new LikeDislike();
});
