"use strict";

(function() {
    window.addEventListener("DOMContentLoaded", event => {
        let button = document.getElementById("load-more-button");
        let form = document.getElementById("load-more-form");
        let offerCount = document.getElementById("offerCount").value;
        let showPage = button.value - 1;

        async function eventHandler(event) {
            event.preventDefault();
            button.innerHTML = "lädt...";

            let url = event.submitter.formAction;
            if (!url.includes("page=")) {
                url += "&page=1";
            }
            url = url.replace(/page=\d+/, "page=" + button.value);
            let pageUpdateResponse = await fetch(url, {
                method: "GET"
            });

            console.log(url);

            if (!pageUpdateResponse.ok) return;
            let pageUpdateText = await pageUpdateResponse.text();
            let parser = new DOMParser();
            let pageUpdateDocument = parser.parseFromString(pageUpdateText, 'text/html');

            let pagination = document.getElementById("pagination");
            document.getElementById("pagination").remove();
            document.getElementById("offers").innerHTML
                += pageUpdateDocument.getElementById("offers").innerHTML;
            let newPagination = document.getElementById("pagination");
            newPagination.innerHTML = pagination.innerHTML;

            button = document.getElementById("load-more-button");
            button.innerHTML = "Mehr laden";
            button.value++;

            form = document.getElementById("load-more-form");
            form.addEventListener("submit",event => eventHandler(event));

            showPage++;
            if (showPage * 30 >= offerCount) {
                document.getElementById("pagination").remove();
            }

        }

        form.addEventListener("submit",event => eventHandler(event));
    });
})();