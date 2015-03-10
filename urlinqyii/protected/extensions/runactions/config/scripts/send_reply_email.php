<?php




if (ERunActions::runBackground()){


        $actor = $params['actor'];
        $to_user = $params['to_user'];
        $post = $params['post'];
        $origin = $params['origin'];
        $reply = $params['reply'];
        $origin_name = $params['origin_name'];




        if($reply->anon){
            $subject = "[Urlinq] Reply in " . $origin_name . " from " . $actor->firstname . ' ' . " from Anonymous";
        }else{
            $subject = "[Urlinq] Reply in " . $origin_name . " from " . $actor->firstname . ' ' . $actor->lastname . " - " . $reply->reply_msg;
        }



        $mail = new YiiMailer('reply_notification_email', array('actor'=>$actor, 'post'=>$post, 'to_user'=>$to_user, 'origin'=>$origin, 'reply'=>$reply));
        $mail->setFrom('team@urlinq.com', 'Urlinq');
        $mail->setSubject($subject);
        $mail->setTo($to_user->user_email);

        $mail->AltBody = $subject;
        $mail->SMTPDebug = 1; //optional

        include_once "email/email.php";
        if(!unsubscribed($to_user->user_email)){
            if($mail->send())
            {
                Yii::log('', CLogger::LEVEL_ERROR, 'Successfully sent the email');
            }
            else
            {

                Yii::log('', CLogger::LEVEL_ERROR, $mail->getError());
            }
        }

}













?>