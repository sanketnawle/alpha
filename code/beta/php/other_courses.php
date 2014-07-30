<?php
include "dbconnection.php"
header("Content-Type: application/json");
$other_courses=array();
	$result=$con->query("SELECT course_name
                         FROM courses
                         WHERE univ_id ='$univ_id'
                               AND dept_id ='$dept_id'
                               AND course_type NOT IN (
     	                                                (SELECT student_type
                                                         FROM student_attribs
                                                         WHERE user_id =  '$user_id'
                                                         ),'both'
                                                       )");
  while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$user_courses[] = array("course_name"=>$row['course_name']);
				
  }
  echo json_encode($other_courses);
?>