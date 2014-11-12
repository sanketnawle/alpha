/// <reference path="../../lib/jquery.js" />
/// <reference path="../helpers/date.js" />
/// <reference path="other.js" />
/// <reference path="event-div.js" />

var WeekGrid = (function (WeekGrid) {
    var dp = new DateProvider();
    var itemHeight = 50;

    var classes = ['a', 'b', 'c', 'd', 'e', 'f'];
    function getRandomClass() { return classes[Math.floor(Math.random() * classes.length)]; }

    var createGridItem = function () {
        var item = document.createElement("div");
        item.className = "grid-item";
        return item;
    }

    var getGridItems = function (itemNodes) {
        var items = [];
        [].forEach.call(itemNodes, function (ele, i, array) { items.push(new GridItem(ele)); });
        return items;
    }

    /* Class GridItem */
    var GridItem = function (element) {
        this.ele = element || createGridItem();
        Object.defineProperties(this, {
            addEvent: {
                value: function (uce, top, pseudo) {
                    if (pseudo) {
                        this.ele.appendChild(new Div("grid-pseudo-event"));
                        return;
                    }
                    UCEvent.assert(uce);

                    var st = uce.startTime.split(":");
                    var et = uce.endTime.split(":");

                    var h = dp.diffTime(uce.startTime, uce.endTime) / 3600 * itemHeight;

                    console.log(dp.diffTime(uce.startTime, uce.endTime), h);

                    var event = new Div("grid-event");
                    var line = new Div("line");
                    var time = new Div("time", st[0] + ":" + st[1] + "-" + et[0] + et[1]);
                    var title = new Div("title", uce.title);

                    event.id = uce.id;
                    event.style.left = (22 * top) + "%";
                    event.style.top = (22 * top) + "%";
                    event.style.height = h + "px";

                    line.classList.add(getRandomClass());

                    event.appendChild(line);
                    event.appendChild(time);
                    event.appendChild(title);

                    this.ele.appendChild(event);

                    return event;
                }
            }
        });
    }

    /* Class Grid */
    var Grid = function (grid, date) {
        var getOffset = function () {
            var dt = new Date();
            return Math.floor((1 + dt.getHours() + dt.getMinutes() / 60) * itemHeight);
        }
        Object.defineProperties(this, {
            ele: { value: grid },
            populate: {
                value: function () {
                    this.ele.innerHTML = "";
                    for (var i = 0; i < 175; ++i) this.ele.appendChild(new GridItem().ele);
                    if (date.getWeek() == dp.getCurrentWeek()
                        && date.getWeekYear() == dp.getCurrentYear()) this.drawTimeLine();
                }
            },
            children: { get: function () { return this.ele.querySelectorAll(".grid-item"); } },
            items: { get: function () { return getGridItems(this.children); } },
            drawTimeLine: {
                value: function () {
                    var offset = getOffset();

                    var hr = document.createElement("hr");
                    hr.className = "time-line";
                    this.ele.appendChild(hr);
                    hr.style.top = offset + "px";

                    var parent = this.ele.parentElement;
                    parent.scrollTop = offset - parent.offsetHeight / 3;

                    this.startTicking();
                }
            },
            startTicking: {
                value: function () {
                    var ele = this.ele;
                    setInterval(function () {
                        hr = ele.querySelectorAll(".time-line")[0];
                        hr.style.top = getOffset() + "px";
                    }, 60 * 1000);
                }
            },
            events: {
                value: {},
                writable: true
            },
            addEvent: {
                value: function (uce, col) {
                    UCEvent.assert(uce);

                    var t = uce.startTime.split(":");
                    var item = this.items[t[0] * 7 + col + 7];
                    var count = item.ele.querySelectorAll(".grid-event").length;
                    count += item.ele.querySelectorAll(".grid-pseudo-event").length;

                    if (uce.id in this.events) {
                        var ele = this.events[uce.id].ele;
                        ele.querySelector(".time").classList.add("short");
                        var oldcol = this.events[uce.id].col;
                        var width = col - oldcol + 1;
                        ele.style.width = (100 * width + width) - (22 * count) + "%";
                        item.addEvent(null, null, true); // add pseudo element
                    } else {
                        var ele = item.addEvent(uce, count);
                        this.events[uce.id] = { col: col, ele: ele };
                    }
                }
            }
        });

        // intialize
        this.populate();
    }
    WeekGrid.Grid = Grid;
    WeekGrid.GridItem = GridItem;

    WeekGrid.createGrid = function (object, date, isclass) {
        if (isclass === undefined) isclass = false;

        var grid = [];
        var ele = typeof object == "string" ? (isclass ?
            document.getElementsByClassName(object) :
            document.getElementById(object)) :
            object;
        if (ele === null || ele === undefined) return null;
        if (isclass) {
            for (var i = 0; i < ele.length; ++i) {
                var d = new Date(date.getTime());
                d = new Date(d.setDate(d.getDate() + (i * 7)));
                grid.push(new Grid(ele[i], d))
            }
        } else {
            grid = new Grid(ele, date);
        }

        return grid;
    }

    return WeekGrid;
}(WeekGrid || {}));