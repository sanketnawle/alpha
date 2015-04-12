<?php

    include_once '../dbconnection.php';
    include_once '../../includes/follow.php';

    session_start();

    if (isset($_POST['user_info'])) {
    	$followers = array();
    	$following = array();
        $followers = myFollowers($_POST['user_info']);
        $following = meFollowing($_POST['user_info']);
        $isfollowing = isFollowing($_SESSION['user_id'], $_POST['user_info']);

         $json = array('followers' => $followers,  'following' => $following, 'isfollowing' => $isfollowing, 'fromuser_id' => $_SESSION['user_id'], 'touser_id' => $_POST['user_info']);
        echo json_encode($json);
    }
    
?>
