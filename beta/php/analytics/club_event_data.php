<?php

if (isset($_GET['group_id'])) {
    require_once '../../includes/common_functions.php';
    require_once '../dbconnection.php';
    $group_id = input_sanitize($_GET['group_id'],$con);



    $json_data_array = array('events' => array());


    if ($events_result = $con->query("SELECT * FROM group_event WHERE group_id = '$group_id'")) {
        $json_data_array['event_count'] = mysqli_num_rows($events_result);
        $events_result->close();
    }
    //Get all the events for this group

    $group_events_result = mysqli_query($con,"SELECT * FROM `group_event` WHERE group_id = '$group_id'");
    while($event_row = mysqli_fetch_array($group_events_result)){
        $event_data = array('attendees'=>array(),'invite_count'=> 0,'accepted_invite_count'=>0,'graduate_count'=>0,'freshman_count'=>0,'sophomore_count'=>0,'junior_count'=>0,'senior_count'=>0,'male_count'=>0,'female_count'=>0);
        $event_id = $event_row['event_id'];
        $event_data['event_title'] = $event_row['title'];
        $event_data['event_id'] = $event_id;
        //Get datetime string (Y-m-d H:m:s) then convert to milliseconds so javascript can easily create date
        $event_data['datetime'] = strtotime($event_row['start_date'] . ' ' . $event_row['start_time'])*1000;
        //Get # of accepted invites for this group

        $event_accepted_invites_result = mysqli_query($con,"SELECT * FROM group_event_invited WHERE event_id = '$event_id' AND added = 1");


        while($invite_row = mysqli_fetch_array($event_accepted_invites_result)){

            //Get user id from invite
            $user_id = $invite_row['user_id'];


            $user_info = get_user_info($con,$user_id);
            if($user_info['user_type'] == 's'){
                $user_json = array('id' => $user_id,'name' => '', 'attendance_count' => 0,'attendance_percent_str' => '');
                $user_json['name'] = $user_info['firstname'] . ' ' . $user_info['lastname'];
                $user_json['user_type'] = $user_info['user_type'];


                //Tally this users gender in count
                if($user_info['gender'] == 'M'){
                    $event_data['male_count'] += 1;
                }else{
                    $event_data['female_count'] += 1;
                }

            //make sure user is student
            //if($user_info['user_type'] == 's'){
                $group_events = mysqli_query($con,"SELECT * FROM `group_event` WHERE group_id = '$group_id'");
                while($group_event_row = mysqli_fetch_array($group_events)){
                    $event_id = $group_event_row['event_id'];
                    //Gets the invite for specific user
                    $group_event_invites = mysqli_query($con,"SELECT * FROM `group_event_invited` WHERE event_id = '$event_id' AND user_id='$user_id' AND added = 1");
                    while($group_event_invite_row = mysqli_fetch_array($group_event_invites)){
                        $user_json['attendance_count'] += 1;
                    }
                }

                $attendance_percent = 0.0;


                if($json_data_array['event_count'] != 0){
                    $attendance_percent = round(($user_json['attendance_count'] / $json_data_array['event_count']),2);
                }

                $user_json['attendance_percent_str'] = strval($attendance_percent * 100) . '%';

                //Add $user_json to the json data being passed back to javascript
                array_push($event_data['attendees'], $user_json);

            //}


            //Add to this events attendee class rank data
            //if($user_info['user_type'] == 's'){
                $user_attribs_query = mysqli_query($con,"SELECT * FROM `student_attribs` WHERE user_id = '$user_id'");
                $user_attribs = mysqli_fetch_array($user_attribs_query);


                //$event_data['total_count'] += 1;  This data is already held by event['accepted_invite_count']
                if($user_attribs['student_type'] == 'grad' || $user_attribs['student_type'] == 'phd'){
                    $event_data['graduate_count'] += 1;
                }elseif($user_attribs['student_type'] == 'undergrad'){
                    $user_grad_year_int = intval($user_attribs['year']);
                    $current_year_int = intval(date("Y"));
                    $year_delta = $user_grad_year_int - $current_year_int;

                    if($year_delta == 4){
                        $event_data['freshman_count'] += 1;
                    }elseif($year_delta == 3){
                        $event_data['sophomore_count'] += 1;
                    }elseif($year_delta == 2){
                        $event_data['junior_count'] += 1;
                    }elseif($year_delta == 1){
                        $event_data['senior_count'] += 1;
                    }
                }
            }



        }


        $event_data['accepted_invite_count'] = count($event_data['attendees']);

        //Count all the invites sent out for this event and add to invite_count
        if ($event_invites_result = $con->query("SELECT * FROM group_event_invited WHERE event_id = '$event_id'")) {
            $event_data['invite_count'] += mysqli_num_rows($event_invites_result);
            $event_invites_result->close();
        }



        array_push($json_data_array['events'],$event_data);
    }



    echo json_encode($json_data_array);
}


?>