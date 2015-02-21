<?php



//$date->format() options: http://php.net/manual/en/function.date.php


//Takes in 2015-2-14 3:00:00
//And returns Saturday, Feb 14 at 3:00 pm
function date_time_string_to_pretty_timestamp($datetime_string){
    $d = new DateTime($datetime_string);
    return $d->format('l') . ', ' . $d->format('M') . ' ' . $d->format('j') . ' at ' . $d->format('g') . ':' . $d->format('i') . ' ' . $d->format('a');

}


function date_string_to_day_string($date_string){
    $d = new DateTime($date_string);
    return $d->format('j');
}


function date_string_to_month_name($date_string){
    $d = new DateTime($date_string);
    return date_to_month_name($d);
}

function date_to_month_name($date){
    return $date->format('F');
}








?>