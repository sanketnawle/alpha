jQuery(document).ready(function(){


    $( window ).resize(function() {
        recalculate_event_positions();
    });


    function recalculate_event_positions(){
        $('.day_grid_item').each(function(index, day_grid_item){
            var $day_grid_item = $(day_grid_item);
            //Start 50 pixels from the left since there is padding on the day grid
            //Leave 15 pixels on the right so new events can be created
            var left_pixels = 50;

            var width = $day_grid_item.width() - 15;

            //check if other events are within this time range
            var $this_day_time_events = $day_grid_item.find('.day_event_holder');
            if($this_day_time_events.length){
                //100 / 3 elements = 33% each
                width /= $this_day_time_events.length;

                //Loop through each event and change the styling
                jQuery.each($this_day_time_events, function(index,$day_time_event){
                    $($day_time_event).css({'width': width.toString() + 'px'});
                    $($day_time_event).css({'left': left_pixels + 'px'});
                    left_pixels += width;
                });
            }
        });
    }


    last_clicked_event_id = null;




    last_month_day_date_selected = null;
    jQuery(document).on('click', '.day_grid_item', function(event){

        //Hide the other popup
        jQuery('#inspect_event_popup_day').removeClass('active');

        event.stopPropagation();
        var $day_div = jQuery(this);
        var this_date = $day_div.attr('data-date');
        var this_date_obj = new Date(this_date);
        var this_time = $day_div.attr('data-time');
        var this_time_int = parseInt($day_div.attr('data-time_num'));

        var end_time = ints_to_time(this_time_int + 1,0,0);
        var $create_day_event_popup = jQuery('#create_day_event_popup');

        //Add the event_id to the inspect_event_popup_month for easy access
        //Add the event_id to the inspect_event_popup_week for easy access
        $create_day_event_popup.attr('data-date', this_date);
        //Add the event_id to the inspect_event_popup_week for easy access
        $create_day_event_popup.attr('data-start_time', this_time);
        $create_day_event_popup.attr('data-end_time', end_time);



        if(!$create_day_event_popup.is(":visible")){
            if((event.pageY - 180) <= 0){
                $create_day_event_popup.css('top', event.pageY + 15);
            }else{
                $create_day_event_popup.css('top', event.pageY - 180);
            }
            $create_day_event_popup.css('left', event.pageX - 160);


            var inspect_event_text = format_event_date_text(this_date_obj) + " " +  date_to_am_pm_string(new Date(this_date + ' ' + this_time)) + ' - ' + date_to_am_pm_string(new Date(this_date + ' ' + end_time));
            $create_day_event_popup.find('#create_day_event_when').text('When: ' + inspect_event_text);


            $create_day_event_popup.addClass('active');

            //Focus the input field
            jQuery('#create_day_event_input').focus();
        }else{
            if(this_date != last_month_day_date_selected){
                //We clicked a different event than the event we were already looking at
                //switch the inspect_event_popup_month to this event
                if((event.pageY - 180) <= 0){
                    $create_day_event_popup.css('top', event.pageY + 15);
                }else{
                    $create_day_event_popup.css('top', event.pageY - 180);
                }
                $create_day_event_popup.css('left', event.pageX - 160);

                var inspect_event_text = format_event_date_text(this_date_obj);
                $create_day_event_popup.find('#create_day_event_when').text('When: ' + inspect_event_text);

            }else{
                $create_day_event_popup.removeClass('active');

            }
        }

        last_month_day_date_selected = this_date;
    });











    jQuery(document).on('click', '.day_event_holder', function(event){
        event.stopPropagation();
        //Hide the other popup
        jQuery('#create_day_event_popup').removeClass('active');

        var $month_day_event_div = jQuery(this);
        var event_id = $month_day_event_div.attr('data-id');
        var $inspect_event_popup_month = jQuery('#inspect_event_popup_day');

        //Add the event_id to the inspect_event_popup_month for easy access
        $inspect_event_popup_month.attr('data-event_id', event_id);


        if(!$inspect_event_popup_month.is(":visible")){
            if((event.pageY - 180) <= 0){
                $inspect_event_popup_month.css('top', event.pageY + 15);
            }else{
                $inspect_event_popup_month.css('top', event.pageY - 180);
            }
            $inspect_event_popup_month.css('left', event.pageX - 140);

            //            Mon, October 27, 2014, 8am – 11am
            var this_date = new Date($month_day_event_div.closest('.day_grid_item').attr('data-date') + ' 00:00:00');
            var start_time = $month_day_event_div.attr('data-time');
            var inspect_event_text = format_event_date_text(this_date);
            $inspect_event_popup_month.find('#inspect_event_text').text(inspect_event_text);
            $inspect_event_popup_month.find('#inspect_event_description').text($month_day_event_div.attr('data-description'));

            $inspect_event_popup_month.addClass('active');
        }else{
            if($month_day_event_div.attr('data-id') != last_clicked_event_id){
                //We clicked a different event than the event we were already looking at
                //switch the inspect_event_popup_month to this event
                if((event.pageY - 180) <= 0){
                    $inspect_event_popup_month.css('top', event.pageY + 15);
                }else{
                    $inspect_event_popup_month.css('top', event.pageY - 180);
                }



                $inspect_event_popup_month.css('left', event.pageX - 140);


                //            Mon, October 27, 2014, 8am – 11am
                var this_date = new Date($month_day_event_div.closest('.day_grid_item').attr('data-date') + ' 00:00:00');
                var start_time = $month_day_event_div.attr('data-time');
                var inspect_event_text = format_event_date_text(this_date);
                $inspect_event_popup_month.find('#inspect_event_text').text(inspect_event_text);
                $inspect_event_popup_month.find('#inspect_event_description').text($month_day_event_div.attr('data-description'));


            }else{
                $inspect_event_popup_month.removeClass('active');
            }
        }

        last_clicked_event_id = $month_day_event_div.attr('data-id');
    });


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


    jQuery(document).on('submit','#create_day_event_form',function(e){
        e.stopPropagation();
        var $form = jQuery(this);
        var $create_day_event_popup = $form.closest('#create_day_event_popup');
        e.preventDefault();

        var post_url = base_url + $form.attr('action');
        var event_input_string = jQuery('#create_day_event_input').val();


        if(event_input_string.length == 0){
            alert('please input an event');
            return;
        }




        var event_name = event_input_string;

        var event_start_date = $create_day_event_popup.attr('data-date');
        var event_start_time = $create_day_event_popup.attr('data-start_time');

        var event_end_date = event_start_date;


        var event_end_time = $create_day_event_popup.attr('data-end_time');


        var event_origin_type = '';
        var event_origin_id = '';

        var event_category = 'personal';

        var event_location = '';
        var event_description = '';


        var event_todo = false;

        var event_all_day = false;


        if(event_end_date == '0-1:00:00'){
            event_all_day = true;
        }



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
                all_day: event_all_day
            }
        };

        console.log(post_data);

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    //reset the input field
                    jQuery('#create_day_event_input').val('');
                    //Hide the create event popup
                    $create_day_event_popup.removeClass('active');
                    //Show the created event
                    show_day_event(response['event']);
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );

    });


    jQuery(document).on('click','#inspect_event_delete_button_day',function(event){
        //alert('day');
        event.stopPropagation();
        var $inspect_event_popup_day = jQuery('#inspect_event_popup_day');
        var event_id = last_clicked_event_id;

        var post_url = base_url + '/event/' + event_id + '/delete';


        var post_data = {event_id: event_id};
        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    $inspect_event_popup_day.removeClass('active');
                    jQuery('.day_event_holder[data-id="' + last_clicked_event_id + '"]').remove();
                    //alert('successfully deleted event: ' + event_id);
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );
    });



});





//returns a formatted sql time string
//input 5
//return 05:00:00
//Which is 5am
function ints_to_time(hours_int,minutes_int,seconds_int){
    return addZero(hours_int) + ":" + addZero(minutes_int) + ":" + addZero(seconds_int);
}

function addZero(i) {
    if (i < 10 && i !== '00') {
        i = "0" + i;
    }
    return i;
}