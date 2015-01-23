<html>
<head>
</head>
<body>
<?php
/*
Sessions set are loggedin,user_id,dept_id,univ_id,user_type,user_tz_offset if he gives correct password 
and email and his account is active
If his account is temp we store his user_id,firstname,status,email and send him to afterselect where  
we check isset($_SESSION['status']) is temp and send him a confirmation email
Also I am checking if there are three continuous wrong password attempts for same email and ip address
If its less than 3 times storing login_email in session and sending him to password error page

*/
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_COOKIE['beta_user_id'])){
header('location:/beta/home.php');
}
require_once("dbconnection.php");
include_once("../includes/common_functions.php");
include "school_other_functions.php";
include_once("signup_functions.php");


if(isset($_SESSION['id'])){


}else if(isset($_POST['login_email'])){
      $email=input_sanitize($_POST['login_email'],$con);
      $password=input_sanitize($_POST['login_password'],$con);
      $query=$con->query("SELECT * FROM user WHERE user_email='$email'");
      if(!$query){
           header("location:../signin_error.php");
      }else if($query->num_rows==0){
              header("location:../signin_error.php");
      }else{
            while($row=$query->fetch_array()){
                     $user_id=$row['user_id'];  
                     $dept_id=$row['dept_id'];
                     $univ_id=$row['univ_id'];
                     $firstname=$row['firstname'];
                     $user_type=$row['user_type'];
                     $status=$row['status'];
                     $query=$con->query("SELECT * FROM user_login WHERE user_id='$user_id'");
                     if(!$query){
                     }else if($query->num_rows===0){
                             header("location:../signin_error.php");
                     }else{
                            while($row=$query->fetch_array()){
                                  $dbpassword=$row['password'];
                                  $salt=$row['salt']; 
                            }
                            if($user_id==47||$user_id==285||$user_id==286){
                                 $hash=oldpassword($password,$salt);
                            }else{
                                  $hash=password($password,$salt);
                            }     
                            if($hash==$dbpassword){
                                       if($status==='temp'){
                                          $_SESSION['status']=$status;
                                          $_SESSION['user_id']=$user_id;
                                          $_SESSION['email']=$email;
                                          $_SESSION['firstname']=$firstname;
                                          echo "Email confirmation is not done"; ?>
                                          <a href="/beta/php/afterselect.php">click here</a>
                                  <?php echo "to resend the email or check your email";
                                       }else if($status==='active'){
                                            $time=time();
                                            setcookie('beta_user_id',$user_id,$time+100000,'/');
                                            $_SESSION['user_tz_offset']=$_POST['offset'];
                                            $url="location:setsession.php";
                                            header($url);
                                       }
                                    
                            }else{
                                   $_SESSION['login_email']=$email;
                                   header("location:../signin_error_usernameknown.php");
                                   //The below code is for 3 succesive wrong attempts
                                   /*$ip=$_SERVER['REMOTE_ADDR'];
                                   $query = $con->query("INSERT INTO user_login_attempts(user_id,attempttime,ipaddress)
                                                                VALUES( $user_id,CURRENT_TIMESTAMP,'$ip')");
                                   if(!$query){
                                         echo "error";
                                   }else{
                                         $query = $con->query("SELECT COUNT(*) as total FROM user_login_attempts
                                                                          WHERE (attempttime > now() - INTERVAL 5 MINUTE)        
                                                                          AND ipaddress = '$ip'");
                                          if(!$query){
                                               echo "error";
                                          }else{
                                               $data=$query->fetch_assoc();
                                               if($data['total']>3){
                                                    header("location:../attempts.php");
                                                }else{
                                                      $_SESSION['login_email']=$email;
                                                      header("location:../lp_beta.php");  
                                                }
                                          }
                                   }*/
                            }
                     }
            }
             
      } 
}else{
  header("location:../signin_error.php");
} 

?>  
</body>
</html>