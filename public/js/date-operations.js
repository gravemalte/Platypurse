"use strict";

(function () {
    function getNiceDate(date, isUTC = false) {
        date = new Date(date);
        if (isUTC) {
            date = getLocalDate(date);
        }

        let now = new Date();
        let dateTime = date.getTime();
        let nowTime = now.getTime();

        if (date.getFullYear() === now.getFullYear()) {
            if (date.getMonth() === now.getMonth()) {
                if (date.getDate() === now.getDate()) {
                    if ((dateTime + 300000) > nowTime) {
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

    function getDatabaseString(date, isUTC = false) {
        date = new Date(date);
        if (isUTC) {
            date = getLocalDate(date);
        }

        let year = date.getUTCFullYear();
        let month = getDoubleDigit(date.getUTCMonth());
        let day = getDoubleDigit(date.getUTCDate());
        let hour = getDoubleDigit(date.getUTCHours());
        let minute = getDoubleDigit(date.getUTCMinutes());
        let second = getDoubleDigit(date.getUTCSeconds());

        return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
    }

    function getLocalDate(date) {
        let year = date.getFullYear();
        let month = date.getMonth();
        let day = date.getDate();
        let hour = date.getHours();
        let minute = date.getMinutes();
        let second = date.getSeconds();

        return new Date(Date.UTC(year, month, day, hour, minute, second));
    }

    function getDigitalTime(date) {
        let hours = getDoubleDigit(date.getHours());
        let minutes = getDoubleDigit(date.getMinutes());

        return hours + ":" + minutes;
    }

    function getMonthDate(date) {
        let dateDate = getDoubleDigit(date.getDate());
        let dateMonth = getDoubleDigit(date.getMonth());

        return `${dateDate}.${dateMonth}.`;
    }

    function getDoubleDigit(number) {
        let parsedNumber = parseInt(number);
        if (isNaN(parsedNumber)) return number;
        if (parsedNumber < 10) return "0" + parsedNumber;
        return parsedNumber.toString();
    }

    window.addEventListener("DOMContentLoaded", async event => {
       for (let element of document.getElementsByClassName("date-display")) {
           let text = element.innerText;
           let utc = false;
           if (text.search(/utc/i) !== -1) utc = true;
           if (utc) text = text.replace(/utc/i, "");
           text = text.trim();
           element.innerText = getNiceDate(text, utc);
       }
    });

    window.getNiceDate = getNiceDate;
    window.getDatabaseString = getDatabaseString;
})();