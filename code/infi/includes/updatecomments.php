<?php

require_once("dbconfig.php");
session_start();

// Uncomment the below 3 lines if you are testing this page alone
// $_POST['postid'] = "92";
// $_POST['commentid']=strtotime("2014-04-01 19:23:41");
// $_POST['commentcontent']="test by kk";
$studentid=1;
$univid=1;

if(isset($_POST['commentcontent'])){

	$comment = $_POST['commentcontent'];
	$post_id = $_POST['postid'];
	// $studentid=$_SESSION['$studentid']; //when session variables are set
	// $univid=$_SESSION['$univid'];		//when session variables are set

	$postquery = $con->prepare("INSERT INTO home_reply (messageid,studentid,univid,replymessage) VALUES (?,?,?,?)");
	if($postquery){
		$postquery->bind_param('iiis',$post_id,$studentid,$univid,$comment);
		$postquery->execute();
		//echo "success";
		$postquery->close();
	}
	else {
		/* Error */
		printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
	}
	}

updatecomments();

function updatecomments(){

	if (isset($_POST['postid'])){

		$post_id = $_POST['postid'];
		$comment_time = date("Y-m-d H:i:s",$_POST['commentid']);
		global $con;
		
		$query = mysqli_query($con,"SELECT * FROM home_reply WHERE messageid = '".$post_id."' AND update_timestamp > '".$comment_time."' ORDER BY update_timestamp");
		$i=0;

		while($row1 = mysqli_fetch_array($query)){
			include "comments.php";
		}
	}

	// else{
		// echo "Mazaak: Give me the details to fetch data";
	// }
}
mysqli_close($con);
?>

