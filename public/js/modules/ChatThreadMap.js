"use strict";

// function to load the ChatThreadMap module async
function buildChatThreadMap(modules) {

    // modules used by this module
    const ChatThread = modules.ChatThread;

    class ChatThreadMap extends Map {
        /**
         * Maps all chat threads into one map with some extras.
         */
        constructor() {
            super();

            /**
             * The HTML element that displays the map.
             *
             * @type {HTMLElement}
             */
            this.container = document.getElementById("chat-list-container");
        }
    }

    return ChatThreadMap;
}

export default buildChatThreadMap;