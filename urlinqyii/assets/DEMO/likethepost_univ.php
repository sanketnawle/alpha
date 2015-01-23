<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_POST['messageid']) && $_POST['messageid']!='' && isset($_POST['type']) && $_POST['type']!='')
{
	$type=$_POST['type'];
	
	//////////// add records in department_posts_likes_1 table ////////////
	$studentid=0;
	$profid=0;
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		$studentid=$_SESSION['student_id'];
		
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$profid=$_SESSION['professor_id'];
	}
	
	if($type=='post')
	{
		$messageid=$_POST['messageid'];
		//////// Check if user already like this post then unlike it 
		$sel_sql="SELECT count(*) as total_likes,univ_post_lkid FROM `university_posts_likes_1` where postid='".$messageid."' and studentid='".$studentid."' and profid='".$profid."'";
		$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
		if($sel_cnt[0]['total_likes']>0)
		{
			$update_sql="UPDATE `university_posts_1` SET like_cnt= like_cnt- 1 WHERE `messageid` = '".$messageid."'";
			$msg_id=$dbObj->fireQuery($update_sql,'update');
			$dele_ssql="DELETE FROM `university_posts_likes_1` WHERE `univ_post_lkid` = '".$sel_cnt[0]['univ_post_lkid']."'";
			$msg_id=$dbObj->fireQuery($dele_ssql,'delete');
		}
		else
		{
			$update_sql="UPDATE `university_posts_1` SET like_cnt= like_cnt+ 1 WHERE `messageid` = '".$messageid."'";
			$msg_id=$dbObj->fireQuery($update_sql,'update');
			$insert_sql="INSERT INTO `university_posts_likes_1` (`studentid`,`profid`,`postid`) VALUES ('".$studentid."','".$profid."','".$messageid."');";
			$msg_id=$dbObj->fireQuery($insert_sql,'insert');
		}
		
	}
	elseif($type=='reply')
	{
		$replyid=$_POST['messageid'];
		/////// Check if user already like this comment then unlike it 
		$sel_sql="SELECT count(*) as total_likes,univ_reply_lkid FROM `university_reply_likes_1` where replyid='".$replyid."' and studentid='".$studentid."' and profid='".$profid."'";
		$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
		if($sel_cnt[0]['total_likes']>0)
		{
			$update_sql="UPDATE `university_reply_1` SET like_cnt= like_cnt- 1 WHERE `replyid` = '".$replyid."'";
			$msg_id=$dbObj->fireQuery($update_sql,'update');
			$dele_ssql="DELETE FROM `university_reply_likes_1` WHERE `univ_reply_lkid` = '".$sel_cnt[0]['univ_reply_lkid']."'";
			$msg_id=$dbObj->fireQuery($dele_ssql,'delete');
		}
		else
		{
			$update_sql="UPDATE `university_reply_1` SET like_cnt= like_cnt+ 1 WHERE `replyid` = '".$replyid."'";
			$msg_id=$dbObj->fireQuery($update_sql,'update');
			$insert_sql="INSERT INTO `university_reply_likes_1` (`studentid`,`profid`,`replyid`) VALUES ('".$studentid."','".$profid."','".$replyid."');";
			$msg_id=$dbObj->fireQuery($insert_sql,'insert');
		}
	} 
	if($msg_id>0)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
?>