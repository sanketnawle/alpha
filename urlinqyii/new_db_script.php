<?php

//Gets data from the old urlinq_beta db strucutre and appends it to the new
//urlinq_new db structure



// Create connection
$con = mysqli_connect("localhost","root","","urlinq_beta");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}else{
    echo "Successfully connected to DB";
}



$courses = array();
    //Get course data from the old database
    $sql = "SELECT * FROM courses";
    $courses_query = mysqli_query($con,$sql);
    while($course = mysqli_fetch_array($courses_query)){
        array_push($courses,$course);
    }


$classes = array();
    //Get course data from the old database
    $sql = "SELECT * FROM courses_semester";
    $classes_query = mysqli_query($con,$sql);
    while($class = mysqli_fetch_array($classes_query)){
        array_push($classes,$class);
    }


$departments = array();
    //Get course data from the old database
    $sql = "SELECT * FROM department";
    $departments_query = mysqli_query($con,$sql);
    while($department = mysqli_fetch_array($departments_query)){
        array_push($departments,$department);
    }


$professors = array();
    //Get course data from the old database
    $sql = "SELECT * FROM user WHERE user_type = 'p' ";
    $professors_query = mysqli_query($con,$sql);
    while($professor = mysqli_fetch_array($professors_query)){
        array_push($professors,$professor);
    }

$groups = array();
    //Get course data from the old database
    $sql = "SELECT * FROM `groups`";
    $groups_query = mysqli_query($con,$sql);
    while($group = mysqli_fetch_array($groups_query)){
        array_push($groups,$group);
    }


$universities = array();
    //Get course data from the old database
    $sql = "SELECT * FROM `parent_university`";
    $universities_query = mysqli_query($con,$sql);
    while($university = mysqli_fetch_array($universities_query)){
        array_push($universities,$university);
    }


$schools = array();
    //Get course data from the old database
    $sql = "SELECT * FROM `university`";
    $schools_query = mysqli_query($con,$sql);
    while($school = mysqli_fetch_array($schools_query)){
        array_push($schools,$school);
    }


mysqli_close($con);



// Create connection to the new database
$con = mysqli_connect("localhost","root","","urlinq_new");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}else{
    echo "Successfully connected to DB";
}
//Insert data from old database into new
mysqli_query($con,"SET FOREIGN_KEY_CHECKS = 0");




//COURSE
    mysqli_query($con,"TRUNCATE TABLE course");
    mysqli_query($con,"ALTER TABLE `course` AUTO_INCREMENT=1");
    foreach ($courses as $course) {
        try {
            mysqli_query($con,"INSERT INTO `course`(`course_id`, `course_tag`, `department_id`, `school_id`, `course_name`, `course_desc`, `course_credits`, `course_type`, `picture_file_id`, `course_visibility_id`)
            VALUES (NULL,'" . $course['course_id'] . "'," . intval($course['dept_id']) . "," . intval($course['univ_id']) . ",'" . $course['course_name'] . "','" . $course['course_desc'] . "'," . intval($course['course_credits']). ",'" . $course['course_type'] . "',1," . intval($course['course_visibility_id']) . ")");
                                              //picture_file_id
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

//CLASS
    mysqli_query($con,"TRUNCATE TABLE class");
    mysqli_query($con,"ALTER TABLE `class` AUTO_INCREMENT=1");
    foreach ($classes as $class) {
        try {
            //Class should refer to the autoincremented ID in course, not the course_tag which looks like this: BE 871X
            //Gotta find the course whose course_tag = the old course_id
            $course_query = mysqli_query($con,"SELECT * FROM course WHERE course_tag = '" . $class['course_id'] . "'");
            $course_row = mysqli_fetch_array($course_query);
            $course_id = intval($course_row['course_id']);

            mysqli_query($con,"INSERT INTO `class`(`class_id`, `course_id`, `department_id`, `school_id`, `section_id`, `private`, `semester`, `year`, `component`, `color_id`, `location`, `professor`, `cover_file_id`, `picture_file_id`, `syllabus_id`)" .
            "VALUES (NULL," . $course_id . "," . $class['dept_id'] . "," . $class['univ_id'] . ",'" . $class['section_id'] . "',". 'true' . ",'" . $class['semester'] . "','" . $class['year']. "','" . $class['component'] . "'," . $class['color_id'] . ",'" . $class['location'] . "'," . intval($class['professor']) . ",NULL,NULL," . intval($class['syllabus_id']) . ")");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


//DEPARTMENT
    mysqli_query($con,"TRUNCATE TABLE department");
    mysqli_query($con,"ALTER TABLE `departmet` AUTO_INCREMENT=1");
    foreach ($departments as $department) {
        try {
            mysqli_query($con,"INSERT INTO `department`(`department_id`, `school_id`, `department_name`, `department_description`, `department_location`, `alias`, `picture_file_id`, `cover_file_id`) VALUES (NULL," . $department['univ_id'] .",'" . $department['dept_name'] . "','" . $department['dept_desc'] . "','" . $department['dept_location'] . "','" . $department['alias'] . "'," . 'NULL' . "," . 'NULL' . ")");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


//PROFESSOR
    mysqli_query($con,"TRUNCATE TABLE user");
    mysqli_query($con,"ALTER TABLE `user` AUTO_INCREMENT=1");
    foreach ($professors as $professor) {
        try {
            //INSERT INTO `user`(`user_id`, `user_email`, `user_type`, `firstname`, `lastname`, `department_id`, `school_id`, `user_bio`, `picture_file_id`, `status`, `gender`, `available`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12])
            mysqli_query($con,"INSERT INTO `user`(`user_id`, `user_email`, `user_type`, `firstname`, `lastname`, `department_id`, `school_id`, `user_bio`, `picture_file_id`, `status`, `gender`, `available`)" .
                " VALUES (NULL,'" . $professor['user_email'] . "','" . $professor['user_type'] . "','" . $professor['firstname'] . "','" . $professor['lastname'] ."'," . $professor['dept_id'] . "," . $professor['univ_id'] . ",'" . $professor['user_bio'] . "'," .  'NULL' . ",'" . $professor['status'] . "','" . $professor['gender'] . "'," . $professor['Available'] . ")");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


//GROUP
    mysqli_query($con,"TRUNCATE TABLE group");
    mysqli_query($con,"ALTER TABLE `group` AUTO_INCREMENT=1");
    foreach ($groups as $group) {
        try {
            mysqli_query($con,"INSERT INTO `group`(`group_id`, `school_id`, `group_name`, `group_desc`, `color_id`, `contact_email`, `website`, `founded_on`, `picture_file_id`, `cover_file_id`) " .
                "VALUES (NULL," . $group['univ_id'] . ",'" . $group['group_name'] . "','" . $group['group_desc'] . "'," . $group['color_id'] . ",'" . $group['contact_email'] . "','" . $group['website'] . "','" . $group['founded_on'] . "'," . 'NULL' . "," .  'NULL'. ")");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

//UNIVERSITY
    mysqli_query($con,"TRUNCATE TABLE university");
    mysqli_query($con,"ALTER TABLE `university` AUTO_INCREMENT=1");
    foreach ($universities as $university) {
        try {
            //INSERT INTO `university`(`university_id`, `university_name`, `university_location`, `alias`, `website_url`, `picture_file_id`, `cover_file_id`, `fb_link`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])
            mysqli_query($con,"INSERT INTO `university`(`university_id`, `university_name`, `university_location`, `alias`, `website_url`, `picture_file_id`, `cover_file_id`, `fb_link`)".
                " VALUES (NULL,'" . $university['parent_univ_name'] . "','" . $university['parent_univ_location'] . "','" . $university['alias'] . "','" . $university['weblink'] . "',NULL,NULL,NULL)");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

//SCHOOL
    mysqli_query($con,"TRUNCATE TABLE school");
    mysqli_query($con,"ALTER TABLE `school` AUTO_INCREMENT=1");
    foreach ($schools as $school) {
        try {
            mysqli_query($con,"INSERT INTO `school`(`school_id`, `university_id`, `school_name`, `school_location`, `school_description`, `fb_link`, `twitter_link`, `alias`, `weblink`, `picture_file_id`, `cover_file_id`) " .
                "VALUES (NULL," . $school['parent_univ_id'] . ",'" . $school['univ_name'] . "','" . $school['univ_location'] . "','" . $school['univ_desc'] . "','" . $school['fb_link'] . "','" . $school['twitter_link'] . "','" . $school['alias'] . "','" . $school['weblink'] . "',NULL,NULL)");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }







mysqli_query($con,"SET FOREIGN_KEY_CHECKS = 1");

mysqli_close($con);


function post($url,$data){

//    $url = 'http://server.com/path';
//    $data = array('key1' => 'value1', 'key2' => 'value2');

// use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

}

//var_dump($professors);

//
//mysqli_query($con,"TRUNCATE TABLE `user`");
//mysqli_query($con,"ALTER TABLE `user` AUTO_INCREMENT=1");
//for ($x=0; $x<=30; $x++) {
//    try {
//
//        mysqli_query($con,"INSERT INTO `mydb`.`user` (`user_id`, `name`, `password`,`creation_datetime`) VALUES (NULL, 'User" . (string) $x . "' , 'test' ,CURRENT_TIMESTAMP)");
//
//        //mysqli_query($con,"INSERT INTO user (name) VALUES ('User" . (string) $x . "'");
//    } catch (Exception $e) {
//        echo 'Caught exception: ',  $e->getMessage(), "\n";
//    }
//
//}
//
//
////GET GROUP MEMBER ASSOCIATION
//// date_default_timezone_set("UTC");
//
//// $query = mysqli_query($con,"SELECT * FROM `group_members` WHERE `id` = 1");
//// $row = mysqli_fetch_array($query);
//// echo $row['joined_datetime'];
//
//
//
//date_default_timezone_set("UTC");
//
//
//
//
//// //Add first 20 users to group with group_id 1
//mysqli_query($con,"TRUNCATE TABLE `group_members`");
//mysqli_query($con,"ALTER TABLE `group_members` AUTO_INCREMENT=1");
//for ($x=0; $x<=20; $x++) {
//    try {
//
//        // $query = mysqli_query($con,"SELECT * FROM `user` WHERE `user_id` = " . $x ."");
//        // //$row = mysqli_fetch_array($query)[0];
//        // $row = mysqli_fetch_array($query);
//        // echo $row['name'];
//        // echo "<br>";
//
//
//        $date = date("Y-m-d H:i:s", time());
//        //$datetime = new DateTime($date);
//
//        $datetime = new DateTime($date);
//        //$datetime->modify('-' . (string)$x . ' week');
//        $datetime->modify('-' . (string)$x . ' week');
//        $date = $datetime->format('Y-m-d H:i:s');
//        //INSERT INTO `mydb`.`group_members` (`id`, `group_id`, `user_id`, `joined_datetime`) VALUES (NULL, '1', '3', UTC_TIME())
//        //mysqli_query($con,"INSERT INTO `mydb`.`group_members` (`id`, `group_id`, `user_id`, `joined_datetime`) VALUES (NULL, '1', '" . (string)$x . "', " . $date . ")");
//
//        mysqli_query($con,"INSERT INTO `mydb`.`group_members` (`id`, `group_id`, `user_id`, `joined_datetime`) VALUES (NULL, '1', '" . ($x + 1) . "', '$date')");
//        // echo $datetime->format('Y-m-d H:i:s');
//        // echo gettype($datetime);
//
//    } catch (Exception $e) {
//        echo 'Caught exception: ',  $e->getMessage(), "\n";
//    }
//
//}
//
//
//mysqli_close($con);



?>