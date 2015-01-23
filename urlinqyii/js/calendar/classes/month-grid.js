/// <reference path="../lib/jquery.js" />
/// <reference path="../helpers/date.js" />
/// <reference path="event-target.js" />
$.noConflict();
var MonthGrid = (function (MonthGrid) {
    var dp = new DateProvider();

    var classes = ['a', 'b', 'c', 'd', 'e', 'f'];
    function getRandomClass() { return classes[Math.floor(Math.random() * classes.length)]; }

    var createGridItem = function (text, oor) {
        var item = document.createElement("div");
        var date = document.createElement("div");
        date.innerHTML = text;
        date.className = "date";
        item.className = "grid-item";
        if (oor) item.classList.add("out-of-range")
        item.appendChild(date);
        return item;
    };

    var getGridItems = function (itemNodes) {
        var items = [];
        [].forEach.call(itemNodes, function (ele, i, array) { items.push(new GridItem(ele)); });
        return items;
    };

    /* Class GridItem */
    var GridItem = function (element, text, oor) {
        this.ele = element || createGridItem(text, oor);
        Object.defineProperties(this, {
            addEvent: {
                value: function (text) {
                    var event = new Div("grid-event event_holder");
                    var line = new Div("line");
                    var title = new Div("title", text || "Test Event");
                    var time = new Div("time", "10p");

                    line.classList.add(getRandomClass());

                    event.appendChild(line);
                    event.appendChild(time);
                    event.appendChild(title);

                    this.ele.appendChild(event);
                }
            }
        })
    };

    /* Class Grid */
    var Grid = function (grid, month, year) {

        EventTarget.call(this);
        var me = this;



        Object.defineProperties(this, {
            init: {
                value: function () {
                    init();

                    function init(){
                        var date_str = new Date();
                        date_str = date_to_string(date_str);
                        get_month_events(date_str);
                    }



                    function get_month_events(date_str){

                        $.getJSON( base_url + '/event/getMonthEvents', {date: date_str},function( json_data ) {
                            if(json_data['success']){
                                show_month_events(json_data['events']);
                            }else{
                                alert('error getting planner events');
                            }
                        });
                    }


                    function show_month_events(events_json){
                        $.each(events_json,function(index, event_json){
                            show_month_event(event_json);
                        });
                    }



                }
            },
            ele: { value: grid },
            populate: {
                value: function () {
                    var premature = false;
                    var prem_plus = false;
                    var start = dp.getDate(month, year, false).getDay();
                    var end = dp.getDate(month, year, true).getDate();

                    this.ele.innerHTML = "";

                    for (var i = 1 - start, text = "", gc = 1; i <= 42 - start; ++i, text = "", gc += 1) {
                        if (i < 1) {
                            text = dp.getMonthName(month == 0 ? 11 : month - 1, true);
                        }
                        else if (i > end) {
                            text = dp.getMonthName((month + 1) % 12, true);
                        }

                        var this_date = new Date(year, month, i);
                        text += " " + this_date.getDate();

                        var gi = new GridItem(null, text, i < 1 || i > end).ele;

                        // find today                        
                        if (dp.getCurrentMonth() == month &&
                            dp.getCurrentYear() == year &&
                            dp.getCurrentDate() == i) {
                            gi.classList.add("td");
                        }

                        gi.setAttribute('data-date',date_to_string(this_date));
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
            items: { get: function () { return getGridItems(this.children); } }
        });
        
        var MonthMouseWheel = function (e) {
            var e = e || event;
            var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
            me.__fire({ type: "scroll", delta: delta });
        };
        if (this.ele.addEventListener) {
            this.ele.addEventListener("mousewheel", MonthMouseWheel, false);
            this.ele.addEventListener("DOMMouseScroll", MonthMouseWheel, false);
        } else {
            this.ele.attachEvent("onmousewheel", MonthMouseWheel);
        }
    };






    // inherit events
    Grid.prototype = Object.create(EventTarget.prototype);

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

        grid.populate();
        grid.init();
        return grid;
    };




    return MonthGrid;
}(MonthGrid || {}));










