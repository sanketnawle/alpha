

<?php
/*
   This is included in redirect.php and this will help to set sessions and cookies
   $_COOKIE['user_id'] gives the user id of the user
   $_COOKIE['type'] is if the user is logged in with fb or email
   if logged in with fb the cookie is set to fb or it is not set at all
   $_SESSION['user_type'] is student or prof
   different sessions are
   setcookie('user_id',$user_id,$time+100000,'/');
   setcookie('type','fb',$time+100000,'/');
   $_SESSION['loggedin']='yes';
   $_SESSION['user_id']=$user_id;
   $_SESSION['dept_id']=$dept_id;
   $_SESSION['univ_id']=$univ_id;   
   $_SESSION['user_type']=$user_type;
   Checking different conditions if the session is not set but cookies are set and setting session
   for fb login both cookies and sessions are set in this page
   for normal login the sessions are set in afterlogin but resetting the sessions for both fb and normal login are done here

*/

    session_start();
    //connecting to db
    include "dbconnection.php";
    require_once('time_change.php');
    //echo $_SESSION['user_tz_offset'];
    //echo "it should get printed";
    if(isset($_SESSION['user_tz_offset'])){
        echo "sometinhg";
        //echo $_SESSION['user_tz_offset'];
        if(!isset($_SESSION['user_tz'])){
          //echo "inside user_tz";
            $isDST = 1; // Daylight Saving 1 - on, 0 - off
            $_SESSION['user_tz'] = timezone_name_from_abbr('', intval($_SESSION['user_tz_offset']) *  3600, $isDST);
            setcookie('user_tz',$_SESSION['user_tz'],$time+100000,'/');
           // echo $_SESSION['user_tz'];
        }
//        else echo "lol";
    }

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
                  setcookie('type','1',$time+100000,'/');
                  $_SESSION['loggedin']='yes';
                  $_SESSION['user_id']=$user_id;
                  $_SESSION['dept_id']=$dept_id;
                  $_SESSION['univ_id']=$univ_id;   
                  $_SESSION['user_type']=$user_type;
                  //$_COOKIE['type']='fb';
                  if(isset($_SESSION['url'])){
                     $url=$_SESSION['url'];
                     unset($_SESSION['url']);
                     
                  }else{
                       $url="/beta/home.php";
                  }
                  
                  //echo "user id cookie ".$_COOKIE['user_id']." type in cookie".$_COOKIE['type'];


           }
 } else if(isset($_COOKIE['user_id'])  && !isset($_SESSION['loggedin'])){   
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
           if(isset($_SESSION['url'])){
                     $url=$_SESSION['url'];
                     unset($_SESSION['url']);
           }else{
                     $url="/beta/home.php";
            }
                  

  }

}else{
     if(isset($_SESSION['url'])){
                     $url=$_SESSION['url'];
                     unset($_SESSION['url']);
                     echo "in else";
     }else{
                       $url="/beta/home.php";
     }
                  
}
header("location:http://urlinq.com$url");

?>