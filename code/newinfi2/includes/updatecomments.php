<?php

	require_once("dbconfig.php");
	require_once("time.php");
	session_start();
	include "feedchecks.php";

	// Uncomment the below 3 lines if you are testing this page alone
	// $_POST['post_id'] = "13";
	// $_POST['top_reply']="1401981625";
	// $_POST['reply_id']="1401981625";
	// $_POST['reply_msg']="reply by tester";
	// $_POST['anon']=1;

	$user_id=1;
	$univ_id=1;

	$up_id = NULL;

	include_once "fileupload.php"; //file-uplod script

	if(isset($_POST['reply_msg'])||($up_id=="success")){

		$comment = $_POST['reply_msg'];
		$post_id = $_POST['post_id'];
		$anon = $_POST['anon'];
		// $user_id=$_SESSION['$user_id']; //when session variables are set
		// $univ_id=$_SESSION['$univ_id'];		//when session variables are set

		$replyquery = "INSERT INTO reply (post_id,user_id,reply_msg,file_id,anon) VALUES (?,?,?,?,?)";
		$replyres = $con->prepare($replyquery);
		if($replyres){
			$replyres->bind_param('iisii',$post_id,$user_id,$comment,$up_id,$anon);
			$replyres->execute();
			// echo "success";
			$replyres->close();
		}
		else {
			/* Error */
			printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
		}
	}

	if (!isset($_POST['top_reply'])) updatecomments($con);

	function updatecomments($con){

		if (isset($_POST['post_id'])){

			$post_id = $_POST['post_id'];
			$comment_time = date("Y-m-d H:i:s",$_POST['reply_id']);
			global $con;
		
			$query = mysqli_query($con,"SELECT * FROM reply WHERE post_id = '".$post_id."' AND update_timestamp > '".$comment_time."' ORDER BY update_timestamp");
			// $i=0;

			while($row1 = mysqli_fetch_array($query)){
				include "comments.php";
			}
		}

		// else{
			// echo "Mazaak: Give me the details to fetch data";
		// }
	}

	if(isset($_POST['top_reply'])){
		$post_id = $_POST['post_id'];
		$comment_time = date("Y-m-d H:i:s",$_POST['top_reply']);
		$query = mysqli_query($con,"SELECT * FROM reply WHERE post_id = '".$post_id."' AND update_timestamp < '".$comment_time."' ORDER BY update_timestamp");
			// $i=0;
		if($query){
			while($row1 = mysqli_fetch_array($query)){
				include "comments.php";
			}
			// echo "</div></div>";
		}
	}
mysqli_close($con);
?>