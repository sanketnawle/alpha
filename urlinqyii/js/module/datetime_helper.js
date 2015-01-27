var week_days_short = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
var week_days_long = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
var months_short = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
var months_long = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];


function date_to_month_string(date_obj){
    return months_short[date_obj.getMonth()];
}







function date_to_day_name(date_obj){
    return week_days_long[date_obj.getDay()];
}


//returns a string like Fri, Jan 9
function date_to_day_of_week_string(this_date){
    return week_days_short[this_date.getDay()] + ', ' + months_short[this_date.getMonth()] + ' ' + this_date.getDate();
}

//returns a string like Friday, January 9
function date_to_day_of_week_string_long(this_date){
    return week_days_long[this_date.getDay()] + ', ' + months_long[this_date.getMonth()] + ' ' + this_date.getDate();
}


//returns a string like Fri, Jan 9
function date_string_to_day_of_week_string(this_date_string){
    var this_date = new Date(this_date_string + 'T00:00:00');
    return week_days_short[this_date.getDay()] + ', ' + months_short[this_date.getMonth()] + ' ' + this_date.getDate();
}


function addZero(i) {
    if (i < 10 && i !== '00') {
        i = "0" + i;
    }
    return i;
}

//Converts date object into date string of SQl format like this:
// 2014-06-02
function date_to_string(date){
    return date.getFullYear() + '-' + addZero((date.getMonth() + 1)) + '-' + addZero(date.getDate());
}

//Takes in datetime object returns string
//returns either 12:30pm or
//4pm
function date_to_am_pm_string(datetime_obj){
    var hours = datetime_obj.getHours();
    var am_pm = ' AM';

    if(hours >= 12){
        am_pm = ' PM';
        if(hours > 12){
            hours -= 12;
        }
    }else if(hours == 0){
        //If its 12am, hours will be 0
        //so set it so 12
        hours = 12;
    }

    var minutes = datetime_obj.getMinutes();
    if(minutes > 0){
        return hours.toString() + ':' + addZero(minutes) + am_pm;
    }else{
        return hours.toString() + am_pm;
    }

}


//Takes in string like 11:25:00
//returns either 12:30pm or
//4pm
function time_string_to_am_pm_string(time_string){
    var datetime_obj = new Date();
    datetime_obj = new Date(date_to_string(datetime_obj) + 'T' + time_string);


    var hours = datetime_obj.getHours();
    var am_pm = ' AM';

    if(hours >= 12){
        am_pm = ' PM';
        if(hours > 12){
            hours -= 12;
        }
    }else if(hours == 0){
        //If its 12am, hours will be 0
        //so set it so 12
        hours = 12;
    }

    var minutes = datetime_obj.getMinutes();
    if(minutes > 0){
        return hours.toString() + ':' + addZero(minutes) + am_pm;
    }else{
        return hours.toString() + am_pm;
    }

}




//Takes in a standard sql date string
//2015-01-01
//and converts it the safe way by making the space a T
//returns a date object
function new_date(date_string){
    return new Date(date_string + 'T00:00:00');
}

//Takes in a standard sql timestamp
//2015-01-01 11:11:11
//and converts it the safe way by making the space a T
//returns a datetime object
function new_datetime(datetime_string){
    return new Date(datetime_string.replace(' ', 'T'));
}




//Takes in a datetime object and returns an SQL formatted string like this:
// 11:01:45
function datetime_to_time_string(datetime_obj){
    return ints_to_time(datetime_obj.getHours(), datetime_obj.getMinutes(), datetime_obj.getSeconds());
}

var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";


function format_event_date_text(date_obj){
    return weekday[date_obj.getDay()].substring(0, 3) + ', ' + (date_obj.getMonth() + 1).toString() + '/' + (date_obj.getDate()).toString();
}


//returns a formatted sql time string
//input 5
//return 05:00:00
//Which is 5am
function ints_to_time(hours_int,minutes_int,seconds_int){
    return addZero(hours_int) + ":" + addZero(minutes_int) + ":" + addZero(seconds_int);
}
