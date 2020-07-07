"use strict";

(function () {
    function mapInit() {
        let lat = document.getElementById("map-lat").value;
        let lon = document.getElementById("map-lon").value;

        let coordinates = [lat, lon];

        let map = L.map('map').setView(coordinates, 11);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: 'Kartendaten &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Mitwirkende',
            maxZoom: 18,
            tileSize: 256
        }).addTo(map);

        L.marker(coordinates).addTo(map);
    }

    window.addEventListener("load", event => {
        mapInit();
    });
})();