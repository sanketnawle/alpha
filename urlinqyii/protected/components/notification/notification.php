<?php

function send_notification($notification_type, $actor_id, $user_id, $origin_id, $origin_type){
    $notification = new Notification;
    $notification->type = $notification_type;
    $notification->actor_id = $actor_id;
    $notification->user_id = $user_id;
    $notification->origin_id = $origin_id;
    $notification->origin_type = $origin_type;

    $notification->save(false);

    Yii::import('ext.runactions.components.ERunActions');
    ERunActions::runBackground(true);
                                            
    ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/api/sendPushNotification',$postData=array('notification_id'=>$notification->notification_id),$contentType=null);
}