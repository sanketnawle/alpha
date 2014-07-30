<?php

	// require_once("../../includes/dbconfig.php");
	// session_start();
	// $user_id = $_SESSION['user_id'];
	// $user_id = 286;

// get_showcase($con,$user_id);

include_once("../file_ops.php");

function get_showcase($con,$user_id){
	// echo "test";
		$showcase_ele = array();
		$showcase = array();
		$get_q = $con -> prepare("SELECT file_id, file_share_type, file_desc FROM showcase WHERE user_id = ?");
		if($get_q){
			$get_q -> bind_param('i',$user_id);
			if($get_q->execute()){
				$get_q->bind_result($file_id, $file_share_type, $file_desc);
				while($get_q->fetch()){
					$showcase[] = array('file_id'=>$file_id, 'file_share_type'=>$file_share_type, 'file_desc'=>$file_desc);
				}
				$get_q->close();
			}
		}

		// echo $file_id." ".$file_share_type." ".$file_desc."*";
		$file_q = $con -> prepare("SELECT file_name, file_type FROM file_upload WHERE file_id = ?");
		$gdrive_q = $con -> prepare("SELECT file_name, file_type, file_url FROM gdrive_share WHERE file_id = ?");	
		$link_q = $con -> prepare("SELECT link FROM showcase_links WHERE link_id = ?");
		
		foreach ($showcase as $row) {
			$f_name = NULL;
			$f_type = NULL;
			$f_url = NULL;
			if($row['file_share_type'] == "regular"){
				if($file_q){
					$file_q -> bind_param('i',$row['file_id']);
					if($file_q->execute()){
						$f_url = "includes/download_file.php?file_id=".$row['file_id'];
						$file_q->bind_result($f_name, $f_type);
						$file_q->fetch();
						$file_q->reset();
					}
				}
			}

			elseif($row['file_share_type'] == "gdrive"){
				if($gdrive_q){
					$gdrive_q -> bind_param('i',$row['file_id']);
					if($gdrive_q->execute()){
						$gdrive_q->bind_result($f_name, $f_type, $f_url);
						$gdrive_q->fetch();
						$gdrive_q->reset();
					}
				}
			}

			elseif($row['file_share_type'] == "link"){
				if($link_q){
					$link_q -> bind_param('i',$row['file_id']);
					if($link_q->execute()){
						$link_q->bind_result($f_url);
						$link_q->fetch();
						$link_q->reset();
					}
				}
			}

		$showcase_ele[] = array('file_share_type'=>$row['file_share_type'],'f_type'=>get_file_type($f_type),
							'f_url'=>$f_url,'f_name'=>$f_name,'file_desc'=>$row['file_desc']);

		}

		return $showcase_ele;
		// echo json_encode(array("showcase"=>$showcase_ele));

	}

	// mysqli_close($con);

?>