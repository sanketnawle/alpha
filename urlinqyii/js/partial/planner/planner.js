$(document).ready(function(){

    init();
    function init(){


        handle_planner_events();
        //show_events(events);
    }

    var blinkflag = 0;

    Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

        switch (operator) {
            case '==':
                return (v1 == v2) ? options.fn(this) : options.inverse(this);
            case '===':
                return (v1 === v2) ? options.fn(this) : options.inverse(this);
            case '<':
                return (v1 < v2) ? options.fn(this) : options.inverse(this);
            case '<=':
                return (v1 <= v2) ? options.fn(this) : options.inverse(this);
            case '>':
                return (v1 > v2) ? options.fn(this) : options.inverse(this);
            case '>=':
                return (v1 >= v2) ? options.fn(this) : options.inverse(this);
            case '&&':
                return (v1 && v2) ? options.fn(this) : options.inverse(this);
            case '||':
                return (v1 || v2) ? options.fn(this) : options.inverse(this);
            default:
                return options.inverse(this);
        }
    });


    

    var w = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
    var y = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
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
    $( ".event_date" ).attr('data-date', d.getFullYear() + '-' + todays_month + '-' + formatted_day_date);


    $('#tp1').attr('data-time', ints_to_time(d.getHours(), d.getMinutes(), d.getSeconds()));
    $('#tp1').val(date_to_am_pm_string(d));



    x= w[ d.getDay() ];
    $("#today_date").text( w[ d.getDay() ] + " " + ( d.getMonth() +1 )+ "/" + d.getDate() );
    $("#tomorrow_date").text( w[ d.getDay()+1 ] + " " + ( d.getMonth() +1 )+ "/" + ( d.getDate()+1 ));

    $('.weekday3').text( y[ d.getDay()+2 ] );
    $('#date3').text( ( d.getMonth() +2 )+ "/" + ( d.getDate()+2 ));

    /* PLUS SIGN ANIMATION */


    $(".entry_field_placeholder").on('click',function(){

    });



//    $("body").on("click", ".entry_field_placeholder", function(){
//
//    });


    $('.checkbox_wrapper label').on("mouseenter", function(){
        if( $(this).parents(".event_listing").find("input:checkbox").is(':checked') ){
            $(this).parents(".event_listing").find(".hint_box").text('Mark as Incomplete');
            $(this).parents(".event_listing").find(".checkbox_hint").css('text-decoration', 'none');
        }
        else{
            $(this).parents(".event_listing").find(".hint_box").text('Mark as Complete');
        }
        ( ($(this).parent() ).parent() ).children(".checkbox_hint").css('opacity', '1');
    });
    $('.checkbox_wrapper label').on("mouseleave", function(){
        ( ($(this).parent() ).parent() ).children(".checkbox_hint").css('opacity', '0');
    });

    $('input:checkbox').on("click", function(){
        if( $(this).is(':checked') ){
            var x = $(this).val();
            $(x).css("text-decoration", "line-through");
            $(x).parent().css("background-color", "#E5E5E5");
        }
        else{
            var x = $(this).val();
            $(x).css("text-decoration", "none");
            if(x == '#event_data1'){
                $(x).parent().css("background-color", "#fff9ea");
            }
            else if(x == '#event_data0'){
                $(x).parent().css("background-color", "rgba(255, 228, 234, 0.77)");
            }
            else{
                $(x).parent().css("background-color", "#fff");
            }
        }
        $(this).parents('.event_listing').find('.checkbox_hint').css('opacity', '0');
    });

    $('.event_listing_wrap').mouseenter(function(){
         /*$(this).children('.color_border').css("width", "3px");
         $(this).children('.color_border').css("margin-left", "2");*/
        if( $(this).find('input:checkbox').is(':checked') ){
            $(this).find('.evt_data').css('text-decoration', 'underline line-through');
        }
    });
    $('.event_listing_wrap').mouseleave(function(){
        /*( $(this).children('.color_border') ).css("width", "1px");
        ( $(this).children('.color_border') ).css("margin-left", "4");*/
        if( $(this).find('input:checkbox').is(':checked') ){
            $(this).find('.evt_data').css('text-decoration', 'line-through');
        }
    });

    var currHr = d.getHours();
    var currMin = d.getMinutes();

    if(currMin%15 != 0){
        currMin += (15- (currMin%15) );
    }
    if(currMin > 59){
        currMin = 0;
        currHr += 1;
    }
    $('.tp1').val( (0<currHr-12<10 ? '0' : '') + (currHr<12? currHr : currHr-12 ) + ":" + (currMin<12 ? '0' : '') + currMin + (currHr<12 ? 'AM' : 'PM') );







//    alert(currHr);
//    alert(currMin);
    for(var i = 1; i < 6; i++){
        currMin += 15;
        if(currMin > 59){
            currMin = 0;
            currHr += 1;
        }
        var sel = '.timeslot' + i;
        $(sel).text( (0<currHr-12<10 ? '0' : '') + (currHr<12? currHr : currHr-12 ) + ":" + (currMin<12 ? '0' : '') + currMin + (currHr<12 ? 'AM' : 'PM') );


        //Add the time attribute to .event_time
        //in SQL format HH:MM:SS
        var formatted_hour = currHr;
        if(formatted_hour < 10){
            formatted_hour = '0' + formatted_hour.toString();
        }

        var formatted_minute = currMin;
        if(formatted_minute < 10){
            formatted_minute = '0' + formatted_minute.toString();
        }
        $(sel).attr('data-time',formatted_hour + ':' + formatted_minute + ":" + '00');


    }




//
//    $(document).delegate('.event_date', 'click', function () {
//        $('.calLayer').toggle();
//
//    });
//
//
//
//    $(".timepicker div").on("click", function(){
//        //$('.event_time').text( $(this).text() );
//        //$('.event_time').css( "margin-left", "20px" );
//        $('.tp1').val( $(this).text() );
//        $('.tp1').css('border-bottom', '1px solid #e5e5e5');
//        $('.tp1').css('border-radius', '3px');
//        $('.timepicker').fadeToggle(150);
//
//
//        $('.event_time').attr('data-time',$(this).attr('data-time'));
//    });



//    $('.tp1').on("keypress", function(){
//        $('.timepicker').css('display', 'none');
//        $(this).css('border-bottom', '1px solid #e5e5e5');
//    });
//
//
//    $(document).delegate(".tp1","click",function(){
//        $(".timepicker").show();
//    });


//    $('html').click(function (e) {
//        if (e.target.id == '.timepicker') {
//            $(".timepicker").show();
//        } else {
//            $(".timepicker").hide();
//        }
//    });


     $(document).click(function(event){
        var $target= $(event.target);

        var $container= $("#event_date");
        var $container2= $(".calLayer");

        if((!$container.is($target)&&($container.has($target).length===0))&&(!$container2.is($target)&&($container2.has($target).length===0))){
            $(".calLayer").hide();
        }


    });

    $(document).on('click','.edit_button',function(){
        var $event = $(this).closest('.event');
        var $edit_box = $('.edit_event_box');
        $edit_box.css({top:$event.position().top+78});
        $edit_box.fadeIn(150);
        $edit_box.find('input#edit_event_title').val($event.find('.event_name').text());
        var datetime = new_datetime($event.attr('data-start_date')+' '+$event.attr('data-start_time'));
        var datetime = utc_to_local(datetime);
        var date_str = date_to_day_of_week_string(datetime);
        $edit_box.find('input#edit_event_date').val(date_str);
        $edit_box.find('input#edit_event_date').attr('data-date',date_to_string(datetime));
        var time_str = date_to_am_pm_string(datetime);
        $edit_box.find('input#edit_event_time').val(time_str);
        //update_time_input($edit_box.find('input#edit_event_time'));
        $edit_box.find('input#edit_event_time').attr('data-time',datetime_to_time_string(datetime));
        $edit_box.attr('data-event_id',$event.attr('data-event_id'));
    });

    $(document).on('click','#cancel_edit_event',function(){
        $('.edit_event_box').fadeOut(150);
    });

    $(document).on('click','#submit_edit_event',function(){
        var $edit_box = $(this).closest('.edit_event_box');
        var post_url = globals.base_url+'/event/update';
        var errors = [];

        var event_name = $('#edit_event_title').val();
        var event_type = 'todo';

        //Check if user input a name for todo
        if($('#edit_event_title').val().length == 0){
            errors.push({name:'event_name_error',value:'You must give a name for this todo'});
        }

        //Make sure the date is converted to UTC before passing to database
        var event_datetime = new_datetime($('#edit_event_date').attr('data-date') + ' ' + $('#edit_event_time').attr('data-time'));

        //var todo_time = $('.event_time').attr('data-time');

        var formatted_date = date_to_month_and_day_string(event_datetime);
        event_datetime = local_to_utc(event_datetime);
        //var todo_date = todo_datetime.getUTCFullYear().toString() + "-" + (todo_datetime.getMonth() + 1).toString() + "-" + todo_datetime.getDate().toString();
        var event_date = date_to_string(event_datetime);

        var event_time = addZero(event_datetime.getHours()).toString() + ':' + addZero(event_datetime.getMinutes()).toString() + ':' + addZero(event_datetime.getSeconds()).toString();

        if(errors.length > 0){
//        alert(JSON.stringify(errors));
            $('#new_listing_text').text(JSON.stringify(errors));
            return false;
        }


      /*  var event_origin_type = globals.origin_type;
        var event_origin_id = globals.origin_id;
        if(globals.origin_type == 'home'){
            event_origin_type = 'user';
            event_origin_id = globals.user_id;
        }*/
        var event_id = $(this).closest('.edit_event_box').attr('data-event_id');
        var $event=$('.event[data-event_id='+event_id+']');
        var duration = new_datetime($event.attr('data-end_date')+' '+$event.attr('data-end_time')).getTime()
            - new_datetime($event.attr('data-start_date')+' '+$event.attr('data-start_time')).getTime();
        console.log(event_datetime.getTime()+duration);
        var end_datetime = new Date(event_datetime.getTime()+duration);
        var event_end_date = date_to_string(end_datetime);
        var event_end_time = addZero(end_datetime.getHours()).toString() + ':' + addZero(end_datetime.getMinutes()).toString() + ':' + addZero(end_datetime.getSeconds()).toString();
        console.log(event_end_date+' '+event_end_time);
        var post_data = {event:{event_id:event_id,event_name:event_name,title:event_name
            ,start_date:event_date,end_date:event_end_date,start_time:event_time,end_time:event_end_time} };
        //alert(JSON.stringify(post_data));
        $.post(
            post_url,
            post_data,
            function(response) {
                if(response['success']){

                    $event.find('.event_name').text($('#edit_event_title').val());
                    $event.find('.event_date_time').text('at '+$('#edit_event_time').val());
                    $event.find('.event_date_time.date').text(formatted_date);
                    $event.attr('data-start_date',event_date);
                    $event.attr('data-start_time',event_time);
                    $event.attr('data-end_date',event_end_date);
                    $event.attr('data-end_time',event_end_time);
                    $('.edit_event_box').fadeOut(150);
                }else{
                    alert(JSON.stringify(response));
                }
            }, 'json'
        );
    });



    function handle_planner_events(){
        //Default it to hide and fadein if there are no posts
        $('#free_planner_wrap').hide();

        var planner_origin_type = globals.origin_type;
        var planner_origin_id = globals.origin_id;
        if(planner_origin_type == 'home'){
            planner_origin_type = 'user';
            planner_origin_id = globals.user_id;
        }

        //alert('GET PLANNER EVENTS');

        console.log(planner_origin_type);
        console.log(planner_origin_id);


        $.getJSON( globals.base_url + '/event/getPlannerEvents', {origin_type: planner_origin_type, origin_id: planner_origin_id, tz_offset:(new Date().getTimezoneOffset())}, function( json_data ) {
            //alert(JSON.stringify(json_data));
            if(json_data['success']){
                show_events(json_data);

            }else{
                alert(JSON.stringify(json_data));
            }
        });

    }



    var weekday = new Array(7);
    weekday[0]=  "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";

    //Seperated from show_event so we can send show_events() an array
    //And send an individual event to show_event() when we only want
    //to display 1 event




    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function myFunction() {
        var d = new Date();
        var x = document.getElementById("demo");
        var h = addZero(d.getHours());
        var m = addZero(d.getMinutes());
        var s = addZero(d.getSeconds());
        x.innerHTML = h + ":" + m + ":" + s;
    }








//
//
//	/*date cell clicked in that mini cal, event trigger here*/
//	$(document).delegate(".calcell", "click", function () {
//
//			var $this_cal=$(this).closest(".calLayer");
//
//			if (!$(this).hasClass("disable")) {
//			    if (blinkflag == 0) {
//			    	var mon= $this_cal.find(".minical-header").find(".minical-h1").text().trim().substring(0,3);
//			    	var dayarr= $(this).attr("id").split("_");
//			    	var day= dayarr[1];
//			    	if(day === "mo") day = "Mon";
//			    	if(day === "tu") day = "Tue";
//			    	if(day === "we") day = "Wed";
//			    	if(day === "th") day = "Thu";
//			    	if(day === "fr") day = "Fri";
//			    	if(day === "sa") day = "Sat"
//			    	if(day === "su") day = "Sun"
//					var selected_day_date = $(this).text();
//
//
//
//                    //Add the selected date to the data-date attribute
//                    //So its easy to pull off while sending the post request
//                    //to create the event, and it will already be in the proper SQL
//                    //format
//                    var todays_date = new Date();
//                    var formatted_day_date = selected_day_date;
//                    if(formatted_day_date < 10){
//                        formatted_day_date  = '0' + formatted_day_date.toString();
//                    }
//                    var todays_month = todays_date.getMonth() + 1;
//                    if(todays_month < 10){
//                        todays_month = '0' + todays_month.toString();
//                    }
//                    $( ".event_date" ).attr('data-date', todays_date.getFullYear() + '-' + todays_month + '-' + formatted_day_date);
//
//
//
//
//
//			    	var yeararr= $this_cal.find(".minical-header").find(".minical-h1").text().trim().split(" ");
//			    	var year= yeararr[1];
//			    	var theDate = day +", "+ mon + " " + selected_day_date; // + s[ d.getDate()%10 > 3 ? '3' : (d.getDate()%10) ]
//			    	$('.event_date').val(theDate);
//
//
//
//
//
//			    }
//			}
//    });



//	});




//For somereason these has to be outside of the .ready()
$(document).on('click','#add_todo:not(.cancel_form), .create_planner_message',function(event){
    event.stopPropagation();
    show_planner_creation_form();


});

$(document).on('click','.cancel_form',function(event){
    event.stopPropagation();
    hide_planner_creation_form();
    $(this).removeClass("cancel_form");

  
});

function show_planner_creation_form(){
    $('#event_name').val('');

    $('.event_date').val(dueOn);
    $( ".event_date" ).attr('data-date', d.getFullYear() + '-' + todays_month + '-' + formatted_day_date);


    $('#tp1').attr('data-time', ints_to_time(d.getHours(), d.getMinutes(), d.getSeconds()));
    $('#tp1').val(date_to_am_pm_string(d));

    $("#planner_body_holder").hide();
    $(".create_event_body").fadeIn(500);
    $("#add_todo_text").text("Discard");
    $(".entry_field_placeholder").css({"width":"62.5px"});
    $("#add_todo").addClass("cancel_form");
    $(".nav-icon-plus").addClass('hide-plus');
    $(".nav-icon").addClass('bounce-minus');
    $(this).css("display", "none");
    $("#todo_wrap").css("height", "150px");
    $(".entry_field").css("border-bottom", "1px solid #ddd");
    $(".planner_creation_form").fadeIn(500);
    $("input.event_title").focus();
    $("#planner_bottom_holder").hide();
}

function hide_planner_creation_form(){
    $("#planner_body_holder").fadeIn(500);
    $('.planner_creation_form').css('display', 'none');
    $(".entry_field").css("height", "0px");
    $(".entry_field").css("border", "none");
    $(".create_event_body").hide();
    $('.entry_field_placeholder').fadeIn(250);
    $('.timepicker').css('display', 'none');
    $('.event_time').text('Add time');
    $("#planner_bottom_holder").show();
    $("#add_todo_text").text("Add");
    $(".nav-icon-plus").removeClass('hide-plus');
    $(".nav-icon").removeClass('bounce-minus');  
    $(".entry_field_placeholder").css({"width":"47px"});
    $('#calLayer.planner').hide();
}



$(document).on('click','.event_time',function(){
    $('.timepicker').fadeToggle(150);
    $('.tp1').css('display', 'initial');
    $('.event_time').css('display', 'none');
});




$(document).on('click','.event_checkbox_input',function(e){

    var $checkbox = $(this);

    var $event = $(this).closest('.event');
    var event_id = $event.attr('data-event_id');


    console.log("EVENT ID");
    console.log(event_id);


    var check_or_uncheck = 'check';
    if(!$checkbox.is(':checked')){
        check_or_uncheck = 'uncheck';
    }

    var post_url = base_url + '/event/' + event_id + '/' + check_or_uncheck;


    var post_data = {event_id: event_id};
    $.post(
        post_url,
        post_data,
        function(response) {
            if(response['success']){


                if(check_or_uncheck == 'check'){
                    $event.removeClass('not_complete');
                    $event.addClass('complete');
                }else{
                    $event.removeClass('complete');
                    $event.addClass('not_complete');
                }

            }else{
                alert(JSON.stringify(response));
            }
        }, 'json'
    );


//
//        //Check if user input a name for todo
//        if($('#event_name').val().length == 0){
//            errors.push({name:'event_name_error',value:'You must give a name for this todo'});
//        }
//
//        //Make sure the date is converted to UTC before passing to database
//        var todo_date = new Date($('.event_date').attr('data-date'));
//        todo_date = local_to_utc(todo_date);
//        todo_date = todo_date.getUTCFullYear().toString() + "-" + (todo_date.getMonth()+ 1).toString() + "-" + todo_date.getDate().toString();
//
//        var todo_time = $('.event_time').attr('data-time');
//
//
//        if(errors.length > 0){
////        alert(JSON.stringify(errors));
//            $('#new_listing_text').text(JSON.stringify(errors));
//            return false;
//        }
//
//        post_data = { todo_name: todo_name, todo_date: todo_date, todo_time: todo_time, origin: origin, origin_id: origin_id};
//        //alert(JSON.stringify(post_data));
//        $.post(
//            post_url,
//            post_data,
//            function(response) {
//                if(response['success']){
//                    //alert(JSON.stringify(response));
//                    add_event(response['event']);
//                    //show_event(response['event'],'#todays_events');
//                }else{
//                    alert(JSON.stringify(response));
//                }
//            }, 'json'
//        );
});



//$('#create_todo_form').submit(function (e) {
$(document).on('click','#create_todo_form',function(e){
    //Send post request to event/create
    e.preventDefault();

    //alert($('.event_date').val());

    var $form = $(this);
    var post_url = $form.attr('action');
    var post_data = $(this).serializeArray();
    var errors = [];

    var todo_name = $('#event_name').val();

    //Check if user input a name for todo
    if($('#event_name').val().length == 0){
        errors.push({name:'event_name_error',value:'You must give a name for this todo'});
    }

    //Make sure the date is converted to UTC before passing to database
    var todo_datetime = new_datetime($('#event_date').attr('data-date') + ' ' + $('#tp1').attr('data-time'));


    //var todo_time = $('.event_time').attr('data-time');


    todo_datetime = local_to_utc(todo_datetime);
    //var todo_date = todo_datetime.getUTCFullYear().toString() + "-" + (todo_datetime.getMonth() + 1).toString() + "-" + todo_datetime.getDate().toString();
    var todo_date = date_to_string(todo_datetime);

    var todo_time = addZero(todo_datetime.getHours()).toString() + ':' + addZero(todo_datetime.getMinutes()).toString() + ':' + addZero(todo_datetime.getSeconds()).toString();

    if(errors.length > 0){
//        alert(JSON.stringify(errors));
        $('#new_listing_text').text(JSON.stringify(errors));
        return false;
    }


    var event_origin_type = globals.origin_type;
    var event_origin_id = globals.origin_id;
    if(globals.origin_type == 'home'){
        event_origin_type = 'user';
        event_origin_id = globals.user_id;
    }

    post_data = { todo_name: todo_name, todo_date: todo_date, todo_time: todo_time, origin: event_origin_type, origin_id: event_origin_id};
    //alert(JSON.stringify(post_data));
    $.post(
        post_url,
        post_data,
        function(response) {
            if(response['success']){
                $('.entry_field_placeholder').removeClass('cancel_form');

                hide_planner_creation_form();
                add_event(response['event']);
                //show_event(response['event'],'#todays_events');
            }else{
                alert(JSON.stringify(response));
            }
        }, 'json'
    );

});
    //$('#event_list').slimScroll({
    //    height: '329px'
    //});



});


//Checks the date of the event and
//Adds it to the proper DIV
function add_event(event_json){
    $("#free_planner_wrap").hide();

    var event_datetime = utc_to_local(new_datetime(event_json['end_date'] + ' ' + event_json['end_time']));



    console.log('ADDED EVENT TIME');
    console.log(event_datetime);
    console.log(event_json['end_date']);
    console.log(event_json['end_time']);


    //var event_date = utc_to_local(new Date('2014-12-27 02:07:00'));

    //Check if the event is today
    var todays_date = new Date();



//    alert(event_date);
//    alert(todays_date);
//    alert(event_date.getDate() == todays_date.getDate());
    if(event_datetime < todays_date){
        if(!$("#past_due_events_header").is(":visible")){
            show_past_due_label();
        }

//        var date = new_date(event_json['end_date']);
//        var formatted_date =  get_formatted_date(date);
//        event_json['end_date'] = formatted_date;

        show_event(event_json,'#past_events');
        return;
    }



    if(date_to_string(event_datetime) === date_to_string(todays_date)){
        if(!$("#todays_events_header").is(":visible")){
            show_todays_label();
        }

//        var date = new_date(event_json['end_date']);
//        var formatted_date = get_formatted_time(date);
//        event_json['end_date'] = formatted_date;

        show_event(event_json,'#todays_events');
        return;
    }

    //Check if the event is tomorrow
    var tomorrows_date = new Date();
    tomorrows_date.setDate(todays_date.getDate() + 1);
    if(date_to_string(event_datetime) === date_to_string(tomorrows_date)){
        if(!$("#tomorrows_events_header").is(":visible")){
            show_tomorrows_label();
        }

//        var date = new_date(event_json['end_date']);
//        var formatted_date = get_formatted_time(date);
//        event_json['end_date'] = formatted_date;

        show_event(event_json,'#tomorrows_events');
        return;
    }

    //Check if the event is in the next week
//    var week_from_now_date = new Date(todays_date);
//    week_from_now_date.setDate(todays_date.getDate() + 1);
//    if(event_datetime > tomorrows_date && event_datetime < week_from_now_date){
//        show_event(event_json,'#future_events');
//        return;
//    }

    if(event_datetime > tomorrows_date){

        if(!$("#future_events_header").is(":visible")){
            show_future_label();
        }

//
//        var date = new_date(event_json['end_date']);
//        var formatted_date = get_formatted_time(date);
//        event_json['end_date'] = formatted_date;

        show_event(event_json,'#future_events');
        return;
    }
}
//Takes in a date and returns abbreviated day and the month/day
//eg Sat 12/19
function get_formatted_date(date){
    return weekday[date.getDay()].substring(0, 3) + ' ' + (date.getMonth() + 1).toString() + '/' + (date.getDate()).toString();
}

//Takes in a date object and returns a string of time like so:
//12:00 am, 5:35pm, etc
function get_formatted_time(date){
    //Contains 0 - 23 so add 1
    var hours = date.getHours() + 1;

    var am_pm = 'am';
    if(hours == 24){
        hours = 12;
    }else if(hours > 11){
        hours %= 12;
        am_pm = 'pm';
    }

    return hours.toString() + ':' + addZero(date.getMinutes()) + ' ' + am_pm;
}

function show_past_due_label(){
    $('#past_due_events_header').fadeIn( "slow", function() {
        // Animation complete
    });
}

function show_todays_label(){
    //show todays date as month/day in the Today header above todays events
    //eg 12/5
    //Actually gets todays date
    var tomorrows_date = new Date();
    //Converts today into tomorrow
    tomorrows_date.setDate(tomorrows_date.getDate() + 1);
    $('#tomorrows_date').text(get_formatted_date(tomorrows_date));


    $('#todays_events_header').fadeIn( "slow", function() {
        // Animation complete
    });

}


function show_tomorrows_label(){
    //show todays date as month/day in the Today header above todays events
    //eg 12/5
    var date = new Date();
    $('#todays_date').text(get_formatted_date(date));


    $('#tomorrows_events_header').fadeIn( "slow", function() {
        // Animation complete
    });

}


function show_future_label(){

    $('#future_events_header').fadeIn( "slow", function() {
        // Animation complete
    });

}

function show_events(json_data){
    //alert(JSON.stringify(json_data));

    if(json_data['events'].length > 0){
        $('#free_planner_wrap').hide();
    }else{
        $('#free_planner_wrap').hide().fadeIn( "slow", function() {
            // Animation complete
//                alert('show planner');
        });
        $('#planner_body_holder .slimScrollDiv').css({"opacity":"0"});
    }



    var planner_height;
    $.each(json_data['events'], function(index, event) {
        add_event(event);
    });


//        console.log(json_data);
//        var past_events = json_data['past_due_events'];
//        if(past_events.length > 0){
//
//            $.each(past_events, function(index, past_event) {
//                past_event['event_class'] = 'past_event';
//                var date = new Date(past_event['end_date']);
//                var formatted_date =  get_formatted_date(date);
//                past_event['end_date'] = formatted_date;
//                show_event(past_event,'#past_events');
//            });
//
//            $('#past_due_events_header').fadeIn( "slow", function() {
//                // Animation complete
//            });
//        }
//
//
//
//        var todays_events = json_data['todays_events'];
//        if(todays_events.length > 0){
//
//
//
//            $.each(todays_events, function(index, todays_event) {
//                todays_event['event_class'] = 'today_event';
//
//                var date = new Date(todays_event['end_date']);
//                var formatted_date = get_formatted_time(date);
//                todays_event['end_date'] = formatted_date;
//
//
//
//                show_event(todays_event,'#todays_events');
//            });
//            show_todays_label();
//
//        }
//
//
//        var tomorrows_events = json_data['tomorrows_events'];
//        if(tomorrows_events.length > 0){
//
//
//
//
//            $.each(tomorrows_events, function(index, tomorrows_event) {
//                tomorrows_event['event_class'] = 'tomorrow_event';
//
//                var date = new Date(tomorrows_event['end_date']);
//                var formatted_date = get_formatted_time(date);
//                tomorrows_event['end_date'] = formatted_date;
//
//                show_event(tomorrows_event,'#tomorrows_events');
//            });
//
//            show_tomorrows_label();
//
//        }



}


//Adds a single event to the DOM
//First parameter is the json event
//Second is the div id to add event to
function show_event(event,event_div_id){


    //Change the boolean 0 or 1 to completed or not_completed
    //so the css is more clear
    if(event['complete'] == '1'){
        event['complete'] = 'complete';
    }else{
        event['complete'] = 'not_complete';
    }

    if(event['event_type'] == "todo" || event['event_type'] == "homework" || event['event_type'] == "project"){
        event['checkable'] = true;
    }else{
        event['checkable'] = false;
    }
    //Convert the utc times to local
    var local_event_start_time = utc_to_local(new_datetime(event['start_date'] + ' ' + event['start_time']));
    // alert("DATETIME TO STRING "+ datetime_to_time_string(local_event_start_time));
//    alert("START TIME: " + time_string_to_am_pm_string(datetime_to_time_string(local_event_start_time)));
    //event['start_time'] = time_string_to_am_pm_string(datetime_to_time_string(local_event_start_time));
    event['formatted_start_time'] = time_string_to_am_pm_string(datetime_to_time_string(local_event_start_time));
    event['formatted_date_time'] = date_to_month_and_day_string(local_event_start_time);
    var formatted_month_day = date_to_month_and_day_string(local_event_start_time).split(' ');
    event['formatted_month'] = formatted_month_day[0];
    event['formatted_day'] = formatted_month_day[1];

    if(event_div_id=="#future_events"){
        event['future'] = true;
    }else{
        event['future'] = false;
    }

    var source   = $("#event_template").html();
    var template = Handlebars.compile(source);
    var generated_html = template(event);
    $(event_div_id).append(generated_html).hide().fadeIn();

}




$(window).load(function(){

        $('#event_list').slimScroll({
            height: '390px',
            alwaysVisible: true,
            railVisible:true,
            disableFadeOut:true,
            touchScrollStep: "20",
            size:"10px",
            allowPageScroll: true,
            distance: "3px"
        });


});