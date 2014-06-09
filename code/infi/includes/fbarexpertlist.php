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
	$cquery = 'SELECT name FROM course_1 WHERE name LIKE "%'.$search_string.'%"
				UNION
				SELECT name FROM professor_1 WHERE name LIKE "%'.$search_string.'%"';

	// Do Search
	$cresult = mysqli_query($con,$cquery);

	if(mysqli_num_rows($cresult)){
		while($row = mysqli_fetch_array($cresult)) {
	    	echo $row['name']."<br>";
		}
	}

	else{
	    // Output
	    echo 'Nothing to display.';
	}
}

mysqli_close($con);
?>