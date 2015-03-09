<?php




if (ERunActions::runBackground()){


        $actor = $params['actor'];
        $to_user = $params['to_user'];
        $post = $params['post'];

        $origin = $params['origin'];

        $subject = $params['subject'];





        $mail = new YiiMailer('post_notification_email', array('actor'=>$actor, 'post'=>$post, 'to_user'=>$to_user, 'origin'=>$origin));
        $mail->setFrom('team@urlinq.com', 'Urlinq');
        $mail->setSubject($subject);
        $mail->setTo($to_user->user_email);
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