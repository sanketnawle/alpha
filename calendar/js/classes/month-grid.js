/// <reference path="../../lib/jquery.js" />
/// <reference path="../helpers/date.js" />

var MonthGrid = (function (MonthGrid) {
    var dp = new DateProvider();

    var createGridItem = function (text, oor) {
        var item = document.createElement("div");
        var date = document.createElement("div");
        date.innerHTML = text;
        date.className = "date";
        item.className = "grid-item";
        if (oor) item.classList.add("out-of-range")
        item.appendChild(date);
        return item;
    }

    var getGridItems = function (itemNodes) {
        var items = [];
        [].forEach.call(itemNodes, function (ele, i, array) { items.push(new GridItem(ele)); });
        return items;
    }

    /* Class GridItem */
    var GridItem = function (element, text, oor) {
        this.ele = element || createGridItem(text, oor);
        Object.defineProperties(this, {
            addEvent: {
                value: function (text) {
                    var event = document.createElement("div");
                    event.className = "grid-event";
                    event.innerHTML = text || "Test Event"
                    this.ele.appendChild(event);
                }
            }
        })
    }

    /* Class Grid */
    var Grid = function (grid, month, year) {
        Object.defineProperties(this, {
            ele: { value: grid },
            populate: {
                value: function () {
                    var premature = false;
                    var prem_plus = false;
                    var start = dp.getDate(month, year, false).getDay();
                    var end = dp.getDate(month, year, true).getDate();

                    this.ele.innerHTML = "";

                    for (var i = 1 - start, text = "", gc = 1; i <= 42 - start; ++i, text = "", gc += 1) {
                        if (i < 1) text = dp.getMonthName(month == 0 ? 11 : month - 1, true);
                        else if (i > end) text = dp.getMonthName((month + 1) % 12, true);
                        text += " " + new Date(year, month, i).getDate();

                        var gi = new GridItem(null, text, i < 1 || i > end).ele;

                        // find today                        
                        if (dp.getCurrentMonth() == month &&
                            dp.getCurrentYear() == year &&
                            dp.getCurrentDate() == i) {
                            gi.classList.add("td");
                        }

                        this.ele.appendChild(gi);

                        if (gc % 7 == 0 && gc / 7 < 6 && i >= end) {
                            if (i == end && i == 28) prem_plus = true;
                            premature = true; break;
                        }
                    }

                    // customization
                    if (premature) {
                        var cls = prem_plus ? "prem-plus" : "prem";
                        for (i = 0; i < this.items.length; ++i) {
                            this.items[i].ele.classList.add(cls);
                        }
                    }

                    var diff = new Date().getWeek() - dp.getDate(month, year, false).getWeek();
                    var factor = premature ? prem_plus ? 4 : 5 : 6;
                    for (i = 0; i < this.items.length; ++i) {
                        if ((diff > 0 && diff < factor) || (diff == 0 && new Date().getDate() < 7))
                            if (Math.floor(i / 7) == diff) this.items[i].ele.classList.add("tl");
                        if (Math.floor(i / 7) + 1 == factor) this.items[i].ele.classList.add("ll");
                    }
                }
            },
            children: { get: function () { return this.ele.querySelectorAll(".grid-item"); } },
            items: { get: function () { return getGridItems(this.children); } },
        });

        // intialize
        this.populate();
    }

    MonthGrid.Grid = Grid;
    MonthGrid.GridItem = GridItem;

    MonthGrid.createGrid = function (object, month, year, isclass) {
        if (isclass === undefined) isclass = false;

        if (month === undefined) month = dp.getCurrentMonth();
        if (year === undefined) year = dp.getCurrentYear();

        var grid = [];
        var ele = typeof object == "string" ? (isclass ?
            document.getElementsByClassName(object) :
            document.getElementById(object)) :
            object;
        if (ele === null || ele === undefined) return null;

        if (isclass) {
            for (var i = 0; i < ele.length; grid.push(new Grid(ele[i], (month + i) % 12, year)), ++i);
        } else {
            grid = new Grid(ele, month, year);
        }

        return grid;
    }

    return MonthGrid;
}(MonthGrid || {}));