jQuery(document).ready(function(){
    last_clicked_event_id = null;



    jQuery(document).on('click', '.event_holder', function(event){
        event.stopPropagation();


        var $event_div = jQuery(this);
        var event_id = $event_div.attr('data-id');

        console.log('inspect event: ' + event_id);


        var $inspect_event_popup = jQuery('.inspect_event_popup');

        //Add the event_id to the inspect_event_popup_week for easy access
        $inspect_event_popup.attr('data-event_id', event_id);


        if(!$inspect_event_popup.is(":visible")){
            if((event.pageY - 180) <= 0){
                $inspect_event_popup.css('top', event.pageY + 15);
            }else{
                $inspect_event_popup.css('top', event.pageY - 180);
            }
            $inspect_event_popup.css('left', event.pageX - 140);

            //            Mon, October 27, 2014, 8am – 11am
            var this_date = new Date($event_div.parent().attr('data-date') + ' 00:00:00');
            var start_time = $event_div.attr('data-start_time');
            var inspect_event_text = format_event_date_text(this_date);
            $inspect_event_popup.find('#inspect_event_text').text(inspect_event_text);
            $inspect_event_popup.find('#inspect_event_description').text($event_div.attr('data-description'));

            $inspect_event_popup.addClass('active');
        }else{
            if($event_div.attr('data-id') != last_clicked_event_id){
                //We clicked a different event than the event we were already looking at
                //switch the inspect_event_popup_week to this event
                if((event.pageY - 180) <= 0){
                    $inspect_event_popup.css('top', event.pageY + 15);
                }else{
                    $inspect_event_popup.css('top', event.pageY - 180);
                }



                $inspect_event_popup.css('left', event.pageX - 140);


                //            Mon, October 27, 2014, 8am – 11am
                var this_date = new Date($event_div.parent().attr('data-date') + ' 00:00:00');
                var start_time = $event_div.attr('data-start_time');
                var inspect_event_text = format_event_date_text(this_date);
                $inspect_event_popup.find('#inspect_event_text').text(inspect_event_text);
                $inspect_event_popup.find('#inspect_event_description').text($event_div.attr('data-description'));


            }else{
                $inspect_event_popup.removeClass('active');
            }
        }

        last_clicked_event_id = $event_div.attr('data-id');
    });



    jQuery(document).on('click','.popup_edit_button', function(){
        var $this_popup_button = jQuery(this);
        var $inspect_event_popup = $this_popup_button.closest('.inspect_event_popup');
        //Hide the popup
        $inspect_event_popup.removeClass('active');



        //Get the event id from this popup
        var event_id = $inspect_event_popup.attr('data-event_id');

        //Get the event div that has this event id
        var $event_holder = jQuery('.event_holder[data-id="' + event_id + '"]');

        var event_name = $event_holder.attr('data-name');



        var event_start_time_string = $event_holder.attr('data-start_time');
        var event_end_time_string = $event_holder.attr('data-end_time');
        var event_start_date_string = $event_holder.attr('data-start_date');
        var event_end_date_string = $event_holder.attr('data-end_date');
        var event_origin_type = $event_holder.attr('data-origin_type');
        var event_origin_id = $event_holder.attr('data-origin_id');
        var event_type = $event_holder.attr('data-event_type');
        var event_location = $event_holder.attr('data-location');


        //Check if this click comes from a create event form
        var $create_event_popup = $('.create_event_popup');
        if($create_event_popup.hasClass('active')){
            $create_event_popup.removeClass('active');
            event_name = $create_event_popup.find('.popup_create_event_name_input').val();


            event_start_date_string = $create_event_popup.attr('data-date');
            event_end_date_string = event_start_date_string;


            event_start_time_string = $create_event_popup.attr('data-start_time');
            event_end_time_string = $create_event_popup.attr('data-end_time');


            if(event_start_time_string == null || event_end_time_string == null){
                var datetime_obj = new Date();
                event_start_time_string = ints_to_time(datetime_obj.getHours(),datetime_obj.getMinutes(),datetime_obj.getSeconds())
                event_end_time_string = ints_to_time(datetime_obj.getHours() + 1,datetime_obj.getMinutes(),datetime_obj.getSeconds())
            }
        }


        //Get the create event dialog
        var $dialog = jQuery('#dialog');


        jQuery('#create_event_name_input').val(event_name);
        jQuery('#event_location_input').val(event_location);



        jQuery('#create_event_start_date_input').val(date_string_to_day_of_week_string(event_start_date_string));
        jQuery('#create_event_start_date_input').attr('data-date',event_start_date_string);
        jQuery('#create_event_end_date_input').val(date_string_to_day_of_week_string(event_end_date_string));
        jQuery('#create_event_end_date_input').attr('data-date',event_end_date_string);

        jQuery('#create_event_start_time_input').val(time_string_to_am_pm_string(event_start_time_string));
        jQuery('#create_event_start_time_input').attr('data-time', event_start_time_string);
        jQuery('#create_event_end_time_input').val(time_string_to_am_pm_string(event_end_time_string));
        jQuery('#create_event_end_time_input').attr('data-time', event_end_time_string);



        //Get the create event form element
        var $create_event_form = jQuery('#create_event_form');
        //Change the event form action to update instead of create
        $create_event_form.attr("action", "/event/update");
        //add the event id to the form so its easy to pull off during the post request
        $create_event_form.attr('data-event_id', event_id);

        $create_event_form.find('#create_event_submit_button').val('UPDATE');

        //Check if there is an element with this origin type and id
        var $this_origin_type = jQuery('.group[data-group_type="' + event_origin_type + '"][data-id="' + event_origin_id + '"]');
        if($this_origin_type.length){
            $this_origin_type.addClass('selected');
        }


        //Check if there is an element with this origin type and id
        var $this_category = jQuery('.category[data-category="' + event_type + '"]');
        if($this_category.length){
            $this_category.addClass('selected');
        }


        //show the create event dialog
        $dialog.show();

    });



    jQuery(document).on('click','.popup_exit_button',function(){
        event.stopPropagation();
        //Clear the text from the event create
        try{
            jQuery(this).closest('.popup').find('.popup_create_event_name_input').val('');
        }catch(err){
        }
        jQuery(this).closest('.popup').removeClass('active');
    });

});