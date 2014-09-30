<?php

require_once("dbconfig.php");
session_start();
include "feedchecks.php";

// Uncomment the below 3 lines if you are testing this page alone
// $_POST['post_id'] = "f6e7eabf-f651-11e3-b732-00259022578e";
// $_POST['top_reply']="1401981625";
// $_POST['reply_id']="1401981625";
// $_POST['reply_msg']="reply by tester";
// $_POST['anon']=1;

$user_id=1;
$univ_id=1;

$up_flag = "";
$id = "";

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
			$filequery = $con->prepare("INSERT INTO file_upload (file_name, file_location, file_type) VALUES (?,?,?)");

			if($filequery){
				$filequery->bind_param('sss',$file_name, $file_location, $file_ext);
				if($filequery->execute()){
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

if(isset($_POST['reply_msg'])||($up_flag=="success")){

	$comment = $_POST['reply_msg'];
	$post_id = $_POST['post_id'];
	$anon = $_POST['anon'];
	// $user_id=$_SESSION['$user_id']; //when session variables are set
	// $univ_id=$_SESSION['$univ_id'];		//when session variables are set

	$replyquery = "INSERT INTO reply (post_id,user_id,reply_msg,file_id,anon) VALUES (?,?,?,?,?)";
	$replyres = $con->prepare($replyquery);
	if($replyres){
		$replyres->bind_param('ssssi',$post_id,$user_id,$comment,$id,$anon);
		$replyres->execute();
		echo "success";
		$replyres->close();
	}
	else {
		/* Error */
		printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
	}
}

if (!isset($_POST['top_reply'])) updatecomments();

function updatecomments(){

	if (isset($_POST['post_id'])){

		$post_id = $_POST['post_id'];
		$comment_time = date("Y-m-d H:i:s",$_POST['reply_id']);
		global $con;
		
		$query = mysqli_query($con,"SELECT * FROM reply WHERE post_id = '".$post_id."' AND update_timestamp > '".$comment_time."' ORDER BY update_timestamp");
		// $i=0;

		while($row1 = mysqli_fetch_array($query)){
			include "comments.php";
		}
	}

	// else{
		// echo "Mazaak: Give me the details to fetch data";
	// }
}

if(isset($_POST['top_reply'])){
	$post_id = $_POST['post_id'];
	$comment_time = date("Y-m-d H:i:s",$_POST['top_reply']);
	$query = mysqli_query($con,"SELECT * FROM reply WHERE post_id = '".$post_id."' AND update_timestamp < '".$comment_time."' ORDER BY update_timestamp");
		// $i=0;
	if($query){
		while($row1 = mysqli_fetch_array($query)){
			include "comments.php";
		}
		// echo "</div></div>";
	}
}

mysqli_close($con);
?>