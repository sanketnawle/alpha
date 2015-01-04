
jQuery(document).ready(function(){


    last_clicked_event_id = null;
    jQuery(document).on('click', '.grid-event', function(event){
        event.stopPropagation();


        var $month_day_event_div = jQuery(this);
        var event_id = $month_day_event_div.attr('id');
        var $inspect_event_popup_week = jQuery('#inspect_event_popup_week_week');

        //Add the event_id to the inspect_event_popup_week for easy access
        $inspect_event_popup_week.attr('data-event_id', event_id);


        if(!$inspect_event_popup_week.is(":visible")){
            if((event.pageY - 180) <= 0){
                $inspect_event_popup_week.css('top', event.pageY + 15);
            }else{
                $inspect_event_popup_week.css('top', event.pageY - 180);
            }
            $inspect_event_popup_week.css('left', event.pageX - 140);

    //            Mon, October 27, 2014, 8am – 11am
            var this_date = new Date($month_day_event_div.closest('.grid-item').attr('data-date') + ' 00:00:00');
            var start_time = $month_day_event_div.attr('data-start_time');
            var inspect_event_text = format_event_date_text(this_date);
            $inspect_event_popup_week.find('#inspect_event_text').text(inspect_event_text);
            $inspect_event_popup_week.find('#inspect_event_description').text($month_day_event_div.attr('data-description'));

            $inspect_event_popup_week.addClass('active');
        }else{
            if($month_day_event_div.attr('data-id') != last_clicked_event_id){
                //We clicked a different event than the event we were already looking at
                //switch the inspect_event_popup_week to this event
                if((event.pageY - 180) <= 0){
                    $inspect_event_popup_week.css('top', event.pageY + 15);
                }else{
                    $inspect_event_popup_week.css('top', event.pageY - 180);
                }



                $inspect_event_popup_week.css('left', event.pageX - 140);


                //            Mon, October 27, 2014, 8am – 11am
                var this_date = new Date($month_day_event_div.closest('.grid-item').attr('data-date') + ' 00:00:00');
                var start_time = $month_day_event_div.attr('data-start_time');
                var inspect_event_text = format_event_date_text(this_date);
                $inspect_event_popup_week.find('#inspect_event_text').text(inspect_event_text);
                $inspect_event_popup_week.find('#inspect_event_description').text($month_day_event_div.attr('data-description'));


            }else{
                $inspect_event_popup_week.removeClass('active');
            }
        }

        last_clicked_event_id = $month_day_event_div.attr('data-id');
    });


    last_month_day_date_selected = null;

    jQuery(document).on('click', '.grid-item', function(event){

        //Hide the other popup
        jQuery('#inspect_event_popup_week').removeClass('active');

        event.stopPropagation();
        var $day_time_div = jQuery(this);
        var this_date = $day_time_div.attr('data-date');
        var this_date_obj = new Date(this_date);
        var this_time = $day_time_div.attr('data-time');
        var this_time_int = parseInt($day_time_div.attr('data-time_num'));
        var $create_week_day_event_popup = jQuery('#create_week_day_event_popup');

        var end_time = ints_to_time(this_time_int + 1,0,0);

        //Add the event_id to the inspect_event_popup_week for easy access
        $create_week_day_event_popup.attr('data-date', this_date);
        //Add the event_id to the inspect_event_popup_week for easy access
        $create_week_day_event_popup.attr('data-start_time', this_time);
        $create_week_day_event_popup.attr('data-end_time', end_time);

        if(!$create_week_day_event_popup.is(":visible")){
            if((event.pageY - 180) <= 0){
                $create_week_day_event_popup.css('top', event.pageY + 15);
            }else{
                $create_week_day_event_popup.css('top', event.pageY - 180);
            }
            $create_week_day_event_popup.css('left', event.pageX - 160);

    //            Mon, January 5, 4:30pm – 5:30pm
            var inspect_event_text = format_event_date_text(this_date_obj) + ' ' + date_to_am_pm_string(new Date(this_date + ' ' + this_time)) + ' - ' + date_to_am_pm_string(new Date(this_date + ' ' + end_time));
            $create_week_day_event_popup.find('#create_week_day_event_when').text('When: ' + inspect_event_text);


            $create_week_day_event_popup.addClass('active');

            //Focus the input field
            jQuery('#create_week_day_event_input').focus();
        }else{
            if(this_date != last_month_day_date_selected){
                //We clicked a different event than the event we were already looking at
                //switch the inspect_event_popup_week to this event
                if((event.pageY - 180) <= 0){
                    $create_week_day_event_popup.css('top', event.pageY + 15);
                }else{
                    $create_week_day_event_popup.css('top', event.pageY - 180);
                }
                $create_week_day_event_popup.css('left', event.pageX - 160);

                var inspect_event_text = format_event_date_text(this_date_obj) + ' ' + date_to_am_pm_string(new Date(this_date + ' ' + this_time)) + ' - ' + date_to_am_pm_string(new Date(this_date + ' ' + end_time));
                $create_week_day_event_popup.find('#create_week_day_event_when').text('When: ' + inspect_event_text);

            }else{
                $create_week_day_event_popup.removeClass('active');

            }
        }

        last_month_day_date_selected = this_date;
    });



    jQuery(document).on('click','.popup_exit_button',function(){
        event.stopPropagation();
        jQuery(this).closest('.popup').removeClass('active');
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




    function show_week_day_event(event_json){


        //Normally source would be jQuery("#group_template").html(); but for whatever reason
        //angular doesnt let jquery select the handlebars template if it is in the html
        var source = '<div class="grid-event" data-id="{{event_id}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}"><div class="event_start_time">{{formatted_start_time}}</div><div class="event_name">{{title}}</div></div>';
        var template = Handlebars.compile(source);

        event_json['formatted_start_time'] = date_to_am_pm_string(new Date(event_json['start_time'] + '00:00:00'));


        var generated_html = template(event_json);

        //.clone()
    //            var grid_item_selector = ele.querySelector("div.grid-item[data-date='" + event_json['start_date'] + "'][data-time='" + event_json['start_time'] + "']");
        var grid_item_selector = jQuery("div.grid-item[data-date='" + event_json['start_date'] + "'][data-time='" + event_json['start_time'] + "']");

        if(grid_item_selector){
    //                grid_item_selector.innerHTML += generated_html;
            grid_item_selector.append(jQuery(generated_html).clone());
        }else{
            console.log("ERROR ADDING EVENT");
            console.log(event_json);
        }


    }

});