"use strict";

(function() {
    let confirmForm = null;
    let confirmContainer = null;
    let confirmDiff = new Map();

    window.addEventListener("load", event => {
        confirmContainer = document
            .getElementById("confirm-changes-container");
        if (confirmContainer === null) return;
        addConfirmEvents(confirmContainer);

        let confirmDiffContainer = document.getElementById("confirm-changes-diff");
        for (let element of confirmDiffContainer.children) {
            if (!(element.dataset.confirmDiff.length > 0)) continue;
            confirmDiff.set(element.dataset.confirmDiff, element);
            element.hidden = true;
        }
    });

    window.addEventListener("submit", event => {
        if (confirmContainer === null) return;
        if (event.target?.dataset?.needsConfirmation !== "") return;
        event.preventDefault();
        confirmForm = event.target;
        confirmContainer.hidden = false;

        for (let element of event.target) {
            let diffElement = confirmDiff.get(element.name);
            if (typeof diffElement === "undefined") continue;
            diffElement.hidden = false;
            if (typeof diffElement.firstChild === "undefined") continue;
            diffElement.children[0].innerHTML = element.value;
            if (diffElement.dataset?.confirmOgValue.trim() === element.value.trim()) {
                diffElement.hidden = true;
            }
        }
    });

    function addConfirmEvents(containerElement) {
        containerElement.addEventListener("click", event => {
            for (let element of event.path) {
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