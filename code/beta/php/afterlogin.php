<html>
<head>
</head>
<body>
<?php
session_start();
include "dbconnection.php";
include "../includes/common_functions.php";
  //echo "after con";
if(isset($_SESSION['id'])){
   //echo $_SESSION['id'];
}else if($_POST['login_email']){
      $email=sanitize($_POST['login_email'],$con);
      $password=sanitize($_POST['login_password'],$con);
      $query=mysqli_query($con,"SELECT * FROM user WHERE user_email='$email'");
      if(!$query){
         echo "query failed";
         header("location:../signin_error.php?empty=1");
      }else if(mysqli_num_rows($query)===0){
              header("location: ../signin_error.php");
       } else{   
             while($row=mysqli_fetch_array($query)){
                 $user_id=$row['user_id'];  
                 $dept_id=$row['dept_id'];
                 $univ_id=$row['univ_id'];
                 $user_type=$row['user_type'];
                 //echo $user_id;
                 //echo $dept_id; 
                 //echo $univ_id;
              }
           } 
        
      $query=mysqli_query($con,"SELECT * FROM login WHERE user_id='$user_id'");
      if(!$query){
         echo "query failed to fetch password and salt from login";
      }else if(mysqli_num_rows($query)===0){
             header("location: ../signin_error.php");
        }else{
              while($row=mysqli_fetch_array($query)){
               $dbpassword=$row['password'];
               $salt=$row['salt'];
               //echo $dbpassword; 
          }
         $hash=sha1($salt.$password);
          //echo $hash;
         if($hash==$dbpassword){
                //echo "passwords equal";
                $time=time();
                setcookie('user_id',$user_id,$time+100000,'/');
                $_SESSION['loggedin']='yes';
                $_SESSION['user_id']=$user_id;
                $_SESSION['dept_id']=$dept_id;
                $_SESSION['univ_id']=$univ_id;
                $_SESSION['user_type']=$user_type;
                $_SESSION['user_tz_offset']=$_POST['offset'];
                $url="location:setsession.php";
                header($url);
          } else{
                 $ip=$_SERVER['REMOTE_ADDR'];
                 $query = mysqli_query($con,"INSERT INTO user_login_attempts(user_id,attempttime,ipaddress)
                                                      VALUES( $user_id,CURRENT_TIMESTAMP,'$ip')");
                 if(!$query){
                     echo "error";
                 } else{
                        $query = mysqli_query($con,"SELECT COUNT(*) as total FROM user_login_attempts
                                                              WHERE (attempttime > now() - INTERVAL 5 MINUTE)        
                                                              AND ipaddress = '$ip'");
                         if(!$query){
                             echo "error";
                         }else{
                             $data=mysqli_fetch_assoc($query);
                             echo $data['total'];
                             //print_r($row);
                             if($data['total']>3){
                                header("location:../attempts.php");
                             }else{
                              $_SESSION['login_email']=$email;
                                 header("location: ../signin_error_usernameknown.php");  
                             }
                          }
                                       
                   }                  
            }
       }      
     


}else{
      header("location:../signin_error.php?empty=1");

}
?>  
</body>
</html>