$(document).ready(function(){

    init();
    function init(){
        handle_planner_events();
        //show_events(events);
    }

    var blinkflag = 0;

});

    setTimeout(function(){
            $(".free_planner_message").fadeOut(150);
            $(".create_planner_message").fadeIn(150);
    }, 3850);

    var w = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
    var y = ["Sunday","Monday","Tueday","Wednesday","Thursday","Friday","Saturday"];
    var z = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var s = ["st", "nd", "rd", "th"];
    var d = new Date();

    var dueOn = w[ d.getDay() ] + ", " + z[ d.getMonth() ] + " " + d.getDate() + s[ d.getDate()%10 > 3 ? '3' : (d.getDate()%10) ];
    $('.event_date').val(dueOn);

    x= w[ d.getDay() ];
    $("#today_date").text( w[ d.getDay() ] + " " + ( d.getMonth() +1 )+ "/" + d.getDate() );
    $("#tomorrow_date").text( w[ d.getDay()+1 ] + " " + ( d.getMonth() +1 )+ "/" + ( d.getDate()+1 ));

    $('.weekday3').text( y[ d.getDay()+2 ] );
    $('#date3').text( ( d.getMonth() +2 )+ "/" + ( d.getDate()+2 ));





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

    for(var i = 1; i < 6; i++){
        currMin += 15;
        if(currMin > 59){
            currMin = 0;
            currHr += 1;
        }
        var sel = '.timeslot' + i;
        $(sel).text( (0<currHr-12<10 ? '0' : '') + (currHr<12? currHr : currHr-12 ) + ":" + (currMin<12 ? '0' : '') + currMin + (currHr<12 ? 'AM' : 'PM') );
    }





    $(document).delegate('.event_date', 'click', function () {
        $('.calLayer').toggle();

    });



    $(".timepicker div").on("click", function(){
        //$('.event_time').text( $(this).text() );
        //$('.event_time').css( "margin-left", "20px" );
        $('.tp1').val( $(this).text() );
        $('.tp1').css('border-bottom', '1px solid #e5e5e5');
        $('.tp1').css('border-radius', '3px');
        $('.timepicker').fadeToggle(150);
    });



    $('.tp1').on("keypress", function(){
        $('.timepicker').css('display', 'none');
        $(this).css('border-bottom', '1px solid #e5e5e5');
    });


    $(document).delegate(".tp1","click",function(){
        $(".timepicker").show();
    });


    $('html').click(function (e) {
        if (e.target.id == '.timepicker') {
            $(".timepicker").show();
        } else {
            $(".timepicker").hide();
        }
    });


     $(document).click(function(event){
        var $target= $(event.target);

        var $container= $("#event_date");
        var $container2= $(".calLayer");

        if((!$container.is($target)&&($container.has($target).length===0))&&(!$container2.is($target)&&($container2.has($target).length===0))){
            $(".calLayer").hide();
        }


    });




    function handle_planner_events(){
        //Default it to hide and fadein if there are no posts
        $('#free_planner_wrap').hide();


        $.getJSON( base_url + '/event/getPlannerEvents', function( json_data ) {
            //alert(JSON.stringify(json_data));
            if(json_data['success']){
                show_events(json_data);
            }else{
                alert('error getting planner events');
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
    function show_events(json_data){
        //alert(JSON.stringify(json_data));

        if(json_data['event_count'] > 0){
            $('#free_planner_wrap').hide();
        }else{
            $('#free_planner_wrap').hide().fadeIn( "slow", function() {
                // Animation complete
            });
        }


        console.log(json_data);
        var past_events = json_data['past_due_events'];
        if(past_events.length > 0){

            $.each(past_events, function(index, past_event) {
                past_event['event_class'] = 'past_event';
                var date = new Date(past_event['end_date']);
                var formatted_date =  weekday[d.getDay()].substring(0, 3) + ' ' + (date.getDate() + 1).toString() + '/' + (date.getMonth() + 1).toString();
                past_event['end_date'] = formatted_date;
                show_event(past_event,'#past_events');
            });

            $('#past_due_events_header').fadeIn( "slow", function() {
                // Animation complete
            });
        }



        var todays_events = json_data['todays_events'];
        if(todays_events.length > 0){


            $.each(todays_events, function(index, todays_event) {
                todays_event['event_class'] = 'today_event';
                show_event(todays_event,'#todays_events');
            });

            $('#todays_events_header').fadeIn( "slow", function() {
                // Animation complete
            });
        }


        var tomorrows_events = json_data['tomorrows_events'];
        if(tomorrows_events.length > 0){

            $.each(tomorrows_events, function(index, tomorrows_event) {
                tomorrows_event['event_class'] = 'tomorrow_event';
                show_event(tomorrows_event,'#tomorrows_events');
            });


            $('#tomorrows_events_header').fadeIn( "slow", function() {
                // Animation complete
            });
        }



    }













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
					var date= $(this).text();
			    	var yeararr= $this_cal.find(".minical-header").find(".minical-h1").text().trim().split(" ");
			    	var year= yeararr[1];
			    	var theDate = day +", "+ mon + " " + date + s[ d.getDate()%10 > 3 ? '3' : (d.getDate()%10) ];
			    	$('.event_date').val(theDate);

			    	


			    	
			    }
			}
    });



//	});


//Adds a single event to the DOM
//First parameter is the json event
//Second is the div id to add event to
function show_event(event,event_div_id){
    //alert('showing event');
    var source   = $("#event_template").html();
    var template = Handlebars.compile(source);
    var generated_html = template(event);
    $(event_div_id).append(generated_html).hide().fadeIn();
}


//For somereason these has to be outside of the .ready()
$(document).on('click','#add_todo',function(){
    $(this).css("display", "none");
    $("#todo_wrap").css("height", "140px");
    $(".planner_creation_form").fadeIn(500);
    $("textarea#event_name").focus();
});

$(document).on('click','.cancel_form',function(){
    $('.planner_creation_form').css('display', 'none');
    $(".entry_field").css("height", "36px");
    $('.entry_field_placeholder').fadeIn(250);
    $('.timepicker').css('display', 'none');
    $('.event_time').text('Add a time');
});
$(document).on('click','.event_time',function(){
    $('.timepicker').fadeToggle(150);
    $('.tp1').css('display', 'initial');
    $('.event_time').css('display', 'none');
});

//$('#create_todo_form').submit(function (e) {
$(document).on('click','#create_todo_form',function(e){
//Send post request to event/create

    e.preventDefault();
    var $form = $(this);
    var post_url = $form.attr('action');
    var post_data = $(this).serializeArray();
    var errors = [];

    var todo_name = $('#event_name').val();

    //Check if user input a name for todo
    if($('#event_name').val().length == 0){
        errors.push({name:'event_name_error',value:'You must give a name for this todo'});
    }


    var todo_date = '10/11/2014';

    var todo_time = '10:10:12';


    if(errors.length > 0){
        alert(JSON.stringify(errors));
        $('#new_listing_text').text(JSON.stringify(errors));
        return false;
    }

    post_data = { todo_name: todo_name, todo_date: todo_date, todo_time: todo_time, origin: origin, origin_id: origin_id };

    $.post(
        post_url,
        post_data,
        function(response) {
            if(response['success']){
                alert(JSON.stringify(response));
                show_event(response['event']);
            }else{
                alert(JSON.stringify(response));
            }
        }, 'json'
    );
});