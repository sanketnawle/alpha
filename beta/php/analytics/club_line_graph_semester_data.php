<?php

if (isset($_GET['group_id'])) {
    try {

        require_once '../../includes/common_functions.php';
        require_once '../dbconnection.php';

        $group_id = input_sanitize($_GET['group_id'],$con);



        $json_data_array = array('attendance_count'=> 0,'invite_count'=>0,'dates' => array());

        //Semester is ~ 4 months, 4 weeks per month
        for ($x=0; $x<=16; $x++) {
            //get current datetime
            $date = date("Y-m-d H:i:s", time());
            $datetime = new DateTime($date);
            //Subtract x amt of weeks from current date
            $datetime->modify('-' . (string)$x . ' week');
            $date = $datetime->format('Y-m-d H:i:s');

            //dates stored as Y-m-d => attendance_count
            $date_key = $datetime->format('Y-m-d');
            $date_data = array($date_key=>0);
            //Find events that happened during the same week as this current $date

            $events_result = mysqli_query($con,"SELECT * FROM group_event WHERE YEARWEEK(`start_date`) = YEARWEEK('$date_key') AND group_id =  '$group_id'");
            while($event_row = mysqli_fetch_array($events_result)){
                $event_id = $event_row['event_id'];
                //count accepted invites for this event
                if ($event_accepted_invites_result = $con->query("SELECT * FROM group_event_invited WHERE event_id = '$event_id' AND added = 1")) {
                    $accepted_invites_count = mysqli_num_rows($event_accepted_invites_result);
                    $date_data[$date_key] += $accepted_invites_count;
                    $json_data_array['attendance_count'] += $accepted_invites_count;
                    $event_accepted_invites_result->close();
                }

                //Count all the invites sent out for this event and add to invite_count
                if ($event_invites_result = $con->query("SELECT * FROM group_event_invited WHERE event_id = '$event_id'")) {
                    $json_data_array['invite_count'] += mysqli_num_rows($event_invites_result);
                    $event_invites_result->close();
                }
            }


            array_push($json_data_array['dates'], $date_data);
        }

        echo json_encode($json_data_array);

    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }


}else{
    echo 'error';
}



?>
