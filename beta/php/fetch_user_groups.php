<?php

include 'dbconnection.php';
require_once '../includes/common_functions.php';
session_start();

$course_array = array();
$group_array = array();
$month_date = date("Y-m-d", strtotime("now"));

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
}
if (isset($_SESSION['univ_id'])) {
    $univ_id = $_SESSION['univ_id'];
}

$current_semester = get_current_semester($con, $univ_id);

if (isset($_POST['month_date'])) {
    $month_date = $_POST['month_date'];
}
//echo $month_date;
//Starting of the month
$month_start = date("Y-m-01", strtotime($month_date));
//-7 days from month start
$month_start = date("Y-m-d", strtotime("-7 days", strtotime($month_start)));
//Month end
$month_end = date("Y-m-t", strtotime($month_date));
//+7 days from month start
$month_end = date("Y-m-d", strtotime("+7 days", strtotime($month_end)));


$range = $month_end;

$current_year = date("Y", strtotime("now"));

$get_group_query = "SELECT
  G.group_name,
  CO.red_code,
  CO.green_code,
  CO.blue_code,
  G.group_id
FROM groups G
  LEFT JOIN event_color_table CO ON G.color_id = CO.color_id
WHERE G.group_id IN (SELECT
                       GE.group_id
                     FROM group_event GE
                     WHERE GE.start_date >= '$month_start' AND GE.end_date <= '$month_end' AND GE.event_id IN (SELECT GI.event_id FROM group_event_invited GI WHERE GI.user_id = $user_id AND GI.added = 1)) OR G.group_id IN (SELECT GE.group_id FROM group_event GE WHERE GE.user_id = $user_id AND GE.start_date >= '$month_start' AND GE.end_date <= '$month_end')";
$get_group_query_result = $con->query($get_group_query);

while ($row = mysqli_fetch_array($get_group_query_result)) {
    $dp_link = get_dp($con, $row['group_id'], 'club');
    $group_array[] = array(
        'group_name' => $row['group_name'],
        'group_id' => $row['group_id'],
        'red_color' => $row['red_code'],
        'green_color' => $row['green_code'],
        'blue_color' => $row['blue_code'],
        'dp_link' => $dp_link
    );
}


$get_course_query = "SELECT
  C.course_name,
  CO.red_code,
  CO.green_code,
  CO.blue_code,
  CM.class_id
FROM courses_semester CM
LEFT JOIN event_color_table CO on CO.color_id = CM.color_id
LEFT JOIN courses C on C.course_id = CM.course_id
WHERE CM.class_id IN (SELECT
                            CE.class_id
                          FROM course_event CE
                          WHERE CE.start_date >= '$month_start' AND CE.end_date <= '$month_end' AND CE.event_id IN (SELECT CI.event_id FROM course_event_invited CI WHERE CI.user_id = 350 AND CI.choice = 1))  OR CM.class_id IN (SELECT CE.class_id from course_event CE WHERE CE.user_id = $user_id AND CE.start_date >= '$month_start' AND CE.end_date <= '$month_end')";
$get_course_query_result = $con->query($get_course_query);

while ($row = mysqli_fetch_array($get_course_query_result)) {
    $dp_link = get_dp($con, $row['class_id'], 'class');
    $course_array[] = array(
        'course_name' => $row['course_name'],
        'class_id' => $row['class_id'],
        'red_color' => $row['red_code'],
        'green_color' => $row['green_code'],
        'blue_color' => $row['blue_code'],
        'dp_link' => $dp_link
    );
}


$json = array(
    'course_array' => $course_array,
    'group_array' => $group_array
);

$jsonstring = json_encode($json);
echo $jsonstring;
?>