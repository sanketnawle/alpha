<?php

require_once("dbconfig.php");
session_start();
include "feedchecks.php";

// Uncomment the below 3 lines if you are testing this page alone
$_POST['fbar_type']="status";
// $_POST['post_status']="fbar test new";
// $_POST['privacy']="campus";
// $_POST['anonymous']=0;

$studentid=1;
$univid=1;

// $studentid=$_SESSION['$studentid']; //when session variables are set
// $univid=$_SESSION['$univid'];		//when session variables are set

// Set vars for querying the db
$up_flag="";
$filelocation="";
$file="";
$file_ext="";
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
		$newname = $studentid."_".md5(strtotime("now")).".".$ext;
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
	      					$up_flag = "success";
							echo $file = $_FILES["file"]["name"];
							echo $filelocation = "uploads/" . $newname ;
							echo $file_ext = $extension;
      					}
	      					// echo "Stored* in: " . "../uploads/" . $newname;
    				}
  				}
		}
		else {
	  		echo "Invalid file";
		}

		// if($up_flag=="success"){
	       	// echo "Thank you for submitting";
	    // }
	}
	catch(Exception $e) {
        echo '<h4>'.$e->getMessage().'</h4>';
    }
}


if(isset($_POST['fbar_type'])=="status"){
	if(isset($_POST['post_status']) || $up_flag=="success"){
		if(isset($_POST['post_status'])) $text = $_POST['post_status'];
		else $text="";

		if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];
		else $privacy="";

		if(isset($_POST['anonymous'])) $anon=$_POST['anonymous'];
		else $anon="";

		$postquery = $con->prepare("INSERT INTO home_posts (studentid,univid,message,visibility,file,filelocation,file_ext,anonymous) VALUES (?,?,?,?,?,?,?,?)");

		if($postquery){
			$postquery->bind_param('iissssss',$studentid,$univid,$text,$privacy,$file,$filelocation,$file_ext,$anon);
			$postquery->execute();
			echo "success";
			$postquery->close();
		}
		else {
			/* Error */
			printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
		}
	}
}

if(isset($_POST['fbar_type'])=="notes"){
	if(isset($_POST['notes_desc']) || $up_flag=="success"){
		if(isset($_POST['notes_desc'])) $text = $_POST['notes_desc'];
		else $text="";

		if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];
		else $privacy="";

		$postquery = $con->prepare("INSERT INTO home_posts (studentid,univid,message,visibility,file,filelocation,file_ext) VALUES (?,?,?,?,?,?,?)");

		if($postquery){
			$postquery->bind_param('iisssss',$studentid,$univid,$text,$privacy,$file,$filelocation,$file_ext);
			$postquery->execute();
			echo "success";
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