"use strict";

(function() {
    window.addEventListener("DOMContentLoaded", async event => {
        let sliderContainer = document.getElementsByClassName("multi-thumb-slider-container");

        for (let container of sliderContainer) {
            for (let child of container.children) {
                if (child.tagName.toLowerCase() !== "input") continue;

                let querySelector = "[data-show-multi-thumb-slider=" + child.id + "]";
                let showElement = document.querySelector(querySelector);
                let updateData = createUpdater(showElement, child);

                child.addEventListener("input", event => updateData(event));
            }
        }
    });

    function createUpdater(showElement, input) {
        showElement.innerHTML = input.value;
        let showSibling = getSibling(showElement);
        let inputSibling = getSibling(input);

        let showPair = getSiblingPair(showElement, showSibling, "innerHTML");
        let inputPair = getSiblingPair(input, inputSibling, "value");

        function updateData(event) {
            let inputValue = parseFloat(input.value);
            let inputSiblingValue = parseFloat(inputSibling.value);

            if ((input === inputPair[0] && inputValue < inputSiblingValue) ||
                (input === inputPair[1] && inputValue < inputSiblingValue)) {
                showPair[0].innerHTML = input.value;
                showPair[1].innerHTML = inputSibling.value;
                return;
            }
            showPair[0].innerHTML = inputSibling.value;
            showPair[1].innerHTML = input.value;
        }

        return updateData;
    }

    function getSibling(element) {
        let parent = element.parentElement;
        let tag = element.tagName;
        for (let child of parent.children) {
            if (child !== element && child.tagName === tag) {
                return child;
            }
        }
        return null;
    }

    function getSiblingPair(element, sibling, attribute) {
        let pair = [];

        if (element[attribute] === "") {
            if (parseFloat(sibling[attribute]) !== 0) {
                pair.push(element, sibling);
                return pair;
            }
            pair.push(sibling, element);
            return pair;
        }
        if (sibling[attribute] === "") {
            if (parseFloat(element[attribute]) !== 0) {
                pair.push(sibling, element);
                return pair;
            }
            pair.push(element, sibling);
            return pair;
        }
        if (parseFloat(element[attribute]) < parseFloat(sibling[attribute])) {
            pair.push(element, sibling);
            return pair;
        }
        pair.push(sibling, element);
        return pair;
    }
})();