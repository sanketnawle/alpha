<?php

    require_once("dbconfig.php");
    session_start();

    if(isset($_POST['dept_id'])){
        echo $res = department_follow($con,$_SESSION['user_id'],$_POST['dept_id']) ;
    }

    function department_follow($con, $user_id, $dept_id) {
        $connect_stmt = $con->prepare("Select count(*) from department_follow where dept_id = ? and user_id = ?");
        $connect_stmt->bind_param("ii",$dept_id, $user_id);
        if($connect_stmt->execute()){
            $connect_stmt->bind_result($count);
            $connect_stmt->fetch();
            $connect_stmt->close();
        }

        if($count == 0) {
            $connect_stmt = $con->prepare("Insert into department_follow(dept_id,user_id) VALUES (?,?)");
            $connect_stmt->bind_param("ii",$dept_id, $user_id);
            $connect_stmt->execute();
            if($connect_stmt->affected_rows == 1) {
                $connect_stmt->close();
                // return "Followed";
            }
            else return "follow failed";
        }

        else {
            $connect_stmt = $con->prepare("DELETE FROM department_follow where dept_id = ? and user_id = ?");
            $connect_stmt->bind_param("ii",$dept_id, $user_id);
            $connect_stmt->execute();

            if($connect_stmt->affected_rows == 1){
                $connect_stmt->close();
                // return "Unfollowed";
            }

            else return "unfollow failed";

        }

        return;

    }



?>