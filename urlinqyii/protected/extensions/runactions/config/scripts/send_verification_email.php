<?php



if (ERunActions::runBackground()){
    $key = $params['key'];
    $to_email = $params['to_email'];
    $subject = $params['subject'];
    $from_email = $params['from_email'];

    $message = $params['message'];

    $mail = new YiiMailer('confirmation', array('key'=>$key, 'message'=>$message));

//    $mail->He
//
//    $emailto = 'to@domain.com';
//    $toname = 'TO NAME';
//    $emailfrom = 'from@domain.com';
//    $fromname = 'FROM NAME';
//    $subject = 'Email Subject';
//    $messagebody = 'Hello.';
//    $headers =
//        'Return-Path: ' . $emailfrom . "\r\n" .
//        'From: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" .
//        'X-Priority: 3' . "\r\n" .
//        'X-Mailer: PHP ' . phpversion() .  "\r\n" .
//        'Reply-To: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" .
//        'MIME-Version: 1.0' . "\r\n" .
//        'Content-Transfer-Encoding: 8bit' . "\r\n" .
//        'Content-Type: text/plain; charset=UTF-8' . "\r\n";
//    $params = '-f ' . $emailfrom;
//    $test = mail($emailto, $subject, $messagebody, $headers, $params);

    $mail->Mailer='smtp';
    $mail->Sender = "team@urlinq.com";
    $mail->setFrom($from_email, 'urlinq team');
    $mail->setSubject($subject);
    $mail->setTo($to_email);
    $mail->SMTPSecure = 'tls';
    $mail->SMTPDebug = 1;

    $mail_response = $mail->send();


    Yii::log($mail_response);

    return $mail_response;
}











?>