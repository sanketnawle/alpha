<?php




if (ERunActions::runBackground()){

        $to_email = $params['to_email'];
        $from_email = $params['from_email'];

        $user = $params['user'];
        $to_user = $params['to_user'];

        $event = $params['event'];

        $subject = $params['subject'];


        $origin_type = $event->origin_type;
        $origin_id = $event->origin_id;

        $origin_name = $params['origin_name'];



        $mail = new YiiMailer('event_email', array('user'=>$user, 'event'=>$event, 'origin_type'=>$origin_type, 'origin_id'=>$origin_id, 'origin_name'=>$origin_name, 'to_user'=>$to_user));
        $mail->setFrom('team@urlinq.com', 'urlinq team');
        $mail->setSubject($subject);
        $mail->setTo($to_email);
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