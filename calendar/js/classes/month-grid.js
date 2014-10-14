/// <reference path="../../lib/jquery.js" />
/// <reference path="../helpers/date.js" />

var MonthGrid = (function (MonthGrid) {
    var dp = new DateProvider();

    var createGridItem = function (text, oor) {
        var item = document.createElement("div");
        item.className = "grid-item";
        if (oor) item.classList.add("out-of-range")
        item.innerHTML = text;
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
                    var hasweek = [false, 0];
                    var start = dp.getDate(month, year, false).getDay();
                    var end = dp.getDate(month, year, true).getDate();

                    this.ele.innerHTML = "";

                    for (var i = 1 - start, text = "", gc = 1; i <= 42 - start; ++i, text = "", gc += 1) {
                        if (i < 1) text = dp.getMonthName(month == 0 ? 11 : month - 1, true);
                        else if (i > end) text = dp.getMonthName((month + 1) % 12, true);

                        var date = new Date(year, month, i);
                        text += " " + date.getDate();

                        this.ele.appendChild(new GridItem(null, text, i < 1 || i > end).ele);

                        if (gc % 7 == 1 && date.getWeek() == new Date().getWeek()) hasweek = [true, gc % 6];
                    }

                    if (hasweek[0]) this.drawWeek(hasweek[1]);
                }
            },
            children: { get: function () { return this.ele.querySelectorAll(".grid-item"); } },
            items: { get: function () { return getGridItems(this.children); } },
            drawWeek: {
                value: function (i) {
                    i = (i == 0 ? 6 : i) - 1;
                    var hr = document.createElement("hr");
                    hr.className = "week-line";
                    hr.style.top = Math.floor((1 / 6) * i * this.ele.offsetHeight) + "px";
                    this.ele.appendChild(hr);
                }
            }
        });

        // intialize
        this.populate();
    }

    MonthGrid.createGrid = function (elementId, month, year) {
        if (month === undefined) month = new Date().getMonth();
        if (year === undefined) year = new Date().getFullYear();

        return new Grid(document.getElementById(elementId), month, year);
    }

    return MonthGrid;
}(MonthGrid || {}));