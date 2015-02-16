<?php
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
$q = strtolower($_GET["term"]);
if (!$q) return;


$departmentListQry = "select `deptid`,`deptname` from department_1 where  deptname LIKE '%".$q."%' order by deptname asc ";
$departmentListRes = $dbObj->fireQuery($departmentListQry);

$departmentList = array();


if(isset($departmentListRes) && count($departmentListRes)>0 && $departmentListRes!=false)
{
	
  		$return_arr = array();	
		foreach ($departmentListRes as $department) {
		$department_title = $department['deptname'];
		$department_id   = $department['deptid'];
		if (strpos(strtolower($department_title), $q) !== false) {
			 $return_arr[] =  array($department_title,$department_id);
			//echo "$department_title|$department_id\n";
			
		}
		
		}
		 echo json_encode($return_arr);
	
	
}
else
{
    echo "No matches";
}

?>