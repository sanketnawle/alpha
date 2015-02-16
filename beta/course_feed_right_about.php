<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/8/14
 * Time: 12:16 PM
 */

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
}
include 'php/dbconnection.php';


$get_course_about_query = "SELECT course_desc FROM courses WHERE course_id = '$course_id'";
$get_course_about_query_result = $con->query($get_course_about_query);

$course_about_row = $get_course_about_query_result->fetch_array();
if ($course_about_row) {
    if (strlen($course_about_row['course_desc']) > 250)
        $course_about_row['course_desc'] = substr($course_about_row['course_desc'], 0, 247) . "...";
} else {
    if ($course_about_row['course_desc'] == NULL or $course_about_row['course_desc'] == 'NULL')
        $course_about_row['course_desc'] = "No description is available";
}

echo "
        <div class='group-about'>
            <div class='box-header'>
                <span class='bh-t1'>
                    ABOUT
                </span>

            </div>
            <div class='box-content content-about'>" . $course_about_row['course_desc'] . "
            </div>
        </div>
";