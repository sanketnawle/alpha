<?php

require_once("dbconfig.php");
session_start();
include "feedchecks.php";

// Uncomment the below 3 lines if you are testing this page alone
// $_POST['fbar_type']="status";
// $_POST['post_status']="fbar test new";
// $_POST['privacy']="campus";
// $_POST['anon']=0;

$user_id=1;
$target_univ_id=1;

// $user_id=$_SESSION['$user_id']; //when session variables are set
// $target_univ_id=$_SESSION['$target_univ_id'];		//when session variables are set

// Set vars for querying the db
$up_flag=NULL;
$file_location=NULL;
$file_name=NULL;
$file_ext=NULL;
$id = NULL; //file_id
// Setting vars end

if(isset($_FILES['file'])){
    try {
		$blockedExts = array(
  			# HTML may contain cookie-stealing JavaScript and web bugs
  			'html', 'htm', 'js', 'jsb', 'mhtml', 'mht', 'xhtml', 'xht',
  			# PHP scripts may execute arbitrary code on the server
  			'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
  			# Other types that may be interpreted by some servers
  			'shtml', 'jhtml', 'pl', 'py', 'cgi',
  			# May contain harmful executables for Windows victims
  			'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl' );
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
		$newname = $user_id."_".md5(strtotime("now")).".".$ext;
		if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			// && ($_FILES["file"]["size"] < 20000)
			&& (!in_array($extension, $blockedExts))) {
	  			if ($_FILES["file"]["error"] > 0) {
	    			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  				}
  				else {
		    		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    				echo "Type: " . $_FILES["file"]["type"] . "<br>";
    				echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    				echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
    				if (file_exists("../uploads/" . $newname)) {
		      			echo $newname . " already exists. ";
    					}
    				else {
		      			$flag = move_uploaded_file($_FILES["file"]["tmp_name"],
      						"../uploads/" . $newname);
      					if($flag){
	      					$up_flag = 1;
							echo $file_name = $_FILES["file"]["name"];
							echo $file_location = "uploads/" . $newname ;
							echo $file_ext = $extension;
      					}
	      					// echo "Stored* in: " . "../uploads/" . $newname;
    				}
  				}
		}
		else {
	  		echo "Invalid file";
		}

		if($up_flag==1){
			$filequery = $con->prepare("INSERT INTO file (file_name, file_location, file_type) VALUES (?,?,?)");

			if($postquery){
				$postquery->bind_param('sss',$file_name, $file_location, $file_ext);
				if($postquery->execute()){
					echo $id = $con->insert_id;
					echo $up_flag = "success";
				}
				$postquery->close();
			}
			else {
				/* Error */
				printf("File_upload_Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
			}	       	
	    }
	}
	catch(Exception $e) {
        echo '<h4>'.$e->gettext_msg().'</h4>';
    }
}


if(isset($_POST['fbar_type'])=="status"){
	if(isset($_POST['post_status']) || $up_flag=="success"){
		if(isset($_POST['post_status'])) $text = $_POST['post_status'];
		else $text=NULL;

		if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];
		else $privacy="campus";

		if(isset($_POST['anon'])) $anon=$_POST['anon'];
		else $anon=NULL;

		$postquery = $con->prepare("INSERT INTO posts (user_id, target_type, target_id, target_univ_id, post_type, text_msg, file_id, privacy, anon) VALUES (?,?,?,?,?,?,?,?,?)");

		if($postquery){
			$postquery->bind_param('isiissisi',$user_id, $target_type, $target_id, $target_univ_id, $_POST['fbar_type'], $text, $id, $privacy, $anon);
			$postquery->execute();
			echo "success";
			$postquery->close();
		}
		else {
			/* Error */
			printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
		}
	}
	else echo "failed to fetch data (text or file)";
}

if(isset($_POST['fbar_type'])=="notes"){
	if(isset($_POST['notes_desc']) || $up_flag=="success"){
		if(isset($_POST['notes_desc'])) $text = $_POST['notes_desc'];
		else $text=NULL;

		if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];
		else $privacy=NULL;

		$postquery = $con->prepare("INSERT INTO posts (user_id, target_type, target_id, target_univ_id, post_type, text_msg, file_id, privacy, anon) VALUES (?,?,?,?,?,?,?,?,?)");

		if($postquery){
			$postquery->bind_param('isiissisi',$user_id, $target_type, $target_id, $target_univ_id, $_POST['fbar_type'], $text, $id, $privacy, $anon);
			if($postquery->execute()){
				echo "success";
			}
			$postquery->close();
		}
		else {
			/* Error */
			printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
		}
	}
}

mysqli_close($con);
?>