<?php

require_once("dbconfig.php");
session_start();

$studentid=1;
$univid=1;
// $_POST['query']="bi";

$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = mysqli_real_escape_string($con,$search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$cquery = 'SELECT course_name FROM courses WHERE name LIKE "%'.$search_string.'%"
				UNION
				SELECT firstname, lastname FROM user WHERE (firstname LIKE "%'.$search_string.'%")
					OR (lastname LIKE "%'.$search_string.'%")';

	// Do Search
	$cresult = mysqli_query($con,$cquery);

	if(mysqli_num_rows($cresult)){
		while($row = mysqli_fetch_array($cresult)) {
	    	echo $row['firstname']." ".$row['lastname']<br>";
		}
	}

	else{
	    // Output
	    echo 'Nothing to display.';
	}
}

mysqli_close($con);
?>