<?php

/* Insert the event details retreived from the page and insert them into the database. */
$host = "localhost";
$user = "campusla_UrlinqU";
$password = "PASSurlinq@word9";
$database = "campusla_urlinq_demo";

$con = mysqli_connect($host, $user, $password, $database);
//Checking connection
if (mysqli_connect_errno()) {
    echo "Failed to connect";
}

$title = mysqli_escape_string($con, $_POST['event_name']);
$date = mysqli_escape_string($con, $_POST['event_date']);
$time = mysqli_escape_string($con, $_POST['event_time']);
//$pos = strpos($time, "PM");
//if (!$pos === false){
//    $time
//}

$date = $date . $time;
$date = strtotime($date);
$date = date("Y-m-d H:i:sa", $date);

$sql = "INSERT INTO personal_event (title, description, start)
VALUES ('$title', ' ', '$date')";

if (!mysqli_query($con, $sql)) {
    echo "Error in executing query";
}

$number_of_events = 5;

if (mysqli_connect_errno()) {
    echo "Failed to connect";
}

$event = mysqli_query($con, "SELECT * FROM personal_event ORDER BY start");
$count = mysqli_num_rows($event);

$event_count = 0;
$events_array = array();

if (TRUE) {
    while ($row = mysqli_fetch_array($event)) {
        if ($event_count == 5) {
            break;
        }

        $event_id = $row['eventid'];
        $title = $row['title'];     //Extracting title field from the event
        $startdate = $row['start']; //Extracting datetime from the event  
        $datetime = explode(" ", $startdate);
        $date = $datetime[0];
        $time = $datetime[1];
        $date = date("l M j", strtotime($date));
        $time = date("g:i a", strtotime($time));
        $now = isNow($startdate);
//                                                echo nl2br($now . "\r\n");
        if ($now == 40) {
            continue;
        } else if ($now == 1) {
            $events_array[] = array("Now", $title, $date, $event_id);
        } else if ($now == 0) {
            $events_array[] = array($time, $title, $date, $event_id);
        }
        $event_count++;
    }
}
/* events_array structure
 *      (array(True or False - specify isNow, Title of the event, time_array(H,M,S), date_array(Y,M,D))
 */

function isNow($startdate) {
    date_default_timezone_set('America/New_York');
    $system_date = date('Y-m-d g:i:sa', time());
    $system_date = strtotime($system_date);
    $startdate = strtotime($startdate);
    $diff = round(($startdate - $system_date) / 60, 2);
//                                            echo nl2br($diff . "\r\n");
    if ($diff < 0.00) {
        return 40;
    } else if ($diff < 30.00) {
        return 1;
    } else {
        return 0;
    }
}

function get_time($time) {
    $time_array = explode(":", $time);
    return $time_array;
}

function get_date($date) {
    $date_array = explode("-", $date);
    return $date_array;
}

function isToday($date) {
    date_default_timezone_set('America/New_York');
    $system_date = date('l M j', time());
    $system_date = strtotime($system_date);
    $date = strtotime($date);
    if (($system_date - $date) == 0.00) {
        return True;
    } else {
        return False;
    }
}

$events_array = array_values($events_array);
$prev_day = 0;
$echo_string = "";

if (count($events_array) === 0) {
    $echo_string . "No events";
} else {
    foreach ($events_array as $value) {
        if ($prev_day === 0) {
            $prev_day = $value[2];
            if (isToday($value[2])) {
                $echo_string = $echo_string . '<div class = "pl_day">
                         <div class = "fl_l">' . 'Today' . '</div>
                      </div>';
            } else {
                $echo_string = $echo_string . '<div class = "pl_day">
                        <div class = "fl_l">' . $value[2] . '</div>
                      </div>';
            }
        } else if ($prev_day !== $value[2]) {
            $prev_day = $value[2];
            if (isToday($value[2])) {
                $echo_string = $echo_string . '<div class = "pl_day">
                                                        <div class = "fl_l">' . 'Today' . '</div>
                                                     </div>';
            } else {
                $echo_string = $echo_string . '<div class = "pl_day">
                                                        <div class = "fl_l">' . $value[2] . '</div>
                                                     </div>';
            }
        }
        if ($value[0] == "Now") {
            $echo_string = $echo_string . '<div class = "upcoming upc-1 id="event'.$value[3].'" ">
                                                        <div class = "upc-floatL">
                                                            <div class = "current time">' . $value[0] . '</div>
                                                        </div>
                                                        <div class = "upc-eventL">
                                                            <div class = "evntName">' . $value[1] . '</div>
                                                        </div>

                                                        <div class="toDowrapper" id="w-2-2'.$value[3].'">
                                                            <div class="button-block">
                                                                <button type="button">
                                                                    <i class="mark x"></i>
                                                                    <i class="mark xx"></i>
                                                                </button>
                                                        </div>
                                                </div>  

                                            </div>';
        } else {
            $echo_string = $echo_string . '<div class = "upcoming upc-1 id="event'.$value[3].'" ">
                                                        <div class = "upc-floatL">
                                                            <div class = "time">' . $value[0] . '</div>
                                                        </div>
                                                        <div class = "upc-eventL">
                                                            <div class = "evntName">' . $value[1] . '</div>
                                                        </div>

                                                        <div class="toDowrapper" id="w-2-2'.$value[3].'">
                                                            <div class="button-block">
                                                                <button type="button">
                                                                    <i class="mark x"></i>
                                                                    <i class="mark xx"></i>
                                                                </button>
                                                        </div>
                                                </div>  

                                            </div>';
        }
    }
}

$json = array(
    'echo_string' => $echo_string,
    'event_count' => count($events_array).' Incomplete'
);
$jsonstring = json_encode($json);
echo $jsonstring;

//$insert_st->close();
mysqli_close($con);
?>
