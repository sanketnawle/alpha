/// <reference path="../../lib/jquery.js" />
/// <reference path="../helpers/date.js" />
/// <reference path="other.js" />
/// <reference path="event-div.js" />
$.noConflict();
var WeekGrid = (function (WeekGrid) {
    var dp = new DateProvider();
    var itemHeight = 50;

    var classes = ['a', 'b', 'c', 'd', 'e', 'f'];
    function getRandomClass() { return classes[Math.floor(Math.random() * classes.length)]; }

    var createGridItem = function () {
        var item = document.createElement("div");
        item.className = "grid-item";
        return item;
    };

    var getGridItems = function (itemNodes) {
        var items = [];
        [].forEach.call(itemNodes, function (ele, i, array) { items.push(new GridItem(ele)); });
        return items;
    };



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

                    var h = dp.diffTime(uce.startTime, uce.endTime) / 3600 * 100;

                    var event = new Div("grid-event event_holder");
                    var line = new Div("line");
                    var time = new Div("time", st[0] + ":" + st[1] + "-" + et[0] + ":" + et[1]);
                    var title = new Div("title", uce.title);

                    event.id = uce.id;
                    event.style.left = (22 * top) + "%";
                    var t1 = 22 * top, t2 = st[1] / 60 * 100, diff = 0;
                    if (t1 > t2) {
                        diff = t1 - t2;
                        event.style.top = t1 + "%";
                    } else {
                        event.style.top = t2 + "%";
                    }
                    event.style.height = h - (diff) + "%";

                    line.classList.add(getRandomClass());

                    event.appendChild(line);
                    event.appendChild(time);
                    event.appendChild(title);

                    event.setAttribute('data-id',uce.id);
                    event.setAttribute('data-start_date',uce.startTime);
                    event.setAttribute('data-end_date',uce.endTime);
                    event.setAttribute('data-origin_type',uce.origin_type);
                    event.setAttribute('data-origin_id',uce.origin_id);



                    this.ele.appendChild(event);

                    return event;
                }
            }
        });
    };

    /* Class Grid */
    var Grid = function (grid, date) {

        var getOffset = function () {
            var dt = new Date();
            return Math.floor((1 + dt.getHours() + dt.getMinutes() / 60) * itemHeight);
        };
        Object.defineProperties(this, {
            init: {
                value: function(){



                }
            },
            ele: { value: grid },
            populate: {
                value: function () {
                    this.ele.innerHTML = "";


                    var current_date = date;

                    //Start at -1 because the first row
                    //is all day events
                    var hour_index = -1;

                    for (var i = 0; i < 175; ++i){
                        if((i % 7) == 0 && i != 0){
                            current_date.setDate(current_date.getDate() - 7);
                            hour_index++;
                        }

                        var grid_item_ele = new GridItem().ele;
                        grid_item_ele.setAttribute('data-date',date_to_string(current_date));
                        grid_item_ele.setAttribute('data-time',ints_to_time(hour_index,0,0));
                        grid_item_ele.setAttribute('data-time_num',hour_index);

                        this.ele.appendChild(grid_item_ele);
                        current_date.setDate(current_date.getDate() + 1);
                    }




                    if (date.getWeek() == dp.getCurrentWeek() && date.getWeekYear() == dp.getCurrentYear()){
                        this.drawTimeLine();
                    }
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
                    setTimeout(function () {
                        parent.scrollTop = offset - parent.offsetHeight / 3;
                    }, 1);
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
    };




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
                var this_ele = ele[i];
                var this_grid = new Grid(this_ele, d);


                grid.push(this_grid);
            }
        } else {
            grid = new Grid(ele, date);
            grid.init();
        }

        return grid;
    };

    return WeekGrid;
}(WeekGrid || {}));

