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
            if (this.latestMessage !== null) {
                lastMessage.innerHTML = this.latestMessage.message;
            }

            let date =
                document.createElement("P");
            if (this.latestMessage !== null) {
                date.innerHTML = (new NiceDate(this.latestMessageDate)).getNiceDate();
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

        getElement() {
            return document.getElementById("chat-thread-" + this.id);
        }

        unselect() {
            this.getElement().children[0].classList.remove("select");
        }

        select() {
            this.getElement().children[0].classList.add("select");
        }

        update(message) {
            if (this.latestMessage === null) {
                this.push(message);
                return true;
            }
            console.log(parseInt(this.latestMessage.id));
            console.log(parseInt(message.id));
            console.log(parseInt(this.latestMessage.id) < parseInt(message.id));
            if (parseInt(this.latestMessage.id) < parseInt(message.id)) {
                this.push(message);
                return true;
            }

            return false;
        }

        static compareDate(a, b) {
            let aDate = a.latestMessageDate;
            let bDate = b.latestMessageDate;
            if (aDate === null) return -1;
            if (bDate === null) return 1;
            if (aDate.getTime() > bDate.getTime()) return -1;
            if (bDate.getTime() < bDate.getTime()) return 1;
            return 0;
        }
    }

    return ChatThread;
}

export default buildChatThread;