<?php
session_start();
include_once('includes/user.php');

$error=FALSE;


$users = new Users;
require 'facebook-php-sdk-master/src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '237922879690774',
  'secret' => 'a964dc8a3e15cf4fe5fc5f307e31d694',
  
    ));

// See if there is a user from a cookie
//$user = $facebook->getUser();
if(isset($_POST['user']))
$user = $_POST['user'];
$user = $_SESSION['user'];
if($user)
{
   try 
        {
          $user_profile = $facebook->api('/me');
          
          
        } 
      catch (FacebookApiException $e) 
        {
          $user = null;
        }
}
if($user)
{
    if(isset($_POST['university'],$_POST['major'],$_POST['year']))
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
       
        $university=$_POST['university'];
        $major=$_POST['major'];
        $year=$_POST['year'];
        $s_id=$user_profile['id'];
        $name=$user_profile['first_name'].$user_profile['last_name'];
        $email=$user_profile['email'];
        $profilepic="https://graph.facebook.com/<?=".$user_profile['id']."?>/picture?type=large";
        if(empty($university))
        {
            $error=TRUE;
            $error_msg="";
        }
        else if($users->addFbUser($s_id, $name, $email, $university, $major, $year, $profilepic)== FALSE)
        {
            $error=TRUE;
            $error_msg='Database Connectivity Issue';
        }
     }
} 
else
{
   $error=TRUE;
   $error_msg=$user;
}

if($error==TRUE)
    echo $error_msg;
else
    echo "true";
?>