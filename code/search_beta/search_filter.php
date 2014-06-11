<?php
	include_once("includefiles.php");
	
//  	$_POST['search_string'] = "Computer";
//  	$_POST['search_type']  = "All";
	
	$university_id=0;
	$first_deptid=0;
	$course_rows = 0;
	$student_rows =0;$professor_rows = 0;$all_rows = 0;$group_rows = 0;
	$current_semester = "";
	
	$course_sql_stmt = $dbObj->stmt_init();
	$group_sql_stmt = $dbObj->stmt_init();
	$user_sql_stmt = $dbObj->stmt_init();
	$search_course_cond="";
	$search_user_cond = "";
	$search_group_cond ="";
	$sel_deptid = 1;
		
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
		$result = $dbObj->query("SELECT semester from univ_semester where univ_id = $university_id and start_date >= (SELECT curdate()) order by start_date");
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$current_semester = $row['semester'];
			break;
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
	
	if(isset($_GET['deptid']) && $_GET['deptid']!=''){
				$sel_deptid=$_GET['deptid'];
		}else{
				$sel_deptid=$first_deptid;
				}
				//echo "Dept".$sel_deptid;
			if(isset($sel_deptid) && $sel_deptid!='')
			{
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
				$course_sql = "";
				if(isset($search_course_cond) && $search_course_cond!="")
				{
					$course_sql = "SELECT course_id, course_name, course_desc, course_credits FROM courses where univ_id = ? and course_name LIKE ?";
					$course_sql_stmt = $dbObj->prepare($course_sql);
					//echo "University".$university_id;
					$course_sql_stmt->bind_param("is", $university_id, $search_course_cond);
					$course_sql_stmt->execute();
					$course_sql_stmt->bind_result($cid, $cname, $cdesc, $ccredits);
					while($course_sql_stmt->fetch())
					{
						//echo "inside result";
						$course_array[] = array('name'=>$cname,
								'id' => $cid,
								'desc'=> $cdesc,
								'credits'=>$ccredits
						);
						$course_rows += 1;
					}
				}
				else
				{
					$course_sql ="SELECT course_id, course_name, course_desc, course_credits FROM courses where univ_id = ? and deptid= ?";
					$course_sql_stmt = $dbObj->prepare($course_sql);
					$course_sql_stmt->bind_param("ii", $university_id, $sel_deptid);
				}
				$user_sql = "";
				$depts = "";
				if(isset($search_user_cond) && $search_user_cond!="")
				{
					$user_sql = "SELECT user_email, 
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
									 or upper(lastname) LIKE ?)";
					
					$user_sql_stmt = $dbObj->prepare($user_sql);
					$user_sql_stmt->bind_param("iss", $university_id, $search_user_cond, $search_user_cond);
					
					$user_sql_stmt->execute();
					$user_sql_stmt->bind_result($uemail, $utype, $ufname, $ulname, $udept_id, $ubio, $upic, $upic_loc);
					
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
						$user_array[] = array('email'=>$uemail,
								'type' => $utype,
								'bio'=> $ubio,
								'name'=>$ufname." ".$ulname,
								'pic'=>$upic_loc.$upic,
								'dept_id' => $udept_id
						);
					
						$depts = $depts.$udept_id.",";
					}
					//echo "Professor".$professor_rows;
					//echo "Student".$student_rows;
					$depts = substr($depts, 0, strlen($depts)-1);
					
				}
				else
				{
					$user_sql="SELECT user_email, 
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
								  and deptid=?";
					$user_sql_stmt = $dbObj->prepare($user_sql);
					$user_sql_stmt->bind_param("ii", $university_id, $sel_deptid);
				}
				
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
								   and UPPER(group_name) LIKE ?";
					$group_sql_stmt = $dbObj->prepare($group_sql);
					$group_sql_stmt->bind_param("is", $university_id, $search_group_cond);
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
				else
				{
					$group_sql="SELECT group_id,
									   group_name,
									   group_desc,
									   contact_email
									   website,
									   founded_on
								  FROM group 
								 where univ_id = ? 
								   and deptid= ?";
					$group_sql_stmt = $dbObj->prepare($group_sql);
					$group_sql_stmt->bind_param("ii", $university_id, $sel_deptid);
				}
				}
	$query = "";
	if(isset($_POST['search_type']) && $_POST['search_type'] != '')
	{
		if(isset($_POST['search_type']) == 'Course')
		{
			if(isset($_POST['filter']) && $_POST['filter'] != '')
			{
				$query = $course_sql.convToSearchString($_POST['filter']);
			}
			else
			{
				
			}
		}
	}			
	
	//$professor_rows = 0;
	//$student_rows = 0;
	//$depts = "";
	//$group_rows = $group_result->num_rows;
	
	$all_rows = $course_rows + $professor_rows + $student_rows + $group_rows;
	
	$json_array = array(
			'all_rows'	  => $all_rows,
			'course_rows' => $course_rows,
			'group_rows'  => $group_rows,
			'professor_rows' => $professor_rows,
			'student_rows' => $student_rows,
	);
	
	$msg = "";
	
	for($i = 0; $i<count($course_array);$i++)
	{
		$msg = $msg.'<div class = "results-top-sec">
	<div class = "result-header">
	
	<div class = "title-limit"></div>
	<h2>'.$course_array[$i]['name'].'</h2>
	<p>'.$course_array[$i]['id'].'</p>
	<p>'.$course_array[$i]['credits'].'</p>
	</div>
	<div class = "result-header-right">
	<div class = "result-functions-wrapper">
	<div class = "btn-small fav">
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
	<div class = "description">
	Prerequisites: SPAN W3349 or SPAN W3350 and Language requirements 3300, 3330 This course will read Venezuela backwards in films, poems, novels and essays, from the present-tense struggle over the legacy of chavismo to the early days of independence.  The constant thread will be the conflict between development and nature with special attention to natural resources and eco-critical approaches.<span><a>More Info</a></span>
	</div>
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
	<div class = "info-piece instructor">
	Professor Di Bartolo
	</div>
	<div class = "info-piece subject">
	Applied Physics
	</div>
	<div class = "info-piece members">
	<div class = "member-pics-wrapper">
	<a class = "innerPic">
	<div class = "smallPic">
	<img class = "img" src = "src/person1.jpg" width = "29" height = "29">
	</div>
	</a>
	<a class = "innerPic">
	<div class = "smallPic">
	<img class = "img" src = "src/person2.jpg" width = "29" height = "29">
	</div>
	</a>
	<a class = "innerPic">
	<div class = "smallPic">
	<img class = "img" src = "src/person3.jpg" width = "29" height = "29">
	</div>
	</a>
	<a class = "innerPic">
	<div class = "smallPic">
	<img class = "img" src = "src/person4.jpg" width = "29" height = "29">
	</div>
	</a>
	<a class = "innerPic">
	<div class = "smallPic">
	<img class = "img" src = "src/person5.jpg" width = "29" height = "29">
	</div>
	</a>
	<a class = "rosterLink">
	<div class = "doubleBox">
	+67
	</div>
	</a>
	</div>
	</div>
	</div>
	
	<div class = "result-bottom">
	<div class = "course-schedule">
	
	</div>
	<div class = "course-bottom-functions">
	<div class = "join-button">
	<a class = "join sign-up">
	Join Class
	</a>
	</div>
	</div>
	</div>
	</div>';
	echo json_encode($json_array);
	
function convToSearchString($str){
	return str_replace("\'", "'", $str);
}		
?>