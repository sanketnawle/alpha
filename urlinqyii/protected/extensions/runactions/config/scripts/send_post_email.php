<?php




if (ERunActions::runBackground()){


        $actor = $params['actor'];
        $to_user = $params['to_user'];
        $post = $params['post'];

        $origin = $params['origin'];
        $origin_name = $params['origin_name'];



        if($post->anon){
            $subject = "Notification - new post in " . ucfirst($origin_name) . " from Anonymous";
        }else{
            $subject = "Notification - new post in " . ucfirst($origin_name)  . " from " . $actor->firstname . ' ' . $actor->lastname;
        }



        $mail = new YiiMailer('post_notification_email', array('actor'=>$actor, 'post'=>$post, 'to_user'=>$to_user, 'origin'=>$origin, 'origin_name'=>$origin_name));
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