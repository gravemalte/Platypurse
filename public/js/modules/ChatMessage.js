"use strict";

// function to load the ChatMessage module async
function buildChatMessage(modules) {

    class ChatMessage {
        /**
         * Represents a message in the chat
         * @param chatData
         * @param {string} chatData.msg_id
         * @param {string} chatData.sender_id
         * @param {string} chatData.receiver_id
         * @param {string} chatData.message
         * @param {string} chatData.send_date
         */
        constructor(chatData) {
            /**
             * The id of the message.
             *
             * @type {string}
             */
            this.messageId = chatData.msg_id;

            /**
             * The id of the sender.
             *
             * @type {string}
             */
            this.senderId = chatData.sender_id;

            /**
             * The id of the receiver.
             *
             * @type {string}
             */
            this.receiverId = chatData.receiver_id;

            /**
             * The content of the message.
             *
             * @type {string}
             */
            this.message = chatData.message;

            /**
             * The date the message was sent.
             * (The servers uses UTC.)
             *
             * @type {Date}
             */
            this.sendDate = new Date(chatData.send_date);
        }

        /**
         * Returns the id of the message.
         *
         * @returns {string}
         */
        get id() {
            return this.messageId;
        }

        /**
         * Create an HTML element of the message.
         *
         * @param {string} currentUserId
         * @returns {HTMLElement}
         */
        createElement(currentUserId) {
            let messageContainer =
                document.createElement("DIV");
            messageContainer.classList.add("chat-message-container");
            messageContainer.id = "message-id-" + this.messageId;
            if (this.receiverId === currentUserId) {
                messageContainer.classList.add("receive");
            }
            else {
                messageContainer.classList.add("send");
            }

            let innerContainer =
                document.createElement("DIV");

            let message =
                document.createElement("H1");
            message.innerText = this.message;

            let date =
                document.createElement("P");
            date.innerText = getNiceDate(this.sendDate, true);

            innerContainer.appendChild(message);
            innerContainer.appendChild(date);
            messageContainer.appendChild(innerContainer);

            return messageContainer;
        }
    }

    return ChatMessage;
}

export default buildChatMessage;