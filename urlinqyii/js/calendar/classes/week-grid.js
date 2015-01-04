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

                    var event = new Div("grid-event");
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


                    this.ele.appendChild(event);

                    return event;
                }
            }
        });
    };

    /* Class Grid */
    var Grid = function (grid, date) {
        handle_jquery(this.ele);
        var getOffset = function () {
            var dt = new Date();
            return Math.floor((1 + dt.getHours() + dt.getMinutes() / 60) * itemHeight);
        };
        Object.defineProperties(this, {
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
    function handle_jquery(ele){
        last_clicked_event_id = null;

        $(document).on('click', '.grid-event', function(event){
            event.stopPropagation();


            var $month_day_event_div = $(this);
            var event_id = $month_day_event_div.attr('id');
            var $inspect_event_popup = $('#inspect_event_popup');

            //Add the event_id to the inspect_event_popup for easy access
            $inspect_event_popup.attr('data-event_id', event_id);


            if(!$inspect_event_popup.is(":visible")){
                if((event.pageY - 180) <= 0){
                    $inspect_event_popup.css('top', event.pageY + 15);
                }else{
                    $inspect_event_popup.css('top', event.pageY - 180);
                }
                $inspect_event_popup.css('left', event.pageX - 140);

//            Mon, October 27, 2014, 8am – 11am
                var this_date = new Date($month_day_event_div.closest('.grid-item').attr('data-date') + ' 00:00:00');
                var start_time = $month_day_event_div.attr('data-start_time');
                var inspect_event_text = format_event_date_text(this_date);
                $inspect_event_popup.find('#inspect_event_text').text(inspect_event_text);
                $inspect_event_popup.find('#inspect_event_description').text($month_day_event_div.attr('data-description'));

                $inspect_event_popup.addClass('active');
            }else{
                if($month_day_event_div.attr('data-id') != last_clicked_event_id){
                    //We clicked a different event than the event we were already looking at
                    //switch the inspect_event_popup to this event
                    if((event.pageY - 180) <= 0){
                        $inspect_event_popup.css('top', event.pageY + 15);
                    }else{
                        $inspect_event_popup.css('top', event.pageY - 180);
                    }



                    $inspect_event_popup.css('left', event.pageX - 140);


                    //            Mon, October 27, 2014, 8am – 11am
                    var this_date = new Date($month_day_event_div.closest('.grid-item').attr('data-date') + ' 00:00:00');
                    var start_time = $month_day_event_div.attr('data-start_time');
                    var inspect_event_text = format_event_date_text(this_date);
                    $inspect_event_popup.find('#inspect_event_text').text(inspect_event_text);
                    $inspect_event_popup.find('#inspect_event_description').text($month_day_event_div.attr('data-description'));


                }else{
                    $inspect_event_popup.removeClass('active');
                }
            }

            last_clicked_event_id = $month_day_event_div.attr('data-id');
        });


        last_month_day_date_selected = null;
        $(document).on('click', '.grid-item', function(event){

            //Hide the other popup
            $('#inspect_event_popup').removeClass('active');

            event.stopPropagation();
            var $day_time_div = $(this);
            var this_date = $day_time_div.attr('data-date');
            var this_date_obj = new Date(this_date);
            var this_time = $day_time_div.attr('data-time');
            var this_time_int = parseInt($day_time_div.attr('data-time_num'));
            var $create_month_day_event_popup = $('#create_month_day_event_popup');

            var end_time = ints_to_time(this_time_int + 1,0,0);

            //Add the event_id to the inspect_event_popup for easy access
            $create_month_day_event_popup.attr('data-date', this_date);
            //Add the event_id to the inspect_event_popup for easy access
            $create_month_day_event_popup.attr('data-start_time', this_time);
            $create_month_day_event_popup.attr('data-end_time', end_time);

            if(!$create_month_day_event_popup.is(":visible")){
                if((event.pageY - 180) <= 0){
                    $create_month_day_event_popup.css('top', event.pageY + 15);
                }else{
                    $create_month_day_event_popup.css('top', event.pageY - 180);
                }
                $create_month_day_event_popup.css('left', event.pageX - 160);

//            Mon, January 5, 4:30pm – 5:30pm
                var inspect_event_text = format_event_date_text(this_date_obj) + ' ' + date_to_am_pm_string(new Date(this_date + ' ' + this_time)) + ' - ' + date_to_am_pm_string(new Date(this_date + ' ' + end_time));
                $create_month_day_event_popup.find('#create_month_day_event_when').text('When: ' + inspect_event_text);


                $create_month_day_event_popup.addClass('active');

                //Focus the input field
                $('#create_month_day_event_input').focus();
            }else{
                if(this_date != last_month_day_date_selected){
                    //We clicked a different event than the event we were already looking at
                    //switch the inspect_event_popup to this event
                    if((event.pageY - 180) <= 0){
                        $create_month_day_event_popup.css('top', event.pageY + 15);
                    }else{
                        $create_month_day_event_popup.css('top', event.pageY - 180);
                    }
                    $create_month_day_event_popup.css('left', event.pageX - 160);

                    var inspect_event_text = format_event_date_text(this_date_obj) + ' ' + date_to_am_pm_string(new Date(this_date + ' ' + this_time)) + ' - ' + date_to_am_pm_string(new Date(this_date + ' ' + end_time));
                    $create_month_day_event_popup.find('#create_month_day_event_when').text('When: ' + inspect_event_text);

                }else{
                    $create_month_day_event_popup.removeClass('active');

                }
            }

            last_month_day_date_selected = this_date;
        });



        $(document).on('click','.popup_exit_button',function(){
            event.stopPropagation();
            $(this).closest('.popup').removeClass('active');
        });


        $(document).on('submit','#create_month_day_event_form',function(e){
            e.stopPropagation();
            var $form = $(this);
            var $create_month_day_event_popup = $form.closest('#create_month_day_event_popup');
            e.preventDefault();

            var post_url = base_url + $form.attr('action');
            var event_input_string = $('#create_month_day_event_input').val();


            if(event_input_string.length == 0){
                alert('please input an event');
                return;
            }




            var event_name = event_input_string;

            var event_start_date = $create_month_day_event_popup.attr('data-date');
            var event_start_time = $create_month_day_event_popup.attr('data-start_time');

            var event_end_date = event_start_date;
            var event_end_time = $create_month_day_event_popup.attr('data-end_time');


            var event_origin_type = '';
            var event_origin_id = '';

            var event_category = 'personal';

            var event_location = '';
            var event_description = '';


            var event_todo = false;
            var event_all_day = true;


            var post_data = {
                event:{
                    event_name: event_name,
                    origin_type: event_origin_type,
                    origin_id: event_origin_id,
                    event_type: event_category,
                    title: event_name,
                    description: event_description,
                    start_time: event_start_time,
                    end_time: event_end_time,
                    start_date: event_start_date,
                    end_date: event_end_date,
                    location: event_location,
                    event_todo: event_todo,
                    event_all_day: event_all_day
                }
            };

            console.log(post_data);

            $.post(
                post_url,
                post_data,
                function(response) {
                    if(response['success']){
                        //reset the input field
                        $('#create_month_day_event_input').val('');
                        //Hide the create event popup
                        $create_month_day_event_popup.removeClass('active');
                        //Show the created event
                        show_week_day_event(response['event']);
                    }else{
                        alert(JSON.stringify(response));
                    }
                }, 'json'
            );

        });

        function show_week_day_event(event_json){
            //Normally source would be $("#group_template").html(); but for whatever reason
            //angular doesnt let jquery select the handlebars template if it is in the html
            var source = '<div class="grid-event" data-id="{{event_id}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}"><div class="event_start_time">{{formatted_start_time}}</div><div class="event_name">{{title}}</div></div>';
            var template = Handlebars.compile(source);

            event_json['formatted_start_time'] = date_to_am_pm_string(new Date(event_json['start_time'] + '00:00:00'));


            var generated_html = template(event_json);


            var grid_item_selector = ele.querySelector("div.grid-item[data-date='" + event_json['start_date'] + "'][data-time='" + event_json['start_time'] + "']");
            if(grid_item_selector){
                grid_item_selector.innerHTML += generated_html;
            }else{
                console.log("ERROR ADDING EVENT");
                console.log(event_json);
            }


        }
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
                var this_ele = ele[i];
                var this_grid = new Grid(this_ele, d);


                grid.push(this_grid);
            }
        } else {
            grid = new Grid(ele, date);
        }

        return grid;
    };

    return WeekGrid;
}(WeekGrid || {}));

//Converts date object into date string of SQl format like this:
// 2014-06-02
function date_to_string(date){
    return date.getFullYear() + '-' + addZero((date.getMonth() + 1)) + '-' + addZero(date.getDate());
}

function addZero(i) {
    if (i < 10 && i !== '00') {
        i = "0" + i;
    }
    return i;
}

//returns a formatted sql time string
//input 5
//return 05:00:00
//Which is 5am
function ints_to_time(hours_int,minutes_int,seconds_int){
    return addZero(hours_int) + ":" + addZero(minutes_int) + ":" + addZero(seconds_int);
}


//Takes in datetime object returns string
//returns either 12:30pm or
//4pm
function date_to_am_pm_string(datetime_obj){
    var hours = datetime_obj.getHours();
    var am_pm = 'am';

    if(hours >= 12){
        am_pm = 'pm';
        if(hours > 12){
            hours -= 12;
        }
    }else if(hours == 0){
        //If its 12am, hours will be 0
        //so set it so 12
        hours = 12;
    }

    var minutes = datetime_obj.getMinutes();
    if(minutes > 0){
        return hours.toString() + ':' + addZero(minutes) + am_pm;
    }else{
        return hours.toString() + am_pm;
    }

}

var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";

function format_event_date_text(date_obj){
    return weekday[date_obj.getDay()].substring(0, 3) + ' ' + (date_obj.getMonth() + 1).toString() + '/' + (date_obj.getDate()).toString();
}