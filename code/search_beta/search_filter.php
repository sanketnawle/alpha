<?php
	include_once("includefiles.php");
	
  	$_POST['search_string'] = "Computer";
  	$_POST['search_type']  = "All";
  	$_POST['univid'] = 1;
	$_SESSION['user_id'] = 1;
  	
/* get all connected ids*/
  	$to_ids = get_connected_users($_SESSION['user_id']);
/*----------------------*/  	
	$university_id=0;
	$first_deptid=0;
	$course_rows = 0;
	$student_rows =0;$professor_rows = 0;$all_rows = 0;$group_rows = 0;
	$current_semester = "";
	$current_year = date("Y");
	
	$course_sql_stmt = $dbObj->stmt_init();
	$group_sql_stmt = $dbObj->stmt_init();
	$user_sql_stmt = $dbObj->stmt_init();
	$search_course_cond="";
	$search_user_cond = "";
	$search_group_cond ="";
	$sel_deptid = 1;
	$course_filter="";
	$maxCredits = ""; $minCredits=""; $deptCond = "";
	
	
	if(isset($_POST['filter']) && $_POST['filter'] != '')
	{
		if(key_exists('minCredits',$_POST['filter']))
		{
			$minCredits = $_POST['filter']['minCredits'];
			$maxCredits = $_POST['filter']['maxCredits'];
			$course_filter .= "and c.course_credits between ? and ?";
		}
		if(key_exists('dept_id', $_POST['filter']))
		{
			$deptCond = $_POST['filter']['dept_id'];
			$filter .= "and dept_id = ?";
		}
	}
		
	if(isset($_POST['univid']) && $_POST['univid']!='' )
	{
		$university_id=$_POST['univid'];
	}
	
/*Get the current semester*/
	$result = $dbObj->query("SELECT semester from univ_semester where univ_id = $university_id and start_date <= (SELECT curdate()) and end_date >= (SELECT curdate()) ");
	if($result->num_rows > 0)
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$current_semester = $row['semester'];
		}
	else 
	{
		if($result = $dbObj->query("SELECT semester from univ_semester where univ_id = $university_id and start_date >= (SELECT curdate()) order by start_date"))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$current_semester = $row['semester'];
				break;
			}
		}
	}
	/////////Get all departments for university here /////////////////////////////
	$deptsql="SELECT * FROM `department` where `univ_id`='".$university_id."';";
	
	if($deptListRes = $dbObj->query($deptsql))
	{
		$deptRow = $deptListRes->fetch_array(MYSQLI_ASSOC);
		$first_deptid=$deptRow['dept_id'];
	}

// 	//echo "Dept".$first_deptid;
	
	if(isset($_GET['deptid']) && $_GET['deptid']!='')
	{
			$sel_deptid=$_GET['deptid'];
	}
	else
	{
			$sel_deptid=$first_deptid;
	}
				
			
	$search_course_cond="";
	if(isset($_POST[search_string]) && $_POST[search_string]!='')
	{
		$search_course_cond="%".$_POST['search_string']."%";
		$search_user_cond = "%".$_POST['search_string']."%";
		$search_group_cond = "%".$_POST['search_string']."%";
// 					echo $search_course_cond;
// 					echo $search_user_cond;
// 					echo $search_group_cond;
	}

/*get everything with courses*/	
	$course_sql = ""; $course_keys = ""; $course_depts=array(); $user_id=array();
	if(isset($search_course_cond) && $search_course_cond!="")
	{
		$course_sql = "SELECT c.course_id, c.dept_id, c.course_name,c.course_desc, c.course_credits,
							  cs.class_id, cs.section_id, cs.location, cs.professor,
							  s.day, s.start_time, s.end_time
						FROM courses AS c
						JOIN courses_semester AS cs
						ON (c.univ_id = cs.univ_id
						AND c.dept_id = cs.dept_id
						AND c.course_id = cs.course_id)
						JOIN courses_semester_schedule as css
                        ON ( cs.class_id = css.class_id)
						JOIN schedule AS s ON (css.schedule_id = s.schedule_id)
						WHERE c.univ_id = ?
						AND ( upper(c.course_name) LIKE ?
						OR upper(c.course_id) LIKE ? )".$course_filter.$filter;
 		//echo $course_sql,$university_id, $search_course_cond;
		$course_sql_stmt = $dbObj->prepare($course_sql);
		
		if($course_filter == "" && $filter == "")
		{
			$course_sql_stmt->bind_param("iss", $university_id, $search_course_cond,$search_course_cond);
		}
		elseif($course_filter != "" && $filter == "")
		{
			$course_sql_stmt->bind_param("issii", $university_id, $search_course_cond,$search_course_cond,$minCredits,$maxCredits);
		}
		elseif($course_filter == "" && $filter != "")
		{
			$course_sql_stmt->bind_param("issi", $university_id, $search_course_cond,$search_course_cond,$deptCond);
		}
		else
		{
			$course_sql_stmt->bind_param("issii", $university_id, $search_course_cond,$search_course_cond,$minCredits,$maxCredits,$deptCond);
		}
		
		$course_sql_stmt->execute();
		$course_sql_stmt->bind_result($cid, $cdept_id, $cname, $cdesc, $ccredits, 
				$cclass_id, $csection_id, $cloc, $cprof_id, $cday, $cstart_time, $cend_time);
		while($course_sql_stmt->fetch())
		{
			//echo $cclass_id;
			$course_array[] = array(
						'name'=>$cname,
						'dept_id' => $cdept_id,
						'id' => $cid,
						'desc'=> $cdesc,
						'credits'=>$ccredits,
						'class'=>$cclass_id,
						'section'=>$csection_id,
						'location'=>$cloc,
						'prof' => $cprof_id,
						'day' => $cday,
						'start' => $cstart_time,
						'end' => $cend_time
				);
				if(is_numeric($cprof_id))
				{
					$user_id[] = $cprof_id;
				}
				$course_rows += 1;
				$course_depts[] = $cdept_id;
		}
// 		echo $course_rows;
	}
// 	elseif(isset($sel_deptid) && $sel_deptid > 0)
// 	{
// 		$course_sql ="SELECT c.course_id, c.dept_id, c.course_name,c.course_desc, c.course_credits,
// 							 cs.class_id, cs.section_id, cs.location, cs.professor,
// 							 s.day, s.start_time, s.end_time
// 						FROM courses AS c
// 						JOIN courses_semester AS cs
// 						ON (c.univ_id = cs.univ_id
// 						AND c.dept_id = cs.dept_id
// 						AND c.course_id = cs.course_id)
// 						JOIN courses_semester_schedule as css
//                         ON ( cs.class_id = css.class_id)
// 						JOIN schedule AS s ON (css.schedule_id = s.schedule_id)
// 						WHERE c.univ_id = ?
// 						 AND  c.dept_id = ? )".$course_filter;
// 		$course_sql_stmt = $dbObj->prepare($course_sql);
		
// 		if($course_filter == "" && $filter == "")
// 		{
// 			$course_sql_stmt->bind_param("ii", $university_id, $sel_deptid);
// 		}
// 		elseif($course_filter != "" && $filter == "")
// 		{
// 			$course_sql_stmt->bind_param("issii", $university_id, $search_course_cond,$search_course_cond,$minCredits,$maxCredits);
// 		}
// 		elseif($course_filter == "" && $filter != "")
// 		{
// 			$course_sql_stmt->bind_param("issi", $university_id, $search_course_cond,$search_course_cond,$deptCond);
// 		}
// 		else
// 		{
// 			$course_sql_stmt->bind_param("issii", $university_id, $search_course_cond,$search_course_cond,$minCredits,$maxCredits,$deptCond);
// 		}
	
// 		$course_sql_stmt->execute();
// 		$course_sql_stmt->bind_result($cid, $cdept_id, $cname, $cdesc, $ccredits, 
// 				$cclass_id,$csection_id, $cprof_id, $cday, $cstart_time, $cend_time);
// 		while($course_sql_stmt->fetch())
// 		{
// 			$course_array[] = array('name'=>$cname,
// 					'dept_id' => $cdept_id,
// 					'id' => $cid,
// 					'desc'=> $cdesc,
// 					'credits'=>$ccredits,
// 					'class_id'=>$cclass_id,
// 					'section'=>$csection_id,
// 					'location'=>$cloc,
// 					'prof' => $cprof_id,
// 					'day' => $cday,
// 					'start' => $cstart_time,
// 					'end' => $cend_time
// 			);
// 			if(is_numeric($cprof_id))
// 			{
// 				$user_id[] = $cprof_id;
// 			}
		
// 			$course_depts[] = $cdept_id;
// 			$course_rows += 1;
// 		}
// 	}
	//echo $course_rows;
	if(count($course_array)>0)
	{
		$params = array_fill(0, count($user_id), '?');
		$prof_sql ="SELECT u.user_id, u.user_email, u.firstname, u.lastname, u.dept_id,
						   u.profile_picture, u.pic_location, p.designation, p.office_location
							FROM user AS u
							LEFT JOIN prof_attribs AS p
							ON (u.user_id = p.prof_id)
							WHERE u.user_id IN (". implode(",",$params).")";
		//echo $prof_sql;
		$prof_sql_stmt = $dbObj->prepare($prof_sql);
		//$prof_cond = implode(",", $user_id);
		//$prof_sql_stmt->bind_param("s", $prof_cond);
		array_unshift($user_id, implode('', array_fill(0, count($user_id), 'i')));
		call_user_func_array(array($prof_sql_stmt,'bind_param'), $user_id);
		//echo $prof_cond;
		$prof_sql_stmt->execute();
		$prof_sql_stmt->bind_result($prof_id, $prof_email, $prof_fname, $prof_lname, $prof_dept_id,$pic,$pic_loc,$prof_desig, $prof_loc);
		$prof_array_count = 0;
		while($prof_sql_stmt->fetch())
		{
			$prof_array[] = array(
					'id'=>$prof_id,
					'email'=>$prof_email,
					'name' => $prof_fname." ".$prof_lname,
					'dept_id'=>$prof_dept_id,
					'picture' => "../../DEMO/".$pic_loc."/".$pic,
					'desig' => $prof_desig,
					'loc' => $prof_loc
			);
			$prof_array_count += 1;
			$course_depts[] = $prof_dept_id;
		}
		//echo $prof_array_count;

/* end of courses */	

/*start of users*/	
				$user_sql = "";
				$depts = array();
				if(isset($search_user_cond) && $search_user_cond!="")
				{
					$user_sql = "SELECT user_id,
										user_email, 
										user_type, 
										firstname, 
										lastname, 
										dept_id, 
										user_bio,
										profile_picture,
										pic_location
								   FROM user 
								  where univ_id = ?
									and status = 'active' 
									and (upper(firstname) LIKE ? 
									 or upper(lastname) LIKE ?)".$filter;
					
					$user_sql_stmt = $dbObj->prepare($user_sql);
					if($filter == "")
					{
						$user_sql_stmt->bind_param("iss", $university_id, $search_user_cond, $search_user_cond);
					}
					else
					{
						$user_sql_stmt->bind_param("issi", $university_id, $search_user_cond, $search_user_cond, $deptCond);
					}
					$user_sql_stmt->execute();
					$user_sql_stmt->bind_result($uid, $uemail, $utype, $ufname, $ulname, $udept_id, $ubio, $upic, $upic_loc);
					
					while($user_sql_stmt->fetch())
					{
						if($utype == 'p')
						{
							$professor_rows += 1;
						}
						else if($utype == 's')
						{
							$student_rows += 1;
						}
						$user_array[] = array(
								'id'=> $uid,
								'email'=>$uemail,
								'type' => $utype,
								'bio'=> $ubio,
								'name'=>$ufname." ".$ulname,
								'pic'=>"../../DEMO/".$upic_loc."/".$upic,
								'dept_id' => $udept_id
						);
						$course_depts[]=$udept_id;
					}
				}
// 				else
// 				{
// 					$user_sql="SELECT user_id
// 									  user_email, 
// 									  user_type, 
// 									  firstname, 
// 									  lastname, 
// 									  dept_id, 
// 									  user_bio,
// 									  profile_picture,
// 									  pic_location
// 								 FROM user 
// 								where univ_id = ?
// 								  and status = 'active' 
// 								  and deptid=?";
// 					$user_sql_stmt = $dbObj->prepare($user_sql);
// 					$user_sql_stmt->bind_param("ii", $university_id, $sel_deptid);
// 					$user_sql_stmt->bind_result($uid,$uemail, $utype, $ufname, $ulname, $udept_id, $ubio, $upic, $upic_loc);	
// 					while($user_sql_stmt->fetch())
// 					{
// 						if($utype == 'p')
// 						{
// 							$professor_rows += 1;
// 						}
// 						else if($utype == 's')
// 						{
// 							$student_rows += 1;
// 						}
// 						$user_array[] = array(
// 								'id' => $uid,
// 								'email'=>$uemail,
// 								'type' => $utype,
// 								'bio'=> $ubio,
// 								'name'=>$ufname." ".$ulname,
// 								'pic'=>"../../DEMO/".$upic_loc."/".$upic,
// 								'dept_id' => $udept_id
// 						);
// 						$course_depts[]=$udept_id;
// 					}
// 				}
/* end of users*/				
				$group_sql="";
				if(isset($search_group_cond) && $search_group_cond!="")
				{
					$group_sql="SELECT group_id,
									   group_name,
									   group_desc,
									   contact_email,
									   website,
									   founded_on
								  FROM groups 
								 where univ_id = ? 
								   and UPPER(group_name) LIKE ?".$filter;
					$group_sql_stmt = $dbObj->prepare($group_sql);
					if($filter == "")
					{
						$group_sql_stmt->bind_param("is", $university_id, $search_group_cond);
					}
					else {
						$group_sql_stmt->bind_param("isi", $university_id, $search_group_cond, $deptCond);
					}
					$group_sql_stmt->execute();
					$group_sql_stmt->bind_result($gid,$gname, $gdesc, $gemail, $gwebsite, $gfounded_on);
					while($group_sql_stmt->fetch())
					{
						$group_array[] = array('id' => $gid,
								'name'=>$gname,
								'desc'=> $gdesc,
								'email' => $gemail,
								'website' => $gwebsite,
								'gfounded' => $gfounded_on
						);
						$group_rows += 1;
					}
					//echo $group_rows;
				}
// 				else
// 				{
// 					$group_sql="SELECT group_id,
// 									   group_name,
// 									   group_desc,
// 									   contact_email
// 									   website,
// 									   founded_on
// 								  FROM group 
// 								 where univ_id = ? 
// 								   and deptid= ?";
// 					$group_sql_stmt = $dbObj->prepare($group_sql);
// 					$group_sql_stmt->bind_param("ii", $university_id, $sel_deptid);
// 				}
	
/* format output*/
	/* Get the department name */
	$course_depts = array_unique($course_depts);
	$course_depts = implode(",", $course_depts);
	$result = $dbObj->query("Select dept_id, dept_name from department where dept_id in ($course_depts)");
	// 		echo "Select dept_id, dept_name from department where dept_id in $course_depts";
	if($result->num_rows > 0)
	{
		$course_depts = array();
		while($row = $result->fetch_array())
		{
			$course_depts[$row['dept_id']] = $row['dept_name'];
		}
	}
	}
	// 	echo $msg;
				
	$lastslide_pos=0;$photo_index = 0; $photo_position = 0;
	$connected_id = get_connected_users($_SESSION['user_id']);
	echo '<div class = "all_results_active"><div class = "horiz-area">
					<div class = "horiz-wrapper">
			<div class = "horiz-mask">
				<div class = "content-area">
				<div class = "ContentSlider">';
	foreach($prof_array as $row)
	{
		$photo_position = 250 * $photo_index;
		$lastslide_pos = $photo_position - 250;
		$professor_rows += 1;
		$photo_index += 1;
		echo '<div class = "slide" style = "transform: matrix(1,0,0,1,'.$photo_position.',0)">
			<div class = "slide-inner">
			<div class = "result-photo">
			<img src = "'.$row['picture'].'">
			<h3>'.$row['name'].'</h3>
			<p>'.$course_depts[$row['dept_id']].'</p>
			</div>
			<div class = "person-bottom-functions">
			<div class = "link-button">';
		if(in_array($prof_array['id'], $to_ids))
		{
			echo 'UrLinqed';
		}
		else
		{
			echo '<a class = "link link-up">Follow</a>';
		}
		echo '</div>
			</div>
			</div>
			</div>';
	}
	echo '</div>
		</div>
	</div>
	<div class = "arrow-disabled arrow-container arrow-prev">
		<a class = "ar-disabled ar-left"></a></div><div class = "arrow-container arrow-next">
		<a id = "ar-right" class = "ar-right"></a></div></div></div>';
	
	$members_sql = "SELECT u.user_id, u.profile_picture, u.pic_location
					FROM user AS u JOIN courses_user AS cu
					ON (u.user_id = cu.user_id)
					WHERE cu.class_id = ?";
	$memebers_sql_stmt = $dbObj->prepare($members_sql);
	
	
	
	echo '<div class = "vert-area">';
	for($i = 0; $i<count($course_array);$i++)
	{
	echo '
	<div class = "course vert-results-wrapper">
	<div class = "results-top-sec">
	<div class = "result-header">
	<div class = "title-limit"></div>
	<h2>'.$course_array[$i]['name'].'</h2>
	<p>'.$course_array[$i]['id'].'</p>
	<p>'.$course_array[$i]['credits'].'</p>
	</div>
	<div class = "result-header-right">
	<div class = "result-functions-wrapper">
	<div id="'.$course_array[$i]['class'].'"class = "btn-small fav">
	</div>
	<div class = "tooltip">
	<div class = "tool-wedge"></div>
	<div class = "tool-box">
	<span>Add This Course To My Bookmarks</span>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class = "results-main-sec">
	<p class = "description">'.$course_array[$i]['desc'].'</p>
	<div class = "lower-info-keys">
	<div class = "info-key instructor">
	Instructor
	</div>
	<div class = "info-key subject">
	Department
	</div>
	<div class = "info-key members">
	Members
	</div>
	</div>
	
	<div class = "lower-info">
	<div class = "info-piece instructor">';
		if(is_numeric($course_array[$i]['prof']))
		{
		foreach($prof_array as $row)
		{
		if(in_array($course_array[$i]['prof'], $row))
		{
		echo $row['name'];
		}
		}
	
		}
		else
		{
		echo $course_array[$i]['prof'];
		}
		echo '</div>
		<div class = "info-piece subject">'.$course_depts[$course_array[$i]['dept_id']].'</div>
			<div class = "info-piece members">
			<div class = "member-pics-wrapper">';
	
				$memebers_sql_stmt->bind_param("s", $course_array[$i]['class_id']);	
				$memebers_sql_stmt->execute();
				$memebers_sql_stmt->bind_result($mem_uid, $mem_pic, $mem_pic_loc);
				$count = 0;
		$hasJoined = false;
		while ($memebers_sql_stmt->fetch())
		{
		if($count <=5)
			{
			echo '<a id = "'.$mem_uid.'"class = "innerPic">
			<div class = "smallPic">
			<img class = "img" src = "'.$mem_pic_loc.$mempic.'" width = "29" height = "29">
			</div>
			</a>';
		}
		if($mem_uid == $_SESSION['userid'])
			$hasJoined = true;
			$count += 1;
		}
		echo '<a class = "rosterLink">
	<div class = "doubleBox">'.
	$count
	.'</div>
		</a>
		</div>
	</div>
	</div>
	
	<div class = "result-bottom">
	<div class = "course-schedule">
	
	</div>
	<div class = "course-bottom-functions">';
		if(!$hasJoined)
		{
		echo '<div class = "join-button">
			<a class = "join sign-up">
			Join Class
			</a>
			</div>';
		}
	echo '</div></div></div></div>';
	}

	$maxCredit = 0;
	
	$course_depts = array();
	foreach ($course_array as $row)
	{
		$course_depts[] = $row['dept_id'];
	}
	
	$course_depts = array_unique($course_depts);
	
	$credit_stmt = $dbObj->prepare("SELECT max( `credits` ) FROM ( 
			SELECT max( `course_credits` ) AS `credits` FROM `courses` WHERE `dept_id`
			IN (".implode(",", $course_depts).")) AS ctable");
	
	$credit_stmt->execute();
	$credit_stmt->bind_result($max);
	
	while($credit_stmt->fetch())
	{
		$maxCredit = $max;
	}
	
	$all_rows = $course_rows + $professor_rows + $student_rows + $group_rows;
	
	echo '<all_rows>'.$all_rows.'</all_rows><course_rows>'.$course_rows.'</course_rows>
		  <group_rows>'.$group_rows.'</group_rows><professor_rows>'.$professor_rows.'</professor_rows>
		  <student_rows>'.$student_rows.'</student_rows><credits>'.$maxCredit.'</credits>';
	
function convToSearchString($str){
	return str_replace("\'", "'", $str);
}		
?>