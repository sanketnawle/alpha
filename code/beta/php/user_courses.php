<?php
include "php/dbconnection.php";
header("Content-Type: application/json");
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
	//echo $current_semester;
	$user_courses=array();
	$result=$con->query("SELECT course_name,class_id,firstname, lastname,courses_semester.course_id, professor
                         FROM courses_semester
                         JOIN courses ON courses.course_id = courses_semester.course_id
                         JOIN user ON user.user_id = courses_semester.professor
                         WHERE courses_semester.semester =  '$current_semester'
                         AND courses_semester.univ_id ='$univ_id'
                         AND courses_semester.dept_id ='$dept_id'
                         AND course_type IN (
     	                                      (SELECT student_type
                                               FROM student_attribs
                                               WHERE user_id =  '$user_id'
                                              ),'both'
                                              )");
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$user_courses[] = array("course_name"=>$row['course_name'],
					                     "class_id"=>$row['class_id'],"lastname"=>$row['lastname'],"courseid"=>$row['course_id']);
	 }
echo json_encode($user_courses);

//SELECT course_id,professor FROM courses_semester WHERE semester='fall' and univ_id=1 and dept_id=3
//SELECT course_id,professor,course_name FROM courses_semester join courses ON courses.course_id=courses_semester.course_id
// WHERE course_semester.semester='fall' and univ_id=1 and dept_id=3
//courses in the current semester that include different class instances
    /*SELECT courses_semester.course_id, professor, course_name, class_id
    FROM courses_semester
    JOIN courses ON courses.course_id = courses_semester.course_id
    WHERE courses_semester.semester =  'fall'
    AND courses_semester.univ_id =1
    AND courses_semester.dept_id =3*/
//courses that are not in the current semester includes different classes
    /*SELECT courses_semester.course_id, professor, course_name, class_id
    FROM courses_semester
    JOIN courses ON courses.course_id = courses_semester.course_id
    WHERE courses_semester.semester NOT IN ('fall')
    AND courses_semester.univ_id =1
    AND courses_semester.dept_id =3*/
//this will select only distinct course names that are not being offered in current semester
    /*SELECT DISTINCT (courses_semester.course_id),course_name FROM courses_semester
     JOIN courses ON courses.course_id = courses_semester.course_id
     WHERE courses_semester.semester =  'fall'
    AND courses_semester.univ_id =1
    AND courses_semester.dept_id =3*/
 //Here we are fetching course_id professor id firstname lastname course_name class_id from courses_semester,courses,user table
     /*SELECT courses_semester.course_id, professor,firstname,lastname, course_name, class_id
     FROM courses_semester
     JOIN courses ON courses.course_id = courses_semester.course_id
     JOIN user ON user.user_id=courses_semester.professor
     WHERE courses_semester.semester =  'fall'
     AND courses_semester.univ_id =1
     AND courses_semester.dept_id =3*/
 // getting every thin g based on user type and both 
    /* SELECT courses_semester.course_id, professor, firstname, lastname, course_name, class_id
     FROM courses_semester
     JOIN courses ON courses.course_id = courses_semester.course_id
     JOIN user ON user.user_id = courses_semester.professor
     WHERE courses_semester.semester =  'fall'
     AND courses_semester.univ_id =1
     AND courses_semester.dept_id =3
     AND course_type
     IN (
     	(SELECT student_type
        FROM student_attribs
        WHERE user_id =  '$user_id'),'both'
        )*/
//getting only course name non clickable other than user type
			/*SELECT distinct(courses_semester.course_id) FROM courses_semester
     				JOIN courses ON courses.course_id = courses_semester.course_id
     				JOIN user ON user.user_id = courses_semester.professor
     				WHERE courses_semester.semester =  'fall'
     				AND courses_semester.univ_id =1
     				AND courses_semester.dept_id =3
     				AND course_type
     				NOT IN (
     							(SELECT student_type
        						FROM student_attribs
       							 WHERE user_id =  '$user_id'),
       							 'both'
        )
*/

		
	

?>