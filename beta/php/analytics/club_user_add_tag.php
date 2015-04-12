

<?php

if (isset($_POST['group_id']) && isset($_POST['user_id']) && isset($_POST['tag'])) {
    require_once '../../includes/common_functions.php';
    require_once '../dbconnection.php';
    $group_id = input_sanitize($_POST['group_id'],$con);
    $user_id = input_sanitize($_POST['user_id'],$con);
    $tag = input_sanitize($_POST['tag'],$con);

    $json_data_array = array('success'=>'true');


    $tag_id = '';

    //Check if the tag exists in database yet
    $tag_result = mysqli_query($con,"SELECT * FROM tags WHERE tag = '$tag'");
    if($tag_row = mysqli_fetch_array($tag_result)){
       $tag_id = $tag_row['tag_id'];
    }else{
        //Tag doesnt exist, create it
        mysqli_query($con,"INSERT INTO `campusla_urlinq_beta`.`tags` (`tag_id`, `tag`) VALUES (NULL, '$tag')");
        $tag_id = mysqli_insert_id($con);
    }
    $tag_result->close();


    $con->query("INSERT INTO `campusla_urlinq_beta`.`group_users_tags` (`tag_id`, `user_id`, `group_id`) VALUES ('$tag_id', '$user_id', '$group_id')");


    echo json_encode($json_data_array);
}




?>