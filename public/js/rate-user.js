"use strict";

// allow users to rate other users
(function() {
    let ratingButtons = new Map();

    /**
     * Apply for every rating button an event.
     */
    function addButtonRatingEvent() {
        ratingButtons.set(1, document.getElementById("user-rating-1"));
        ratingButtons.set(2, document.getElementById("user-rating-2"));
        ratingButtons.set(3, document.getElementById("user-rating-3"));
        ratingButtons.set(4, document.getElementById("user-rating-4"));
        ratingButtons.set(5, document.getElementById("user-rating-5"));

        ratingButtons.forEach((value, key, map) => {
            let handler = buildRate(key);
            value.addEventListener("click", event => handler());
        });
    }

    // add button event on first load
    window.addEventListener("DOMContentLoaded", event => addButtonRatingEvent());

    /**
     * Builds the rating handler
     * @param {number} rating
     * @returns {function()}
     */
    function buildRate(rating) {
        return async function() {

            let payload = new FormData();
            payload.set("rating", rating.toString());
            payload.set("csrf", document.getElementById("csrf-token").value);
            payload.set("rating-user-id", document.getElementById("rating-user-id").value);

            let sendMessageResponse = await fetch("./profile/rateUser", {
                method: "POST",
                body: payload
            });
            if (!sendMessageResponse.ok) return;

            // after rate was successful update buttons
            let pageUpdateResponse = await fetch(window.location, {
                method: "GET"
            });

            if (!pageUpdateResponse.ok) return;
            let pageUpdateText = await pageUpdateResponse.text();
            let parser = new DOMParser();
            let pageUpdateDocument = parser.parseFromString(pageUpdateText, 'text/html');

            document.getElementById("user-rating").innerHTML
                = pageUpdateDocument.getElementById("user-rating").innerHTML;

            // add button event after the new pages are loaded
            addButtonRatingEvent();
        }
    }
})();