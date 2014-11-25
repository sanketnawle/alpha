<?php
	/* if(isset($con))
	{
		$con->close();
	} */
	$con=mysqli_connect("localhost","root","","urlinq_new");

	// Check connection

	if (mysqli_connect_errno()){
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}

?>