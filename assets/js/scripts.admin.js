/* jshint esversion:8 */

/*
 |----------------------
 | @since 1.0.0
 |----------------------
 */

jQuery(document).ready(function ($) {
    
    /**
     * Handles all functionality to fetch book detail.
     *
     * @since 1.3.0
     */
    class BookDetail {
        
        /**
         * The `modal-body` class-attribute of HTML element.
         *
         * @since 1.3.0
         */
        #modalBody;
        
        /**
         * The `more-detail-btn` class-attribute of HTML elements.
         *
         * @since 1.3.0
         */
        #moreDetailBtn;
        
        /**
         * Initializes requirements.
         *
         * @returns void
         * @since 1.3.0
         */
        constructor() {
            
            this.#modalBody = $(".modal-body");
            this.#moreDetailBtn = $(".more-detail-btn");
            
            this.#addEvenet();
        }
        
        /**
         * Adds the click-event to the each `more-deatil` button.
         *
         * @returns void
         * @since 1.3.0
         */
        #addEvenet() {
            
            this.#moreDetailBtn.on("click", (e) => {
                
                e.preventDefault();
                
                let isbnCode = $(e.target).attr("data-id");
                
                this.#modalBody.html(
                    this.#loadingTemplate()
                );
                
                this.#handleResponse(isbnCode);
            })
        }
        
        /**
         * Invokes the fetch-API, and renders the response.
         *
         * @param {string} isbnCode Book ISBN code.
         *
         * @returns void
         * @since 1.3.0
         */
        #handleResponse(isbnCode) {
            
            this.#fetchMoreDetails(
                `http://openlibrary.org/api/books?bibkeys=ISBN:${isbnCode}&jscmd=data&format=json`
            ).then(data => {
                
                const details = Object.values(data)[0];
                
                this.#modalBody.empty().html(
                    this.#responseTemplate(
                        details.title,
                        details.authors[0].name
                    )
                );
            }).catch(error => {
                
                console.error("Error: ", error);
            });
        }
        
        /**
         * Retrieves response of request for a book based-on ISBN code.
         *
         * @param {string} url A URL of API endpoint.
         *
         * @returns {Promise} A promise object as response.
         * @since 1.3.0
         */
        async #fetchMoreDetails(url) {
            
            let response, obj;
            
            response = await fetch(url, {
                method: "GET",
                headers: {
                    "Accept": "application/json",
                }
            });
            
            obj = await response.json();
            
            return obj;
        }
        
        /**
         * Renders an HTML format to demonstrates book title and authors.
         *
         * @param title
         * @param authors
         *
         * @returns {(*|jQuery)[]}
         * @since 1.3.0
         */
        #responseTemplate(title, authors) {
            
            return [
                $("<div>", {class: "d-flex justify-content-start align-items-baseline gap-2 bg-success-subtle p-2 my-2"})
                    .append([
                        $("<p>", {class: "fs-5 fw-medium"}).text("Title:"),
                        $("<p>", {class: "text-muted fs-6 fw-normal p-1 word-wrap-break-word"}).text(title),
                    ]),
                $("<div>", {class: "d-flex justify-content-start align-items-baseline gap-2 bg-success-subtle p-2 my-2"})
                    .append([
                        $("<p>", {class: "fs-5 fw-medium"}).text("Authors:"),
                        $("<p>", {class: "text-muted fs-6 fw-normal p-1 word-wrap-break-word"}).text(authors)
                    ]),
            ];
        }
        
        /**
         * Renders a spinner.
         *
         * @returns {(*|jQuery)[]}
         * @since 1.3.0
         */
        #loadingTemplate() {
            
            return [
                $("<div>", {class: "d-flex justify-content-center"})
                    .append([
                        $("<div>", {class: "spinner-grow text-success"})
                            .attr({
                                "role": "status",
                                "style": "width: 3rem; height: 3rem;",
                            })
                            .append([
                                $("<span>", {class: "visually-hidden"})
                                    .text("Loading...")
                            ])
                    ])
            ];
        }
    }
    
    // Invokes the class.
    new BookDetail();
});
