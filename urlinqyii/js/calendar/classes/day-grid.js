/// <reference path="../../lib/jquery.js" />
/// <reference path="../helpers/date.js" />
/// <reference path="event-target.js" />

var DayGrid = (function (DayGrid) {
    var dp = new DateProvider();
    var _scope = null;
    var _compiler = null;
    var _iconbase = "http://lorempixel.com/100/100?";

    var classes = ['a', 'b', 'c', 'd', 'e', 'f'];
    function getRandomClass() { return classes[Math.floor(Math.random() * classes.length)]; }

    var createTodo = function (title, checked) {
        var todowrap = document.createElement("div");
        var todo = document.createElement("div"); todo.className = "todo";
        var check = document.createElement("div"); check.className = "check";
        check.setAttribute("ng-uc-check", "");
        if (checked) check.classList.add("checked");
        var label = document.createElement("div"); label.className = "label";
        label.innerHTML = title;
        todo.appendChild(check);
        todo.appendChild(label);
        todowrap.appendChild(todo);
        return todowrap.innerHTML;
    };

    var TodoItem = function (ele, title, checked) {
        this.ele = ele || _compiler(createTodo(title, checked))(_scope)[0];
        Object.defineProperties(this, {
            checked: {
                get: function () { return this.ele.querySelector(".check").classList.contains("checked"); },
                set: function (value) {
                    if (value == this.checked) return;
                    else if (value) this.ele.querySelector(".check").classList.add("checked");
                    else this.ele.querySelector(".check").classList.remove("checked");
                }
            },
            label: { set: function (value) { return this.ele.querySelector(".label").innerHTML = value } }
        })
    };

    var GridItem = function () {
        EventTarget.call(this);

        this.ele = _compiler("<div class='day-event' ng-uc-day-event></div>")(_scope)[0];

        // created
        var gi = this; _scope.$on("ucDayEventLoaded", function () { gi.__fire("load"); });

        Object.defineProperties(this, {
            title: { set: function (value) { this.ele.querySelector(".row1 .title .label").innerHTML = value; } },
            desc: { set: function (value) { this.ele.querySelector(".row2 .desc").innerHTML = value; } },
            time: { set: function (value) { this.ele.querySelector(".time").innerHTML = value; } },
            loc: {
                set: function (value) {
                    if (value == null || value.toString().trim() == "")
                        this.ele.querySelector(".row1 .loc").style.display = "none";
                    else
                        this.ele.querySelector(".row1 .location").innerHTML = value;
                }
            },
            attending: {
                get: function () { return this.ele.querySelector(".row2 .att .yesno").classList.contains("checked"); },
                set: function (value) {
                    if (value == this.attending) return;
                    var yesno = this.ele.querySelector(".row2 .att .yesno");
                    if (value) yesno.classList.add("checked");
                    else yesno.classList.remove("checked");
                }
            },
            color: { set: function (value) { this.ele.querySelector(".row1 .icon").className = "icon " + value; } },
            icon: {
                set: function (value) {
                    this.ele.querySelector(".row1 .icon img").setAttribute("src", _iconbase + value);
                }
            },
            addTodo: {
                value: function (todo, checked) {
                    var todos = this.ele.querySelector(".row2 .todos");
                    var ti = null;
                    if (todo instanceof TodoItem) ti = todo;
                    else if (typeof todo == "object" && todo.title) ti = new TodoItem(null, todo.title, todo.checked);
                    else if (typeof todo == "string") ti = new TodoItem(null, todo, checked);
                    if (ti) todos.appendChild(ti.ele);
                    else return false;
                }
            },
            getTodos: {
                value: function () {
                    var todos = this.ele.querySelectorAll(".row2 .todos .todo");
                    var items = [];
                    [].forEach.call(todos, function (e, i, a) {
                        items.push(new TodoItem(e));
                    });
                    return items;
                }
            }
        });
    };

    GridItem.prototype = Object.create(EventTarget.prototype);

    var Grid = function (ele) {
        this.ele = ele;
        this.count = 0;
        Object.defineProperties(this, {
            iconbase: { set: function (value) { _iconbase = value; } },
            addEvent: {
                value: function (uce, id) {
                    UCEvent.assert(uce);
                    if (_scope == undefined || _compiler == undefined) return false;
                    var eve = new GridItem();
                    var grid = this;
                    eve.addListener("load", function () {
                        eve.title = uce.title;
                        eve.desc = uce.desc;
                        // eve.icon = id;
                        eve.loc = uce.loc;
                        eve.id = uce.id;
                        eve.color = getRandomClass();
                        eve.origin_type = uce.origin_type;
                        eve.origin_id = uce.origin_id;

                        //alert(uce);
                        //console.log(uce);
                        if (uce.allday) eve.time = "allday";
                        else eve.time = dp.to12Hrs(uce.startTime) + " - " + dp.to12Hrs(uce.endTime);

                        grid[eve.id] = eve;
                        ++grid.count;
                        eve.ele.setAttribute('data-origin_type',uce.origin_type);
                        eve.ele.setAttribute('data-origin_id',uce.origin_id);
                        eve.ele.setAttribute('data-id',uce.id);
                        $(eve.ele).addClass('event_holder');

                        if (uce.allday) grid.ele.insertBefore(eve.ele, grid.ele.children[0]);
                        else grid.ele.appendChild(eve.ele);
                    });
                    return eve;
                }
            }
        });

    };

    DayGrid.TodoItem = TodoItem;
    DayGrid.GridItem = GridItem;
    DayGrid.Grid = Grid;

    DayGrid.createGrid = function (object, scope, compiler, isclass) {
        _scope = scope;
        _compiler = compiler;

        if (isclass === undefined) isclass = false;

        var grid = [];
        var ele = typeof object == "string" ? (isclass ?
            document.getElementsByClassName(object) :
            document.getElementById(object)) :
            object;
        if (ele === null || ele === undefined) return null;

        if (isclass) {
            for (var i = 0; i < ele.length; ++i){
                grid.push(new Grid(ele[i]));
            }
        } else {
            grid = new Grid(ele);
        }

        //grid.ele.innerHTML = "";

        var current_date = scope.getTodaysDate();
        //Start at -1 because the first row
        //is all day events

        for (var i = 0; i < 26; i++){

            var html_string = '<div class="day_grid_item"><div class="day_time">12pm</div></div>';
            if(i == 0){
                html_string = '<div class="day_grid_item all_day"><div class="day_time">All day</div></div>';
            }

            var grid_item_ele = jQuery(html_string);

            if(i != 0){
                if(i == 1){
                    grid_item_ele.find('.day_time').text('12am');
                }else if(i == 13){
                    grid_item_ele.find('.day_time').text('12pm');
                }else if(i < 13){
                    grid_item_ele.find('.day_time').text((i - 1).toString() + 'am');
                }else{
                    grid_item_ele.find('.day_time').text((i - 13).toString() + 'pm');
                }
            }


            //grid_item_ele.find('.day_time').text('12am');

            grid_item_ele.attr('data-date',date_to_string(current_date));
            grid_item_ele.attr('data-time',ints_to_time(i - 1,0,0));
            grid_item_ele.attr('data-time_num', i - 1);

            //grid.ele.appendChild(grid_item_ele);
            jQuery('#day-grid').append(grid_item_ele);

            jQuery('#day-grid').attr('data-date',date_to_string(current_date));
        }

        return grid;
    };

    return DayGrid;
}(DayGrid || {}));


//Converts date object into date string of SQl format like this:
// 2014-06-02
function date_to_string(date){
    return date.getFullYear() + '-' + addZero((date.getMonth() + 1)) + '-' + addZero(date.getDate());
}

// inj = angular.injector(['ng', ApplicationName]);
// inj.invoke(function ($rootScope, $compile) {
//    ele = $compile("<div ng-uc-day-event></div>")($rootScope)[0];
//    $(".day-grid").append(ele);
// });