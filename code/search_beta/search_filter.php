<?php
	include_once("follow.php");
	include_once "includes/feedchecks.php";
	include_once 'SPL.php';
	
  	$_POST['search_string'] = "games";
  	$_POST['search_type']  = "All";
  	$_POST['page'] = 1;
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
	
	$course_sql_stmt = $con->stmt_init();
	$group_sql_stmt = $con->stmt_init();
	$user_sql_stmt = $con->stmt_init();
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
			$course_filter .= "and gtable.course_credits between ? and ?";
		}
		if(key_exists('dept_id', $_POST['filter']))
		{
			$deptCond = $_POST['filter']['dept_id'];
			$filter .= "and gtable.dept_id = ?";
		}
	}
		
	if(isset($_POST['univid']) && $_POST['univid']!='' )
	{
		$university_id=$_POST['univid'];
	}
	
/*Get the current semester*/
	$result = $con->query("SELECT semester from univ_semester where univ_id = $university_id and start_date <= (SELECT curdate()) and end_date >= (SELECT curdate()) ");
	if($result->num_rows > 0)
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$current_semester = $row['semester'];
		}
	else 
	{
		if($result = $con->query("SELECT semester from univ_semester where univ_id = $university_id and start_date >= (SELECT curdate()) order by start_date"))
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
	
	if($deptListRes = $con->query($deptsql))
	{
		$deptRow = $deptListRes->fetch_array(MYSQLI_ASSOC);
		$first_deptid=$deptRow['dept_id'];
	}
	
	if(isset($_GET['deptid']) && $_GET['deptid']!='')
	{
			$sel_deptid=$_GET['deptid'];
	}
	else
	{
			$sel_deptid=$first_deptid;
	}
				
			
	$search_course_cond="";
	$casedSearchString = str_ireplace("+", " ", $_POST['search_string']);
	$casedSearchString = strtoupper($casedSearchString);
	if(isset($casedSearchString) && $casedSearchString!='')
	{
		$search_course_cond="%".$casedSearchString."%";
		$search_user_cond = "%".$casedSearchString."%";
		$search_group_cond = "%".$casedSearchString."%";
		$search_post_cond = "%".$casedSearchString."%";
	}

	else
	{
		exit("No Search String");
	}
/*get everything with courses*/	
	$course_sql = ""; $course_keys = ""; $course_depts=array(); $user_id=array(); $class_ids = array();
	if(isset($search_course_cond) && $search_course_cond!="")
	{
		$course_sql = "SELECT gtable.course_id, gtable.dept_id, gtable.course_name,gtable.course_desc, gtable.course_credits,
							  cs.class_id, cs.section_id, cs.location, cs.professor
						FROM courses AS gtable
						JOIN courses_semester AS cs
						ON (gtable.univ_id = cs.univ_id
						AND gtable.dept_id = cs.dept_id
						AND gtable.course_id = cs.course_id)
						WHERE gtable.univ_id = ?
						AND ( upper(gtable.course_name) LIKE ?
						OR upper(gtable.course_id) LIKE ? )".$course_filter.$filter;
		$course_sql_stmt = $con->prepare($course_sql);
		
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
		$course_sql_stmt->bind_result($cid, $cdept_id, $cname, $cdesc, $ccredits, $cclass_id, $csection_id, $cloc, $cprof_id);
		while($course_sql_stmt->fetch())
		{
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
				);
				if(is_numeric($cprof_id))
				{
					$user_id[] = $cprof_id;
				}
				$course_rows += 1;
				$course_depts[] = $cdept_id;
				$class_ids[] = $cclass_id;
		}
	}

/*---------------------------------------------------------------------------------------*/
// Prioritize
/*---------------------------------------------------------------------------------------*/
	if(count($class_ids) > 0)
	{
		$class_ids = array_unique($class_ids);
		$lq_class_id = $class_ids;
		$members_sql = "SELECT count(tab.user_id), tab.class_id 
							FROM (SELECT user_id, class_id from courses_user cu JOIN connect c 
							ON (c.to_user_id = cu.user_id)
							WHERE c.from_user_id = ?) tab
							GROUP BY tab.class_id
							HAVING tab.class_id IN (".implode(",",array_fill(0, count($lq_class_id),"?")).")";
		$memebers_sql_stmt = $con->prepare($members_sql);
		$bs = implode("", array_fill(0, count($lq_class_id), "s"));
		$bs = "i".$bs;
		array_unshift($lq_class_id, $_SESSION['user_id']);
		array_unshift($lq_class_id,$bs);
		call_user_func_array(array($memebers_sql_stmt,'bind_param'), $lq_class_id);
		$memebers_sql_stmt->execute();
		$memebers_sql_stmt->bind_result($linq_no, $cid);
		$priority_array = array();
		while ($memebers_sql_stmt->fetch())
		{
			$priority_array[$cid] = array("links" => $linq_no);	
		}
		$memebers_sql_stmt->close();
		
		$members_sql = "SELECT count(user_id), class_id
							FROM courses_user
							GROUP BY class_id 
							HAVING class_id IN (".implode(",", array_fill(0, count($class_ids), "?")).")";
		$memebers_sql_stmt = $con->prepare($members_sql);
		array_unshift($class_ids, implode("", array_fill(0, count($class_ids), "s")));
		call_user_func_array(array($memebers_sql_stmt,'bind_param'), $class_ids);
		$memebers_sql_stmt->execute();
		$memebers_sql_stmt->bind_result($linq_no, $cid);
		while ($memebers_sql_stmt->fetch())
		{
			$priority_array[$cid]["tot"] = $linq_no;
		}
		$memebers_sql_stmt->close();
		
		$pq_course_array = new SplPriorityQueue();
		foreach ($course_array as $v)
		{ 
			if(isset($priority_array[$v['class']]))
				$pq_course_array->insert($v, $priority_array[$v['class']]);
		}
	}
/*---------------------------------------------------------------------------------------*/
	if(count($user_id)>0)
	{
		$params = array_fill(0, count($user_id), '?');
		$prof_sql ="SELECT u.user_id, u.user_email, u.firstname, u.lastname, u.dept_id,
						   u.profile_picture, u.pic_location, p.designation, p.office_location,
							univ.univ_name
							FROM user AS u
							LEFT JOIN prof_attribs AS p
							ON (u.user_id = p.prof_id)
							JOIN university univ
							ON (u.univ_id = univ.univ_id)
							WHERE u.user_id IN (". implode(",",$params).")";
		$prof_sql_stmt = $con->prepare($prof_sql);
		array_unshift($user_id, implode('', array_fill(0, count($user_id), 'i')));
		call_user_func_array(array($prof_sql_stmt,'bind_param'), $user_id);
		$prof_sql_stmt->execute();
		$prof_sql_stmt->bind_result($prof_id, $prof_email, $prof_fname, $prof_lname, $prof_dept_id,$pic,$pic_loc,$prof_desig, $prof_loc, $uname);
		$prof_array_count = 0;
		while($prof_sql_stmt->fetch())
		{
			$prof_array[] = array(
					'id'=>$prof_id,
					'email'=>$prof_email,
					'type' => 'p',
					'name' => $prof_fname." ".$prof_lname,
					'dept_id'=>$prof_dept_id,
					'picture' => "../../DEMO/".$pic_loc."/".$pic,
					'desig' => $prof_desig,
					'loc' => $prof_loc,
					'uname' => $uname
			);
			$prof_array_count += 1;
			$course_depts[] = $prof_dept_id;
		}
	}

/* end of courses */	

/*start of users*/	
				$user_sql = "";
				$depts = array();
				if(isset($search_user_cond) && $search_user_cond!="")
				{
					$user_sql = "SELECT gtable.user_id,
										gtable.user_email, 
										gtable.user_type, 
										gtable.firstname, 
										gtable.lastname, 
										gtable.dept_id, 
										gtable.user_bio,
										gtable.profile_picture,
										gtable.pic_location,
										un.univ_name
								   FROM user gtable
							       JOIN university un
									 ON (gtable.univ_id = un.univ_id)
								  where un.univ_id = ?
									and gtable.status = 'active' 
									and (upper(gtable.firstname) LIKE ? 
									 or upper(gtable.lastname) LIKE ?)".$filter;
					
					$user_sql_stmt = $con->prepare($user_sql);
					if($filter == "")
					{
						$user_sql_stmt->bind_param("iss", $university_id, $search_user_cond, $search_user_cond);
					}
					else
					{
						$user_sql_stmt->bind_param("issi", $university_id, $search_user_cond, $search_user_cond, $deptCond);
					}
					$user_sql_stmt->execute();
					$user_sql_stmt->bind_result($uid, $uemail, $utype, $ufname, $ulname, $udept_id, $ubio, $upic, $upic_loc,$uuniv_name);
					
					while($user_sql_stmt->fetch())
					{
						$user_array[] = array(
								'id'=> $uid,
								'email'=>$uemail,
								'type' => $utype,
								'bio'=> $ubio,
								'name'=>$ufname." ".$ulname,
								'picture'=>"../../DEMO/".$upic_loc."/".$upic,
								'dept_id' => $udept_id,
								'uname'=>$uuniv_name
						);
						$course_depts[]=$udept_id;
					}
				}
/* end of users*/				
				$group_sql="";
				if(isset($search_group_cond) && $search_group_cond!="")
				{
					$group_sql="SELECT gtable.group_id,
									   gtable.group_name,
									   gtable.group_desc,
									   gtable.contact_email,
									   gtable.website,
									   gtable.founded_on
								  FROM groups gtable
								 where gtable.univ_id = ? 
								   and UPPER(gtable.group_name) LIKE ?".$filter;
					//echo $group_sql;
					$group_sql_stmt = $con->prepare($group_sql);
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
				}
/*------------------end of groups-----------------------------------------------------------------*/
				$post_sql="";$post_user_ids = array(); $post_filter="";
				if (count($prof_array)>0)
				{
					$post_user_ids = array_column($prof_array,"id");
				}
				if (count($user_array)>0)
				{
					$post_user_ids = array_merge($post_user_ids, array_column($user_array,"id"));
				}
				if(count($post_user_ids) > 0)
				{
					$post_user_ids = array_unique($post_user_ids);
					$post_filter = "or gtable.user_id IN (".implode(",", $post_user_ids).")";
				}
				
				$post_sql="SELECT gtable.post_id,
								  gtable.user_id,
								  gtable.target_univ_id,
								  gtable.post_type,
								  gtable.text_msg,
								  gtable.sub_text,
								  gtable.file_id,
								  gtable.privacy,
								  gtable.anon,
								  gtable.like_count,
								  gtable.update_timestamp
							 FROM posts gtable
						    where gtable.text_msg LIKE ?
							   or gtable.sub_text LIKE ?".$post_filter.$filter;
				echo $post_sql;
				
				$post_sql_stmt = $con->prepare($post_sql);
				if($filter == "")
				{
					$post_sql_stmt->bind_param("ss", $search_post_cond, $search_post_cond);
				}
				else 
				{
					$post_sql_stmt->bind_param("ssi", $search_post_cond, $search_post_cond, $deptCond);
				}
				$post_sql_stmt->execute();
				$post_sql_stmt->bind_result($post_id,$user_id,$target_univ_id,$post_type,$text_msg,
						$sub_text,$file_id,$privacy,$anon,$like_count,$update_timestamp);
				while($post_sql_stmt->fetch())
				{
					if(in_array($privacy, scope($_SESSION['user_id'], $user_id)))
					{
						$post_array[] = array('post_id' => $post_id,
								'user_id' => $user_id,
								'target_univ_id'=> $target_univ_id,
								'post_type'=> $post_type,
								'text_msg'=> $text_msg,
								'sub_text'=> $sub_text,
								'file_id'=> $file_id,
								'privacy'=> $privacy,
								'anon'=> $anon,
								'like_count'=> $like_count,
								'update_timestamp'=> $update_timestamp
						);
						$post_rows += 1;
					}
				}
/*----------------------------Prioritize Posts--------------------------------------------*/
					$pq_posts_array = new SplPriorityQueue();
					$prior_count = $post_rows;
					foreach ($post_array as $row)
					{
						if(isFollowing($_SESSION, $row['user_id']))
						{
							$priority = array(1,$prior_count);
							$pq_posts_array->insert($row, $priority);
						}
						else {
							$priority = array(0,$prior_count);
							$pq_posts_array->insert($row, $priority);
						}
					}
/*---------------------------------------------------------------------------------------*/
/* format output*/		
/* Get the department name */
	$course_depts = array_unique($course_depts);
	$course_depts = implode(",", $course_depts);
	$result = $con->query("Select dept_id, dept_name from department where dept_id in ($course_depts)");
	// 		echo "Select dept_id, dept_name from department where dept_id in $course_depts";
	if($result->num_rows > 0)
	{
		$course_depts = array();
		while($row = $result->fetch_array())
		{
			$course_depts[$row['dept_id']] = $row['dept_name'];
		}
	}
	// 	echo $msg;
/*make a new array with all users*/
	$all_user_array = array();
	if(isset($prof_array))
		$all_user_array = array_merge($all_user_array,$prof_array);
	if(isset($user_array))
    	$all_user_array = array_merge($all_user_array,$user_array);
	if(isset($group_array))
		$all_user_array = array_merge($all_user_array,$group_array);
/*--------------------------------------------------------------------------*/	
	
	$lastslide_pos=0;$photo_index = 0; $photo_position = 0;
	$connected_id = get_connected_users($_SESSION['user_id']);
	if($_POST['search_type'] == "All" && (($course_rows > 0 || $post_rows > 0) 
	&& ($professor_rows>0 || $student_rows>0 || $group_rows>0)))
	{
	echo '<div class = "all_results_active"><div class = "horiz-area">
					<div class = "horiz-wrapper">
			<div class = "horiz-mask">
				<div class = "content-area">
				<div class = "ContentSlider">';
	foreach($all_user_array as $row)
	{
		$photo_position = 250 * $photo_index;
		$lastslide_pos = $photo_position - 250;
		if($row['type'] == 'p')
		{
			$professor_rows += 1;
		}
		elseif($row['type'] == 's')
		{
			$student_rows += 1;
		}
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
	}
	$members_sql = "SELECT u.user_id, u.profile_picture, u.pic_location
					FROM user AS u JOIN courses_user AS cu
					ON (u.user_id = cu.user_id)
					WHERE cu.class_id = ?";
	$memebers_sql_stmt = $con->prepare($members_sql);
	
	/*------------------------PAGINATE---------------------------------------------------*/
	$total = $course_rows + $post_rows + $professor_rows + $student_rows + $group_rows;
	$page = new Paginator(20, $total);
	$page->paginate($_POST['page']);
	$offset = $page->getOffset(); $isPageFull = false;
	$limit = $page->getLimit();
	if($offset < $course_rows)
	{
		$course_array = array_slice($course_array, $page->getOffset(), $limit);
		$offset = $offset +count($course_array);
		$limit -= count($course_array); 
		if($limit == 0)
		{
			$isPageFull = true;
			$post_array = array();
			$all_user_array = array();
		}
	}
	elseif(!$isPageFull && $page->getOffset() < $course_rows + $post_rows)
	{
		$post_array = array_slice($post_array, $offset, $limit);
		$offset = $offset +count($post_array);
		$limit -= count($post_array);
		if($limit == 0)
		{
			$isPageFull = true;
			$all_user_array = array();
		}
	}
	elseif(!$isPageFull && $page->getOffset() < 
			$course_rows + $post_rows + $professor_rows + $student_rows + $group_rows)
	{
		$all_user_array = array_slice($all_rows, $offset, $limit);
		$offset = $offset +count($all_user_array);
		$limit -= count($all_user_array);
		if($limit == 0)
		{
			$isPageFull = true;
			if(count($all_user_array) == $page->getLimit())
			{
				$post_array = array();
				$course_array = array();
			}
			elseif (count($all_user_array) + count($post_array) == $page->getLimit())
			{
				$course_array = array();
			}
		}
	}
/*-----------------------------------------------------------------------------------*/	
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
	foreach($all_user_array as $row)
	{
		echo '<div class = "person vert-results-wrapper">
							<a class = "person-result-image">
								<div style = "background-image: url('.$row['picture'].');" class = "img"></div>
							</a>
							<div class = "person-main">
								<div class = "person-header">
									<div class = "result-header">
										<h2>'.$row['name'].'</h2>
										<span>—</span>
										<p>'.$course_depts[$row['dept_id']].'</p>					
									</div>
									<div class = "result-header-right">
										<div class = "result-functions-wrapper">
											<div class = "prof-btn-small btn-small fav">
											</div>			
											<div class = "prof-tooltip tooltip">
												<div class = "tool-wedge"></div>
												<div class = "prof-tool-box tool-box">
													<span>Add This Professor To My Bookmarks</span>
												</div>
											</div>														
										</div>

									</div>
								</div>
								<div class = "person-result-main">
									<div class = "person-info">
										<div style = "background-image: url('.$row['picture'].');" class = "title-limit">
										</div>
										<h4>'.$row['uname'].'</h4> 
									</div>
									<div class = "person-info">
										<div class = "title-limit mail">
										</div>
										<h4>'.$row['email'].'</h4>										
									</div>';
									if($row['type'] == 'p')
									{
										echo '<div class = "person-info info-location">
											<div class = "title-limit location">
											</div>
											<h4>'.$location.'</h4>				
										</div>';
									}
								echo '</div>
								<div class = "person-bottom-functions">
									<div class = "link-button">
										<a class = "link link-up">
											Follow
										</a>
									</div>
								</div>									
							</div>
						</div>';
	}
	foreach ($pq_posts_array as $row)
	{
		include 'includes/posts.php';
	}
	echo '</div>';
	$maxCredit = 0;
	
	$course_depts = array();
	if(is_array($course_array))
	{
		foreach ($course_array as $row)
		{
			$course_depts[] = $row['dept_id'];
		}
	}

	if(count($course_depts)>0)
	{
		$course_depts = array_unique($course_depts);
		
		$credit_stmt = $con->prepare("SELECT max( `credits` ) FROM ( 
				SELECT max( `course_credits` ) AS `credits` FROM `courses` WHERE `dept_id`
				IN (".implode(",", $course_depts).")) AS ctable");
		
		$credit_stmt->execute();
		$credit_stmt->bind_result($max);
		
		while($credit_stmt->fetch())
		{
			$maxCredit = $max;
		}
	}
	if($maxCredit == 0)
		$maxCredit = 4;
	
	$all_rows = $course_rows + $professor_rows + $student_rows + $group_rows + $post_rows;
	
	echo '<all_rows>'.$all_rows.'</all_rows><course_rows>'.$course_rows.'</course_rows>
		  <group_rows>'.$group_rows.'</group_rows><professor_rows>'.$professor_rows.'</professor_rows>
		  <student_rows>'.$student_rows.'</student_rows><post_rows>'.$post_rows.'</post_rows><credits>'.$maxCredit.'</credits>';
	
   $con->close();
	
function convToSearchString($str){
	return str_replace("\'", "'", $str);
}	