<?php

if (isset($_GET['group_id'])) {
    require_once '../../includes/common_functions.php';
    require_once '../dbconnection.php';
    $group_id = input_sanitize($_GET['group_id'],$con);

    $json_data_array = array('members_count' => 0,'joined_this_week' => 0,'joined_this_month' => 0,'joined_this_year' => 0);

    //SELECT * FROM group_users gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE gu.group_id = '2'
    //Get total # of members (students)
    if ($all_members_result = $con->query("SELECT * FROM group_users gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE group_id = '$group_id'")) {
        $json_data_array['members_count'] = mysqli_num_rows($all_members_result);
        $all_members_result->close();
    }

    //Get # of members who joined this week
    if ($members_joined_this_week_result = $con->query("SELECT * FROM group_users gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE yearweek(`join_time`) = yearweek(curdate()) AND `group_id` = '$group_id'")) {
        $json_data_array['joined_this_week'] = mysqli_num_rows($members_joined_this_week_result);
        $members_joined_this_week_result->close();
    }

    //Get # of members who joined this month
    if ($members_joined_month_result = $con->query("SELECT * FROM group_users gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE MONTH(`join_time`) = MONTH(curdate()) AND `group_id` = '$group_id'")) {
        $json_data_array['joined_this_month'] = mysqli_num_rows($members_joined_month_result);
        $members_joined_month_result->close();
    }


    //Get # of members who joined this year
    if ($members_joined_this_year_result = $con->query("SELECT * FROM group_users gu JOIN user u ON (gu.user_id = u.user_id AND u.user_type = 's') WHERE YEAR(`join_time`) = YEAR(curdate()) AND `group_id` = '$group_id'")) {
        $json_data_array['joined_this_year'] = mysqli_num_rows($members_joined_this_year_result);
        $members_joined_this_year_result->close();
    }

    echo json_encode($json_data_array);
}


?>