<?php
//include_once("../includes/common_functions.php");
include_once("sendconfirmmail.php");//for sending cofirmation email
include_once("signup_functions.php");
//include_once("sendconfirmmail.php");

if (session_status() == PHP_SESSION_NONE) {//for starting session
    session_start();
}
//print_r($_SESSION);
$firstname=$_SESSION['firstname'];
$email=$_SESSION['email'];
$lastname=$_SESSION['lastname'];
$user_id=$_SESSION['user_id'];
require_once("dbconnection.php");//for $con object
//checking if the user clicked finsh in the signup process.
//i.e checking if he didnot click the resend button on the final step
if(!isset($_SESSION['resend'])&& $_SESSION['status']!=='temp'){
         if(isset($_SESSION['professor'])){
              $user_type=$_SESSION['type_pro'];
         }else{                           
               $user_type=$_SESSION['user_type'];
               $univ_id=$_SESSION['univ_id'];
               $dept_id=$_SESSION['dept_id'];
               $year=$_SESSION['year'];
               if(isset($_SESSION['id'])){
                     $student_type='s';
               }else{
                     $student_type=$_SESSION['type'];
               }     
               $gender=$_SESSION['gender'];
         }           
         //uploading his profile picture if he is logging in normally or fb 
         //img_upload will take care of uploading the image to database and give you an id i.e up_id
         //take that up_id and store it in $dp_blob (user table) and set flag as blob
         include "img_upload.php";
         if($up_id!=NULL){
             $dp_blob=$up_id;
             $dp_flag="blob";
         }
         $status="";
         $user_id="";
         if(isset($_SESSION['professor'])){ 
            //do nothing;             
         }else if(isset($_SESSION['status'])&&isset($_SESSION['user_id'])){  //checking if the status and user_id is set for people who are invited
                  $status=$_SESSION['status'];
                  $user_id=$_SESSION['user_id'];
         }
         //checking if he is invited or not
         //and if the profile pic is uploaded or not                        
         if($status==='invited'){
                if(isset($dp_flag)&&isset($dp_blob)){
                              $query=$con->query("UPDATE user 
                                                   SET user_type='$user_type',firstname='$firstname',
                                                       lastname='$lastname',univ_id='$univ_id',dept_id='$dept_id',status='temp',dp_blob='$dp_blob',dp_flag='$dp_flag',
                                                       gender='$gender' 
                                                   WHERE user_id=$user_id");
                 }else{
                              $query=$con->query("UPDATE user 
                                                  SET user_type='$user_type',firstname='$firstname',
                                                      lastname='$lastname',univ_id='$univ_id',dept_id='$dept_id',status='temp',
                                                      gender='$gender' 
                                                  WHERE user_id=$user_id");

                  }

          }else if(!isset($_SESSION['professor'])){
                  if(isset($dp_flag)&&isset($dp_blob)){       
                        $query=$con->query("INSERT INTO user(user_email,user_type,firstname,lastname,univ_id,dept_id,dp_flag,dp_blob,status,gender) 
                                                   VALUES('$email','$user_type','$firstname',
                                                   '$lastname','$univ_id','$dept_id','$dp_flag','$dp_blob','temp','$gender')");
                   }else{
                         $query=$con->query("INSERT INTO user(user_email,user_type,firstname,lastname,univ_id,dept_id,status,gender) 
                                                    VALUES('$email','$user_type','$firstname',
                                                    '$lastname','$univ_id','$dept_id','temp','$gender')");
                   }                                                   
                   $user_id=$con->insert_id;
                   $_SESSION['user_id']=$user_id;     
          }else if(isset($_SESSION['professor'])){
                 if($type_pro=='admin'){
                      if(isset($dp_flag)&&isset($dp_blob)){
                              $query=$con->query("UPDATE user 
                                 SET firstname='$firstname',lastname='$lastname',dp_blob='$dp_blob',dp_flag='$dp_flag',user_type='a'
                                 WHERE user_id=$user_id");
                      }else{
                          $query=$con->query("UPDATE user 
                                 SET firstname='$firstname',lastname='$lastname',user_type='a'
                                 WHERE user_id=$user_id");
                      }    
                 }else{
                        if(isset($dp_flag)&&isset($dp_blob)){
                               $query=$con->query("UPDATE user 
                                                   SET firstname='$firstname',lastname='$lastname',dp_blob='$dp_blob',dp_flag='$dp_flag'
                                                   WHERE user_id=$user_id");

                        }else{
                               $query=$con->query("UPDATE user 
                                                   SET firstname='$firstname',lastname='$lastname'
                                                   WHERE user_id=$user_id");      
                        }
                         $query=$con->query("SELECT * FROM prof_attribs
                                             WHERE prof_id=$user_id");      
                         if($query->num_rows==1){
                                 $query=$con->query("UPDATE prof_attribs 
                                                     SET designation='$type_pro'
                                                     WHERE prof_id=$user_id");

                         }else{
                                 $query=$con->query("INSERT INTO prof_attribs(prof_id,designation) 
                                                     VALUES($user_id,'$type_pro')");
                         }
                } 
          }
          //inserting into login for normal login    
          if(!isset($_SESSION['id'])){   
                 $salt=salt();
                 $password=$_SESSION['password'];
                 $password=password($password,$salt);  
                 $query=$con->query("INSERT INTO user_login(user_id,password,salt) 
                                            values($user_id,'$password','$salt')");
           }
           //inserting into user_auth_provider
           //and also uploading his fb pic if he didnot select a pic in the signup process
           if(isset($_SESSION['id'])){
                  $fbemail=$_SESSION['fbemail'];
                  $fbid=$_SESSION['id'];
                  $dp_flag="link";
                  $dp_link="http://graph.facebook.com/".$fbid."/picture?type=large";
                  $query=$con->query("UPDATE user   
                                      SET dp_flag='$dp_flag',dp_link='$dp_link'  
                                      WHERE user_id=$user_id");                        
                  $query=$con->query("INSERT INTO user_auth_provider(user_id,auth_key,auth_provider,fb_email) 
                                      values($user_id,'$fbid','facebook','$fbemail')");
           } 
           $query=$con->query("INSERT INTO student_attribs(user_id,major,year,student_type) 
                                                  values($user_id,$dept_id,'$year','$student_type')");
           $_SESSION['password'] = false;
           unset($_SESSION['password']);
           $_SESSION['register_firstname'] = false;
           unset($_SESSION['register_firstname']); 
           $_SESSION['register_lastname'] = false;
           unset($_SESSION['register_lastname']);
           $_SESSION['register_user_type'] = false;
           unset($_SESSION['register_user_type']); 
           $_SESSION['register_email'] = false;
           unset($_SESSION['register_email']);
           $_SESSION['type'] = false;
           unset($_SESSION['type']);
           $_SESSION['user_type'] = false;
           unset($_SESSION['user_type']);
           confirmmail($email,$con,$user_id,$firstname);
                    //session_destroy();
  }else if(isset($_POST['resend'])){
        $user_id=$_SESSION['user_id'];
        confirmmail($email,$con,$user_id,$firstname);
  }else if($_SESSION['status']==='temp'){
      confirmmail($email,$con,$user_id,$firstname);
      echo "email has been resend";
      session_destroy();
  } 
     
?>