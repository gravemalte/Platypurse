"use strict";

(function () {
    window.addEventListener("click", event => {
        if (typeof event.target?.dataset?.togglePassword === "undefined") return;

        let clickElement = event.target;
        let toggleId = clickElement.dataset.togglePassword;
        let toggleElement = document.getElementById(toggleId);

        if (clickElement.checked) {
            toggleElement.type = "text";
            return;
        }
        toggleElement.type = "password";
    });
})();