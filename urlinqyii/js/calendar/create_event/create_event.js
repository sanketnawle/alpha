$(document).ready(function(){

    var $recent_date_input = null;
    var blinkflag = 0;

    var w = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
    var y = ["Sunday","Monday","Tueday","Wednesday","Thursday","Friday","Saturday"];
    var z = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var s = ["st", "nd", "rd", "th"];
    var d = new Date();

    var dueOn = w[ d.getDay() ] + ", " + z[ d.getMonth() ] + " " + d.getDate() ; //+ s[ d.getDate()%10 > 3 ? '3' : (d.getDate()%10) ]
    $('.event_date').val(dueOn);
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
    $( ".event_date").each(function(){
        $(this).attr('data-date', d.getFullYear() + '-' + todays_month + '-' + formatted_day_date);
    });



    x= w[ d.getDay() ];
    $("#today_date").text( w[ d.getDay() ] + " " + ( d.getMonth() +1 )+ "/" + d.getDate() );
    $("#tomorrow_date").text( w[ d.getDay()+1 ] + " " + ( d.getMonth() +1 )+ "/" + ( d.getDate()+1 ));

    $('.weekday3').text( y[ d.getDay()+2 ] );
    $('#date3').text( ( d.getMonth() +2 )+ "/" + ( d.getDate()+2 ));

    /* PLUS SIGN ANIMATION */


    $(".entry_field_placeholder").on('click',function(){
        $(".nav-icon-plus").toggleClass('hide-plus');
        $(".nav-icon").toggleClass('bounce-minus');
    });


    $(document).delegate('.date_input', 'click', function () {
        $recent_date_input = $(this);


        $('.calLayer').css({position:'fixed', top: $recent_date_input.position().top + 85, left: $recent_date_input.position().left + 200});
        $('.calLayer').toggle();

    });

    /*date cell clicked in that mini cal, event trigger here*/
    $(document).delegate(".calcell", "click", function () {

        var $this_cal=$(this).closest(".calLayer");

        if (!$(this).hasClass("disable")) {
            if (blinkflag == 0) {
                var mon= $this_cal.find(".minical-header").find(".minical-h1").text().trim().substring(0,3);
                var dayarr= $(this).attr("id").split("_");
                var day= dayarr[1];
                if(day === "mo") day = "Mon";
                if(day === "tu") day = "Tue";
                if(day === "we") day = "Wed";
                if(day === "th") day = "Thu";
                if(day === "fr") day = "Fri";
                if(day === "sa") day = "Sat"
                if(day === "su") day = "Sun"
                var selected_day_date = $(this).text();



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
        $('#create_event_name_input').val('');

        var todays_date = new Date();

        $('#create_event_start_date_input').val(date_to_day_of_week_string(todays_date));
        $('#create_event_start_date_input').attr('data-date',date_to_string(todays_date));
        $('#create_event_end_date_input').val(date_to_day_of_week_string(todays_date));
        $('#create_event_end_date_input').attr('data-date',date_to_string(todays_date));

        $('#todo_checkbox').attr('checked', false);
        $('#allday_checkbox').attr('checked', false);

        $('.group.selected').removeClass('selected');
        $('.category.selected').removeClass('selected');

        $('#event_location_input').val('');
        $('#event_description_input').val('');

    }


    $(document).on('click','.category',function(){
        var $this_category_div = $(this);
        //If there is a currently selected group, remove the class
        $('div.category.selected').removeClass('selected');
        $this_category_div.addClass('selected');
    });



    $(document).on('click','.group',function(){
        var $this_group_div = $(this);
        var group_type = $this_group_div.attr('data-group_type');

        //Remove the active class from the previous category
        $('div.category_list.active').removeClass('active');
        //Show the category list for this group type
        $("div.category_list[data-group_type='" + group_type + "']").addClass('active');

        //If there is a currently selected group, remove the class
        $('div.group.selected').removeClass('selected');
        $this_group_div.addClass('selected');
    });


    $(document).on('click','.popup_edit_button', function(){
        //insert
    });


    $(document).on('click','#create_new_event_button',function(){

        var $dialog = $('#dialog');
        $dialog.show();
//        if($dialog.is(":visible")){
//            $dialog.hide();
//        }else{
//            $dialog.show();
//        }
    });


    $(document).on('click','#create_event_back_button',function(e){
        var $dialog = $('#dialog');
        $dialog.hide();
        reset_create_event_form();
    });




    $(document).on('submit','#create_event_form',function(event){
        var $form = $(this);
        event.preventDefault();

        var post_url = base_url + $form.attr('action');

        var event_name = $('#create_event_name_input').val();

        var event_start_date = $('#create_event_start_date_input').attr('data-date');
        var event_start_time  = '00:00:00';

        var event_end_date = $('#create_event_end_date_input').attr('data-date');
        var event_end_time  = '00:05:00';

        var $selected_group = $('div.group.selected');

        var event_origin_type = $selected_group.attr('data-group_type');
        var event_origin_id = $selected_group.attr('data-id');

        var event_category = $('div.category.selected').attr('data-category');

        var event_location = $('#event_location_input').val();
        var event_description = $('#event_description_input').val();


        var event_todo = $('#todo_checkbox').is(':checked');
        var event_all_day = $('#allday_checkbox').is(':checked');



        if($('#todo_checkbox').is(':checked')){
            event_category = 'todo';
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


        //alert(JSON.stringify(post_data));



        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){
                    $('#dialog').hide();
                    reset_create_event_form();
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );

    });



    //Intercept the click event if the user clicked the create form
    $(document).on('click','#create_event_holder',function(e){
        e.stopPropagation();
    });

    $(document).on('click','.wrapper',function(){

        var $dialog = $('#dialog');
        $dialog.hide();
        reset_create_event_form();
    });
});