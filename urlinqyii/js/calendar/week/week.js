
jQuery(document).ready(function(){








    last_month_day_date_selected = null;

    jQuery(document).on('click', '.grid-item', function(event){
        jQuery(".popup_create_event_name_input").focus();

        //Hide the other popup
        hide_inspect();

        event.stopPropagation();
        var $day_time_div = jQuery(this);
        var this_date = $day_time_div.attr('data-date');
        var this_date_obj = local_to_utc(new_date(this_date));
        var this_time = $day_time_div.attr('data-time');
        var this_time_int = parseInt($day_time_div.attr('data-time_num'));
        var $create_week_day_event_popup = jQuery('#create_week_day_event_popup');
        

        var end_time;
        if(this_time!="23:00:00")
            end_time = ints_to_time(this_time_int + 1,0,0);
        else end_time = ints_to_time(this_time_int + 0,59,0);

        //FOR X POSITION CHECKING IN COMPARISON TO WINDOW WIDTH //

        var $window = $(window);
        var windowsize = $window.width();
        var click_x_difference = event.pageX;
        //Add the event_id to the inspect_event_popup_week for easy access
        $create_week_day_event_popup.attr('data-date', this_date);
        //Add the event_id to the inspect_event_popup_week for easy access
        $create_week_day_event_popup.attr('data-start_time', this_time);
        $create_week_day_event_popup.attr('data-end_time', end_time);
        if(!$create_week_day_event_popup.is(":visible")){
            if(event.pageY <= 300){
                $create_week_day_event_popup.css('top', event.pageY + 15);
                jQuery($create_week_day_event_popup).addClass("top_position");
                if(click_x_difference <= 187){
                    $create_week_day_event_popup.css('right', event.pageX - 328.5);
                    $create_week_day_event_popup.css('left', 0);
                    jQuery($create_week_day_event_popup).addClass("right_position");
                }
                else{
                    $create_week_day_event_popup.css('left', event.pageX - 182.5);
                    jQuery($create_week_day_event_popup).removeClass("right_position");
                }
            }else{
                $create_week_day_event_popup.css('top', event.pageY - 230);
                jQuery($create_week_day_event_popup).removeClass("top_position");
                if(click_x_difference <= 187){
                    $create_week_day_event_popup.css('right', event.pageX - 328.5);
                    $create_week_day_event_popup.css('left', 0);
                    jQuery($create_week_day_event_popup).addClass("right_position");
                }
                else{
                    $create_week_day_event_popup.css('left', event.pageX - 182.5);
                    jQuery($create_week_day_event_popup).removeClass("right_position");
                }

            }
            

    //            Mon, January 5, 4:30pm – 5:30pm
            var inspect_event_text = '';
            if(this_time == '0-1:00:00'){
                inspect_event_text = format_event_date_text(this_date_obj) + ' All day';
            }else{
                inspect_event_text = format_event_date_text(this_date_obj) + ' ' + date_to_am_pm_string(new_datetime(this_date + ' ' + this_time)) + ' - ' + date_to_am_pm_string(new_datetime(this_date + ' ' + end_time));
            }


            $create_week_day_event_popup.find('#create_week_day_event_when').text(inspect_event_text);


            $create_week_day_event_popup.addClass('active');
            jQuery('#create_week_day_event_input').focus();
            //Focus the input field
            
        }else{
            if(this_date != last_month_day_date_selected){
                //We clicked a different event than the event we were already looking at
                //switch the inspect_event_popup_week to this event
                if(event.pageY <= 300){
                    $create_week_day_event_popup.css('top', event.pageY + 15);
                    jQuery($create_week_day_event_popup).addClass("top_position");
                    if(click_x_difference <= 187){
                        $create_week_day_event_popup.css('right', event.pageX - 328.5);
                        $create_week_day_event_popup.css('left', 0);
                        jQuery($create_week_day_event_popup).addClass("right_position");
                    }
                    else{
                        $create_week_day_event_popup.css('left', event.pageX - 182.5);
                        jQuery($create_week_day_event_popup).removeClass("right_position");
                    }
                }else{
                    $create_week_day_event_popup.css('top', event.pageY - 230);
                    jQuery($create_week_day_event_popup).removeClass("top_position");
                    if(click_x_difference <= 187){
                        $create_week_day_event_popup.css('right', event.pageX - 328.5);
                        $create_week_day_event_popup.css('left', 0);
                        jQuery($create_week_day_event_popup).addClass("right_position");
                    }
                    else{
                        $create_week_day_event_popup.css('left', event.pageX - 182.5);
                        jQuery($create_week_day_event_popup).removeClass("right_position");
                    }

                }


                var inspect_event_text = '';
                if(this_time == '0-1:00:00'){
                    inspect_event_text = format_event_date_text(this_date_obj) + ' All day';
                }else{
                    inspect_event_text = format_event_date_text(this_date_obj) + ' ' + date_to_am_pm_string(new_datetime(this_date + ' ' + this_time)) + ' - ' + date_to_am_pm_string(new_datetime(this_date + ' ' + end_time));
                }
                $create_week_day_event_popup.find('#create_week_day_event_when').text(inspect_event_text);

            }else{
                $create_week_day_event_popup.removeClass('active');

            }
        }

        last_month_day_date_selected = this_date;
    });






    jQuery(document).on('submit','#create_week_day_event_form',function(e){
        e.stopPropagation();
        var $form = jQuery(this);
        var $create_week_day_event_popup = $form.closest('#create_week_day_event_popup');
        e.preventDefault();

        var post_url = base_url + $form.attr('action');
        var event_input_string = jQuery('#create_week_day_event_input').val();


        if(event_input_string.length == 0){
            alert('please input an event');
            return;
        }


        var event_id = '';

        var event_name = event_input_string;

        var event_start_date = $create_week_day_event_popup.attr('data-date');
        var event_start_time = $create_week_day_event_popup.attr('data-start_time');





        var event_end_date = event_start_date;
        var event_end_time = $create_week_day_event_popup.attr('data-end_time');


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

                    //alert(JSON.stringify(response));
                    //reset the input field
                    jQuery('#create_week_day_event_input').val('');
                    //Hide the create event popup
                    $create_week_day_event_popup.removeClass('active');
                    //Show the created event
                    show_week_day_event(response['event']);
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );

    });













    jQuery(document).on('click','#inspect_event_delete_button_week',function(event){
        event.stopPropagation();
        var $inspect_event_popup_week = jQuery('#inspect_event_popup_week');
        var event_id = last_clicked_event_id;

        var post_url = base_url + '/event/' + event_id + '/delete';


        var post_data = {event_id: event_id};
        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    $inspect_event_popup_week.removeClass('active');
                    jQuery('.grid-event.event_holder[data-id="' + last_clicked_event_id + '"]').remove();
                    //alert('successfully deleted event: ' + event_id);
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );
    });


});