<?php
include_once ('includefiles.php');
$_SESSION['user_id'] = 1;
// $_POST['class'] = "92da67e6-f589-11e3-b732-00259022578e";
function addBookmark($class_id,$user_id)
{
	global  $dbObj;
	$affected_rows = 0;
	$check_stmt = "SELECT count(*) from
			user AS u JOIN courses_semester AS cs
			ON u.dept_id = cs.dept_id
			WHERE u.user_id = ?
			AND cs.class_id = ?";
	$ins_stmt = "Insert into course_bookmarks(class_id, user_id) VALUES (?,?)";
	
	$count = 0;
	if($stmt = $dbObj->prepare($check_stmt))
	{
// 		echo "prepared";
		$stmt->bind_param("is", $user_id, $class_id);
// 		echo "bound";
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
	}
	if($count != 0)
	{
		$ins_stmt = $dbObj->prepare($ins_stmt);
		$ins_stmt->bind_param("si", $class_id, $user_id);
		$ins_stmt->execute();
		$affected_rows = $ins_stmt->affected_rows;
		$ins_stmt->close();
	}
	else
	{
		exit("Cannot add this course to bookmarks");
	}
	return $affected_rows;
}

function removeBookmark($class_id, $user_id)
{
	global  $dbObj;
	$affected_rows = 0;
	
	$del_stmt = $dbObj->prepare("DELETE FROM course_bookmarks WHERE class_id = ? and user_id = ?");
	$del_stmt->bind_param("si", $class_id, $user_id);
	$del_stmt->execute();
	$affected_rows = $del_stmt->affected_rows;
	$del_stmt->close();
	return  $affected_rows;
}

function checkConflict($user_id)
{
	global  $dbObj;
	$schedule_array = array();
	
	$sel_stmt = $dbObj->prepare("Select c.course_name,
										cb.class_id, 
										css.schedule_id,
										s.day,
										s.start_time,
										s.end_time 
				from courses c join courses_semester cs
				join courses_semester_schedule css join course_bookmarks cb
			    join schedule s
				on (cb.class_id = css.class_id
				and css.class_id = cs.class_id
				and c.course_id = cs.course_id
				and c.dept_id = cs.dept_id
				and c.univ_id = cs.univ_id
				and s.schedule_id = css.schedule_id)
				where cb.user_id = ?");
	$sel_stmt->bind_param("i", $user_id);
	$sel_stmt->execute();
	$sel_stmt->bind_result($course_name, $class_id, $schedule_id, $day, $start_time, $end_time);
	while($sel_stmt->fetch())
	{
		$schedule_array[] = array(
								  'schedule'=>$schedule_id,
								  'course' => $course_name,
								  'class' => $class_id,
								  'day' => $day,
								  'start' => $start_time,
								  'end' => $end_time,
								  'conflict' => false);
	}
	for($i=0; $i < count($schedule_array)-1; $i++)
	{
		if($schedule_array[$i]['schedule'] == 1)
			continue;
			
			for($j=$i+1; $j < count($schedule_array); $j++)
			{
				if(($schedule_array[$j]['schedule'] == $schedule_array[$i]['schedule'])
				||(($schedule_array[$j]['day'] == $schedule_array[$i]['day'])
				&&((($schedule_array[$j]['start'] > $schedule_array[$i]['start']) 
				 &&($schedule_array[$j]['start'] < $schedule_array[$i]['end']))
				||(($schedule_array[$j]['end'] > $schedule_array[$i]['start']) 
				 &&($schedule_array[$j]['end'] < $schedule_array[$i]['end']))		
				  )))
				{
					$schedule_array[$i]['conflict'] = true;
					$schedule_array[$j]['conflict'] = true;
				}
			}
	}
	return $schedule_array;
}
function selectBookmarks($user_id)
{
	$result_array = checkConflict($user_id);
	$class_ids = array_column($result_array, 'class');
	$class_ids = array_unique($class_ids);
	//echo "<br/> unique";
	// 	foreach ($class_ids as $v)
		// 		echo  "<br/>".$v;
	foreach($class_ids as $v)
	{
		echo '<div class = "bookmark-piece">
				  <div class = "bookmark-title-clear';
	
		foreach($result_array as $row)
		{
			if($row['class'] == $v
			&& $row['conflict'] == true)
			{
				echo " busy";
				break;
			}
		}
		echo '"><p class = "bookmark-title">';
		//echo $i." ".$v." ".$key."<br/>";
		$key = searchForClassId($v, $result_array);
		echo $result_array[$key]['course'].
		'</p>
				  </div>
				  <div class = "bookmark-timing"><p>';
		foreach($result_array as $row)
		{
			if($row['class'] == $v)
			{
				$stime = new DateTime($row['start'], new DateTimeZone("America/New_York"));
				if($row['conflict'])
				{
					echo "<span class='busy'>".$row['day'].$stime->format('H:i')."</span><br/>";
				}
				else
				{
					echo "<span>".$row['day'].$stime->format('H:i')."</span><br/>";
				}
			}
		}
		echo '</p></div></div>';
	}
}
function searchForClassId($id, $array) {
	foreach ($array as $key => $val) {
		if ($val['class'] == $id) {
			return $key;
		}
	}
	return null;
}
	$choice = '';
	$user_id = $_SESSION['user_id'];
	if(isset($_POST['class']))
	{
		$class_id = $_POST['class'];
		$chk_query = "SELECT count( * ) FROM `course_bookmarks` WHERE class_id = ? AND user_id =?";
		$chk_stmt = $dbObj->prepare($chk_query);
		$chk_stmt->bind_param("si", $class_id, $user_id);
		$chk_stmt->execute();
		$chk_stmt->bind_result($count);
		$chk_stmt->fetch();
		$chk_stmt->close();
		if($count == 1)
		{
			$choice = 'REMOVE';
		}
		else
		{
			$choice = 'ADD';
		}
	}
	else
	{
		$choice = 'SELECT';
	}
// 	echo $choice;
if($choice == 'SELECT')
{
	selectBookmarks($user_id);
}
elseif($choice == 'ADD')
{	
 	if(addBookmark($class_id, $user_id) == 1)
 	{
 		selectBookmarks($user_id);
 	}
}
elseif($choice == 'REMOVE')
{
	$user_id = $_SESSION['user_id'];
	removeBookmark($class_id, $user_id);
	selectBookmarks($user_id);
}
$dbObj->close();