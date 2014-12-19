/// <reference path="../../lib/jquery.js" />
/// <reference path="../helpers/date.js" />

var MiniMonthGrid = (function (MiniMonthGrid) {
    var dp = new DateProvider();

    var createGridItem = function (text, param, oor) {
        var item = document.createElement("div");
        var date = document.createElement("a");
        switch (param.type) {
            case "m": date.href = "#/month/" + (param.month + 1) + "/" + param.year; break;
            case "w": date.href = "#/week/" + param.week + "/" + param.year; break;
            case "d": date.href = "#/day/" + param.day + "/" + (param.month + 1) + "/" + param.year; break;
        }
        date.innerHTML = text;
        date.className = "date";
        item.className = "grid-item";
        if (oor) item.classList.add("out-of-range")
        item.appendChild(date);
        return item;
    }

    /* Class GridItem */
    var GridItem = function (element, text, param, oor) {
        this.ele = element || createGridItem(text, param, oor);
    }

    /* Class Grid */
    var Grid = function (grid, month, year, param) {
        Object.defineProperties(this, {
            ele: { value: grid },
            populate: {
                value: function () {
                    var premature = false;
                    var start = dp.getDate(month, year, false).getDay();
                    var end = dp.getDate(month, year, true).getDate();

                    this.ele.innerHTML = "";

                    for (var i = 1 - start, text = "", gc = 1; i <= end; ++i, text = "", gc += 1) {
                        var date = new Date(year, month, i);
                        if (i >= 1) text = date.getDate();

                        param.day = i;
                        if (param.type == "w") {
                            param.week = date.getWeek();
                            param.year = date.getWeekYear();
                        }
                        var gi = new GridItem(null, text, param, i < 1).ele;

                        // find today
                        if (dp.getCurrentMonth() == month &&
                            dp.getCurrentYear() == year &&
                            dp.getCurrentDate() == i)
                            gi.classList.add("td");

                        this.ele.appendChild(gi);
                    }
                }
            }
        });

        // intialize
        this.populate();
    }

    MiniMonthGrid.Grid = Grid;
    MiniMonthGrid.GridItem = GridItem;

    MiniMonthGrid.createGrid = function (object, month, year, param, isclass) {
        if (isclass === undefined) isclass = false;
        if (param === undefined || param === null) {
            param = {};
            param.type = "d";
            param.month = month;
            param.year = year;
        }

        if (month === undefined) month = dp.getCurrentMonth();
        if (year === undefined) year = dp.getCurrentYear();

        var grid = [];
        var ele = typeof object == "string" ? (isclass ?
            document.getElementsByClassName(object) :
            document.getElementById(object)) :
            object;
        if (ele === null || ele === undefined) return null;

        if (isclass) {
            for (var i = 0; i < ele.length; grid.push(new Grid(ele[i], (month + i) % 12, year, param)), ++i);
        } else {
            grid = new Grid(ele, month, year, param);
        }

        return grid;
    }

    return MiniMonthGrid;
}(MiniMonthGrid || {}));