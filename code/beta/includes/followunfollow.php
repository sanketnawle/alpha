<?php

    require_once("dbconfig.php");
    session_start();

    if(isset($_POST['follow_user'])){
        echo $res = followUnfollow($con, $_SESSION['user_id'],$_POST['follow_user']) ;
    }

    function followUnfollow($con, $from_user, $to_user) {
        if($from_user == $to_user)  return;

        $connect_stmt = $con->prepare("Select count(*) from connect where from_user_id = ? and to_user_id = ?");
        $connect_stmt->bind_param("ii",$from_user, $to_user);
        if($connect_stmt->execute()){
            $connect_stmt->bind_result($count);
            $connect_stmt->fetch();
            $connect_stmt->close();
        }

        if($count == 0) {
            $connect_stmt = $con->prepare("Insert into connect (from_user_id, to_user_id) VALUES (?,?)");
            $connect_stmt->bind_param("ii",$from_user, $to_user);
            $connect_stmt->execute();
            if($connect_stmt->affected_rows == 1) {
                $connect_stmt->close();
                // return "Followed";
            }
            else return "follow failed";
        }

        else {
            $connect_stmt = $con->prepare("DELETE FROM connect where from_user_id = ? and to_user_id = ?");
            $connect_stmt->bind_param("ii",$from_user, $to_user);
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