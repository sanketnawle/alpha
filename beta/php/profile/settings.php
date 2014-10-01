<?php

include_once '../dbconnection.php';
include_once '../signup_functions.php';
include_once '../../includes/common_functions.php';
session_start();

// For testing, uncomment below  lines
//    echo $_POST['cur_pwd'] = "frontline";
//    echo $_POST['new_pwd'] = "frontline1";

if(isset($_POST['cur_pwd']) && isset($_POST['new_pwd'])){
    change_pwd($con, $_POST['cur_pwd'], $_POST['new_pwd']);
}
else echo json_encode($pwd_error="Something went wrong!! Password could not be changed");

function change_pwd($con, $cur_pwd, $new_pwd){
    if(check_credentials($con, $cur_pwd)){
        $salt = salt();
        $pwd = password($new_pwd, $salt);
        $chp_query = $con->prepare("UPDATE `user_login` SET `password`=?,`salt`=?
                            WHERE user_id = ?");
        if($chp_query){
            $chp_query->bind_param('ssi',$pwd,$salt,$_SESSION['user_id']);
            if($chp_query->execute()){
                echo json_encode($pwd_success="Success!! Password changed successfully.");
                $chp_query->close();
            }
            else echo json_encode($pwd_error="Something went wrong!! Password could not be changed");
        }
        else echo json_encode($pwd_error="Something went wrong!! Password could not be changed");
    }
    else echo json_encode($pwd_error="You have entered an incorrect password");
}

?>