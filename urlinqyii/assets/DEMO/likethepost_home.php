<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_POST['messageid']) && $_POST['messageid']!='' && isset($_POST['type']) && $_POST['type']!='')
{
	$type=$_POST['type'];
	$univid=$_POST['univid'];
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
		$sel_sql="SELECT count(*) as total_likes,home_post_lkid  FROM `home_posts_likes` where postid='".$messageid."' and studentid='".$studentid."' and profid='".$profid."' and univid='".$univid."'";
		$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
		if($sel_cnt[0]['total_likes']>0)
		{
			$update_sql="UPDATE `home_posts` SET like_cnt= like_cnt- 1 WHERE `messageid` = '".$messageid."' and univid='".$univid."'";
			$msg_id=$dbObj->fireQuery($update_sql,'update');
			$dele_ssql="DELETE FROM `home_posts_likes` WHERE `home_post_lkid` = '".$sel_cnt[0]['home_post_lkid']."'";
			$msg_id=$dbObj->fireQuery($dele_ssql,'delete');
		}
		else
		{
			$update_sql="UPDATE `home_posts` SET like_cnt= like_cnt+ 1 WHERE `messageid` = '".$messageid."' and univid='".$univid."'";
			$msg_id=$dbObj->fireQuery($update_sql,'update');
			$insert_sql="INSERT INTO `home_posts_likes` (`univid`,`studentid`,`profid`,`postid`) VALUES ('".$univid."','".$studentid."','".$profid."','".$messageid."');";
			$msg_id=$dbObj->fireQuery($insert_sql,'insert');
		}
		
	}
	elseif($type=='reply')
	{
		$replyid=$_POST['messageid'];
		/////// Check if user already like this comment then unlike it 
		$sel_sql="SELECT count(*) as total_likes,home_reply_lkid FROM `home_reply_likes` where replyid='".$replyid."' and studentid='".$studentid."' and profid='".$profid."' and univid='".$univid."'";
		$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
		if($sel_cnt[0]['total_likes']>0)
		{
			$update_sql="UPDATE `home_reply` SET like_cnt= like_cnt- 1 WHERE `replyid` = '".$replyid."' and univid='".$univid."'";
			$msg_id=$dbObj->fireQuery($update_sql,'update');
			$dele_ssql="DELETE FROM `home_reply_likes` WHERE `home_reply_lkid` = '".$sel_cnt[0]['home_reply_lkid']."'";
			$msg_id=$dbObj->fireQuery($dele_ssql,'delete');
		}
		else
		{
			$update_sql="UPDATE `home_reply` SET like_cnt= like_cnt+ 1 WHERE `replyid` = '".$replyid."' and univid='".$univid."'";
			$msg_id=$dbObj->fireQuery($update_sql,'update');
			$insert_sql="INSERT INTO `home_reply_likes` (`studentid`,`profid`,`univid`,`replyid`) VALUES ('".$studentid."','".$profid."','".$univid."','".$replyid."');";
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