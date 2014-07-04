<?php

require_once("dbconfig.php");
session_start();
include "feedchecks.php";

// Uncomment the below 4 lines if you are testing this page alone
// $_POST['fbar_type']="notes";
// $_POST['post_status']="fbar test new";
// $_POST['notes_desc']="fbar notes test new";
// $_POST['privacy']="campus";
// $_POST['anon']=0;

$user_id=1;
$target_univ_id=1;

// $user_id=$_SESSION['$user_id']; //when session variables are set
// $target_univ_id=$_SESSION['$target_univ_id'];		//when session variables are set

// Set vars for querying the db
$up_id = NULL;
if((isset($_POST['target_type']))&&(isset($_POST['target_id']))){
	$target_type = $_POST['target_type'];
	$target_id = $_POST['target_id'];
}
else{
	$target_type = NULL;
	$target_id = NULL;	
}

include_once "fileupload.php";

if(isset($_POST['fbar_type'])){
	if($_POST['fbar_type']=="status"){
		if(isset($_POST['post_status']) || $up_id!=NULL){
			if(isset($_POST['post_status'])) $text = $_POST['post_status'];
			else $text=NULL;

			if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];
			else $privacy="campus";

			if(isset($_POST['anon'])) $anon=$_POST['anon'];
			else $anon=NULL;

			$postquery = $con->prepare("INSERT INTO posts (user_id, target_type, target_id, target_univ_id, post_type, text_msg, file_id, privacy, anon) VALUES (?,?,?,?,?,?,?,?,?)");

			if($postquery){
				$postquery->bind_param('isiissisi',$user_id, $target_type, $target_id, $target_univ_id, $_POST['fbar_type'], $text, $up_id, $privacy, $anon);
				if($postquery->execute()) echo "success";
				$postquery->close();
			}
			else {
				/* Error */
				printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
			}
		}
		else echo "Status mazaak: failed to fetch data (text or file)";
	}

	// $up_id = 38;
	if($_POST['fbar_type']=="notes"){
		if($up_id!=NULL){
			if(isset($_POST['notes_desc'])) $text = $_POST['notes_desc'];
			else $text=NULL;

			if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];
			else $privacy=NULL;

			if(isset($_POST['anon'])) $anon=$_POST['anon'];
			else $anon=NULL;

			$postquery = $con->prepare("INSERT INTO posts (user_id, target_type, target_id, target_univ_id, post_type, text_msg, file_id, privacy) VALUES (?,?,?,?,?,?,?,?)");

			if($postquery){
				$postquery->bind_param('isiissis',$user_id, $target_type, $target_id, $target_univ_id, $_POST['fbar_type'], $text, $up_id, $privacy);
				if($postquery->execute()) echo "success";
				else "execution failed";
				$postquery->close();
			}
			else {
				/* Error */
				printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
			}
		}
		else echo "Notes mazaak: failed to fetch file";
	}

	if($_POST['fbar_type']=="question"){
		if((isset($_POST['que_title'])AND(!empty($_POST['que_title']))) || $up_id!=NULL){
			echo "test";
			if(isset($_POST['que_title'])) echo $text = $_POST['que_title'];
			else echo $text=NULL;

			if(isset($_POST['que_desc'])) echo $sub_text = $_POST['que_desc'];
			else echo $sub_text=NULL;

			if(isset($_POST['privacy'])) echo $privacy=$_POST['privacy'];
			else echo $privacy=NULL;

			if(isset($_POST['anon'])) echo $anon=$_POST['anon'];
			else echo $anon=NULL;

			$ptagid = NULL;
			$postquery = $con->prepare("INSERT INTO posts (user_id, target_type, target_id, target_univ_id, post_type, text_msg, sub_text, file_id, privacy, anon) VALUES (?,?,?,?,?,?,?,?,?,?)");

			if($postquery){
				$postquery->bind_param('isiisssisi',$user_id, $target_type, $target_id, $target_univ_id, $_POST['fbar_type'], $text, $sub_text, $up_id, $privacy, $anon);
				if($postquery->execute()){
					$ptagid = $con->insert_id;
					echo "success";
				}
				$postquery->close();
			}
			else {
				/* Error */
				printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
			}

			if(!is_null($ptagid)){
				if(isset($_POST['experts'])) {
					$experts = json_decode(stripslashes($_POST['experts']));
					$tag_q = $con->prepare("INSERT INTO posts_questions (post_id, tag_type, tag_id) VALUES (?,?,?)");
					foreach ($experts as $e) {
						if(isset($exp)) $exp = NULL;
						$exp = explode("$$", $e);
						if($tag_q){
							// echo "|**".$ptagid."*".$exp[0]."*".$exp[1]."**|";
							$tag_q->bind_param('iss',$ptagid,$exp[0],$exp[1]);

							if($tag_q->execute()) echo "tag success";
							else echo "tag failed";
							// echo mysqli_error($con);
						}
					}
				}
			}
			else echo "Mazaak: No post_id :(";
		}
	}
}
mysqli_close($con);
?>