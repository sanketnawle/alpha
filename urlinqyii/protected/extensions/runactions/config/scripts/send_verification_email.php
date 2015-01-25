<?php



if (ERunActions::runBackground()){
    $key = $params['key'];
    $to_email = $params['to_email'];
    $subject = $params['subject'];
    $from_email = $params['from_email'];
    $user_firstname = 'Alex';
    $message = $params['message'];

    $mail = new YiiMailer('confirmation', array('key'=>$key, 'user_firstname'=>$user_firstname, 'message'=>$message));
    $mail->setFrom($from_email, 'urlinq team');
    $mail->setSubject($subject);
    $mail->setTo($to_email);



    return $mail->send();
}











?>