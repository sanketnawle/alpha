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




//    jQuery(document).on('focusout','input',function(){
//        console.log('VERIFYING DATE INPUTS');
//        verify_date_inputs();
//    });

    jQuery(document).on('click', '.dates', function(){
        verify_date_inputs();
    });


    jQuery(document).on('click', '.time_selector_div', function(){
        verify_date_inputs();
    });

    jQuery(document).on('click', '.text_input', function(){
        console.log('VERIFYING DATE INPUTS');
        verify_date_inputs();
    });


    function verify_date_inputs(){
        var event_start_date = $('#create_event_start_date_input').attr('data-date');
        var event_start_time = $('#create_event_start_time_input').attr('data-time');

        var event_end_date = $('#create_event_end_date_input').attr('data-date');
        var event_end_time = $('#create_event_end_time_input').attr('data-time');


        //Make sure the start date is less than the end date
        var start_datetime_object = new Date(event_start_date + ' ' + event_start_time);
        var end_datetime_object = new Date(event_end_date + ' ' + event_end_time);


        if(end_datetime_object < start_datetime_object){
            //alert('end time must be after start time');


            //Create just date objects
            //so we can compare the date only
            var start_date = new Date(date_to_string(start_datetime_object) + ' 00:00:00');
            var end_date = new Date(date_to_string(end_datetime_object) + ' 00:00:00');
            //Set the end time input as an error
            if(start_date > end_date){
                $('#create_event_end_date_input').addClass('error');
                $('#create_event_end_time_input').removeClass('error');
            }else {
                $('#create_event_end_time_input').addClass('error');
                $('#create_event_end_date_input').removeClass('error');
            }


        }else{
            $('#create_event_end_date_input').removeClass('error');
            $('#create_event_end_time_input').removeClass('error');
        }
    }




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


        var event_origin_type = $selected_group.attr('data-group_type') ? $selected_group.attr('data-group_type'):'';
        var event_origin_id = $selected_group.attr('data-id') ? $selected_group.attr('data-id'):'';

        var event_category = jQuery('div.category.selected').attr('data-category') ? jQuery('div.category.selected').attr('data-category'):'';

        var event_location = jQuery('#event_location_input').val();
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
        var start_datetime_object = new Date(event_start_date + ' ' + event_start_time);
        var end_datetime_object = new Date(event_end_date + ' ' + event_end_time);
//        var start_time_value = parseInt(event_start_date.substring(0,2)) + parseInt(event_end_date.substring(3,5));
//        var end_time_value = parseInt(event_end_date.substring(0,2)) + parseInt(event_end_date['end_time'].substring(3,5));

        if(end_datetime_object < start_datetime_object){
            alert('start date and time need to be before the end date and time.');
            return;
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


        console.log(JSON.stringify(post_data));

        alert(JSON.stringify(post_data));

        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    //If this was an update event, do some shit
                    if($form.attr('action') == '/event/update'){
                        //Delete the old event
                        jQuery('.day_event_holder[data-id="' + event_id + '"]').remove();
                        //show new event
                        var $active_tab = jQuery('a.ng-binding.active');
                        if($active_tab.text().toLowerCase() == 'day'){
                            show_day_event(response['event']);
                        }else if($active_tab.text().toLowerCase() == 'week'){
                            show_week_day_event(response['event']);
                        }else if($active_tab.text().toLowerCase() == 'month'){
                            show_month_event(response['event']);
                        }
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



        //Hide all popups
        var $time_selector = $('#time_selector');
        //Hide the selector
        $time_selector.removeClass('active');



        var $calLayer = $('.calLayer');
        //Hide the selector
        $calLayer.removeClass('active');
    });

    jQuery(document).on('click','.wrapper',function(){

        var $dialog = jQuery('#dialog');
        $dialog.hide();
        reset_create_event_form();
    });




});