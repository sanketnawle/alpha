<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 

if(isset($_POST['messageid']) && $_POST['messageid']!='')
{
	$univid=$_POST['univid'];
	////////////////// Delete posts and its message from reply tables///////////////
	$sql_del="delete from home_posts where messageid='".$_POST['messageid']."' and univid='".$univid."'";
	$res=$dbObj->fireQuery($sql_del,'delete');
	$sql_del="delete from home_posts_likes where postid='".$_POST['messageid']."' and univid='".$univid."'";
	$res=$dbObj->fireQuery($sql_del,'delete');
	
	$sql_del_comment="delete from home_reply where messageid='".$_POST['messageid']."' and univid='".$univid."'";
	$res=$dbObj->fireQuery($sql_del_comment,'delete');
	$sql_del="delete from home_reply_likes where replyid='".$_POST['messageid']."' and univid='".$univid."'";
	$res=$dbObj->fireQuery($sql_del,'delete');
	echo $res;
}
?>
