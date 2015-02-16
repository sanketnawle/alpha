<?php



if (ERunActions::runBackground()){

    $to_email = $params['to_email'];
    $from_email = $params['from_email'];



    $actor = $params['actor'];

    $subject = 'Urlinq Invitation';


    $mail = new YiiMailer('invite', array('actor'=>$actor));
    $mail->setFrom($from_email, 'urlinq team');
    $mail->setSubject($subject);
    $mail->setTo($to_email);
    $mail->SMTPDebug = 1; //optional

    if($mail->send())
    {
        Yii::log('', CLogger::LEVEL_ERROR, $mail->getError());
    }
    else
    {

        Yii::log('', CLogger::LEVEL_ERROR, $mail->getError());
    }


}









?>