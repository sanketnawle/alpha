/// <reference path="../../lib/jquery.js" />
/// <reference path="../helpers/date.js" />

var MonthGrid = (function (MonthGrid) {
    var dp = new DateProvider();

    var GridItem = function (text, outOfRange) {
        var item = document.createElement("div");
        item.className = "grid-item";
        if(outOfRange) item.classList.add("out-of-range")
        item.innerHTML = text;
        return item;
    }

    var Grid = function (grid, month, year) {        
        var start = dp.getDay(month, year, false);
        var end = dp.getDate(month, year, true).getDate();

        grid.innerHTML = "";

        for (var i = 1 - start; i <= 42 - start; ++i) {
            var text = "";
            if (i < 1) text += dp.getMonthName(month == 0 ? 11 : month - 1, true) + " ";
            else if (i > end) text += dp.getMonthName((month + 1) % 12, true) + " ";
            text += new Date(year, month, i).getDate();
            grid.appendChild(new GridItem(text), i < 1 || i > end);
        }
    }

    MonthGrid.createGrid = function (elementId, month, year) {
        if (month === undefined) month = new Date().getMonth();
        if (year === undefined) year = new Date().getFullYear();

        return new Grid(document.getElementById(elementId), month, year);
    }

    return MonthGrid;
}(MonthGrid || {}));