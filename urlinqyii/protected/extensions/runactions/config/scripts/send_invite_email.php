<?php



if (ERunActions::runBackground()){

    $to_email = $params['to_email'];
    $from_email = $params['from_email'];



    $actor = $params['actor'];

    $subject = 'Urlinq Invitation';


    $mail = new YiiMailer('invite', array('actor'=>$actor, 'to_email'=>$to_email));
    $mail->setFrom($from_email, 'Urlinq');
    $mail->setSubject($subject);
    $mail->setTo($to_email);
    $mail->SMTPDebug = 1; //optional

    include_once "email/email.php";
    if(!unsubscribed($to_email)){
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