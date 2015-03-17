<?php











//Takes in user model and determines if user is 'online'
//based on users last activity
function is_online($user){

    $current_time = time();
    $last_activity = strtotime($user->last_activity);

    $minutes = 4 * 60;

    if(($current_time - $last_activity) < $minutes){
        return true;
    }else{
        return false;
    }
}






?>