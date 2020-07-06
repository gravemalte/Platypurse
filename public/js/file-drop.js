"use strict";

(function () {
    document.addEventListener("DOMContentLoaded", event => {
        for (let element of document.getElementsByClassName("drop-files")) {
            element.addEventListener("dragover", event => {
                // prevent dragover actions
                event.preventDefault();
            });
            let drop = buildDrop(element);
            element.addEventListener("drop", event => {
                // prevents default drop behaviour and use custom behaviour
                event.preventDefault();
                drop(event);
            });
        }
    });

    /**
     * Build the drop function.
     *
     * @param elementContainer
     * @returns {function}
     */
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

        /**
         * Insert dropped files into corresponding file input.
         *
         * @param {DragEvent} event
         */
        function drop(event) {
            // check if file is image
            for (let file of event.dataTransfer.files) {
                if (!file.type.startsWith("image")) {
                    show.innerText = "Nur Bilder einfügen";
                    return;
                }
            }

            // apply dropped files to input
            input.files = event.dataTransfer.files;

            // display dropped file names for feedback
            for (let file of event.dataTransfer.files) {
                if (file.type.startsWith("image")) {
                    show.innerText += "\n" + file.name;
                }
            }
        }
        return drop;
    }
})();