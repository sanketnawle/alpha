<?php




if (ERunActions::runBackground()){


        $actor = $params['actor'];
        $to_user = $params['to_user'];
        $post = $params['post'];
        $origin = $params['origin'];
        $subject = $params['subject'];
        $reply = $params['reply'];




        $mail = new YiiMailer('reply_notification_email', array('actor'=>$actor, 'post'=>$post, 'to_user'=>$to_user, 'origin'=>$origin, 'reply'=>$reply));
        $mail->setFrom('team@urlinq.com', 'urlinq team');
        $mail->setSubject($subject);
        $mail->setTo($to_user->user_email);
        $mail->SMTPDebug = 1; //optional

        if($mail->send())
        {
            Yii::log('', CLogger::LEVEL_ERROR, 'Successfully sent the email');
        }
        else
        {

            Yii::log('', CLogger::LEVEL_ERROR, $mail->getError());
        }

}













?>