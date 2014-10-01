<?php
	require_once("dbconfig.php");

	$stmt = $con->prepare("SELECT file_content from file_upload where file_id = ?");
	$stmt->bind_param('i',$_GET['id']);
	if($stmt->execute()){
		$stmt->store_result();
		$stmt->bind_result($img);
		$stmt->fetch();

		header("Content-Type: image/jpeg");
		echo $img;
	}


?>