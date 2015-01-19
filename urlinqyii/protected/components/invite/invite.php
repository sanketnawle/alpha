<?php

//invite_id
//user_id
//origin_id
//origin_type
//choic
function send_invite($actor_id, $user_id, $origin_id, $origin_type){
    $invite = new Invite;

    $invite->user_id = $user_id;
    $invite->origin_id = $origin_id;
    $invite->origin_type = $origin_type;


    if($invite->save(false)){
        include_once "notification/notification.php";
        //If this invitation was successful, create a notification for the user
        send_notification('invite', $actor_id, $user_id, $origin_id, $origin_type);

    }
}



?>