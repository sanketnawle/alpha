<?php
	require_once("../../includes/dbconfig.php");
	include "showcase_fun.php"; // to get and delete showcase
	session_start();
	$user_id = $_SESSION['user_id'];

	include_once "../../includes/fileupload.php";

	// setting showcase title
	if(isset($_POST['title'])) $title = $_POST['title'];
	else $title = NULL;

// uploading link and collecting it's id
	if(isset($_POST['link'])){
		$up_id = shcase_link($con);
	}

	function shcase_link($con){
	    $stmt = $con->prepare("INSERT INTO showcase_links (link) VALUES (?)");
	    $stmt->bind_param('s', $_POST['link']);
	    if($stmt->execute()){
	        return $up_id = $con->insert_id;
	    }
	}
// uploading link close

	if(isset($up_id)) {
		// echo $up_id;
		if(!is_null($up_id)) $up_type = 'regular';
		else $up_type = NULL;
	}

	if(isset($_POST['gdrive_id'])) {
		if(!is_null($_POST['gdrive_id'])) $up_type = 'gdrive';
		else $up_type = NULL;
	}

	elseif(isset($_POST['link'])) {
		if(!is_null($_POST['link'])) $up_type = 'link';
		else $up_type = NULL;
	}

	if(isset($up_id)){
		$postquery = $con->prepare("INSERT INTO showcase (user_id, file_id, file_share_type, file_desc) VALUES (?,?,?,?)");

		if($postquery){
			$postquery->bind_param('iiss',$user_id, $up_id, $up_type, htmlspecialchars($title));
			$postquery->execute();
			$postquery->close();
		}
		else {
			/* Error */
			printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
		}
	}

	if(isset($_POST['del_showcase'])){
		del_showcase($con, $_POST['file_id'], $_POST['file_share_type']);
	}

	$showcase_ele[] = get_showcase($con,$user_id);
	echo json_encode(array("showcase_ele"=>$showcase_ele));
	
	// mysqli_close($con);

?>