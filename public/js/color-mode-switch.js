"use strict";

(function() {
    let storageKeyName = "colorScheme"

    /**
     * Check if color is preferred by media query.
     *
     * @param {"dark"|"light"} color
     * @returns {boolean}
     */
    function matchDeviceColor(color) {
        return window.matchMedia("(prefers-color-scheme: " + color + ")").matches;
    }

    /**
     * Activates light mode.
     *
     * @param {boolean} [setStorage=true]
     * @returns {Promise<void>}
     */
    async function makeLight(setStorage = true) {
        document.body.classList.add("light");
        document.body.classList.remove("dark");
        document.getElementById("light-mode-switch-off").hidden = false;
        document.getElementById("light-mode-switch-on").hidden = true;
        if (setStorage) sessionStorage.setItem(storageKeyName, "light");
    }

    /**
     * Activates dark mode.
     *
     * @param {boolean} [setStorage=true]
     * @returns {Promise<void>}
     */
    async function makeDark(setStorage = true) {
        document.body.classList.remove("light");
        document.body.classList.add("dark");
        document.getElementById("light-mode-switch-off").hidden = true;
        document.getElementById("light-mode-switch-on").hidden = false;
        if (setStorage) sessionStorage.setItem(storageKeyName, "dark");
    }

    window.addEventListener("DOMContentLoaded", async event => {
        // using session storage to only change mode in this session
        let lightStorage = sessionStorage.getItem(storageKeyName);

        if (lightStorage === "dark") {
            await makeDark();
        }
        if (lightStorage === "light") {
            await makeLight();
        }

        document.getElementById("light-mode-switch")
            .addEventListener("click", event => lightSwitchButton(event));
    });

    /**
     * Switch between dark and light mode.
     *
     * @param {Event} event
     * @returns {Promise<void>}
     */
    async function lightSwitchButton(event) {
        // using session storage to only change mode in this session
        let lightStorage = sessionStorage.getItem(storageKeyName);

        await (async () => {
            // decide by if storage is set or media query
            if (lightStorage === "light") {
                await makeDark();
                return
            }
            if (lightStorage === "dark") {
                await makeLight();
                return
            }
            if (matchDeviceColor("light")) {
                await makeDark();
                return
            }
            if (matchDeviceColor("dark")) {
                await makeLight();
            }
        })();
    }
})();