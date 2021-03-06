<?php
	// header('content-type: application/json');
	require_once("dbconfig.php");
	require_once("feedchecks.php");
	session_start();

	$user_id = $_SESSION['user_id'];
	$target_univ_id= $_SESSION['univ_id'];

	// Uncomment the below 5 lines if you are testing this page alone
//	 $_POST['fbar_type']="question";
//     $_POST['que_title'] = "Q title";
//     $_POST['que_desc'] = "Q desc";
	// $_POST['post_status']="fbar test new";
	// $_POST['notes_desc']="fbar notes test new";
//	 $_POST['privacy']="campus";
//	 $_POST['anon']=0;
	// $_POST['gdrive_id'] = "0ByrlP5cSHyeNWE5ueGNMUWZuX29jLUJudlQxUjhtWHo4alBB";
	// $_POST['gdrive_name'] = "Programming languages.txt";
	// $_POST['gdrive_type'] = "text/plain";
	// $_POST['gdrive_url'] = "https://docs.google.com/a/nyu.edu/file/d/0ByrlP5cSHyeNWE5ueGNMUWZuX29jLUJudlQxUjhtWHo4alBB/preview";
	// $_POST['notes_desc'] = "test drive";


	// $user_id=$_SESSION['$user_id']; //when session variables are set
	// $target_univ_id=$_SESSION['$target_univ_id'];		//when session variables are set

	// Set vars for querying the db
	$up_id = NULL;
	if((isset($_POST['target_type']) && isset($_POST['target_id'])) && ($_POST['target_type']!="" && $_POST['target_id']!="")) {
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

				if(isset($up_id)) {
					// echo $up_id;
					if(!is_null($up_id)) $up_type = 'regular';
					else $up_type = NULL;
				}

				if(isset($_POST['gdrive_id'])) {
					if(!is_null($_POST['gdrive_id'])) $up_type = 'gdrive';
					else $up_type = NULL;
				}

				$postquery = $con->prepare("INSERT INTO posts (user_id, target_type, target_id, target_univ_id, post_type, text_msg, file_id, file_share_type, privacy, anon) VALUES (?,?,?,?,?,?,?,?,?,?)");

				if($postquery){
					$postquery->bind_param('issississi',$user_id, $target_type, $target_id, $target_univ_id, $_POST['fbar_type'], ($text), $up_id, $up_type, $privacy, $anon);
					if($postquery->execute()){
						// echo "success";
						$pid = $con->insert_id;
						$p_id = array('pid'=>$pid);
						echo json_encode($p_id);
					}
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
		else if($_POST['fbar_type']=="notes"){
			if($up_id!=NULL){
				if(isset($_POST['notes_desc'])) $text = $_POST['notes_desc'];
				else $text=NULL;

				if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];
				else $privacy=NULL;

				if(isset($_POST['anon'])) $anon=$_POST['anon'];
				else $anon=NULL;

				if(isset($up_id)) {
					// echo $up_id;
					if(!is_null($up_id)) $up_type = 'regular';
					else $up_type = NULL;
				}

				if(isset($_POST['gdrive_id'])) {
					if(!is_null($_POST['gdrive_id'])) $up_type = 'gdrive';
					else $up_type = NULL;
				}

				$postquery = $con->prepare("INSERT INTO posts (user_id, target_type, target_id, target_univ_id, post_type, text_msg, file_id, file_share_type, privacy) VALUES (?,?,?,?,?,?,?,?,?)");

				if($postquery){
					// echo "**************";
					// echo $user_id."*". $target_type."*". $target_id."*". $target_univ_id."*". $_POST['fbar_type']."*".htmlspecialchars($text)."*". $up_id."*". $up_type."*". $privacy;
					$postquery->bind_param('issississ',$user_id, $target_type, $target_id, $target_univ_id, $_POST['fbar_type'], htmlspecialchars($text), $up_id, $up_type, $privacy);
					if($postquery->execute()){
						// echo "success";
						$pid = $con->insert_id;
						echo json_encode(array('pid'=>$pid));
					}
					else echo "execution failed";
					$postquery->close();
				}
				else {
					/* Error */
					printf("Mazaak: %s\n", $mysqli->error); //Prepared Statement Error
				}
			}
			else echo "Notes mazaak: failed to fetch file";
		}

		else if($_POST['fbar_type']=="question"){
			if(isset($_POST['que_title'])AND(!empty($_POST['que_title']))){
				if(isset($_POST['que_title'])) $text = $_POST['que_title'];
				else $text=NULL;

				if(isset($_POST['que_desc'])) $sub_text = $_POST['que_desc'];
				else $sub_text=NULL;

				if(isset($_POST['privacy'])) $privacy=$_POST['privacy'];
				else $privacy=NULL;

				if(isset($_POST['anon'])) $anon=$_POST['anon'];
				else $anon=NULL;

				$ptagid = NULL;
				$postquery = $con->prepare("INSERT INTO posts (user_id, target_type, target_id, target_univ_id, post_type, text_msg, sub_text, file_id, privacy, anon) VALUES (?,?,?,?,?,?,?,?,?,?)");

				if($postquery){
					$postquery->bind_param('ississsisi',$user_id, $target_type, $target_id, $target_univ_id, $_POST['fbar_type'], htmlspecialchars($text), htmlspecialchars($sub_text), $up_id, $privacy, $anon);
					if($postquery->execute()){
						$ptagid = $con->insert_id;
						echo json_encode(array('pid'=>$ptagid));
						// echo "success";
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

								if($tag_q->execute()){
									// echo "tag success";
								}
								else{
									// echo "tag failed";
								}
								// echo mysqli_error($con);
							}
						}
					}
				}
				else echo "Mazaak: No post_id :(";
			}
		}
	}

	// echo $ptagid=341;
	// echo $target_type = "profile";
	// echo $target_id = 47;

	mysqli_close($con);

?>