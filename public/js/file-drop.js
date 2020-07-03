"use strict";

(function () {
    document.addEventListener("DOMContentLoaded", event => {
        for (let element of document.getElementsByClassName("drop-files")) {
            element.addEventListener("dragover", event => {
                event.preventDefault();
            });
            let drop = buildDrop(element);
            element.addEventListener("drop", event => {
                event.preventDefault();
                drop(event);
            });
        }
    });

    function buildDrop(elementContainer) {
        let input;
        for (let element of elementContainer.children) {
            if (element.type === "file") {
                input = element;
                break;
            }
        }
        let show = elementContainer.getElementsByClassName("drop-files-show")[0];
        show.innerText = "";
        function drop(event) {
            for (let file of event.dataTransfer.files) {
                if (!file.type.startsWith("image")) {
                    show.innerText = "Nur Bilder einfügen";
                    return;
                }
            }
            input.files = event.dataTransfer.files;
            for (let file of event.dataTransfer.files) {
                if (file.type.startsWith("image")) {
                    show.innerText += "\n" + file.name;
                }
            }
        }
        return drop;
    }
})();