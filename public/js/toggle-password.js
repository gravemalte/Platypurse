"use strict";

(function () {
    window.addEventListener("DOMContentLoaded", async event => {
        let toggles = document.querySelectorAll("[data-toggle-password]");
        for (let toggle of toggles) {
            let toggleFunction = createToggle(toggle);
            toggle.addEventListener("click", async event => (await toggleFunction)(event));
        }
    });

    async function createToggle(clickElement) {
        let toggleId = clickElement.dataset.togglePassword;
        let toggleElement = document.getElementById(toggleId);

        function toggle(event) {
            if (clickElement.checked) {
                toggleElement.type = "text";
                return;
            }
            toggleElement.type = "password";
        }

        return toggle;
    }
})();