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
    var am_pm = 'am';

    if(hours >= 12){
        am_pm = 'pm';
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

var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";

function format_event_date_text(date_obj){
    return weekday[date_obj.getDay()].substring(0, 3) + ' ' + (date_obj.getMonth() + 1).toString() + '/' + (date_obj.getDate()).toString();
}


//returns a formatted sql time string
//input 5
//return 05:00:00
//Which is 5am
function ints_to_time(hours_int,minutes_int,seconds_int){
    return addZero(hours_int) + ":" + addZero(minutes_int) + ":" + addZero(seconds_int);
}
