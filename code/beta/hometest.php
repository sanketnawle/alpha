<?php
    session_start();
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
    require_once('php/time_change.php');
    if(isset($_SESSION['id']) && !isset($_COOKIE['user_id'])){
             echo "in creating cookie for fb";
            $fbid=$_SESSION['id'];
            $query=mysqli_query($con,"SELECT user_id from user_auth_provider WHERE auth_key='$fbid' ");
            if(!$query){
                    echo "query failed to get user id from user_auth_provider";
            }
            while($row=mysqli_fetch_array($query)){
                   $user_id=$row['user_id'];
            }
            $query=mysqli_query($con,"SELECT user_type,univ_id,dept_id FROM user WHERE user_id='$user_id'");
            if(!$query){
                 echo "failed to get univ_id,dept_id from user"; 
            }else{
                  while($row=mysqli_fetch_array($query)){
                      $dept_id=$row['dept_id'];
                      $univ_id=$row['univ_id'];
                      $user_type=$row['user_type'];
                      echo $user_id;
                      echo $dept_id;
                      echo $univ_id;
                  }
                  $time=time();
                  setcookie('user_id',$user_id,$time+100000,'/');
                  setcookie('type','fb',$time+100000,'/');
                  $_SESSION['loggedin']='yes';
                  $_SESSION['user_id']=$user_id;
                  $_SESSION['dept_id']=$dept_id;
                  $_SESSION['univ_id']=$univ_id;   
                  $_SESSION['user_type']=$user_type;
                  $_COOKIE['type']='fb';
                  echo "user id cookie ".$_COOKIE['user_id']." type in cookie".$_COOKIE['type'];


           }
 } 
 echo $_COOKIE['type']." cookie out side";
 if(isset($_COOKIE['user_id']) && isset($_COOKIE['type']) && !isset($_SESSION['loggedin'])){   
        $user_id=$_COOKIE['user_id'];
        $query=mysqli_query($con,"SELECT user_type,univ_id,dept_id FROM user WHERE user_id='$user_id'");
    if(!$query){
      echo "failed to get univ_id,dept_id from user"; 
    }else{
           while($row=mysqli_fetch_array($query)){
                 $dept_id=$row['dept_id'];
                 $univ_id=$row['univ_id'];
                 $user_type=$row['user_type'];
                 //echo $user_id;
                 //echo $dept_id;
                 //echo $univ_id;
            }
            $_SESSION['loggedin']='yes';
            $_SESSION['user_id']=$user_id;
            $_SESSION['dept_id']=$dept_id;
            $_SESSION['univ_id']=$univ_id;   
            $_SESSION['user_type']=$user_type;


      }

   }

if($_COOKIE['user_id'] && !isset($_SESSION['loggedin']) && !isset($_COOKIE['type'])){
        $user_id=$_COOKIE['user_id'];
        $query=mysqli_query($con,"SELECT * FROM user WHERE user_id='$user_id'");
        if(!$query){
             echo "query failed";
        }
        while($row=mysqli_fetch_array($query)){
             $user_email=$row['user_email'];
             $dept_id=$row['dept_id'];
             $univ_id=$row['univ_id'];
             $user_id=$row['user_type'];
        }
        $_SESSION['loggedin']='yes';
        $_SESSION['user_id']=$user_id;
        $_SESSION['dept_id']=$dept_id;
        $_SESSION['univ_id']=$univ_id;
        $_SESSION['user_type']=$user_type;

}
echo $_COOKIE['user_id'];

?>