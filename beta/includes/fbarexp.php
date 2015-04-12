<?php

require_once("dbconfig.php");
require_once("common_functions.php");
session_start();

// $_POST['query']="bi";

if(isset($_POST['query'])){
$search_string = $_POST['query'];

$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = mysqli_real_escape_string($con,$search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== '') {
	// Build Query
	$cquery = 'SELECT user_id as uid, NULL as cid, CONCAT(firstname, " ",lastname) as search_res FROM user WHERE (firstname LIKE "%'.$search_string.'%") OR (lastname LIKE "%'.$search_string.'%")
				UNION
			SELECT NULL, course_id as cid, course_name as search_res FROM courses WHERE course_name LIKE "%'.$search_string.'%"';

	// Do Search
	$cresult = mysqli_query($con,$cquery);

	if($cresult){
		if(mysqli_num_rows($cresult)){
			while($row = mysqli_fetch_array($cresult)) {
				$dp_link = NULL;
				if($row['uid']!=NULL){
					$id=$row['uid'];
					$type = "user";
					$dp_link = get_user_dp($con,$id);
				}
				else if($row['cid']!=NULL){
					$id=$row['cid'];
					$type = "courses";
					$dp_link = get_course_dp($con,$id);
				}

				$id = str_replace(" ","_",$id);
	    		echo "<div id='".$id."' class='tag-col sub-col ".$type."'><div class='exp_pic' style='background-image:url(".$dp_link.");background-size:cover;height:20px;width:20px;position:absolute;'></div><span style='margin-left:30px;'>".$row['search_res']."</span></div>";
			}
		}

		else{
		    // Output
	    	echo "<div class='tag-col-end'>No Result</div>";
		}
	}

}
}
mysqli_close($con);
?>