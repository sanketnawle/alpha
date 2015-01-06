jQuery(document).ready(function(){

    var $recent_date_input = null;
    var blinkflag = 0;

    var w = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
    var y = ["Sunday","Monday","Tueday","Wednesday","Thursday","Friday","Saturday"];
    var z = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var s = ["st", "nd", "rd", "th"];
    var d = new Date();

    var dueOn = w[ d.getDay() ] + ", " + z[ d.getMonth() ] + " " + d.getDate() ; //+ s[ d.getDate()%10 > 3 ? '3' : (d.getDate()%10) ]
    jQuery('.event_date').val(dueOn);
    //Add todays date to the data-date attribute
    //So its easy to pull off while sending the post request
    //to create the event, and it will already be in the proper SQL
    //format
    //.getDate() returns the day of the month
    var formatted_day_date = d.getDate();
    if(formatted_day_date < 10){
        formatted_day_date  = '0' + formatted_day_date.toString();
    }
    var todays_month = d.getMonth() + 1;
    if(todays_month < 10){
        todays_month = '0' + todays_month.toString();
    }
    jQuery( ".event_date").each(function(){
        jQuery(this).attr('data-date', d.getFullYear() + '-' + todays_month + '-' + formatted_day_date);
    });



    x= w[ d.getDay() ];
    jQuery("#today_date").text( w[ d.getDay() ] + " " + ( d.getMonth() +1 )+ "/" + d.getDate() );
    jQuery("#tomorrow_date").text( w[ d.getDay()+1 ] + " " + ( d.getMonth() +1 )+ "/" + ( d.getDate()+1 ));

    jQuery('.weekday3').text( y[ d.getDay()+2 ] );
    jQuery('#date3').text( ( d.getMonth() +2 )+ "/" + ( d.getDate()+2 ));

    /* PLUS SIGN ANIMATION */


    jQuery(".entry_field_placeholder").on('click',function(){
        jQuery(".nav-icon-plus").toggleClass('hide-plus');
        jQuery(".nav-icon").toggleClass('bounce-minus');
    });


    jQuery(document).delegate('.date_input', 'click', function () {
        $recent_date_input = jQuery(this);


        jQuery('.calLayer').css({position:'fixed', top: $recent_date_input.position().top + 85, left: $recent_date_input.position().left + 200});
        jQuery('.calLayer').toggle();

    });

    /*date cell clicked in that mini cal, event trigger here*/
    jQuery(document).delegate(".calcell", "click", function () {

        var $this_cal=jQuery(this).closest(".calLayer");

        if (!jQuery(this).hasClass("disable")) {
            if (blinkflag == 0) {
                var mon= $this_cal.find(".minical-header").find(".minical-h1").text().trim().substring(0,3);
                var dayarr= jQuery(this).attr("id").split("_");
                var day= dayarr[1];
                if(day === "mo") day = "Mon";
                if(day === "tu") day = "Tue";
                if(day === "we") day = "Wed";
                if(day === "th") day = "Thu";
                if(day === "fr") day = "Fri";
                if(day === "sa") day = "Sat"
                if(day === "su") day = "Sun"
                var selected_day_date = jQuery(this).text();



                //Add the selected date to the data-date attribute
                //So its easy to pull off while sending the post request
                //to create the event, and it will already be in the proper SQL
                //format
                var todays_date = new Date();
                var formatted_day_date = selected_day_date;
                if(formatted_day_date < 10){
                    formatted_day_date  = '0' + formatted_day_date.toString();
                }
                var todays_month = todays_date.getMonth() + 1;
                if(todays_month < 10){
                    todays_month = '0' + todays_month.toString();
                }
                $recent_date_input.attr('data-date', todays_date.getFullYear() + '-' + todays_month + '-' + formatted_day_date);





                var yeararr= $this_cal.find(".minical-header").find(".minical-h1").text().trim().split(" ");
                var year= yeararr[1];
                var theDate = day +", "+ mon + " " + selected_day_date; // + s[ d.getDate()%10 > 3 ? '3' : (d.getDate()%10) ]
                $recent_date_input.val(theDate);





            }
        }
    });




    function reset_create_event_form(){
        jQuery('#create_event_name_input').val('');

        var todays_date = new Date();

        jQuery('#create_event_start_date_input').val(date_to_day_of_week_string(todays_date));
        jQuery('#create_event_start_date_input').attr('data-date',date_to_string(todays_date));
        jQuery('#create_event_end_date_input').val(date_to_day_of_week_string(todays_date));
        jQuery('#create_event_end_date_input').attr('data-date',date_to_string(todays_date));

        jQuery('#todo_checkbox').attr('checked', false);
        jQuery('#allday_checkbox').attr('checked', false);

        jQuery('.group.selected').removeClass('selected');
        jQuery('.category.selected').removeClass('selected');

        jQuery('#event_location_input').val('');
        jQuery('#event_description_input').val('');

        jQuery('#create_event_form').attr("action", "/event/create");

        jQuery('#create_event_form').find('#create_event_submit_button').val('CREATE');

    }


    jQuery(document).on('click','.category',function(){
        var $this_category_div = jQuery(this);
        //If there is a currently selected group, remove the class
        jQuery('div.category.selected').removeClass('selected');
        $this_category_div.addClass('selected');
    });



    jQuery(document).on('click','.group',function(){
        var $this_group_div = jQuery(this);
        var group_type = $this_group_div.attr('data-group_type');

        //Remove the active class from the previous category
        jQuery('div.category_list.active').removeClass('active');
        //Show the category list for this group type
        jQuery("div.category_list[data-group_type='" + group_type + "']").addClass('active');

        //If there is a currently selected group, remove the class
        jQuery('div.group.selected').removeClass('selected');
        $this_group_div.addClass('selected');
    });


    jQuery(document).on('click','.popup_edit_button', function(){
        var $this_popup_button = jQuery(this);
        var $inspect_event_popup = $this_popup_button.closest('.inspect_event_popup');
        //Hide the popup
        $inspect_event_popup.removeClass('active');


        //Get the event id from this popup
        var event_id = $inspect_event_popup.attr('data-event_id');


        //Get the event div that has this event id
        var $event_holder = jQuery('.day_event_holder[data-id="' + event_id + '"]');

        var event_name = $event_holder.attr('data-name');
        var event_start_time_string = $event_holder.attr('data-start_time');
        var event_end_time_string = $event_holder.attr('data-end_time');
        var event_start_date_string = $event_holder.attr('data-start_date');
        var event_end_date_string = $event_holder.attr('data-end_date');
        var event_origin_type = $event_holder.attr('data-origin_type');
        var event_origin_id = $event_holder.attr('data-origin_id');
        var event_type = $event_holder.attr('data-event_type');
        var event_location = $event_holder.attr('data-location');

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


    jQuery(document).on('click','#create_new_event_button',function(){

        var $dialog = jQuery('#dialog');
        $dialog.show();
//        if($dialog.is(":visible")){
//            $dialog.hide();
//        }else{
//            $dialog.show();
//        }
    });


    jQuery(document).on('click','#create_event_discard_button',function(e){
        var $dialog = jQuery('#dialog');
        $dialog.hide();
        reset_create_event_form();
    });


    jQuery(document).on('click','#create_event_back_button',function(e){
        var $dialog = jQuery('#dialog');
        $dialog.hide();
        reset_create_event_form();
    });




    jQuery(document).on('submit','#create_event_form',function(event){
        var $form = jQuery(this);
        event.preventDefault();

        var post_url = base_url + $form.attr('action');

        //Event id only used for update event
        var event_id = '';



        if($form.attr('action') == '/event/update'){
            event_id = parseInt($form.attr('data-event_id')).toString();
        }


        console.log('event id');
        console.log(event_id);

        var event_name = jQuery('#create_event_name_input').val();

        var event_start_date = jQuery('#create_event_start_date_input').attr('data-date');
        var event_start_time  = jQuery('#create_event_start_time_input').attr('data-time');

        var event_end_date = jQuery('#create_event_end_date_input').attr('data-date');
        var event_end_time  = jQuery('#create_event_end_time_input').attr('data-time');

        var $selected_group = jQuery('div.group.selected');

        var event_origin_type = $selected_group.attr('data-group_type');
        var event_origin_id = $selected_group.attr('data-id');

        var event_category = jQuery('div.category.selected').attr('data-category');

        var event_location = jQuery('#event_location_input').val();
        var event_description = jQuery('#event_description_input').val();


        var event_todo = jQuery('#todo_checkbox').is(':checked');
        var event_all_day = jQuery('#allday_checkbox').is(':checked');



        if(jQuery('#todo_checkbox').is(':checked')){
            event_category = 'todo';
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


        //alert(JSON.stringify(post_data));



        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    jQuery('#dialog').hide();
                    reset_create_event_form();
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );

    });



    //Intercept the click event if the user clicked the create form
    jQuery(document).on('click','#create_event_holder',function(e){
        e.stopPropagation();
    });

    jQuery(document).on('click','.wrapper',function(){

        var $dialog = jQuery('#dialog');
        $dialog.hide();
        reset_create_event_form();
    });
});