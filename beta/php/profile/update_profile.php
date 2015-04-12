<?php
	require_once("../../includes/dbconfig.php");
	session_start();    

	// echo $_SESSION['user_id'];

	if(isset($_POST['update_profile'])){
		// if($_POST['update_profile']==$_SESSION['user_id']){
			// Uncomment the below lines if you are testing this page alone

			// echo $_POST['mail'].$_POST['firstname'].$_POST['lastname'].
			// 				$_POST['univ_id'].$_POST['dept_id'].$_POST['about'].
			// 				$_POST['interests'].$_POST['website'].
			// 				$_SESSION['user_id'].$_POST['designation'].
			// 				$_POST['office_loc'].$_POST['office_hrs'];

			// $user_id=$_SESSION['$user_id']; //when session variables are set
			// $target_univ_id=$_SESSION['$target_univ_id'];		//when session variables are set

			// Set vars for querying the db
			$up_id = NULL;

			// fetch the img id, if exists.
			if(isset($_FILES['img'])){

				$user_q = "SELECT dp_blob FROM user WHERE user_id=?";
				$user_stmt = $con->prepare($user_q);

				if($user_stmt){
					$user_stmt->bind_param('i',$_SESSION['user_id']);
					if($user_stmt->execute()){
						$user_stmt->bind_result($dp_blob);
						$user_stmt->fetch();
						$user_stmt->close();
					}

					// uploading image into the database
					include_once "../img_upload.php";

					// deleting the pic, if exists
					if(!is_null($dp_blob)){
						$del_dp = mysqli_query($con, "DELETE FROM display_picture WHERE img_id=".$dp_blob);
						// if($del_dp) echo "deleted";
					}
				
				}
			}

			if(!is_null($up_id)){
			    // error_log("id = ".$up_id);
				$update_dp = mysqli_query($con, "UPDATE user SET dp_blob=".$up_id.", dp_flag = 'blob' WHERE user_id=".$_SESSION['user_id']);
			}

			if(isset($_POST['firstname'])){
				$update_pro_q = "UPDATE user SET user_email=?, firstname=?, lastname=?, univ_id=?, dept_id=?,
					user_bio=? WHERE user_id = ?";
					$update_pro_stmt = $con->prepare($update_pro_q);
					if($update_pro_stmt){
						$update_pro_stmt->bind_param('sssiisi',$_POST['mail'], $_POST['firstname'], $_POST['lastname'],
							$_POST['univ_id'], $_POST['dept_id'], $_POST['about'],
							$_SESSION['user_id']);
						$update_pro_stmt->execute();
						$update_pro_stmt->close();
					}
					// if ($update_pro_stmt->errno) {
	  		// 			echo "FAILURE!!! " . $update_pro_stmt->error;
	  		// 			echo "Database trolled us!! :(";
					// }

				// $update_profile_stmt = mysqli_query($con, $sql) ;
			}

			// updating professor attribs
			$profex_id = NULL;
			if(isset($_POST['office_hrs'])){
				// check if prof_attribs are already inserted
				$attrib_exist_q = "SELECT prof_id FROM prof_attribs WHERE prof_id = ?";
				$attrib_exist_stmt = $con->prepare($attrib_exist_q);
				if($attrib_exist_stmt){
					$attrib_exist_stmt->bind_param('i',$_SESSION['user_id']);
					$attrib_exist_stmt->execute();
					$attrib_exist_stmt->bind_result($profex_id);
					$attrib_exist_stmt->fetch();
					$attrib_exist_stmt->close();
				}

				if(is_null($profex_id)){
					$update_proatt_q = "INSERT INTO prof_attribs (prof_id, designation, office_location,
						office_hours, website) VALUES(?,?,?,?,?)";
					$update_proatt_stmt = $con->prepare($update_proatt_q);
					if($update_proatt_stmt){
						$update_proatt_stmt->bind_param('issss',$_SESSION['user_id'], $_POST['designation'],
							$_POST['office_loc'], $_POST['office_hrs'],$_POST['website']);
						$update_proatt_stmt->execute();
						$update_proatt_stmt->close();
					}
					// if ($update_proatt_stmt->errno) {
	  		// 			echo "FAILURE!!! " . $update_proatt_stmt->error;
	  		// 			echo "Database trolled us!! :(";
					// }
				}
				else{
					if(isset($_POST['designation'])){
						// echo "-".$profex_id."-";
						$update_proatt_q = "UPDATE prof_attribs SET designation=?, office_location=?, office_hours=?, website=? WHERE prof_id =?";
						$update_proatt_stmt = $con->prepare($update_proatt_q);
						if($update_proatt_stmt){
							$update_proatt_stmt->bind_param('ssssi',$_POST['designation'], $_POST['office_loc'], $_POST['office_hrs'], $_POST['website'], $_SESSION['user_id']);
							$update_proatt_stmt->execute();
							$update_proatt_stmt->close();
						}
					}
					elseif (isset($_POST['office_hrs'])) {
						$update_proatt_q = "UPDATE prof_attribs SET office_hours=? WHERE prof_id =?";
						$update_proatt_stmt = $con->prepare($update_proatt_q);
						if($update_proatt_stmt){
							$update_proatt_stmt->bind_param('si', $_POST['office_hrs'], $_SESSION['user_id']);
							$update_proatt_stmt->execute();
							$update_proatt_stmt->close();
						}
					}
				}
			}
			// updating professor attribs end

			// updating student attribs
			$profex_id = NULL;
			if(isset($_POST['major'])){
				// check if student_attribs are already inserted
				$attrib_exist_q = "SELECT user_id FROM student_attribs WHERE user_id = ?";
				$attrib_exist_stmt = $con->prepare($attrib_exist_q);
                echo "step 1";
				if($attrib_exist_stmt){
					$attrib_exist_stmt->bind_param('i',$_SESSION['user_id']);
					$attrib_exist_stmt->execute();
					$attrib_exist_stmt->bind_result($stuex_id);
					$attrib_exist_stmt->fetch();
					$attrib_exist_stmt->close();
				}
                echo "step 2";
				if(is_null($stuex_id) OR ($stuex_id == 0)){
					$update_stuatt_q = "INSERT INTO student_attribs (user_id, website, major, year, student_type) VALUES (?,?,?,?,?)";
					$update_stuatt_stmt = $con->prepare($update_stuatt_q);
                    echo "step 3";
					if($update_stuatt_stmt){
                        echo "step 4";
						$update_stuatt_stmt->bind_param('issss',$_SESSION['user_id'], $_POST['website'],
							$_POST['major'], $_POST['year'],$_POST['student_type']);
						echo $update_stuatt_stmt->execute()? "success": "failed";
						$update_stuatt_stmt->close();
					}
					// if ($update_proatt_stmt->errno) {
	  		// 			echo "FAILURE!!! " . $update_proatt_stmt->error;
	  		// 			echo "Database trolled us!! :(";
					// }
				}
				else{
                    echo "step 5";
					if(isset($_POST['major'])){
						// echo "-".$profex_id."-";
						$update_stuatt_q = "UPDATE student_attribs SET website=?, major=?, year=?, student_type=? WHERE user_id =?";
						$update_stuatt_stmt = $con->prepare($update_stuatt_q);
                        echo "step 6";
						if($update_stuatt_stmt){
                            echo "step 7";
							$update_stuatt_stmt->bind_param('ssisi', $_POST['website'], $_POST['major'],
								$_POST['year'], $_POST['student_type'], $_SESSION['user_id']);
							echo $update_stuatt_stmt->execute()? "success 2": "failed 2";
							$update_stuatt_stmt->close();
                            print_r($update_stuatt_stmt);
						}
					}
				}
			}
			// updating student attribs end
            if ($update_stuatt_stmt->errno) {
	  		 			echo "FAILURE!!! " . $update_stuatt_stmt->error;
	  		 			echo "Database trolled us!! :(";
					 }

		// }
			// else die("Access denied");
	}

	// include_once "profile_fun.php";
	// user_info($con, $_SESSION['user_id']);

	mysqli_close($con);

?>