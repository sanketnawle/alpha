<?php



function date_string_to_day_string($date_string){
    $d = new DateTime($date_string);
    return $d->format('d');
}


function date_string_to_month_name($date_string){
    $d = new DateTime($date_string);
    return date_to_month_name($d);
}

function date_to_month_name($date){
    return $date->format('F');
}








?>