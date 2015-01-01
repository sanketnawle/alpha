$(document).ready(function(){
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
    $( ".event_date" ).attr('data-date', d.getFullYear() + '-' + todays_month + '-' + formatted_day_date);



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
                $( ".event_date" ).attr('data-date', todays_date.getFullYear() + '-' + todays_month + '-' + formatted_day_date);





                var yeararr= $this_cal.find(".minical-header").find(".minical-h1").text().trim().split(" ");
                var year= yeararr[1];
                var theDate = day +", "+ mon + " " + selected_day_date; // + s[ d.getDate()%10 > 3 ? '3' : (d.getDate()%10) ]
                $('.event_date').val(theDate);





            }
        }
    });
});