"use strict";

// shows all elements that are exclusively working with js

(function() {
    window.addEventListener("DOMContentLoaded", async event => {
        let hiddenElements = document.getElementsByClassName("no-js-hide");
        for (let hiddenElement of hiddenElements) {
            hiddenElement.classList.remove("no-js-hide");
        }

        let showElements = document.getElementsByClassName("no-js-container");
        for (let showElement of showElements) {
            showElement.style.display = "none";
        }

        let allowJSEvent = new Event("jsallowed");
        window.dispatchEvent(allowJSEvent);
    })
})();