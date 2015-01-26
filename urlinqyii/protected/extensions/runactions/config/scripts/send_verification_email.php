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





//    $mail->setFrom($from_email, 'urlinq team');
//    $mail->setSubject($subject);
//    $mail->setTo($to_email);
//    $mail->IsHTML(true);
//    $mail->Sender = "team@urlinq.com";
//    $mail->Port= 465;
//    $mail->SMTPSecure = 'ssl';
//    $mail->SMTPDebug = 1;

//    $mail->Mailer='smtps';
//    $mail->IsSMTP(); // enable SMTP
//	$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
//	$mail->SMTPAuth = true;  // authentication enabled
//	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
//	$mail->Host = 'box791.bluehost.com';
//	$mail->Port = 465;
//	$mail->Username = 'team@urlinq.com';
//	$mail->Password = 'test#123';
//	$mail->SetFrom($from, 'Urlinq Team');
//	$mail->Subject = '';
//	$mail->Body = '';
//	$mail->AddAddress($to_email);
//
//
//    $mail_response = $mail->send();
//
//
//    Yii::log($mail_response);
//
//
//    if($mail_response){
//        return var_dump('EMAIL SENT');
//    }
//    else
//    {
//        echo '<pre>';
//        var_dump($mail->getError());
//        echo '</pre>';
//    }
//


    $mail = new YiiMailer();
    $mail->IsSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'box791.bluehost.com';  // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'team@urlinq.com';                            // SMTP username
    $mail->Password = 'test#123';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
    $mail->Port = 587;
                //set mail properties
    $mail->setFrom($from_email, 'YYY');

    $mail->setTo($to_email);

    $mail->setSubject('');
    //$mail->setBody($model->message, 'text/html');

    return $mail->send();





     //$mail_response;
}











?>