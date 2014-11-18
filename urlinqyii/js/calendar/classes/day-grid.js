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
    }

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
    }

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
    }

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
                        if (uce.allday) eve.time = "allday";
                        else eve.time = dp.to12Hrs(uce.startTime) + " - " + dp.to12Hrs(uce.endTime);

                        grid[eve.id] = eve;
                        ++grid.count;

                        if (uce.allday) grid.ele.insertBefore(eve.ele, grid.ele.children[0]);
                        else grid.ele.appendChild(eve.ele);
                    });
                    return eve;
                }
            }
        })
    }

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
            for (var i = 0; i < ele.length; grid.push(new Grid(ele[i])), ++i);
        } else {
            grid = new Grid(ele);
        }

        return grid;
    }

    return DayGrid;
}(DayGrid || {}));

// inj = angular.injector(['ng', ApplicationName]);
// inj.invoke(function ($rootScope, $compile) {
//    ele = $compile("<div ng-uc-day-event></div>")($rootScope)[0];
//    $(".day-grid").append(ele);
// });