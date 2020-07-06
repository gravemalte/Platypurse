"use strict";

(function () {
    /**
     * Get a beautiful date expression.
     *
     * @param {Date|string} date
     * @param {boolean} [isUTC=false]
     * @returns {string}
     */
    function getNiceDate(date, isUTC = false) {
        date = new Date(date);
        if (isUTC) {
            // if the date is originally UTC change it to local time
            date = getLocalDate(date);
        }

        let now = new Date();
        let dateTime = date.getTime();
        let nowTime = now.getTime();

        // compare times to now
        if (date.getFullYear() === now.getFullYear()) {
            if (date.getMonth() === now.getMonth()) {
                if (date.getDate() === now.getDate()) {
                    if ((dateTime + 300000) > nowTime) {
                        // show this only for 5 minutes
                        return "gerade eben";
                    }
                    return `Heute um ${getDigitalTime(date)}`;
                }
                if (date.getDate() + 1 === now.getDate()) {
                    return `Gestern um ${getDigitalTime(date)}`;
                }
                return `am ${date.getDate()}. um ${getDigitalTime(date)}`;
            }
            return `am ${getMonthDate(date)} um ${getDigitalTime(date)}`;
        }
        return `am ${getMonthDate(date)}${date.getFullYear()} um ${getDigitalTime(date)}`;
    }

    /**
     * Returns a string that is passable to our database.
     *
     * @param {Date|string} date
     * @param {boolean} [isUTC=false]
     * @returns {string}
     */
    function getDatabaseString(date, isUTC = false) {
        date = new Date(date);
        if (isUTC) {
            // if the date is originally UTC change it to local time
            date = getLocalDate(date);
        }

        let year = date.getUTCFullYear();
        let month = getDoubleDigit(date.getUTCMonth());
        let day = getDoubleDigit(date.getUTCDate());
        let hour = getDoubleDigit(date.getUTCHours());
        let minute = getDoubleDigit(date.getUTCMinutes());
        let second = getDoubleDigit(date.getUTCSeconds());

        // format it to "YYYY-MM-DD HH:MM:SS"
        return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
    }

    /**
     * Takes a date object in UTC and returns date with the local time.
     *
     * @param {Date} date
     * @returns {Date}
     */
    function getLocalDate(date) {
        let year = date.getFullYear();
        let month = date.getMonth();
        let day = date.getDate();
        let hour = date.getHours();
        let minute = date.getMinutes();
        let second = date.getSeconds();

        return new Date(Date.UTC(year, month, day, hour, minute, second));
    }

    /**
     * Returns a digital time string.
     *
     * @param {Date} date
     * @returns {string}
     */
    function getDigitalTime(date) {
        let hours = getDoubleDigit(date.getHours());
        let minutes = getDoubleDigit(date.getMinutes());

        // format it to "HH:MM"
        return hours + ":" + minutes;
    }

    /**
     * Returns a date with day and month.
     *
     * @param {Date} date
     * @returns {string}
     */
    function getMonthDate(date) {

        let dateDate = getDoubleDigit(date.getDate());
        let dateMonth = getDoubleDigit(date.getMonth());

        // format it to "DD.MM."
        return `${dateDate}.${dateMonth}.`;
    }

    /**
     * Returns a number as a double digit.
     *
     * @param {number|string} number
     * @returns {string}
     */
    function getDoubleDigit(number) {
        let parsedNumber = parseInt(number);
        if (isNaN(parsedNumber)) return number;
        if (parsedNumber < 10) return "0" + parsedNumber;
        return parsedNumber.toString();
    }

    window.addEventListener("DOMContentLoaded", async event => {
        // replace dates to nice dates
        for (let element of document.getElementsByClassName("date-display")) {
            let text = element.innerText;
            let utc = false;
            if (text.search(/utc/i) !== -1) utc = true;
            if (utc) text = text.replace(/utc/i, "");
            text = text.trim();
            element.innerText = getNiceDate(text, utc);
        }
    });

    // attach getNiceDate and getDatabaseString to the global object
    window.getNiceDate = getNiceDate;
    window.getDatabaseString = getDatabaseString;
})();