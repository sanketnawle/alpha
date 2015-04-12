<?php



if (ERunActions::runBackground()){
    $key = $params['key'];
    $to_email = $params['to_email'];
    $subject = $params['subject'];
    $from_email = $params['from_email'];
    $user_firstname = 'Alex';
    $message = $params['message'];
    $mail = new YiiMailer('confirmation', array('key'=>$key, 'user_firstname'=>$user_firstname, 'message'=>$message, 'to_email'=>$to_email));
    $mail->setFrom($from_email, 'Urlinq');
    $mail->setSubject($subject);
    $mail->setTo($to_email);
    $mail->SMTPDebug = 1; //optional


    $mail->AltBody = $subject;

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