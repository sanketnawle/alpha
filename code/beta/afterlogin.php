<html>
<head>
</head>
<body>
<?php
session_start();
echo "hi";
//connecting to db
$db_host = "localhost";
$db_username = "campusla_UrlinqU";
$db_pass = "mArCh3!!1992X";
$db_name = "campusla_urlinq_beta";
try {
    $con = new mysqli($db_host, $db_username, $db_pass, $db_name);
} catch (Exception $e) {
    exit("Database error. $e");
  }
  //echo "after con";
if(isset($_SESSION['id'])){
   echo $_SESSION['id'];
}else{
      $email=$_POST['login_email'];
      $password=$_POST['login_password'];
      // echo $email;
      //echo $password;
      $query=mysqli_query($con,"SELECT * FROM user WHERE user_email='$email'");
      if(!$query){
         echo "query failed";
         header("location: lp_beta.php");
      }else if(mysqli_num_rows($query)===0){
              header("location: lp_beta.php");
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
             header("location: lp_beta.php");
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
                $user_type['user_type']=$user_type;
                $url="location:hometest.php";
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
                                header("location:attempts.php");
                             }else{
                                 header("location: lp_beta.php");  
                             }
                          }
                                       
                   }                  
            }
       }      
     


}
?>  
</body>
</html>