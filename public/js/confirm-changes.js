"use strict";

(function() {
    // closure wide variables
    let confirmForm = null;
    let confirmContainer = null;
    let confirmDiff = new Map();

    window.addEventListener("DOMContentLoaded", async event => {
        // get confirm container and activate confirm and cancel buttons
        confirmContainer = document.getElementById("confirm-changes-container");
        if (confirmContainer === null) return;
        addConfirmEvents(confirmContainer);

        // load all potential diffs
        let confirmDiffContainer = document.getElementById("confirm-changes-diff");
        for (let element of confirmDiffContainer.children) {
            if (!(element.dataset.confirmDiff.length > 0)) continue;
            confirmDiff.set(element.dataset.confirmDiff, element);
            element.hidden = true;
        }
    });

    window.addEventListener("submit", async event => {
        // deny submit to get second confirm
        if (confirmContainer === null) return;
        if (event.target?.dataset?.needsConfirmation !== "") return;
        event.preventDefault();
        confirmForm = event.target;
        confirmContainer.hidden = false;

        // check for changes to display them
        for (let element of event.target) {
            let diffElement = confirmDiff.get(element.name);
            if (typeof diffElement === "undefined") continue;
            diffElement.hidden = false;
            if (typeof diffElement.firstChild === "undefined") continue;
            for (let child of diffElement.children) {
                if (child.dataset.confirmNew !== "") continue;
                child.innerHTML = element.value;
                if (element.type === "file") {
                    let fileNames = [];
                    for (let file of element.files) {
                        fileNames.push(file.name);
                    }
                    child.innerHTML = fileNames.join(", ");
                }
            }
            if (diffElement.dataset?.confirmOgValue.trim() === element.value.trim()) {
                diffElement.hidden = true;
            }
        }
    });

    /**
     * Allow confirm and cancel buttons to work.
     *
     * @param {HTMLElement} containerElement
     */
    function addConfirmEvents(containerElement) {
        containerElement.addEventListener("click", event => {
            for (let element of event.composedPath()) {
                if (element.tagName === "BUTTON") {
                    switch (element.dataset.confirm) {
                        case "confirm":
                            confirmForm.submit();
                            break;
                        case "cancel":
                            confirmContainer.hidden = true;
                            break;
                    }
                    break;
                }
            }
        });
    }
})();