    <?php
$sid = 0;
$today_time = strtotime("now");
if (isset($_GET['student_id'])) {
    $sid = $_GET['student_id'];
}
if (isset($_GET['time'])) {
    $today_time = $_GET['time'];
}

include ("dbconnection.php");

$datetime = date("Y-m-d", $today_time);
$datetime_today_start = $datetime . " 00:00:00";            //Today Midnight
$datetime_today_end = $datetime . " 23:59:59";              //Today End of Time

$datetime_3Ahead = date("Y-m-d", $today_time + (3*24*60*60));     //3 Days from Today
$datetime_3Ahead = $datetime_3Ahead . " 23:59:59";

$datetime_7Ahead = date("Y-m-d", $today_time + (6*24*60*60));     //Week End
$datetime_7Ahead = $datetime_7Ahead . " 23:59:59";


$sql = "SELECT * from personal_event WHERE `s_id`= $sid AND `start` >= '$datetime_today_start' ";


echo nl2br("\r\n");

$event = mysqli_query($con, $sql);

$today_event = array();
$exam_event = array();
$week_event = array();

while ($row = mysqli_fetch_array($event)) {
    if ($row['start'] <= $datetime_today_end) {
        $today_event[] = array($row['title'], $row['start'], $row['ischeck']);
//        echo "Today event: " . $row['title'];
//        echo nl2br("\r\n");
    } else if (!stristr($row['title'], 'EXAM') === FALSE) {
        if ($row['start'] <= $datetime_3Ahead) {
            $exam_event[] = array($row['title'], $row['start']);
//            echo "Exam event: " . $row['title'];
//            echo nl2br("\r\n");
        }
    } else if (date('D', $today_time) === 'Mon') {
        if ($row['start'] <= $datetime_7Ahead) {
            $week_event[] = array($row['title'], $row['start']);
//            echo "Week events: " . $row['title'];
//            echo nl2br("\r\n");
        }
    }
}

//$sql1 = "SELECT isseen from event_notifications WHERE `sid`= $sid";
//
//$event1 = mysqli_query($con, $sql1);
//
//while($row = mysqli_fetch_array($event1)){
//    if($row['isseen'] == 0){
//        $show = 1;
//    }
//}

$json = array(
    'today_event' => $today_event,
    'week_event' => $week_event,
    'exam_event' => $exam_event
);

$json_string = json_encode($json);
echo $json_string;
?>
