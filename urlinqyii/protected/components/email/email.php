<?php

function unsubscribed($email){
    $email_unsubscribe = EmailUnsubscribe::model()->find('email=:email', array(':email'=>$email));
    if($email_unsubscribe){
        return true;
    }else{
        return false;
    }
}




?>