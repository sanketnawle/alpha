/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />

ulcal.filter("range", function () {
    return function (input, lb, ub) {
        if (ub === undefined) {
            ub = lb;
            lb = 0;
        }
        ub = parseInt(ub);
        lb = parseInt(lb);
        for (var i = lb; i < ub; ++i)
            input.push(i);
        return input;
    }
});