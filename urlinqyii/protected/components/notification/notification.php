<?php



function send_notification($actor_id, $user_id, $origin_id, $origin_type){
    $notification = new Notification;
    $notification->actor_id = $actor_id;
    $notification->user_id = $user_id;
    $notification->origin_id = $origin_id;
    $notification->origin_type = $origin_type;

    $notification->save(false);
}






?>