<?php
include "../includes/common_functions.php";
include "sendconfirmmail.php";
session_start();
include "dbconnection.php"; 
//echo "you are here";
if(isset($_COOKIE['user_id'])){
    header("location:setsession.php");

}else if(isset($_SESSION['id'])){
      $firstname=sanitize($_POST['first'],$con);
      $lastname=sanitize($_POST['last'],$con);
      $email=sanitize($_POST['emailid'],$con);
      $univ_id=sanitize($_POST['university'],$con);
      $dept_id=sanitize($_POST['department'],$con);
      $user_type=sanitize($_POST['account-type'],$con);
      $gender=sanitize($_POST['gender'],$con);
      $fbid=sanitize($_SESSION['id'],$con);
      $picurl="http://graph.facebook.com/".$fbid."/picture?type=large";
      $query=mysqli_query($con,"INSERT INTO user (user_email,user_type,firstname,lastname,univ_id,dept_id,dp_link,status) 
                                VALUES('$email','$user_type','$firstname','$lastname','$univ_id','$dept_id','$picurl','temp')");
      if(!$query){
            $problem="some thing went wrong while registering.Please try again";
            header("location: ../lp_beta.php?problem=$problem");
            die();
            break 1;
                
       }else{
           $user_id=mysqli_insert_id($con);
       }
       
       $query=mysqli_query($con,"UPDATE user_auth_provider SET user_id='$user_id' WHERE auth_key='$fbid'");     
       if(!$query){
              echo "getting user id failed";
       }else{
           confirmmail($email,$con,$user_id);
           echo "check your mail";

       }


}else if(isset($_POST['password'])){
        $pos_first=strpos(sanitize($_POST['fname'],$con),sanitize($_POST['password'],$con)); 
        $pos_last=strpos(sanitize($_POST['lname'],$con),sanitize($_POST['password'],$con));
        foreach($_POST as $key=>$value){
                if(empty($value)){
                    $problem="All fields are to be filled";
                    header("location: ../lp_beta.php?problem=$problem");
                    die();
                    break 1;
                }else if($post_first===0 || $post_last===0){
                    $problem="password contains name";
                    header("location: ../lp_beta.php?problem=$problem");
                    die();
                    break 1;

                }else if(strlen($_POST['password'])<6){
                    $problem="password length atleast 6 chars";
                    header("location: ../lp_beta.php?problem=$problem");
                    die();
                    break 1;
                }
                if($key=='email'&& strpos($value,'@nyu.edu')==false){
                   $problem .="invalid email";
                   header("location: ../lp_beta.php?problem=$problem");
                   die();
                   break 1;  
               }
       } 
          $firstname=sanitize($_POST['fname'],$con);
          $lastname=sanitize($_POST['lname'],$con);
          $user_type=sanitize($_POST['account-type'],$con);
          $email=sanitize($_POST['email'],$con);
          $gender=sanitize($_POST['gender'],$con);
          $univ_id=sanitize($_POST['university'],$con);
          $dept_id=sanitize($_POST['department'],$con);
          $password=sanitize($_POST['password'],$con);
          $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
          $salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
          $password=sha1($salt.$password);          
          $queryget=mysqli_query($con,"SELECT user_id,status FROM user WHERE user_email='$email'");
          if(mysqli_num_rows($queryget)===0){
                $queryinsert=mysqli_query($con,"INSERT INTO user (user_email,user_type,firstname,lastname,univ_id,dept_id,status) 
                                                VALUES('$email','$user_type','$firstname',
                                                       '$lastname','$univ_id','$dept_id','temp')");
                if(!$queryinsert){
                    echo "insert user failed"; 
                    $problem="some thing went wrong while registering.Please try again";
                    header("location: ../lp_beta.php?problem=$problem");
                    die();
                    break 1;       
                }else{
                        $user_id=mysqli_insert_id($con);
                        echo $user_id;
                        echo "check your email";
                        
                 }
         }else{
                while($row=mysqli_fetch_array($queryget)){
                      $user_id=$row['user_id'];
                      $status=$row['status'];
                }
                if($status==='temp'){
                      
                    echo "Already registered.Please verify the mail";

                }else if($status==='invited'){
                   $query=mysqli_query($con,"UPDATE user 
                                             SET user_type='$user_type',firstname='$firstname',
                                                 lastname='$lastname',univ_id='$univ_id',dept_id='$dept_id',status='temp' 
                                             WHERE user_id=$user_id");
                   echo "check your email";
                   
                   
            
                }else if($status==='active'){
                       
                       echo "already registered.If you forgot your email please check your mail to update your password";

                }


          }    
   if($status!='active' && $status!='temp'){
            $query=mysqli_query($con,"INSERT INTO login (user_id,password,salt) VALUES ('$user_id','$password','$salt') ");
            if(!$query){
                echo 'login falied';
             }else{
             }
             confirmmail($email,$con,$user_id);
    }                  
          
  
  


                                                                                    

}
else{
         $problem="password not set and all other fields are to be filled";
            header("location: ../lp_beta.php?problem=$problem");
            break 1; 
}     

?>