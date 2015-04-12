<?php


if (isset($_GET['group_id'])) {
    // ../ goes to parent directory

    try {

        require_once '../../includes/common_functions.php';
        require_once '../dbconnection.php';

        $group_id = input_sanitize($_GET['group_id'],$con);


        $group_users = mysqli_query($con,"SELECT * FROM `group_users` WHERE group_id = '$group_id'");


        $json_data_array = array('freshman_count' => 0,'sophomore_count' => 0,'junior_count' => 0,'senior_count' => 0,'graduate_count' => 0,'total_count' => 0);


        while($row = mysqli_fetch_array($group_users)){
            $user_id = $row['user_id'];
            $user = get_user_info($con,$user_id);
            //if the user is a student, query their student attributes
            if($user['user_type'] == 's'){
                //$user_attribs = get_student_attribs($con,$user_id);
                $user_attribs_query = mysqli_query($con,"SELECT * FROM `student_attribs` WHERE user_id = '$user_id'");
                $user_attribs = mysqli_fetch_array($user_attribs_query);
//                $stmt = $dbConnection->prepare('SELECT * FROM employees WHERE name = ?');
//                $stmt->bind_param('s', $name);
//
//                $stmt->execute();
//
//                $result = $stmt->get_result();
//                while ($row = $result->fetch_assoc()) {
//                    // do something with $row
//                }

            //user ids: 285/286/350
                //$group_users = mysqli_query($con,"SELECT * FROM `group_users` WHERE group_id = '$group_id'");
                $json_data_array['total_count'] += 1;
                if($user_attribs['student_type'] == 'grad' || $user_attribs['student_type'] == 'phd'){
                    $json_data_array['graduate_count'] += 1;
                }elseif($user_attribs['student_type'] == 'undergrad'){
                    $user_grad_year_int = intval($user_attribs['year']);
                    $current_year_int = intval(date("Y"));
                    $year_delta = $user_grad_year_int - $current_year_int;

                    if($year_delta == 4){
                        $json_data_array['freshman_count'] += 1;
                    }elseif($year_delta == 3){
                        $json_data_array['sophomore_count'] += 1;
                    }elseif($year_delta == 2){
                        $json_data_array['junior_count'] += 1;
                    }elseif($year_delta == 1){
                        $json_data_array['senior_count'] += 1;
                    }
                }
            }
        }

        echo json_encode($json_data_array);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }


}else{
    echo 'error';
}



?>