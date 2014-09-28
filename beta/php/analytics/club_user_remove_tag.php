

<?php

if (isset($_POST['group_id']) && isset($_POST['user_id']) && isset($_POST['tag'])) {
    require_once '../../includes/common_functions.php';
    require_once '../dbconnection.php';
    $group_id = input_sanitize($_POST['group_id'],$con);
    $user_id = input_sanitize($_POST['user_id'],$con);
    $tag = input_sanitize($_POST['tag'],$con);

    $json_data_array = array('success'=>'true');

    $tag_id = '';
    $tag_result = mysqli_query($con,"SELECT * FROM tags WHERE tag = '$tag'");
    //Only do something if the tag exists, will always exist if passed by the javascript
    if($tag_row = mysqli_fetch_array($tag_result)){
       $tag_id = $tag_row['tag_id'];
       $tag_result->close();
       $con->query("DELETE FROM `group_users_tags` WHERE tag_id = '$tag_id' AND user_id = '$user_id' AND group_id = '$group_id'");
    }else{
        $json_data_array['success'] = 'false';
    }

    echo json_encode($json_data_array);

}




?>