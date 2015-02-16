<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 

if(isset($_POST['messageid']) && $_POST['messageid']!='')
{
	////////////////// Delete posts and its message from reply tables///////////////
	$sql_del="delete from department_posts_1 where messageid='".$_POST['messageid']."'";
	$res=$dbObj->fireQuery($sql_del,'delete');
	$sql_del_comment="delete from department_reply_1 where messageid='".$_POST['messageid']."'";
	$res=$dbObj->fireQuery($sql_del_comment,'delete');
	echo $res;
}
?>
