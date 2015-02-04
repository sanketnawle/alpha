<?php



function send_notification($notification_type, $actor_id, $user_id, $origin_id, $origin_type){
    $notification = new Notification;
    $notification->type = $notification_type;
    $notification->actor_id = $actor_id;
    $notification->user_id = $user_id;
    $notification->origin_id = $origin_id;
    $notification->origin_type = $origin_type;

    $notification->save(false);

    include_once 'iOSPushNotifications.php';
    notifyAlliOSDevicesForUserID($user_id, 'This is a test message. From the server. Hi Ben.');
}






?>