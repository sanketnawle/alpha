<?php
	
	// $_GET['file_id']='1';

	require_once("dbconfig.php");

	if(isset($_GET['file_id'])){
		$id = mysqli_real_escape_string($con, $_GET['file_id']);
		$SELECT = "SELECT * FROM file_upload WHERE file_id = $id";
		$result = mysqli_query($con, $SELECT);
		$result = mysqli_fetch_assoc($result);

		if(!$result){
			?>
			<script> alert("File not found"); </script>
		<?php
		}
		else{

			header("content-type:". $result['file_type']);
			header("content-disposition: attachment; filename=".$result['file_name']);
			echo $result['file_content'];
		}
	}
?>