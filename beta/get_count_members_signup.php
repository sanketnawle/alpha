<?php
/*
This will handle the ajax call from signup_school_select.php
and give student and professor count for the selected department
*/
header("Content-Type: application/json");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once ("php/dbconnection.php");
include_once("includes/common_functions.php");
if(isset($_POST['dept_id'])){
	$_SESSION['dept_id']=$_POST['dept_id'];
	$dept_id=$_POST['dept_id'];
}
$member_count=array();
 $result = $con->query("SELECT count(*) AS member_count,user_type 
                        FROM user 
                        WHERE 
                             dept_id=$dept_id
                         GROUP BY user_type");
 while($row=$result->fetch_array(MYSQLI_ASSOC)){
       $member_count[]=$row;
 }                      
 echo json_encode($member_count);
?>