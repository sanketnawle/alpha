<?php






function hash_password($password,$salt){
    $hashedpassword=hash("sha512",$salt.$password);
    return $hashedpassword;
}
function oldpassword($password,$salt){
    $hashedpassword=sha1($salt.$password);
    return $hashedpassword;
}
function salt(){
//    $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
//    $salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
//    return $salt;
    return uniqid(mt_rand(), true);
}


?>