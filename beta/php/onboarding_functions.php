<?php
if(isset($_POST['profilepicture'])){
  include "dbconnection.php";
}else{
include_once("includes/common_functions.php");
}
if(isset($_POST['profilepicture'])){
  session_start();
  $user_id=$_SESSION['user_id'];
  $dp_link=$_POST['profilepicture'];
   $query=$con->query("UPDATE user 
                       SET dp_flag='link',dp_link='$dp_link'
                       WHERE user_id='$user_id'");
}
function get_professor($dept_id,$con){
  $user_id=$_SESSION['user_id'];
  $query=$con->query("SELECT count(*) AS followers,user_id,firstname,dp_flag,dp_link,dp_blob 
                      FROM connect 
                      JOIN user ON connect.to_user_id=user.user_id
                      WHERE user.user_type='p' AND user.dept_id=$dept_id LIMIT 1");
  $row=$query->fetch_array();
  if($row['followers']==0){
    $query=$con->query("SELECT user_id,firstname,dp_flag,dp_link,dp_blob 
                      FROM  user 
                      WHERE user.user_type='p' AND user.dept_id=$dept_id LIMIT 1");
    $row=$query->fetch_array();
    $row['followers']=0;
    
    
  }
  $to_user_id=$row['user_id'];
  $query=$con->query("SELECT * FROM connect WHERE to_user_id=$to_user_id AND from_user_id=$user_id");
    if($query->num_rows==0){
     $row['flag']=0; 
    }else{
      $row['flag']=1;
    }
  $row['dp_link']=get_user_dp($con,$row['user_id']);
  return $row;
}
function get_student($dept_id,$con){
  $user_id=$_SESSION['user_id'];
  $query=$con->query("SELECT count(*) AS followers,user_id,firstname,dp_flag,dp_link,dp_blob 
                      FROM connect 
                      JOIN user ON connect.to_user_id=user.user_id
                      WHERE user.user_type='s' AND user.dept_id=$dept_id LIMIT 1");
  $row=$query->fetch_array();
  if($row['followers']==0){
    $query=$con->query("SELECT user_id,firstname,dp_flag,dp_link,dp_blob 
                      FROM  user 
                      WHERE user.user_type='s' AND user.dept_id=$dept_id LIMIT 1");
    $row=$query->fetch_array();
    $row['followers']=0;
  }
  $to_user_id=$row['user_id'];
    $query=$con->query("SELECT * FROM connect WHERE to_user_id=$to_user_id AND from_user_id=$user_id");
    if($query->num_rows==0){
     $row['flag']=0; 
    }else{
      $row['flag']=1;
    }
    $row['dp_link']=get_user_dp($con,$row['user_id']);
  return $row;
}

?>