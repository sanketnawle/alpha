<?php
include "php/dbconnection.php";
$current_semester = "";
	$result = $con->query("SELECT semester from univ_semester where univ_id = 1 and start_date <= (SELECT curdate()) and end_date >= (SELECT curdate()) ");
	if($result->num_rows > 0)
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$current_semester = $row['semester'];
		}
	else 
	{
		if($result = $con->query("SELECT semester from univ_semester where univ_id = $university_id and start_date >= (SELECT curdate()) order by start_date"))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$current_semester = $row['semester'];
				break;
			}
		}
	}
	echo $current_semester;
	$result = $con->query("SELECT course_id,course_name FROM courses WHERE course_id IN (SELECT course_id FROM courses_semester WHERE semester='$current_semester' and univ_id=1)");
	
	 	while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			echo $row['course_name'];
			break;
		}
	$result=$con->query("SELECT user_id,firstname FROM user WHERE univ_id='' and dept_id='' and user_type='p'");
	//SELECT course_id,professor FROM courses_semester WHERE semester='fall' and univ_id=1 and dept_id=3
	//SELECT course_id,professor,course_name FROM courses_semester join courses ON courses.course_id=courses_semester.course_id WHERE course_semester.semester='fall' and univ_id=1 and dept_id=3
    /*SELECT courses_semester.course_id, professor, course_name, class_id
    FROM courses_semester
    JOIN courses ON courses.course_id = courses_semester.course_id
    WHERE courses_semester.semester =  'fall'
    AND courses_semester.univ_id =1
    AND courses_semester.dept_id =3*/
		
	

?>