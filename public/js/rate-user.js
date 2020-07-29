"use strict";

(function() {
    let ratingButtons = new Map();

    function addButtonRatingEvent() {
        ratingButtons.set(1, document.getElementById("user-rating-1"));
        ratingButtons.set(2, document.getElementById("user-rating-2"));
        ratingButtons.set(3, document.getElementById("user-rating-3"));
        ratingButtons.set(4, document.getElementById("user-rating-4"));
        ratingButtons.set(5, document.getElementById("user-rating-5"));

        ratingButtons.forEach((value, key, map) => {
            let handler = buildRate(key);
            value.addEventListener("click", event => handler(event));
        });
    }

    window.addEventListener("DOMContentLoaded", event => addButtonRatingEvent());

    function buildRate(rating) {
        return async function(event) {
            let payload = new FormData();
            payload.set("rating", rating);
            payload.set("csrf", document.getElementById("csrf-token").value);
            payload.set("rating-user-id", document.getElementById("rating-user-id").value);
            console.log(payload);
            let sendMessageResponse = await fetch("./profile/rateUser", {
                method: "POST",
                body: payload
            });
            console.log(sendMessageResponse);
            console.log(await sendMessageResponse.text());
            if (!sendMessageResponse.ok) return;

            let pageUpdateResponse = await fetch(window.location, {
                method: "GET"
            });
            console.log(pageUpdateResponse);
            if (!pageUpdateResponse.ok) return;
            let pageUpdateText = await pageUpdateResponse.text();
            let parser = new DOMParser();
            let pageUpdateDocument = parser.parseFromString(pageUpdateText, 'text/html');
            console.log(pageUpdateDocument);
            document.getElementById("user-rating").innerHTML
                = pageUpdateDocument.getElementById("user-rating").innerHTML;
            console.log("done");

            addButtonRatingEvent();
        }
    }
})();