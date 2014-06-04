<?php
$host = "localhost";
$user = "campusla_UrlinqU";
$password = "PASSurlinq@word9";
$database = "campusla_urlinq_demo";

$sid = 0;
if (isset($_GET['student_id'])) {
    $sid = $_GET['student_id'];
}

$con = mysqli_connect($host, $user, $password, $database);

$number_of_events = 5;

if (mysqli_connect_errno()) {
    echo "Failed to connect";
}

$event = mysqli_query($con, "SELECT * FROM personal_event WHERE `s_id`= $sid ORDER BY start");
$count = mysqli_num_rows($event);

$event_count = 0;
$count_incomplete = 0;
$events_array = array();

if (TRUE) {
    while ($row = mysqli_fetch_array($event)) {
        if ($event_count == 5) {
            break;
        }
        $event_id = $row['eventid'];
        $isCheck = $row['ischeck'];
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
            $events_array[] = array("Now", $title, $date, $event_id, $isCheck);
        } else if ($now == 0) {
            $events_array[] = array($time, $title, $date, $event_id, $isCheck);
        }
        $event_count++;
        if ($isCheck == 0) {
            $count_incomplete++;
        }
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

echo '
                            <div class = "rightsec">
                                <div class = "n_pf_5">
                                    <div class = "planner">
                                        <div class = "pl_head">
                                            <div class = "pl_head_wrap">
                                                <div class = "floatL">
                                                    <div class = "text1">MY PLANNER</div>
                                                    <i class="fa fa-caret-down"></i>
                                                    <div class = "pl_options">
                                                        <div class = "pl_option">View my full planner</div>
                                                        <div class = "pl_option">View my monthly calendar</div>
                                                        <div class = "pl_option">Hide all upcoming</div>
                                                    </div>
                                                </div>
                                                <div class = "floatR">';
if ($count_incomplete == 0) {
    echo '<div id="event_count" class = "upcomingNmbr">' . 'All Complete' . '</div>';
} else {
    echo '<div id="event_count" class = "upcomingNmbr">' . $count_incomplete . ' Incomplete</div>';
}
echo '
                                                </div>

                                            </div>
                                        </div>
                                        <div class = "add_upcoming">                                            
                                                <textarea placeholder = "+ Add new Event" class = "pl_add" name="event_name" id="event_name"></textarea>
                                                <div class = "pl_addevnt">
                                                    <div class = "evnt_inps">
                                                        When<input class = "set_date" name="event_date" id="event_date"
                                                               </input>

                                                        <input id="set_time_24hr"  class = "set_time" name="event_time"></input>
                                                        <div class = "calLayer">
                                                            <section id = "mounth" class="mounth">
                                                                <header class="minical-header">
                                                                    <h1 class="minical-h1">JANUARY 2013</h1>

                                                                    <nav role="padigation">
                                                                        <span class="m-prev"></span>
                                                                        <span class="m-next"></span>
                                                                    </nav>
                                                                </header>

                                                                <article>
                                                                    <div class="days">
                                                                        <b>SU</b>
                                                                        <b>MO</b>
                                                                        <b>TU</b>
                                                                        <b>WE</b>
                                                                        <b>TH</b>
                                                                        <b>FR</b>
                                                                        <b>SA</b>
                                                                    </div>
                                                                    <div class="dates">
                                                                        <span id="calcell_su_0" class="calcell disable cl_0"></span>
                                                                        <span id="calcell_mo_1" class="calcell disable cl_1"></span>

                                                                        <span id="calcell_tu_2" class="calcell disable cl_2"></span>
                                                                        <span id="calcell_we_3" class="calcell disable cl_3"></span>
                                                                        <span id="calcell_th_4" class="calcell disable cl_4"></span>
                                                                        <span id="calcell_fr_5" class="calcell disable cl_5"></span>
                                                                        <span id="calcell_sa_6" class="calcell disable cl_6"></span>
                                                                        <span id="calcell_su_7" class="calcell disable cl_7"></span>
                                                                        <span id="calcell_mo_8" class="calcell disable cl_8"></span>
                                                                        <span id="calcell_tu_9" class="calcell disable cl_9"></span>
                                                                        <span id="calcell_we_10" class="calcell disable cl_10"></span>
                                                                        <span id="calcell_th_11" class="calcell disable cl_11"></span>
                                                                        <span id="calcell_fr_12" class="calcell disable cl_12"></span>
                                                                        <span id="calcell_sa_13" class="calcell disable cl_13"></span>
                                                                        <span id="calcell_su_14" class="calcell disable cl_14"></span>
                                                                        <span id="calcell_mo_15" class="calcell disable cl_15"></span>
                                                                        <span id="calcell_tu_16" class="calcell disable cl_16"></span>
                                                                        <span id="calcell_we_17" class="calcell disable cl_17"></span>
                                                                        <span id="calcell_th_18" class="calcell disable cl_18"></span>
                                                                        <span id="calcell_fr_19" class="calcell disable cl_19"></span>
                                                                        <span id="calcell_sa_20" class="calcell disable cl_20"></span>
                                                                        <span id="calcell_su_21" class="calcell disable cl_21"></span>
                                                                        <span id="calcell_mo_22" class="calcell disable cl_22"></span>
                                                                        <span id="calcell_tu_23" class="calcell disable cl_23"></span>
                                                                        <span id="calcell_we_24" class="calcell disable cl_24"></span>
                                                                        <span id="calcell_th_25" class="calcell disable cl_25"></span>
                                                                        <span id="calcell_fr_26" class="calcell disable cl_26"></span>
                                                                        <span id="calcell_sa_27" class="calcell disable cl_27"></span>
                                                                        <span id="calcell_su_28" class="calcell disable cl_28"></span>
                                                                        <span id="calcell_mo_29" class="calcell disable cl_29"></span>
                                                                        <span id="calcell_tu_30" class="calcell disable cl_30"></span>
                                                                        <span id="calcell_we_31" class="calcell disable cl_31"></span>
                                                                        <span id="calcell_th_32" class="calcell disable cl_32"></span>

                                                                        <span id="calcell_fr_33" class="disable calcell cl_33"></span>
                                                                        <span id="calcell_sa_34" class="disable calcell cl_34"></span>
                                                                        <span id="calcell_su_35" class="disable calcell cl_35"></span>
                                                                        <span id="calcell_mo_36" class="disable calcell cl_36"></span>
                                                                        <span id="calcell_tu_37" class="disable calcell cl_37"></span>
                                                                        <span id="calcell_we_38" class="disable calcell cl_38"></span>
                                                                        <span id="calcell_th_39" class="disable calcell cl_39"></span>
                                                                        <span id="calcell_fr_40" class="disable calcell cl_40"></span>
                                                                        <span id="calcell_sa_41" class="disable calcell cl_41"></span>
                                                                    </div>
                                                                </article>
                                                            </section>
                                                        </div>
                                                    </div>
                                                    <div class = "evnt_create">
                                                        <a class = "btn_canc">Cancel</a>
                                                        <button id="add_event" class = "btn_addvent" type = "submit">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>';


$events_array = array_values($events_array);
echo '<div id="result" class = "upcomingEvnt-wrapper">';
$prev_day = 0;

if (count($events_array) === 0) {
    echo "No events";
} else {
    foreach ($events_array as $value) {
        if ($prev_day === 0) {
            $prev_day = $value[2];
            if (isToday($value[2])) {
                echo '<div class = "pl_day">
                         <div class = "fl_l">' . 'Today' . '</div>
                      </div>';
            } else {
                echo '<div class = "pl_day">
                        <div class = "fl_l">' . $value[2] . '</div>
                      </div>';
            }
        } else if ($prev_day !== $value[2]) {
            $prev_day = $value[2];
            if (isToday($value[2])) {
                echo '<div class = "pl_day">
                                                        <div class = "fl_l">' . 'Today' . '</div>
                                                     </div>';
            } else {
                echo '<div class = "pl_day">
                                                        <div class = "fl_l">' . $value[2] . '</div>
                                                     </div>';
            }
        }
        echo '<div class = "upcoming upc-1 id="event' . $value[3] . '" ">';
        if ($value[0] == "Now") {
            echo '
                    <div class = "upc-floatL">
                        <div class = "current time">' . $value[0] . '</div>
                    </div>';
        } else {
            echo '
                    <div class = "upc-floatL">
                        <div class = "time">' . $value[0] . '</div>
                    </div>';
        }
        echo '<div class = "upc-eventL">
                        <div class = "evntName">' . $value[1] . '</div>
                    </div>';

        if ($value[4] == 0) {
            echo '<div class="toDowrapper" id="w-2-2' . $value[3] . '">
                        <div class="button-block">
                            <button type="button">
                                <i class="mark x"></i>
                                <i class="mark xx"></i>
                            </button>
                        </div>
                    </div>
            </div>';
        } else {
            echo '<div class="toDowrapper checked" id="w-2-2' . $value[3] . '">
                        <div class="button-block canceled">
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
echo '</div>';
?>