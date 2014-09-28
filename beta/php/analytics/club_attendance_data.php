<?php


//Restricts requests with same origin policy (javascript AJAX)
//header('Access-Control-Allow-Origin: http://' . $_SERVER["SERVER_NAME"]);



//Check if request is authenticated

//session_start();
//if(!isset($_SESSION['user_id'])){
//    exit("Not authenticated.");
//}
//
//
//
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    if (isset($_SERVER["HTTP_ORIGIN"])) {
//        $address = "http://".$_SERVER["SERVER_NAME"];
//        if (strpos($address, $_SERVER["HTTP_ORIGIN"]) !== 0) {
//            exit('Origin does not match.');
//        }
//    }else{
//        echo "Http origin not set";
//    }
//}







if (isset($_GET['group_id'])) {
    require_once '../../includes/common_functions.php';
    require_once '../dbconnection.php';
    $group_id = input_sanitize($_GET['group_id'],$con);
    $filter = $_GET['filter'];


    $json_data_array = array('invite_count' => 0,'accepted_invite_count'=>0);

    $sql_str = '';
    if (strpos($filter, 'Week') !== FALSE){
        $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND yearweek(`start_date`) = yearweek(curdate())";
    }elseif(strpos($filter, 'Month') !== FALSE){
        $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND MONTH(`start_date`) = MONTH(curdate())";
    }elseif(strpos($filter, 'Semester') !== FALSE){
        $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND YEAR(`start_date`) = YEAR(curdate())";
    }

    $group_events_result = mysqli_query($con,$sql_str);
    while($event_row = mysqli_fetch_array($group_events_result)){
        $event_id = $event_row['event_id'];

        //Count all the invites sent out for this event and add to invite_count
        if ($event_invites_result = $con->query("SELECT * FROM group_event_invited WHERE event_id = '$event_id'")) {
            $json_data_array['invite_count'] += mysqli_num_rows($event_invites_result);
            $event_invites_result->close();
        }

        //Count all the accepted invites
        if ($event_accepted_invites_result = $con->query("SELECT * FROM group_event_invited WHERE event_id = '$event_id' AND added = 1")) {
            $json_data_array['accepted_invite_count'] += mysqli_num_rows($event_accepted_invites_result);
            $event_accepted_invites_result->close();
        }

    }



    echo json_encode($json_data_array);
}


?>