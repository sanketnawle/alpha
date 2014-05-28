<?php

require_once("dbconfig.php");

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
		echo "success";
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
		
		$query = mysqli_query($con,"SELECT * FROM home_reply WHERE messageid = '".$post_id."' AND update_timestamp >= '".$comment_time."' ORDER BY update_timestamp");
		$i=0;

		while($row1 = mysqli_fetch_array($query)){
					echo "<div class='post_comment' id='".strtotime($row1['update_timestamp'])."'>";
					echo "<img src='dummy_pic/dummypic.png' class='comment_user_icon'>";

					if($row1['studentid']!=0){
						$cowner_result=mysqli_query($con,"select name from student_1 where studentid='".$row1['studentid']."'");
						$cowner_row=mysqli_fetch_array($cowner_result);
						$comment_owner=$cowner_row['name'];
					}
					else if($row1['profid']!=0){
						$cowner_result=mysqli_query($con,"select name from professor_1 where profid='".$row1['profid']."'");
						$cowner_row=mysqli_fetch_array($cowner_result);
						$comment_owner=$cowner_row['name'];
					}
					else{
						$comment_owner="Invalid User";
					}

					echo "<div class='comment_main'><span class='comment_owner'>".$comment_owner."</span> "."<span class='comment_msg'>".$row1['replymessage']."</span></div>";
					
					echo "<br><div class='comment_time'>".$row1['update_timestamp']."</div>";
					echo "<div class='comment_like'><img src='src/like-button.png'><div class='comment_like_number'>10</div></div>";

					echo "</div>";
		}
	}

	else{
		echo "Mazaak: Give me the details to fetch data";
	}
}
mysqli_close($con);
?>

