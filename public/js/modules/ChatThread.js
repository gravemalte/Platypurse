"use strict";

// function to load the ChatThread module async
function buildChatThread(modules) {

    class ChatThread extends Array {
        /**
         * Represents a chat thread.
         *
         * @param {string} id
         */
        constructor(id) {
            super();

            /**
             * The recipient of the messages.
             * This will be used as title for the log.
             *
             * @type {string}
             */
            this.recipientName = "";

            /**
             * The id of the thread.
             * It's the same as the recipient id.
             *
             * @type {string}
             */
            this.id = id;

            /**
             * The avatar of the user.
             *
             * @type {HTMLElement}
             */
            this.avatarElement = document.createElement("IMG");
            this.avatarElement.alt = "user icon";
            this.fetchAvatar();
        }

        /**
         * Returns the latest message in the thread.
         *
         * @returns {null|ChatMessage}
         */
        get latestMessage() {
            if (this.length === 0) return null;
            return this[this.length - 1];
        }

        /**
         * Returns the date of the latest message in the thread.
         *
         * @returns {null|Date}
         */
        get latestMessageDate() {
            let latestMessage = this.latestMessage;
            if (latestMessage === null) return null;
            return latestMessage.sendDate;
        }

        /**
         * Creates an HTML element for the thread list on the left.
         *
         * @param {boolean} isSelected
         * @returns {HTMLElement}
         */
        createElement(isSelected) {
            let element =
                document.createElement("DIV");
            element.id = "chat-thread-" + this.id;

            let contactContainer =
                document.createElement("DIV");
            contactContainer.classList.add("chat-contact-container");
            // if selected highlight the thread
            if (isSelected) contactContainer.classList.add("select");

            let iconContainer =
                document.createElement("DIV");
            iconContainer.classList.add("chat-contact-icon-container");

            let icon = this.avatarElement;

            let textContainer =
                document.createElement("DIV");
            textContainer.classList.add("chat-contact-text-container");

            let displayName =
                document.createElement("H1");
            displayName.innerHTML = this.recipientName;

            let lastMessage =
                document.createElement("P");
            if (this.latestMessage !== null) {
                lastMessage.innerText = this.latestMessage.message;
            }

            let date =
                document.createElement("P");
            if (this.latestMessage !== null) {
                date.innerText = getNiceDate(this.latestMessageDate, true);
            }

            iconContainer.appendChild(icon);
            textContainer.appendChild(displayName);
            textContainer.appendChild(lastMessage);
            contactContainer.appendChild(iconContainer);
            contactContainer.appendChild(textContainer);
            contactContainer.appendChild(date);
            element.appendChild(contactContainer);

            return element;
        }

        /**
         * Returns the HTML element that display the thread.
         * Or create a new one if none is present.
         *
         * @returns {HTMLElement}
         */
        getElement() {
            let element = document.getElementById("chat-thread-" + this.id);
            if (element === null) {
                element = document.createElement("DIV");
                element.appendChild(document.createElement("DIV"));
            }
            return element;
        }

        /**
         * Unselect this thread.
         * (Removes highlight.)
         */
        unselect() {
            this.getElement().children[0].classList.remove("select");
        }

        /**
         * Select this thread.
         * (Adds highlight.)
         */
        select() {
            this.getElement().children[0].classList.add("select");
        }

        /**
         * Try to update a message.
         * If known return false.
         *
         * @param {ChatMessage} message
         * @returns {boolean}
         */
        update(message) {
            if (this.latestMessage === null) {
                // always add if no messages are present
                this.push(message);
                return true;
            }
            if (parseInt(this.latestMessage.id) < parseInt(message.id)) {
                // only add if new message is actually new
                this.push(message);
                return true;
            }

            // not a new message
            return false;
        }

        /**
         * Comparator for two threads.
         * Which one has the newer messages.
         *
         * @param {ChatThread} a
         * @param {ChatThread} b
         * @returns {number}
         */
        static compareDate(a, b) {
            let aDate = a.latestMessageDate;
            let bDate = b.latestMessageDate;
            if (aDate === null) return -1;
            if (bDate === null) return 1;
            if (aDate.getTime() > bDate.getTime()) return -1;
            if (bDate.getTime() < bDate.getTime()) return 1;
            return 0;
        }

        /**
         * Fetches avatar to only load it once.
         *
         * @returns {Promise<void>}
         */
        async fetchAvatar() {
            let fetchResponse = await fetch("./profile/avatar?id=" + this.id, {
                method: "GET"
            });
            let imageBuffer = await fetchResponse.arrayBuffer();
            let base64Flag = "data:" + fetchResponse.headers.get["Content-Type"] + ";base64,";
            let imageStr = arrayBufferToBase64(imageBuffer);

            function arrayBufferToBase64(buffer) {
                let binary = '';
                let bytes = [].slice.call(new Uint8Array(buffer));

                bytes.forEach((b) => binary += String.fromCharCode(b));

                return window.btoa(binary);
            }

            this.avatarElement.src = base64Flag + imageStr;
        }
    }

    return ChatThread;
}

export default buildChatThread;