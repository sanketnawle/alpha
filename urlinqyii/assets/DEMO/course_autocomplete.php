<?php
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
$deptid=$_GET['dept_id'];
$q = strtolower($_GET["term"]);
if (!$q) return;


$courseListQry = "select `cid`, `name` from course_1 where  name LIKE '%".$q."%' and  deptid = '".$deptid."' order by name asc ";
$courseListRes = $dbObj->fireQuery($courseListQry);

$courseList = array();


if(isset($courseListRes) && count($courseListRes)>0 && $courseListRes!=false)
{
  		$return_str='[';
		foreach ($courseListRes as $course) {
		$course_title = $course['name'];
		$course_id   = $course['cid'];
		if (strpos(strtolower($course_title), $q) !== false) {
			//echo "$course_title|$course_id\n";
			$return_str.='{ "id": "'.$course_id.'", "value": "'.$course_title.'"},';
		}
		
	}
	$return_str.=']';
	echo $return_str;
	
}
else
{
    echo "No matches";
}

?>