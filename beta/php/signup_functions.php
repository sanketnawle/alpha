<?php
if(!isset($con)){
    include_once 'dbconnection.php';
}
include_once 'includes/common_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function password($password,$salt){
     $hashedpassword=hash("sha512",$salt.$password); 
     return $hashedpassword;
}
function oldpassword($password,$salt){
     $hashedpassword=sha1($salt.$password); 
     return $hashedpassword;
}
function salt(){
      $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
      $salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
      return $salt; 
}

function check_credentials($con, $entered_pwd){
    $pwd_query = $con->prepare("SELECT salt, password
            FROM user_login WHERE user_id =?");
    if($pwd_query){
        // echo "test";
        $pwd_query->bind_param('i',$_SESSION['user_id']);
        if($pwd_query->execute()){
            $pwd_query->bind_result($user_salt, $user_pwd);
            $pwd_query->fetch();
            $pwd_query->close();

            if(password($entered_pwd,$user_salt) == $user_pwd){
                return TRUE;
            }
            else {
//                echo "1Something went wrong!!";
                return FALSE;
            }
        }
        else{
//            echo "2Something went wrong!!";
            return FALSE;
        }
    }
}
if(isset($_POST['univ_id'])){
   echo get_dp($con,$_POST['univ_id'],'school');
}
if(isset($_POST['dept_id'])){
   echo get_dp($con,$_POST['dept_id'],'dept');
}
?>