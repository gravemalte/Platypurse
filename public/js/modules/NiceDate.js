"use strict";

function buildNiceDate(modules) {

    class NiceDate extends Date {
        constructor(dateData) {
            super(dateData);
        }

        getDigitalTime() {
            let hours = this.getHours();
            if (hours < 10) hours = "0" + hours;
            let minutes = this.getMinutes();
            if (minutes < 10) minutes = "0" + minutes;
            return hours + ":" + minutes;
        }

        getMonthDate() {
            let date = this.getDate();
            if (date < 10) date = "0" + date;
            let month = this.getMonth();
            if (month < 10) month = "0" + month;
            return `${date}.${month}.`;
        }

        getNiceDate() {
            let now = new Date();

            if (this.getFullYear() === now.getFullYear()) {
                if (this.getMonth() === now.getMonth()) {
                    if (this.getDate() === now.getDate()) {
                        if (this.getHours() === now.getHours()) {
                            return "gerade eben";
                        }
                        return `Heute um ${this.getDigitalTime()}`;
                    }
                    if (this.getDate() + 1 === now.getDate()) {
                        return `Gestern um ${this.getDigitalTime()}`;
                    }
                    return `am ${this.getDate()}. um ${this.getDigitalTime()}`;
                }
                return `am ${this.getMonthDate()} um ${this.getDigitalTime()}`;
            }
            return `am ${this.getMonthDate()}${this.getFullYear()} um ${this.getDigitalTime()}`;
        }

        getDatabaseString() {
            let offset = this.getTimezoneOffset();
            let unixTime = this.getTime();
            let unixOffset = offset * 60 * 1000;
            let newUnixTime = unixTime - unixOffset;
            let newDate = new Date(newUnixTime);
            let isoString = newDate.toISOString();
            return isoString.substr(0,19).replace("T", " ");
        }
    }

    return NiceDate;
}

export default buildNiceDate;