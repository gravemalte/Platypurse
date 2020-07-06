"use strict";

(function () {
    function mapInit() {
        let coordinates = [52.89192, 8.42608999999993];

        let map = L.map('map').setView(coordinates, 13);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: 'Kartendaten &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Mitwirkende',
            maxZoom: 18,
            tileSize: 256,
            useCache: true
        }).addTo(map);

        L.marker(coordinates).addTo(map);
    }

    window.addEventListener("load", event => {
        mapInit();
    });
})();