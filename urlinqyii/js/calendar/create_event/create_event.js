jQuery(document).ready(function(){


    init();

    function init(){
        //get the current datetime object
        var datetime = new Date();
        //sql formatted timestring
        var start_time_string = ints_to_time(datetime.getHours(),datetime.getMinutes(),datetime.getSeconds());

        //Set the default time for the time_inputs
        var $start_time_input = $('#create_event_start_time_input');
        $start_time_input.attr('data-time',start_time_string);
        $start_time_input.val(time_string_to_am_pm_string(start_time_string));



        var end_time_string = ints_to_time(datetime.getHours() + 1,datetime.getMinutes(),datetime.getSeconds());

        //Set the default time for the time_inputs
        var $end_time_input = $('#create_event_end_time_input');

        $end_time_input.attr('data-time',end_time_string);
        $end_time_input.val(time_string_to_am_pm_string(end_time_string));

        

    }


//    function verify_date_inputs(){
//        var event_start_date = $('#create_event_start_date_input').attr('data-date');
//        var event_start_time = $('#create_event_start_time_input').attr('data-time');
//
//        var event_end_date = $('#create_event_end_date_input').attr('data-date');
//        var event_end_time = $('#create_event_end_time_input').attr('data-time');
    function verify_date_inputs(){
        var $event_start_date = $('#create_event_start_date_input');
        var $event_start_time = $('#create_event_start_time_input');
        var $event_end_date = $('#create_event_end_date_input');
        var $event_end_time = $('#create_event_end_time_input');


        var event_start_date = $event_start_date.attr('data-date');
        var event_start_time = $event_start_time.attr('data-time');

        var event_end_date = $event_end_date.attr('data-date');
        var event_end_time = $event_end_time.attr('data-time');


        //Make sure the start date is less than the end date
        var start_datetime_object = new_datetime(event_start_date + ' ' + event_start_time);
        var end_datetime_object = new_datetime(event_end_date + ' ' + event_end_time);


        console.log('- start date time object -');
        console.log(start_datetime_object);


        console.log('- end date time object -');
        console.log(end_datetime_object);


        if(end_datetime_object < start_datetime_object){
            //alert('end time must be after start time');


            //Create just date objects
            //so we can compare the date only
            var start_date = new_datetime(date_to_string(start_datetime_object) + ' 00:00:00');
            var end_date = new_datetime(date_to_string(end_datetime_object) + ' 00:00:00');


            if(start_date.getTime() == end_date.getTime()){
                var new_end_time_string;
                console.log('hours '+start_datetime_object.getHours());
                /*if(start_datetime_object.getHours() == 23){
                    new_end_time_string = ints_to_time(23,59, start_datetime_object.getSeconds());
                }else{
                    new_end_time_string = ints_to_time(start_datetime_object.getHours() + 1, start_datetime_object.getMinutes(), start_datetime_object.getSeconds());

                }       */
                end_datetime_object = new Date(start_datetime_object.getTime() + 60*60000);
                new_end_time_string = ints_to_time(end_datetime_object.getHours(), end_datetime_object.getMinutes(), end_datetime_object.getSeconds());

                         //make the time an hour from the start time
                $event_end_time.attr('data-time', new_end_time_string);
                $event_end_time.val(time_string_to_am_pm_string(new_end_time_string));
                if(end_datetime_object.getDate() != start_datetime_object.getDate()){
                    $event_end_date.val(date_to_day_of_week_string(end_datetime_object));
                    $event_end_date.attr('data-date', date_to_string(end_datetime_object));
                }
            }else if(start_date > end_date){
                //If the start date is greater than the end date,
                //make the end date the start date
                $event_end_date.val(date_to_day_of_week_string(start_date));
                $event_end_date.attr('data-date', date_to_string(start_date));


                var new_end_time_string;
                console.log('hours '+start_datetime_object.getHours());
              //  if(start_datetime_object.getHours() == 23){
                    end_datetime_object = new Date(start_datetime_object.getTime() + 60*60000);
                    new_end_time_string = ints_to_time(end_datetime_object.getHours(), end_datetime_object.getMinutes(), end_datetime_object.getSeconds());
              //  }else{
               //     new_end_time_string = ints_to_time(start_datetime_object.getHours() + 1, start_datetime_object.getMinutes(), start_datetime_object.getSeconds());

              //  }
                //make the time an hour from the start time
                $event_end_time.attr('data-time', new_end_time_string);
                $event_end_time.val(time_string_to_am_pm_string(new_end_time_string));

                if(end_datetime_object.getDate() != start_datetime_object.getDate()){
                    $event_end_date.val(date_to_day_of_week_string(end_datetime_object));
                    $event_end_date.attr('data-date', date_to_string(end_datetime_object));
                }


    //                        $event_end_date.addClass('error');
    //                        $event_end_time.removeClass('error');
            }else {
                $event_end_time.addClass('error');
                $event_end_date.removeClass('error');
            }


        }else{
            $event_start_date.removeClass('error');
            $event_start_time.removeClass('error');

            $event_end_date.removeClass('error');
            $event_end_time.removeClass('error');
        }
    }



    jQuery(document).on('focusout', '.date_input', function(){

        console.log('yo');
        verify_date_inputs();
    });


    jQuery(document).on('click', '.calcell', function(e){
        console.log('create event js');
        verify_date_inputs();
        console.log("IS THIS EVEN FIRING???");



        e.stopPropagation();
    });

    jQuery(document).on('click', '.dates', function(){
        verify_date_inputs();
    });


    jQuery(document).on('click', '.time_selector_div', function(){
        console.log('time');
        verify_date_inputs();
    });

    jQuery(document).on('click', '.text_input', function(){
        console.log('VERIFYING DATE INPUTS');
        verify_date_inputs();
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

        var $invite_input = $('#event_invite_input');
        $invite_input.removeClass('active');
        $invite_input.val('');
        $invite_input.attr('data-name','');
        $invite_input.attr('data-email','');
        $invite_input.attr('data-id','');

        //Clear the invite list
        $('#invite_list').empty();

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





    jQuery(document).on('click','#create_new_event_button',function(){
        jQuery(".left_panel_create_button.left_panel_create_button").addClass("disabled");
        jQuery(".mini_calendar_cover").addClass("enabled");
        var $dialog = jQuery('#dialog');
        $dialog.show();
//        if($dialog.is(":visible")){
//            $dialog.hide();
//        }else{
//            $dialog.show();
//        }
    });


    jQuery(document).on('click','#create_event_discard_button',function(e){
        jQuery(".left_panel_create_button.left_panel_create_button").removeClass("disabled");
        jQuery(".mini_calendar_cover").removeClass("enabled");
        var $dialog = jQuery('#dialog');
        $dialog.hide();
        reset_create_event_form();
    });


    jQuery(document).on('click','#create_event_back_button',function(e){
        jQuery(".left_panel_create_button.left_panel_create_button").removeClass("disabled");
        jQuery(".mini_calendar_cover").removeClass("enabled");
        var $dialog = jQuery('#dialog');
        $dialog.hide();
        reset_create_event_form();
    });








    jQuery(document).on('submit','#create_event_form',function(event){
        jQuery(".left_panel_create_button.left_panel_create_button").removeClass("disabled");
        jQuery(".mini_calendar_cover").removeClass("enabled");
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


        var event_origin_type = $selected_group.attr('data-group_type') ? $selected_group.attr('data-group_type'):'';
        var event_origin_id = $selected_group.attr('data-id') ? $selected_group.attr('data-id'):'';

        var event_category = jQuery('div.category.selected').attr('data-category') ? jQuery('div.category.selected').attr('data-category'):'';

        var event_location = jQuery('#event_location').val();
        var event_description = jQuery('#event_description_input').val();


        var event_todo = jQuery('#todo_checkbox').is(':checked');
        var event_all_day = jQuery('#allday_checkbox').is(':checked');


        if(jQuery('#todo_checkbox').is(':checked')){
            event_category = 'todo';
        }



        //Make sure event has a name
        if(event_name.length == 0){
            alert('event needs a name');
            return;
        }


        //Make sure the start date is less than the end date
        var start_datetime_object = new_datetime(event_start_date + ' ' + event_start_time);
        var end_datetime_object = new_datetime(event_end_date + ' ' + event_end_time);
//        var start_time_value = parseInt(event_start_date.substring(0,2)) + parseInt(event_end_date.substring(3,5));
//        var end_time_value = parseInt(event_end_date.substring(0,2)) + parseInt(event_end_date['end_time'].substring(3,5));

        if(end_datetime_object < start_datetime_object){
            alert('start date and time need to be before the end date and time.');
            return;
        }



        //Get the invitations for this event
        var invites = [];

        var $invite_holder = $('.invite_holder');
        var $invite_list = $invite_holder.find('#invite_list');

        //loop through the chikldren of the invite list
        $invite_list.children('div').each(function () {
            var $invite_item = $(this);
            var user_id = $invite_item.attr('data-id');

            invites.push(user_id);
        });




        //Convert to UTC for the database

        var event_start_datetime = local_to_utc(new_datetime(event_start_date + ' ' + event_start_time));
        var event_end_datetime = local_to_utc(new_datetime(event_end_date + ' ' + event_end_time));

        event_start_date = date_to_string(event_start_datetime);
        event_start_time = datetime_to_time_string(event_start_datetime);

        event_end_date = date_to_string(event_end_datetime);
        event_end_time = datetime_to_time_string(event_end_datetime);
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
                all_day: event_all_day,
                invites: invites
            }
        };

        if($selected_group){
            var checkbox_share_isset = $selected_group.children().find('.checkbox_share_event').is(':checked');
            if (checkbox_share_isset) {
                console.log("yeah")
                post_url = "post/create"
                post_data = {"post" :
                                    {"text":"",
                                    "post_type":"event",
                                    "origin_type":event_origin_type,
                                    "origin_id":event_origin_id,
                                    "sub_text":"",
                                    "privacy":"",
                                    "anon":0,
                                    "like_count":0,
                                    "event": {"title":event_name,
                                             "start_date": event_start_date,
                                             "start_time":event_start_time,
                                             "end_date": event_end_date,
                                             "end_time": event_end_time,
                                             "description":event_description,
                                             "location":event_location,
                                             "origin_type":event_origin_type,
                                             "origin_id": event_origin_id,
                                             "event_type": event_category
                                            }
                                    }
                            };
              /*  $.post(
                    post_post_url,
                    post_post_data,
                    function(response){
                        if(response['success']){
                            console.log('created post');
                        }else{
                            console.log(JSON.stringify(response));
                        }
                    }

                );*/
            }
        }

        console.log(JSON.stringify(post_data));

        //alert(JSON.stringify(post_data));

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    //If this was an update event, do some shit
//                    if($form.attr('action') == '/event/update'){
//                        //Delete the old event
//                        jQuery('.day_event_holder[data-id="' + event_id + '"]').remove();
//                        //show new event
//                        var $active_tab = jQuery('a.ng-binding.active');
//                        if($active_tab.text().toLowerCase() == 'day'){
//                            show_day_event(response['event']);
//                        }else if($active_tab.text().toLowerCase() == 'week'){
//                            show_week_day_event(response['event']);
//                        }else if($active_tab.text().toLowerCase() == 'month'){
//                            show_month_event(response['event']);
//                        }
//                    }
                    var new_response = response;
                    if(!new_response["event"]){
                        new_response = {};
                        new_response["event"] = $.extend({}, response["post"]["event"],{"color" : {"color_id":3,"hex":"#669999"}});
                    }

                    //Delete the old event
                    jQuery('.event_holder[data-id="' + event_id + '"]').remove();

                    //show new event
                    var $active_tab = jQuery('a.ng-binding.active');
                    if($active_tab.text().toLowerCase() == 'day'){
                        var current_date = $('#day-grid').attr('data-date');
                        if(new_response['event']['start_date'] === current_date){
                            show_day_event(new_response['event']);
                        }

                    }else if($active_tab.text().toLowerCase() == 'week'){
                        show_week_day_event(new_response['event']);
                    }else if($active_tab.text().toLowerCase() == 'month'){
                        show_month_event(new_response['event']);
                    }


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

        verify_date_inputs();

        //Hide all popups
        var $time_selector = $('#time_selector');
        //Hide the selector
        $time_selector.removeClass('active');


        verify_invite_input($('.invite_holder').find('.invite_input'));


        var $calLayer = $('.calLayer');
        //Hide the selector
        $calLayer.removeClass('active');
    });

    function verify_invite_input($invite_input){
        jQuery('#invite_popup').removeClass('active');

        var name = $invite_input.attr('data-name');
        var email = $invite_input.attr('data-email');
        var id = $invite_input.attr('data-id');



        if($invite_input.val() == ''){
            $invite_input.removeClass('error');
            return;
        }

        if(id == '' || name == '' || email == ''){
            $invite_input.addClass('error');
        }else{
            $invite_input.removeClass('error');
        }


    }




    jQuery(document).on('click','.wrapper',function(){

        var $dialog = jQuery('#dialog');
        $dialog.hide();
        jQuery(".left_panel_create_button.left_panel_create_button").removeClass("disabled");
        jQuery(".mini_calendar_cover").removeClass("enabled");
        reset_create_event_form();
    });




});