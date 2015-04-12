<?php
/*
In this file we are checking the user's email
And also checking different cases like temp,active,invited
we are also storing variables in SESSION like firstname,lastname,email,user_type,password
Also if user enters wrong info or empty fields we send him to lp_beta with error displayed as get varaible in the header
$_SESSION['register_firstname']
$_SESSION['register_lastname']
$_SESSION['register_user_type']
$_SESSION['register_email']         
$_SESSION['register_password']
*/
//header("location:../lp_beta.php?error=0");
include_once("../includes/common_functions.php");
//include_once("sendconfirmmail.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();    
}
$_SESSION['refresh']=1;
require_once("dbconnection.php"); 
//echo "you are here";
if(isset($_POST['password'])
   ||isset($_POST['firstname'])
   ||isset($_POST['lastname'])
   ||isset($_POST['account-types'])
   ||isset($_POST['email'])){
         $_SESSION['register_firstname']=input_sanitize($_POST['fname'],$con);
          $_SESSION['register_lastname']=input_sanitize($_POST['lname'],$con);
          $_SESSION['register_user_type']=input_sanitize($_POST['account-types'],$con);
          $_SESSION['register_email']=input_sanitize($_POST['email'],$con);         
          //$_SESSION['register_password']=input_sanitize($_POST['password'],$con);
        $pos_first=strpos(input_sanitize($_POST['fname'],$con),input_sanitize($_POST['password'],$con)); 
        $pos_last=strpos(input_sanitize($_POST['lname'],$con),input_sanitize($_POST['password'],$con));
        if(!isset($_POST['account-types'])){
              $error=1;
              header("location: ../lp_beta.php?error=$error");
              die();
              break 1;
        }
        foreach($_POST as $key=>$value){
                
                if(empty($value)){
                    $error=2;
                    header("location: ../lp_beta.php?error=$error");
                    die();
                    break 1;
                }else if($pos_first===0 || $pos_last===0){
                    $error=3;
                    header("location: ../lp_beta.php?error=$error");
                    die();
                    break 1;

                }
                if($key=='email'&& strpos($value,'nyu.edu')==false){
                      if(strpos($value,'poly.edu')){
                          $error=4;
                          header("location: ../lp_beta.php?error=$error");
                      }else if(strpos($value,'.edu')){
                          $error=5;
                          header("location: ../lp_beta.php?error=$error");
                      }else{
                            $error=6;
                            header("location: ../lp_beta.php?error=$error");
                      }   
                   die();
                   break 1;  
               }
       }
       if(strlen($_POST['password'])<6){
                    $error=7;
                    header("location: ../lp_beta.php?error=$error");
                    die();
                    break 1;
       } 
          $_SESSION['firstname']=input_sanitize($_POST['fname'],$con);
          $_SESSION['lastname']=input_sanitize($_POST['lname'],$con);
          $_SESSION['user_type']=input_sanitize($_POST['account-types'],$con);
          $_SESSION['email']=input_sanitize($_POST['email'],$con);         
          $_SESSION['password']=input_sanitize($_POST['password'],$con);
          $firstname=$_SESSION['firstname'];
          $lastname=$_SESSION['lastname'];
          $user_type=$_SESSION['user_type'];
          $email=$_SESSION['email'];
          $user_type=$_SESSION['user_type'];
          //If user type is professor we are checking if the user is already in the database
          //If user is in database we are sending him to signup_school_select.php with professor=1 get varaible
          //If the user not present in the database we store his data as temp status and echo him that data will be verified and he would be notified
           if($user_type=='p'){
               $query=$con->query("SELECT user_id,firstname,lastname 
                                           FROM user 
                                           WHERE user_email='$email'" );
               if($query->num_rows===1){
                     while($row=$query->fetch_array()){
                        $_SESSION['user_id']=$row['user_id'];
                        $_SESSION['professor']=1;
                        header("location:../signup_school_select.php?professor=1");
                     }
                 }else{
                      $query=$con->query("INSERT INTO user(user_email,user_type,firstname,lastname,univ_id,dept_id,status) 
                                                     VALUES('$email','$user_type','$firstname',
                                                            '$lastname','$univ_id','$dept_id','temp')");
                      header("location:/beta/professor_verify.php");


                 }
            //If the user is student we are checking if the data is present in the database already
            //If the user email is present we are checking his status
            //If it is temp we are asking the user to check his mail or resend the email
            //If the user clicks the resend link we will store status as 'temp' in session variable and send him to afterselect.php to resend his email
            //If it is active we say You are already registered.If you forget the password and send him to password reset page if he clicks the link
            //If invited we get user_id and status in session variables and send him to signup_school_select.php page
            //If the data us not present we will send him to signup_school_select.php  
            }else if($user_type=='s'){
                $query=$con->query("SELECT user_id,status FROM user WHERE user_email='$email'");
                if($query->num_rows>0){
                          while($row=$query->fetch_array(MYSQLI_ASSOC)){
                              $user_id=$row['user_id'];
                              $status=$row['status'];
                              $_SESSION['status']=$status;
                              $_SESSION['user_id']=$user_id;
                          }
                          if($status==='invited'){
                            //echo 'invited';
                            header("location:../signup_school_select.php");
                          }else if($status==='temp'){
                            //$_SESSION['status']='temp';
                            echo "already registered check your mail.If you want the mail to be resend"; ?>
                            <a href="/beta/php/afterselect.php">click here</a>
                    <?php 
                          }else if($status==='active'){ //echo "You are already registered.If you forget the password.";
                           header("location:../lp_beta.php?error=11"); 
                           session_destroy();
                          }else{

                          }

                }else{
                    header("location:../signup_school_select.php");
                } 
        }                         
}else if($_POST['fb_email']){

}
else{
            $error=2;
            header("location: ../lp_beta.php?error=$error");
            break 1; 
}     
$con->close();
?>