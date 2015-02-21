jQuery(document).ready(function(){
    var grid_number = (".grid-item").length;
    console.log(grid_number);



    
    var weekday = new Array(7);
    weekday[0]=  "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";

//    last_clicked_event_id = null;
//
//    jQuery(document).on('click', '.month_day_event', function(event){
//        event.stopPropagation();
//        //Hide the other popup
//        jQuery('#create_month_day_event_popup').removeClass('active');
//
//        var $month_day_event_div = jQuery(this);
//        var event_id = $month_day_event_div.attr('id');
//        var $inspect_event_popup_month = jQuery('#inspect_event_popup_month');
//
//        //Add the event_id to the inspect_event_popup_month for easy access
//        $inspect_event_popup_month.attr('data-event_id', event_id);
//
//
//        if(!$inspect_event_popup_month.is(":visible")){
//            if((event.pageY - 180) <= 0){
//                $inspect_event_popup_month.css('top', event.pageY + 15);
//            }else{
//                $inspect_event_popup_month.css('top', event.pageY - 180);
//            }
//            $inspect_event_popup_month.css('left', event.pageX - 140);
//
//            //            Mon, October 27, 2014, 8am – 11am
//            var this_date = new Date($month_day_event_div.closest('.grid-item').attr('data-date') + ' 00:00:00');
//            var start_time = $month_day_event_div.attr('data-start_time');
//            var inspect_event_text = format_event_date_text(this_date);
//            $inspect_event_popup_month.find('#inspect_event_text').text(inspect_event_text);
//            $inspect_event_popup_month.find('#inspect_event_description').text($month_day_event_div.attr('data-description'));
//
//            $inspect_event_popup_month.addClass('active');
//        }else{
//            if($month_day_event_div.attr('data-id') != last_clicked_event_id){
//                //We clicked a different event than the event we were already looking at
//                //switch the inspect_event_popup_month to this event
//                if((event.pageY - 180) <= 0){
//                    $inspect_event_popup_month.css('top', event.pageY + 15);
//                }else{
//                    $inspect_event_popup_month.css('top', event.pageY - 180);
//                }
//
//
//
//                $inspect_event_popup_month.css('left', event.pageX - 140);
//
//
//                //            Mon, October 27, 2014, 8am – 11am
//                var this_date = new Date($month_day_event_div.closest('.grid-item').attr('data-date') + ' 00:00:00');
//                var start_time = $month_day_event_div.attr('data-start_time');
//                var inspect_event_text = format_event_date_text(this_date);
//                $inspect_event_popup_month.find('#inspect_event_text').text(inspect_event_text);
//                $inspect_event_popup_month.find('#inspect_event_description').text($month_day_event_div.attr('data-description'));
//
//
//            }else{
//                $inspect_event_popup_month.removeClass('active');
//            }
//        }
//
//        last_clicked_event_id = $month_day_event_div.attr('data-id');
//    });





    jQuery(document).on('click','#inspect_event_delete_button_month',function(event){
        //alert('MONTH');

        event.stopPropagation();
        hide_inspect();
        var $inspect_event_popup_month = jQuery('#inspect_event_popup_month');
        var event_id = $inspect_event_popup_month.attr('data-event_id');



        var post_url = base_url + '/event/' + event_id + '/delete';


        var post_data = {event_id: event_id};
        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    $inspect_event_popup_month.removeClass('active');
                    jQuery('.month_day_event[data-id="' + last_clicked_event_id + '"]').remove();
                    //alert('successfully deleted event: ' + event_id);
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );
    });


    last_month_day_date_selected = null;
    jQuery(document).on('click', '.grid-item', function(event){
        jQuery(".popup_create_event_name_input").focus();
        hide_inspect();
        jQuery(".event_holder").removeClass("colorfied");
        //Hide the other popup
        jQuery('#inspect_event_popup_month').removeClass('active');
        jQuery('.grid-item').removeClass('making_event');
        event.stopPropagation();
        var $day_div = jQuery(this);
        jQuery($day_div).addClass("making_event");
        var this_date = $day_div.attr('data-date');

        var this_date_obj = local_to_utc(new_date(this_date));
        console.log(this_date_obj);
        var $create_month_day_event_popup = jQuery('#create_month_day_event_popup');

        var $window = $(window);
        var windowsize = $window.width();
        var click_x_difference = event.pageX;

        //Add the event_id to the inspect_event_popup_month for easy access
        $create_month_day_event_popup.attr('data-date', this_date);


        if(!$create_month_day_event_popup.is(":visible")){
            if(event.pageY <= 300){
                $create_month_day_event_popup.css('top', event.pageY + 15);
                jQuery($create_month_day_event_popup).addClass("top_position");
                if(click_x_difference <= 187){
                    $create_month_day_event_popup.css('right', event.pageX - 328.5);
                    $create_month_day_event_popup.css('left', 0);
                    jQuery($create_month_day_event_popup).addClass("right_position");
                }
                else{
                    $create_month_day_event_popup.css('left', event.pageX - 182.5);
                    jQuery($create_month_day_event_popup).removeClass("right_position");
                }
            }else{
                $create_month_day_event_popup.css('top', event.pageY - 230);
                jQuery($create_month_day_event_popup).removeClass("top_position");
                if(click_x_difference <= 187){
                    $create_month_day_event_popup.css('right', event.pageX - 328.5);
                    $create_month_day_event_popup.css('left', 0);
                    jQuery($create_month_day_event_popup).addClass("right_position");
                }
                else{
                    $create_month_day_event_popup.css('left', event.pageX - 182.5);
                    jQuery($create_month_day_event_popup).removeClass("right_position");
                }

            }


            var inspect_event_text = format_event_date_text(this_date_obj);
            $create_month_day_event_popup.find('#create_month_day_event_when').text(inspect_event_text);


            $create_month_day_event_popup.addClass('active');

            
        }else{
            if(this_date != last_month_day_date_selected){
                //We clicked a different event than the event we were already looking at
                //switch the inspect_event_popup_month to this event
                if(event.pageY <= 300){
                    $create_month_day_event_popup.css('top', event.pageY + 15);
                    jQuery($create_month_day_event_popup).addClass("top_position");
                    if(click_x_difference <= 187){
                        $create_month_day_event_popup.css('right', event.pageX - 328.5);
                        $create_month_day_event_popup.css('left', 0);
                        jQuery($create_month_day_event_popup).addClass("right_position");
                    }
                    else{
                        $create_month_day_event_popup.css('left', event.pageX - 182.5);
                        jQuery($create_month_day_event_popup).removeClass("right_position");
                    }
                }else{
                    $create_month_day_event_popup.css('top', event.pageY - 230);
                    jQuery($create_month_day_event_popup).removeClass("top_position");
                    if(click_x_difference <= 187){
                        $create_month_day_event_popup.css('right', event.pageX - 328.5);
                        $create_month_day_event_popup.css('left', 0);
                        jQuery($create_month_day_event_popup).addClass("right_position");
                    }
                    else{
                        $create_month_day_event_popup.css('left', event.pageX - 182.5);
                        jQuery($create_month_day_event_popup).removeClass("right_position");
                    }

                }

                var inspect_event_text = format_event_date_text(this_date_obj);
                $create_month_day_event_popup.find('#create_month_day_event_when').text(inspect_event_text);

            }else{
                $create_month_day_event_popup.removeClass('active');

            }
        }

        last_month_day_date_selected = this_date;
    });


    function format_event_date_text(date_obj){
        return weekday[date_obj.getDay()].substring(0, 3) + ' ' + (date_obj.getMonth() + 1).toString() + '/' + (date_obj.getDate()).toString();
    }


    jQuery(document).on('submit','#create_month_day_event_form',function(e){
        e.stopPropagation();
        jQuery('.grid-item').removeClass('making_event');
        var $form = jQuery(this);
        var $create_month_day_event_popup = $form.closest('#create_month_day_event_popup');
        e.preventDefault();

        var post_url = base_url + $form.attr('action');
        var event_input_string = jQuery('#create_month_day_event_input').val();


        if(event_input_string.length == 0){
            alert('please input an event');
            return;
        }

        //Only used for update event
        var event_id = '';

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
        var event_all_day = false;


        if(event_start_time == '0-1:00:00'){
            event_all_day = true;
        }



        //Convert to UTC for the database

        var event_start_datetime = local_to_utc(new_datetime(event_start_date + ' ' + event_start_time));
        var event_end_datetime = local_to_utc(new_datetime(event_end_date + ' ' + event_end_time));

        event_start_date = date_to_string(event_start_datetime);
        event_start_time = datetime_to_time_string(event_start_datetime);

        event_end_date = date_to_string(event_end_datetime);
        event_end_time = datetime_to_time_string(event_end_datetime);



        if(event_all_day){
            event_start_date = event_end_date;
            event_start_time = event_end_time;
        }

        var post_data = {
            event:{
                event_id: event_id,
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
                all_day: event_all_day
            }
        };



        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    //reset the input field
                    jQuery('#create_month_day_event_input').val('');
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

});
