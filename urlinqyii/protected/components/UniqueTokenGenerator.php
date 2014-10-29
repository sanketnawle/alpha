<?php


function token(){
    return md5(uniqid(rand(), true));
}

function generateUniqueToken($userid, $username){

    $rand = mt_rand(100,999);
    $md5 = md5($userid.'!(&^ 532567_465 ///'.$username);

    $md53 = substr($md5,0,3);
    $md5_remaining = substr($md5,3);

    $md5 = $md53. $rand. $userid. $md5_remaining;

    return $md5;
}

?>