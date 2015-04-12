/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />

var DateProvider = function () {
    var day = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var month = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];

    var getFullDate = function (month, year, last) {
        if (month === undefined) month = new Date().getMonth();
        if (year === undefined) year = new Date().getFullYear();
        return new Date(year, month + (last ? 1 : 0), (last ? 0 : 1));
    }

    this.getMonthName = function (index, short) {
        if (short === undefined) short = true;
        return short ? month[index].substr(0, 3) : month[index];
    }

    this.getDayName = function (index, short) {
        if (short === undefined) short = true;
        return short ? day[index].substr(0, 3) : day[index];
    }

    this.getDate = function (month, year, last) { return getFullDate(month, year, last); }
    this.getDay = function (month, year, last) { return getFullDate(month, year, last).getDay(); }    
}

ulcal.service("DateService", DateProvider);