<?php



if (ERunActions::runBackground()){
    $key = $params['key'];
    $to_email = $params['to_email'];
    $subject = $params['subject'];
    $from_email = $params['from_email'];

    $message = $params['message'];

    $mail = new YiiMailer('confirmation', array('key'=>$key, 'message'=>$message));



    ini_set('sendmail_from', 'team@urlinq.com');

    $mail->Mailer='smtp';
    $mail->setFrom($from_email, 'urlinq team');
    $mail->setSubject($subject);
    $mail->setTo($to_email);

    $mail->set('username', "team@urlinq.com"); // SMTP username



    return $mail->send();
}











?>