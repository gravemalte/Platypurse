"use strict";

(function() {
    let storageKeyName = "colorScheme"

    function matchDeviceColor(color) {
        return window.matchMedia("(prefers-color-scheme: " + color + ")").matches;
    }

    async function makeLight(setStorage = true) {
        document.body.classList.add("light");
        document.body.classList.remove("dark");
        document.getElementById("light-mode-switch-off").hidden = false;
        document.getElementById("light-mode-switch-on").hidden = true;
        if (setStorage) sessionStorage.setItem(storageKeyName, "light");
    }
    async function makeDark(setStorage = true) {
        document.body.classList.remove("light");
        document.body.classList.add("dark");
        document.getElementById("light-mode-switch-off").hidden = true;
        document.getElementById("light-mode-switch-on").hidden = false;
        if (setStorage) sessionStorage.setItem(storageKeyName, "dark");
    }

    window.addEventListener("DOMContentLoaded", async event => {
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

    async function lightSwitchButton(event) {
        let lightStorage = sessionStorage.getItem(storageKeyName);

        await (async () => {
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

        await setTimeout(() => document.body.classList.remove("transition"), 600);
    }
})();