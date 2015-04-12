<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<title>Untitled Document</title>
</head>
<body>  
<?php
/*
In this page we are checking fblogin for the person.
This page is common for both facebook register and login
If it for login we are checking if the fb id is there in the db 
If present we are checking if he is temp,invited,active
If active I am sending him to set session and home 
If temp I am asking him to activate the account
If invited I am grabbing the user_id,status and storing them in session and sending him to school_select page
If for the first time I am checking his email If its nyu.edu I am sending him to school select
If not I am sending him to FBSignup where he has to enter the nyu email
session varaibles are fbemail,email(if nyu),firstname,lastname,id
*/
  $flag=0;
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  include_once("../includes/common_functions.php");
  include "school_other_functions.php";
  require_once("dbconnection.php");
  if(isset($_COOKIE['beta_user_id'])){
       header("location:setsession.php");
  }else if(isset($_POST['id'])){
       $id=input_sanitize($_POST['id'],$con); 
       $query=$con->query("SELECT * FROM user_auth_provider WHERE auth_key='$id'");
       if(!$query){
       }else{
               $number=$query->num_rows;
               if($number==1){
                        $row=$query->fetch_array();
                        $user_id=$row['user_id'];
                        $_SESSION['beta_id']=$id;
                        $query=$con->query("SELECT * FROM user WHERE user_id='$user_id'");
                        if(!$query){
                        }else{
                                        $row=$query->fetch_array();
                                        $status=$row['status'];
                                        $_SESSION['status']=$status;
                                        $_SESSION['user_id']=$user_id;
                                        if($status==='invited'){
                                           header("location:../signup_school_select.php");
                                        }else if($status==='temp'){
                                          echo "already registered check your mail.If you want the mail to be resend"; ?>
                                          <a href="/beta/php/afterselect.php">click here</a>
                                  <?php }else if($status==='active'){
                                            $_SESSION['user_tz_offset']=$_POST['offset'];
                                            header("location: setsession.php");
                                        }else{
                                               
                                        }
                               
                         }    
              }else{
                          $flag=1;
                          $firstname=input_sanitize($_POST['first'],$con);
                          $_SESSION['firstname']=$firstname;
                          $lastname=input_sanitize($_POST['last'],$con);
                          $_SESSION['lastname']=$lastname;
                          $_SESSION['beta_id']=$id;
                          if($_POST['email']==NULL){
                            $email="undefined";
                          }else{
                             $email=input_sanitize($_POST['fb_email'],$con);
                          }   
                          $_SESSION['fbemail']=$email;
                          if(strpos($email,'nyu.edu')==false){
                            header("location:../FBSignup.php");
                          }else{
                                $_SESSION['email']=$email;
                                header("location:../signup_school_select.php");
                          }
                          

              }
       }       
  }      
?>
</body>
</html>