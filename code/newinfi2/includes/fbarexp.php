<?php

require_once("dbconfig.php");
session_start();

$studentid=1;
$univid=1;
// $_POST['query']="bi";

if(isset($_POST['query'])){
$search_string = $_POST['query'];

$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = mysqli_real_escape_string($con,$search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== '') {
	// Build Query
	$cquery = 'SELECT user_id as uid, NULL as cid, CONCAT(firstname, " ",lastname) as search_res FROM user WHERE (firstname LIKE 			"%'.$search_string.'%") OR (lastname LIKE "%'.$search_string.'%")
				UNION
			SELECT NULL, course_id as cid, course_name as search_res FROM courses WHERE course_name LIKE "%'.$search_string.'%"';

	// Do Search
	$cresult = mysqli_query($con,$cquery);

	if($cresult){
		if(mysqli_num_rows($cresult)){
			while($row = mysqli_fetch_array($cresult)) {
				if($row['uid']!=NULL){
					$id=$row['uid'];
					$type = "user";
				}
				else if($row['cid']!=NULL){
					$id=$row['cid'];
					$type = "courses";
				}

				$id = str_replace(" ","_",$id);
	    		echo "<div id='".$id."' class='tag-col sub-col ".$type."'>".$row['search_res']."</div>";
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