"use strict";

(function() {
    let storageKeyName = "colorScheme";

    function matchDeviceColor(color) {
        return window.matchMedia("(prefers-color-scheme: " + color + ")").matches;
    }

    async function makeLight(setStorage = true) {
        document.body.classList.add("light");
        document.getElementById("light-mode-switch-off").hidden = false;
        document.getElementById("light-mode-switch-on").hidden = true;
        if (setStorage) localStorage.setItem(storageKeyName, "light");
    }
    async function makeDark(setStorage = true) {
        document.body.classList.remove("light");
        document.getElementById("light-mode-switch-off").hidden = true;
        document.getElementById("light-mode-switch-on").hidden = false;
        if (setStorage) localStorage.setItem(storageKeyName, "dark");
    }

    window.addEventListener("DOMContentLoaded", async event => {
        let lightStorage = localStorage.getItem(storageKeyName);

        if (lightStorage === null) {
            if (matchDeviceColor("light")) {
                await makeLight(false);
            }
        }
        else if (lightStorage === "light") {
            await makeLight();
        }

        document.getElementById("light-mode-switch")
            .addEventListener("click", event => lightSwitchButton(event));
    });

    async function lightSwitchButton(event) {
        console.log(localStorage.getItem(storageKeyName));
        let lightStorage = localStorage.getItem(storageKeyName);

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
    }
})();