<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront();
	if(isset($_REQUEST['pg']))
	{
			$RootFolder="pages/";
			if(!file_exists($RootFolder.$_REQUEST['pg'].".php"))
			{
				include_once("pages/home.php");
			}
			else
			{
				include_once($RootFolder.$_REQUEST['pg'].".php");
			}
	}
	else
	{       
		$RootFolder="pages/";
		include_once($RootFolder."home.php");
	}
?>