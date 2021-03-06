$(document).ready(function(){

    var $calLayer=jQuery('#calLayer');
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



    jQuery('#calLayer.fbar').attr('data-month', d.getMonth());
    jQuery('#calLayer.fbar').attr('data-year', d.getFullYear());
    jQuery('#calLayer.planner').attr('data-month', d.getMonth());
    jQuery('#calLayer.planner').attr('data-year', d.getFullYear());
    jQuery('#calLayer').attr('data-month', d.getMonth());
    jQuery('#calLayer').attr('data-year', d.getFullYear());



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




    jQuery(document).delegate('.date_input', 'click', function (e) {
        e.stopPropagation();

        //Close the time input if there is one
        try{
            $('#time_selector').removeClass('active');
        }catch(err){
            console.log('Clicked date_input with no time selector to hide');
        }


        console.log(jQuery('#calLayer').css("display"));
        //alert(jQuery('#calLayer').css("display"));
       /* if(jQuery(this).hasClass('planner') || jQuery(this).hasClass('planner_edit')){
            $calLayer = jQuery('#calLayer.planner');
            jQuery('#calLayer.fbar').hide();
        }else if(jQuery(this).hasClass('fbar_date_time')){
            $calLayer = jQuery('#calLayer.fbar');
            jQuery('#calLayer.planner').hide();
        }else{
            $calLayer = jQuery('#calLayer');
        }*/
        $calLayer=jQuery('#calLayer');

        if(jQuery(this).is($recent_date_input) && $calLayer.css("display") == 'block'){
            //jQuery('#calLayer').hide();
        } else {

            $recent_date_input = jQuery(this);
            jQuery('#calLayer').css({'z-index': '9999',position:'fixed', top: $recent_date_input.offset().top - $(window).scrollTop()+$recent_date_input.outerHeight(), left: $recent_date_input.offset().left});
           /* if(jQuery(this).hasClass('fbar_date_time')) {
                if(jQuery(this).attr('id')=="opportunity_due_date"){
                    $calLayer.css({
                        'z-index': '9999',
                        position: 'absolute',
                        top: '222px',
                        left: '145px'
                    });
                }else{
                    $calLayer.css({
                        'z-index': '9999',
                        position: 'absolute',
                        top: '149px',
                        left: $recent_date_input.position().left + 20
                    });
                }

            }else if(jQuery(this).hasClass('planner')){
                console.log("planner");
                $calLayer.css({'z-index': '9999',position:'absolute', top: '121px', left: $recent_date_input.position().left+12});
            }else if(jQuery(this).hasClass('planner_edit')){
                console.log("planner");
                $calLayer.css({'z-index': '9999',position:'absolute', top: $('.edit_event_box').position().top+$recent_date_input.position().top+28, left: '18px'});
            }else{
                jQuery('#calLayer').css({'z-index': '9999',position:'absolute', top: $recent_date_input.offset().top + $recent_date_input.outerHeight()-50, left: $recent_date_input.offset().left-23});
            }*/

            $calLayer.show();
        }

    });


    jQuery(document).on('click', '.m-prev', function(e){
        e.stopPropagation();

        var month = parseInt($calLayer.attr('data-month'));

        month--;
        if(month == -1){
            month = 12;
            var year = parseInt($calLayer.attr('data-year'));
            year--;
            jQuery('#calLayer.planner').attr('data-year', year.toString());
            jQuery('#calLayer.fbar').attr('data-year', year.toString());
            jQuery('#calLayer').attr('data-year', year.toString());
        }

        jQuery('#calLayer.planner').attr('data-month', month.toString());
        jQuery('#calLayer.fbar').attr('data-month', month.toString());
        jQuery('#calLayer').attr('data-month', month.toString());

    });


    jQuery(document).on('click', '.m-next', function(e){
        e.stopPropagation();


        var month = parseInt($calLayer.attr('data-month'));

        month++;
        if(month == 13){
            month = 0;
            var year = parseInt($calLayer.attr('data-year'));
            year++;
            jQuery('#calLayer.planner').attr('data-year', year.toString());
            jQuery('#calLayer.fbar').attr('data-year', year.toString());
            jQuery('#calLayer').attr('data-year', year.toString());
        }

        jQuery('#calLayer.planner').attr('data-month', month.toString());
        jQuery('#calLayer.fbar').attr('data-month', month.toString());
        jQuery('#calLayer').attr('data-month', month.toString());

    });


    $('#page').scroll(function(e){

            e.preventDefault();
            e.stopPropagation();
            if($recent_date_input){
                //Get the position of this time input
                console.log('scroll');
                var input_position = $recent_date_input.offset();

                //Set the position of the time selector to underneath this time input
                jQuery('#calLayer').css({'z-index': '9999',position:'fixed', top: $recent_date_input.offset().top - $(window).scrollTop()+$recent_date_input.outerHeight(), left: $recent_date_input.offset().left});
            }


    });




    jQuery(document).on('click', function(){
        if($calLayer){
            $calLayer.hide();
        }

    });




    /*date cell clicked in that mini cal, event trigger here*/
    jQuery(document).delegate(".calcell", "click", function (e) {
        console.log('date selector js');


        var $this_cal = jQuery(this).closest("#calLayer");

        $this_cal.hide();
//
        if (!jQuery(this).hasClass("disable")) {
            if (blinkflag == 0) {
                var mon = $this_cal.find(".minical-header").find(".minical-h1").text().trim().substring(0,3);
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
                var formatted_day_date = parseInt(selected_day_date);


                //alert(formatted_day_date);
//                if(formatted_day_date < 10){
//                    formatted_day_date  = '0' + formatted_day_date.toString();
//                }

                var current_calendar_month = parseInt($this_cal.attr('data-month')) + 1;
                var current_calendar_year = $this_cal.attr('data-year');


                console.log(current_calendar_month);
                console.log(current_calendar_year);

                console.log(current_calendar_year.toString() + '-' + addZero(current_calendar_month).toString() + '-' + addZero(formatted_day_date).toString());

                var selected_date = local_to_utc(new_date(current_calendar_year.toString() + '-' + addZero(current_calendar_month).toString() + '-' + (addZero(formatted_day_date)).toString()));



                console.log(selected_date);
                $recent_date_input.attr('data-date', date_to_string(selected_date));

                $recent_date_input.val(date_to_day_of_week_string(selected_date));

            }
        }


    });
});
var $recent_date_input = null;
jQuery(document).scroll(function(e){
    e.preventDefault();
    e.stopPropagation();
    if($recent_date_input){
        //Get the position of this time input
        console.log('scroll');
        var input_position = $recent_date_input.offset();

        //Set the position of the time selector to underneath this time input
        jQuery('#calLayer').css({'z-index': '9999',position:'fixed', top: $recent_date_input.offset().top - $(window).scrollTop()+$recent_date_input.outerHeight(), left: $recent_date_input.offset().left});
    }

});