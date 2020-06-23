"use strict";

function buildChatThread(modules) {
    const NiceDate = modules.NiceDate;

    class ChatThread extends Array {
        constructor(id) {
            super();

            this.recipientName = "";
            this.id = id;
        }

        get latestMessage() {
            if (this.length === 0) return null;
            return this[this.length - 1];
        }

        get latestMessageDate() {
            let latestMessage = this.latestMessage;
            if (latestMessage === null) return null;
            return latestMessage.sendDate;
        }

        createElement(isSelected) {
            let element =
                document.createElement("DIV");
            element.id = "chat-thread-" + this.id;

            let contactContainer =
                document.createElement("DIV");
            contactContainer.classList.add("chat-contact-container");
            if (isSelected) contactContainer.classList.add("select");

            let iconContainer =
                document.createElement("DIV");
            iconContainer.classList.add("chat-contact-icon-container");

            let icon =
                document.createElement("IMG");
            icon.src = "assets/nav/user-circle-solid.svg";
            icon.alt = "user icon";

            let textContainer =
                document.createElement("DIV");
            textContainer.classList.add("chat-contact-text-container");

            let displayName =
                document.createElement("H1");
            displayName.innerHTML = this.recipientName;

            let lastMessage =
                document.createElement("P");
            lastMessage.innerHTML = this.latestMessage.message;

            let date =
                document.createElement("P");
            date.innerHTML = (new NiceDate(this.latestMessage.sendDate)).getNiceDate();

            iconContainer.appendChild(icon);
            textContainer.appendChild(displayName);
            textContainer.appendChild(lastMessage);
            contactContainer.appendChild(iconContainer);
            contactContainer.appendChild(textContainer);
            contactContainer.appendChild(date);
            element.appendChild(contactContainer);

            return element;
        }
    }

    return ChatThread;
}

export default buildChatThread;