<?php


if (isset($_GET['group_id'])) {
    // ../ goes to parent directory

    require_once '../../includes/common_functions.php';
    require_once '../dbconnection.php';
    $group_id = input_sanitize($_GET['group_id'],$con);

    $query = mysqli_query($con,"SELECT * FROM `group_users` WHERE group_id = '$group_id'");
    $json_data_array = array('female_count' => 0,'male_count' => 0);
    while($row = mysqli_fetch_array($query)){
        $user_id = $row['user_id'];
        $user = get_user_info($con,$user_id);

        //only count students
        if($user['user_type'] == 's'){
            if($user['gender'] == 'M'){
                $json_data_array['male_count'] += 1;
            }else{
                $json_data_array['female_count'] += 1;
            }
        }

    }

    echo json_encode($json_data_array);

}

?>