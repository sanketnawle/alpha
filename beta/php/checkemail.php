<?php
/*
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
include_once("../includes/common_functions.php"); 
require_once("dbconnection.php");
$email="";
if($_POST['email']){
	$email=input_sanitize($_POST['email'],$con);
}
header("Content-Type: application/json");

$json_data="";
 $query=$con->query("SELECT * FROM user WHERE user_email='$email'");
          if($query->num_rows==1){
          	    $json_data=1;                      
	          	$row=$query->fetch_array();
	          	$user_id=$row['user_id'];
	          	$_SESSION['user_id']=$row['user_id'];
			    $_SESSION['firstname']=$row['firstname'];
			    $_SESSION['lastname']=$row['lastname'];
			    $_SESSION['email']=$row['user_email'];
	          	$query_login=$con->query("SELECT * FROM login WHERE user_id='$user_id'");
	          	if($query_login->num_rows==1){
	          	        
                }else{
                	  
                	  //$json_data=0;
                }
	           
          }else{
                  $json_data=0;
          }
 echo json_encode($json_data);          

?>                    