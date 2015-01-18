function hexToRgb(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function hide_inspect(){
    jQuery('.inspect_event_popup').removeClass('active');

    jQuery('.event_holder').each(function(){
        var $event_holder = jQuery(this);
        var $holder_color_block = jQuery($event_holder).find(".white_bg_line_blocker");
        var event_holder_hex = $event_holder.attr("data-hex");
        var event_holder_rgb_r = hexToRgb(event_holder_hex).r;
        var event_holder_rgb_g = hexToRgb(event_holder_hex).g;
        var event_holder_rgb_b = hexToRgb(event_holder_hex).b;
        if($event_holder.hasClass('colorfied') && $event_holder.hasClass('month_day_event')){
            $event_holder.css({"background-color":"transparent"});
            $event_holder.removeClass('colorfied');
        }          
        else if($event_holder.hasClass('colorfied')){
            $holder_color_block.css({"background-color":"rgba(" + event_holder_rgb_r + "," + event_holder_rgb_g + "," + event_holder_rgb_b + ", .1)"});
            $event_holder.removeClass('colorfied');
        }

    });
}

jQuery(document).ready(function(){
    last_clicked_event_id = null;

    jQuery(document).on('click', 'a.event_origin_link', function(event){
        event.stopPropagation();
    });

    jQuery(document).on('click', '.event_holder', function(event){
        event.stopPropagation();

        jQuery(".create_event_popup").removeClass("active");


        hide_inspect();
        var $event_div = jQuery(this);
        var $event_div_color_block = jQuery($event_div).find(".white_bg_line_blocker");
        var event_div_hex = $event_div.attr("data-hex");
        var event_title = $event_div.attr("data-name");
        var event_description = $event_div.attr("data-description");
        jQuery($event_div).addClass("colorfied");
        var $window = $(window);
        var windowsize = $window.width();
        var click_x_difference = windowsize - event.pageX;       

        if($event_div.hasClass('month_day_event')){
            jQuery($event_div).css({"background-color": event_div_hex});
        }
        else{
            jQuery($event_div_color_block).css({"background-color": event_div_hex});
        }
        

        var event_id = $event_div.attr('data-id');

        console.log('inspect event: ' + event_id);

        //Create variables to fill with content in inspect boxes//
        var $inspect_event_popup = jQuery('.inspect_event_popup');
        var $inspect_event_title = jQuery($inspect_event_popup).find("#inspect_event_title");
        var $inspect_event_description = jQuery($inspect_event_popup).find("#inspect_event_description");
        //Add the event_id to the inspect_event_popup_week for easy access
        $inspect_event_popup.attr('data-event_id', event_id);
        jQuery($inspect_event_title).css({"color":event_div_hex});
        jQuery($inspect_event_title).text(event_title);
        jQuery($inspect_event_description).text(event_description);

        if(!$inspect_event_popup.is(":visible")){
            if(event.pageY <= 300){
                $inspect_event_popup.css('top', event.pageY + 15);
                jQuery($inspect_event_popup).addClass("top_position");
                if(click_x_difference <= 187){
                    $inspect_event_popup.css('left', event.pageX - 328.5);
                    jQuery($inspect_event_popup).addClass("right_position");
                }
                else{
                    $inspect_event_popup.css('left', event.pageX - 182.5);
                    jQuery($inspect_event_popup).removeClass("right_position");
                }
            }else{
                $inspect_event_popup.css('top', event.pageY - 230);
                jQuery($inspect_event_popup).removeClass("top_position");
                if(click_x_difference <= 187){
                    $inspect_event_popup.css('left', event.pageX - 328.5);
                    jQuery($inspect_event_popup).addClass("right_position");
                }
                else{
                    $inspect_event_popup.css('left', event.pageX - 182.5);
                    jQuery($inspect_event_popup).removeClass("right_position");
                }

            }

            //            Mon, October 27, 2014, 8am – 11am
            var this_date = new Date($event_div.parent().attr('data-date') + ' 00:00:00');
            var start_time = $event_div.attr('data-start_time');
            var inspect_event_text = format_event_date_text(this_date);
            $inspect_event_popup.find('#inspect_event_text').text(inspect_event_text);
            $inspect_event_popup.find('#inspect_event_description').text($event_div.attr('data-description'));


            $event_div.css({});

            $inspect_event_popup.addClass('active');



        }else{
            if($event_div.attr('data-id') != last_clicked_event_id){
                //We clicked a different event than the event we were already looking at
                //switch the inspect_event_popup_week to this event
                if(event.pageY <= 300){
                    $inspect_event_popup.css('top', event.pageY + 15);
                    jQuery($inspect_event_popup).addClass("top_position");
                    if(click_x_difference <= 187){
                        $inspect_event_popup.css('left', event.pageX - 328.5);
                        jQuery($inspect_event_popup).addClass("right_position");
                    }
                    else{
                        $inspect_event_popup.css('left', event.pageX - 182.5);
                        jQuery($inspect_event_popup).removeClass("right_position");
                    }
                }else{
                    $inspect_event_popup.css('top', event.pageY - 230);
                    jQuery($inspect_event_popup).removeClass("top_position");
                    if(click_x_difference <= 187){
                        $inspect_event_popup.css('left', event.pageX - 328.5);
                        jQuery($inspect_event_popup).addClass("right_position");
                    }
                    else{
                        $inspect_event_popup.css('left', event.pageX - 182.5);
                        jQuery($inspect_event_popup).removeClass("right_position");
                    }

                }

                //            Mon, October 27, 2014, 8am – 11am
                var this_date = new Date($event_div.parent().attr('data-date') + ' 00:00:00');
                var start_time = $event_div.attr('data-start_time');
                var inspect_event_text = format_event_date_text(this_date);
                $inspect_event_popup.find('#inspect_event_text').text(inspect_event_text);
                $inspect_event_popup.find('#inspect_event_description').text($event_div.attr('data-description'));


            }else{
                hide_inspect();
            }
        }

        last_clicked_event_id = $event_div.attr('data-id');
    });



    jQuery(document).on('click','.popup_edit_button', function(){
        jQuery('.grid-item.prem').removeClass('making_event');
        var $this_popup_button = jQuery(this);
        var $inspect_event_popup = $this_popup_button.closest('.inspect_event_popup');
        //Hide the popup
        hide_inspect();



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



    jQuery(document).on('click','.popup_exit_button',function(e){
        hide_inspect();
        jQuery(".event_holder").removeClass("colorfied");
        jQuery('.grid-item.prem').removeClass('making_event');
        e.stopPropagation();
        //Clear the text from the event create
        try{
            jQuery(this).closest('.popup').find('.popup_create_event_name_input').val('');
        }catch(err){
        }
        jQuery(this).closest('.popup').removeClass('active');
    });

});
