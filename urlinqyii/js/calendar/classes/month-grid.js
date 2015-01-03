/// <reference path="../lib/jquery.js" />
/// <reference path="../helpers/date.js" />
/// <reference path="event-target.js" />

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
                    var event = new Div("grid-event");
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

                }
            },
            ele: { value: grid },
            populate: {
                value: function () {
                    var premature = false;
                    var prem_plus = false;
                    var start = dp.getDate(month, year, false).getDay();
                    var end = dp.getDate(month, year, true).getDate();
                    handle_month_events(this.ele);
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
            items: { get: function () { return getGridItems(this.children); } },
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


    function handle_month_events(ele){

        var date_str = new Date();
        date_str = date_to_string(date_str);
        get_month_events(date_str);

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

        function show_month_event(event_json){
            //Normally source would be $("#group_template").html(); but for whatever reason
            //angular doesnt let jquery select the handlebars template if it is in the html
            var source = '<div class="month_day_event" data-id="{{event_id}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}"><div class="event_start_time">{{formatted_start_time}}</div><div class="event_name">{{title}}</div></div>';
            var template = Handlebars.compile(source);

            event_json['formatted_start_time'] = date_to_am_pm_string(new Date(event_json['start_time'] + '00:00:00'));


            var generated_html = template(event_json);
            var grid_item_selector = ele.querySelector("div.grid-item.prem[data-date='" + event_json['start_date'] + "']");
            if(grid_item_selector){
                grid_item_selector.innerHTML += generated_html;
            }else{
                console.log("ERROR ADDING EVENT");
                console.log(event_json);
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

        last_clicked_event_id = null;

        $(document).on('click', '.month_day_event', function(event){
            event.stopPropagation();
            //Hide the other popup
            $('#create_month_day_event_popup').removeClass('active');

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


        $(document).on('click','.popup_exit_button',function(){
            event.stopPropagation();
            $(this).closest('.popup').removeClass('active');
        });


        $(document).on('click','#inspect_event_delete_button',function(){
            event.stopPropagation();
            var $inspect_event_popup = $('#inspect_event_popup');
            var event_id = last_clicked_event_id;

            var post_url = base_url + '/event/' + event_id + '/delete';


            var post_data = {event_id: event_id};
            $.post(
                post_url,
                post_data,
                function(response) {
                    if(response['success']){
                        $inspect_event_popup.removeClass('active');
                        $('.month_day_event[data-id="' + last_clicked_event_id + '"]').remove();
                        alert('successfully deleted event: ' + event_id);
                    }else{
                        alert(JSON.stringify(response));
                    }
                }, 'json'
            );
        });


        last_month_day_date_selected = null;
        $(document).on('click', '.grid-item.prem', function(event){
            //Hide the other popup
            $('#inspect_event_popup').removeClass('active');

            event.stopPropagation();
            var $day_div = $(this);
            var this_date = $day_div.attr('data-date');
            var this_date_obj = new Date(this_date);
            var $create_month_day_event_popup = $('#create_month_day_event_popup');

            //Add the event_id to the inspect_event_popup for easy access
            $create_month_day_event_popup.attr('data-date', this_date);


            if(!$create_month_day_event_popup.is(":visible")){
                if((event.pageY - 180) <= 0){
                    $create_month_day_event_popup.css('top', event.pageY + 15);
                }else{
                    $create_month_day_event_popup.css('top', event.pageY - 180);
                }
                $create_month_day_event_popup.css('left', event.pageX - 160);


                var inspect_event_text = format_event_date_text(this_date_obj);
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

                    var inspect_event_text = format_event_date_text(this_date_obj);
                    $create_month_day_event_popup.find('#create_month_day_event_when').text('When: ' + inspect_event_text);

                }else{
                    $create_month_day_event_popup.removeClass('active');

                }
            }

            last_month_day_date_selected = this_date;
        });


        function format_event_date_text(date_obj){
            return weekday[date_obj.getDay()].substring(0, 3) + ' ' + (date_obj.getMonth() + 1).toString() + '/' + (date_obj.getDate()).toString();
        }


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

            //Seaches for a string like 1pm or 12:20am
            //We are assuming the first time like string is the start time of this event
            var match = /([1-9]|1[0-2])((pm|am)|(:[0-9][0-9](pm|am)))/g.exec(event_input_string);
            var event_start_time = '00:00:00';


            if(match){
                event_start_time = match[0];

                //remove the event_start_time from the event_input_string
                event_input_string = event_input_string.replace(event_start_time,'');
                if(event_input_string.charAt(0) == ' '){
                    event_input_string.substring(1,event_input_string.length);
                }

                //Check if this time is just an hour with am or pm
                //like 9am or 12pm
                var regex_match = event_start_time.match(/([1-9]|1[0-2])(pm|am)/g);
                if(regex_match){
                    event_start_time = match[0];
                    am_pm = event_start_time.substring(event_start_time.length - 2,event_start_time.length);
                    hours = parseInt(event_start_time.substring(0,event_start_time.length - 2));


                    if(hours < 12 && am_pm == 'pm'){
                        hours += 12;
                    }else if(hours == 12 && am_pm == 'am'){
                        hours = 0;
                    }

                    //The start time is now in SQL time format
                    // 00:00:00
                    event_start_time = addZero(hours) + ':00:00';
                }


                //Check if this time looks like
                // 12:00pm or 1:30am
                var regex_match = event_start_time.match(/([1-9]|1[0-2]):[0-9][0-9](pm|am)/g);
                if(regex_match){
                    event_start_time = match[0];
                    var res = event_start_time.split(":");
                    var hours = parseInt(res[0]);
                    var minutes = res[1].substring(0,2);
                    var am_pm = res[1].substring(2,res[1].length);

                    if(hours < 12 && am_pm == 'pm'){
                        hours += 12;
                    }else if(hours == 12 && am_pm == 'am'){
                        hours = 0;
                    }


                    //The start time is now in SQL time format
                    // 00:00:00
                    event_start_time = addZero(hours) + ':' + addZero(minutes) + ':00';
                }
            }


            var event_name = event_input_string;

            var event_start_date = $create_month_day_event_popup.attr('data-date');

            var event_end_date = event_start_date;
            var event_end_time  = event_start_time;


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
                        show_month_event(response['event']);
                    }else{
                        alert(JSON.stringify(response));
                    }
                }, 'json'
            );

        });

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

    //Converts date object into date string of SQl format like this:
    // 2014-06-02
    function date_to_string(date){
        return date.getFullYear() + '-' + addZero((date.getMonth() + 1)) + '-' + addZero(date.getDate());
    }


    function addZero(i) {
        if (i < 10 && i != '00') {
            i = "0" + i;
        }
        return i;
    }





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

        return grid;
    };




    return MonthGrid;
}(MonthGrid || {}));









//function handle_day_events(ele){
//
//    var date_str = new Date();
//    date_str = date_str.getFullYear() + '-' + addZero((date_str.getMonth() + 1)) + '-' + addZero(date_str.getDate());
//    get_day_events(date_str);
//
//    function get_day_events(date_str){
//
//        $.getJSON( base_url + '/event/getEvents', {date: date_str},function( json_data ) {
//            if(json_data['success']){
//                show_day_events(json_data['events']);
//            }else{
//                alert('error getting planner events');
//            }
//        });
//    }
//
//
//    function show_day_events(events_json){
//        $.each(events_json,function(index, event_json){
//            show_day_event(event_json);
//        });
//    }
//
//    function show_day_event(event_json){
//        //Normally source would be $("#group_template").html(); but for whatever reason
//        //angular doesnt let jquery select the handlebars template if it is in the html
//        var source = '<div class="day_event" data-group_type="{{group_type}}" data-id="{{id}}"><div class="group_name">TEST EVENT</div></div>';
//        var template = Handlebars.compile(source);
//        var generated_html = template(event_json);
//        ele.querySelector('.grid-item.td.prem.tl').innerHTML += generated_html;
//    }
//
//}
//
//
//function addZero(i) {
//    if (i < 10) {
//        i = "0" + i;
//    }
//    return i;
//}



