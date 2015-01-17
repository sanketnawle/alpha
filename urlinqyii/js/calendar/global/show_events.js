function show_day_event(event_json){


    //Normally source would be jQuery("#group_template").html(); but for whatever reason
    //angular doesnt let jquery select the handlebars template if it is in the html
    var source = jQuery('#day_event_template').html();
    var template = Handlebars.compile(source);
    event_json['color']['rgb'] = hexToRgb(event_json['color']['hex']);


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
        var time_range_height = 50;

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
        var event_height = (event_hour_length * time_range_height) - 4;
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
        var width = $grid_item_selector.width() - 25;
        //check if other events are within this time range
        var $this_day_time_events = $grid_item_selector.find('.day_event_holder');
        if($this_day_time_events.length){
            //100 / 3 elements = 33% each
            //Add one because we have not added our new event element yet
            width /= $this_day_time_events.length + 1;

            //Loop through each event and change the styling
            jQuery.each($this_day_time_events, function(index,$day_time_event){
                $($day_time_event).css({'width': width.toString() + 'px'});
                $($day_time_event).css({'left': left_pixels + 10 + 'px'});
                left_pixels += width;
            });
        }


        html_object.css({'position':'absolute'});
        html_object.css({'top': top_pixels.toString() + 'px'});
        html_object.css({'left': left_pixels + 'px'});
        html_object.css({'height':event_height.toString() + 'px'});
        html_object.css({'z-index':time_range_height.toString()});
        html_object.css({'width': width.toString() + 'px'});
        html_object.css({'background-color':"rgba(" + event_json['color']['rgb']['r'] + "," + event_json['color']['rgb']['g'] + "," + event_json['color']['rgb']['b'] + ", .23)"});




        $grid_item_selector.append(html_object);

    }else{
        console.log("ERROR ADDING EVENT");
        console.log(event_json);
    }


}



function show_week_day_event(event_json){

    var source = jQuery('#week_day_event_template').html();
    var template = Handlebars.compile(source);

    event_json['formatted_start_time'] = date_to_am_pm_string(new Date(event_json['start_time'] + '00:00:00'));

    //alert(event_json);

    var generated_html = template(event_json);
    var html_object = jQuery(generated_html);

    //formatted start time
    var event_time_text = date_to_am_pm_string(new Date(event_json['start_time'] + '00:00:00')) + " - " + date_to_am_pm_string(new Date(event_json['end_time'] + '00:00:00'));
    html_object.find('.event_start_time').text(event_time_text);

    event_json['color']['rgb'] = hexToRgb(event_json['color']['hex']);
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

    var $grid_item_selector = jQuery("div.grid-item[data-time='" + start_time_hour + "'][data-date='" + event_json['start_date'] + "']");
    //Make sure this div exists b4 we do anything
    if($grid_item_selector){




        //Size in pixels of the time ranges
        var time_range_height = 50;

        //Start after the all day events + 15 for the padding bottom
        var top_pixels = jQuery("div.day_grid_item.all_day").height() + 15;
        top_pixels += parseInt(event_json['start_time'].substring(0,2)) * time_range_height;
        //Add the pixels for the minutes
        console.log('minutes int: ' + parseInt(event_json['start_time'].substring(3,5)));
        //top_pixels += (parseInt(event_json['start_time'].substring(3,5)) / 60) * time_range_height;



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



        //Start 0 pixels from the left since there is padding on the day grid
        var left_pixels = 0;
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



        //html_object.css({'position':'absolute'});
        //html_object.css({'top': top_pixels.toString() + 'px'});
        //html_object.css({'left': left_pixels + 'px'});
        html_object.css({'height':event_height.toString() + 'px'});
        html_object.css({'z-index':event_height.toString()});
        html_object.css({'width': width.toString() + 'px'});

        html_object.css({'background-color':"rgba(" + event_json['color']['rgb']['r'] + "," + event_json['color']['rgb']['g'] + "," + event_json['color']['rgb']['b'] + ", .23)"});

        $grid_item_selector.append(html_object);

    }else{
        console.log("ERROR ADDING EVENT");
        console.log(event_json);
    }


}



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



function show_month_event(event_json){
    //Normally source would be jQuery("#group_template").html(); but for whatever reason
    //angular doesnt let jquery select the handlebars template if it is in the html
    //var source = '<div class="month_day_event event_holder" data-id="{{event_id}}" data-origin_id="{{origin_id}}" data-origin_type="{{origin_type}}" data-start_time="{{start_time}}" data-end_time="{{end_time}}" data-description="{{description}}"><div class="event_start_time">{{formatted_start_time}}</div><div class="event_name">{{title}}</div></div>';
    var source = jQuery('#month_event_template').html();

    var template = Handlebars.compile(source);

    event_json['formatted_start_time'] = date_to_am_pm_string(new Date(event_json['start_time'] + '00:00:00'));


    var generated_html = template(event_json);
    //            var grid_item_selector = ele.querySelector("div.grid-item.prem[data-date='" + event_json['start_date'] + "']");
    var $grid_item_selector = jQuery("div.grid-item.prem[data-date='" + event_json['start_date'] + "']");

    if($grid_item_selector){

        var $dom_object = jQuery(generated_html);
        $dom_object.attr('ng-click','clickMonthDayEvent()');

        $grid_item_selector.append($dom_object);

//        var $month_day_event = $('.month_day_event[data-id="' + event_json['event_id'] + '"]');
//        var children_height = $grid_item_selector.children().length * $month_day_event.height();
//
//        if(children_height > $grid_item_selector.height()){
//            alert('overflow :o event_id=' + event_json['event_id']);
//
//            $grid_item_selector.append('<a>more</div>')
//
//        }

        //alert('Children height = ' + children_height.toString());

    }else{
        console.log("ERROR ADDING EVENT");
        console.log(event_json);
    }




}
