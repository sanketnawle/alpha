<?php
include "php/dbconnection.php";
header("Content-Type: application/json");
$professor_dept=array();
$result=$con->query("SELECT user_id,lastname 
                         FROM user
                         WHERE dept_id='$dept_id' AND univ_id='$univ_id'");
while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$professor_dept[] = array("user_id"=>$row['user_id'],
					                     "lastname"=$row['lastname']);
				
}
	 echo json_encode($professor_dept);

?>