"use strict";

// shows all elements that are exclusively working with js

(function() {
    window.addEventListener("DOMContentLoaded", async event => {
        let hiddenElements = document.querySelectorAll(".no-js-hide");
        for (let hiddenElement of hiddenElements) {
            hiddenElement.classList.remove("no-js-hide");
        }

        let allowJSEvent = new Event("jsallowed");
        window.dispatchEvent(allowJSEvent);
    })
})();