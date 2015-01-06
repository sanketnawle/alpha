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


        init();
        function init(){
            get_day_events();
        }


        function get_day_events(){
            var todays_date = jQuery('div#day-grid').attr('data-date');
            //console.log(todays_date);

            jQuery.getJSON(base_url + '/event/getEvents?date=' + '2015-01-05',{date: todays_date}, function(json_data){
                jQuery.each(json_data['events'],function(index, event_json){
                    //console.log('DAY EVENTS');

                    show_day_event(event_json);
                });
            });
        }


        function show_day_event(event_json){


            //Normally source would be jQuery("#group_template").html(); but for whatever reason
            //angular doesnt let jquery select the handlebars template if it is in the html
            var source = '<div class="day_event_holder" data-location="{{location}}" data-id="{{event_id}}" data-event_type="{{event_type}}" data-origin_type="{{origin_type}}" data-origin_id="{{origin_id}}" data-name="{{title}}" data-start_date="{{start_date}}" data-end_date="{{end_date}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}"><div class="event_start_time">{{formatted_start_time}}</div><div class="event_name">{{title}}</div></div>';
            var template = Handlebars.compile(source);

            event_json['formatted_start_time'] = date_to_am_pm_string(new Date(event_json['start_time'] + '00:00:00'));
            var generated_html = template(event_json);
            var html_object = jQuery(generated_html);

            //formatted start time
            var event_time_text = date_to_am_pm_string(new Date(event_json['start_time'] + '00:00:00')) + " - " + date_to_am_pm_string(new Date(event_json['end_time'] + '00:00:00'));
            html_object.find('.event_start_time').text(event_time_text);


            var start_time_hour = ints_to_time(parseInt(event_json['start_time'].substring(0,2)),0,0);

            //if this is an all day event, show it at the top and stop this function
//        if(event_json['all_day'] == '1' || event_json['all_day'] == 'false'){
//            jQuery("div.day_grid_item.all_day").append($(generated_html));
//            //recalculate top
//            jQuery.each($this_day_time_events, function(index,$day_time_event){
//                $($day_time_event).css({'width': width.toString() + 'px'});
//                $($day_time_event).css({'left': left_pixels + 'px'});
//                left_pixels += width;
//            });
//            return;
//        }

            var $grid_item_selector = jQuery("div.day_grid_item[data-time='" + start_time_hour + "']");
            //Make sure this div exists b4 we do anything
            if($grid_item_selector){




                //Size in pixels of the time ranges
                var time_range_height = 40;

                //Start after the all day events + 15 for the padding bottom
                var top_pixels = jQuery("div.day_grid_item.all_day").height() + 15;
                top_pixels += parseInt(event_json['start_time'].substring(0,2)) * time_range_height;
                //Add the pixels for the minutes
                console.log('minutes int: ' + parseInt(event_json['start_time'].substring(3,5)));
                top_pixels += (parseInt(event_json['start_time'].substring(3,5)) / 60) * time_range_height;



                //var event_height = (parseInt(event_json['end_time'].substring(0,2)) - (parseInt(event_json['start_time'].substring(0,2)))) * time_range_height;
                var hour_difference = parseInt(event_json['end_time'].substring(0,2)) - parseInt(event_json['start_time'].substring(0,2));
                var minute_difference = parseInt(event_json['end_time'].substring(3,5)) - parseInt(event_json['start_time'].substring(3,5));
                var event_hour_length =  hour_difference + (minute_difference / 60); //in hour form with decimals for minutes
                console.log('EVENT HOUR LENGTH');
                console.log(event_hour_length);
                var event_height = (event_hour_length * time_range_height) + 1;
                //event_height += (parseInt(event_json['end_time'].substring(3,5)) / 60) * time_range_height;




//            console.log(start_time_hour);
//            console.log(event_json);
//            console.log(generated_html);
//
//
//            console.log('top pixels');
//            console.log(top_pixels);



                //Start 50 pixels from the left since there is padding on the day grid
                var left_pixels = 50;
                //Leave 15 pixels on the right so new events can be created
                //by clicking that space
                var width = $grid_item_selector.width() - 15;
                //check if other events are within this time range
                var $this_day_time_events = $grid_item_selector.find('.day_event_holder');
                if($this_day_time_events.length){
                    //100 / 3 elements = 33% each
                    //Add one because we have not added our new event element yet
                    width /= $this_day_time_events.length + 1;

                    //Loop through each event and change the styling
                    jQuery.each($this_day_time_events, function(index,$day_time_event){
                        $($day_time_event).css({'width': width.toString() + 'px'});
                        $($day_time_event).css({'left': left_pixels + 'px'});
                        left_pixels += width;
                    });
                }



                html_object.css({'position':'absolute'});
                html_object.css({'top': top_pixels.toString() + 'px'});
                html_object.css({'left': left_pixels + 'px'});
                html_object.css({'height':event_height.toString() + 'px'});
                html_object.css({'z-index':event_height.toString()});
                html_object.css({'width': width.toString() + 'px'});

                $grid_item_selector.append(html_object);

            }else{
                console.log("ERROR ADDING EVENT");
                console.log(event_json);
            }


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