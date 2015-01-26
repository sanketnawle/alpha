<?php



if (ERunActions::runBackground()){
    $key = $params['key'];
    $to_email = $params['to_email'];
    $subject = $params['subject'];
    $from_email = $params['from_email'];

    $message = $params['message'];

    $mail = new YiiMailer('confirmation', array('key'=>$key, 'message'=>$message));
    $mail->SMTPSecure='ssl';
    $mail->Mailer='smtps';
    $mail->setFrom($from_email, 'urlinq team');
    $mail->setSubject($subject);
    $mail->setTo($to_email);



    return $mail->send();
}











?>