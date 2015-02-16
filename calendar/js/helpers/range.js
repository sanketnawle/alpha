/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />

ulcal.filter("range", function () {
    return function (input, total) {
        total = parseInt(total);
        for (var i = 0; i < total; ++i)
            input.push(i);        
        return input;
    }
})