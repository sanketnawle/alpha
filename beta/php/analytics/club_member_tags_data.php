<?php

if (isset($_GET['group_id'])) {
    try {

        require_once '../../includes/common_functions.php';
        require_once '../dbconnection.php';

        $group_id = input_sanitize($_GET['group_id'],$con);



        $json_data_array = array('users' => array());


        if ($events_result = $con->query("SELECT * FROM group_event WHERE group_id = '$group_id'")) {
            $json_data_array['event_count'] = mysqli_num_rows($events_result);
            $events_result->close();
        }


        $group_users = mysqli_query($con,"SELECT * FROM `group_users` WHERE group_id = '$group_id'");
        while($group_user_row = mysqli_fetch_array($group_users)){
            $user_id = $group_user_row['user_id'];
            $user = get_user_info($con,$user_id);
            $user_json = array('name' => '', 'attendance_count' => 0,'attendance_percent_str' => '','join_time' => 0);
            $user_json['name'] = $user['firstname'] . ' ' . $user['lastname'];
            //Convert php datetime to milliseconds for the javascript new Date(milliseconds) function
            $user_json['join_time'] = strtotime($group_user_row['join_time'])*1000;
            //make sure user is student
            if($user['user_type'] == 's'){
                $group_events = mysqli_query($con,"SELECT * FROM `group_event` WHERE group_id = '$group_id'");
                while($group_event_row = mysqli_fetch_array($group_events)){
                    $event_id = $group_event_row['event_id'];

                    //Gets the invite for specific user
                    $group_event_invites = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `group_event_invited` WHERE event_id = '$event_id'"));
                    while($group_event_invite_row = mysqli_fetch_array($group_event_invites)){
                        //If the added field = 1, we can assume user attended the event
                        if($group_event_invite_row['added'] == 1){
                            $user_json['attendance_count'] += 1;
                        }
                    }
                }
            }

            $attendance_percent = round(($user_json['attendance_count'] / $json_data_array['event_count']),2);
            $user_json['attendance_percent_str'] = strval($attendance_percent * 100) . '%';

            //Add $user_json to the json data being passed back to javascript
            array_push($json_data_array['users'], $user_json);
        }

        echo json_encode($json_data_array);













    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }


}else{
    echo 'error';
}



?>
