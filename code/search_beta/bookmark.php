<?php
include_once ('includefiles.php');
$_SESSION['user_id'] = 1;
//$_POST['class'] = "92e9ddb3-f589-11e3-b732-00259022578e";
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
	
	$stmt = $dbObj->prepare($check_stmt);
	echo "prepared";
	$stmt->bind_param("is", $user_id, $class_id);
	echo "bound";
	$stmt->execute();
	$stmt->bind_result($count);
	while($stmt->fetch())
		echo $count;
	$stmt->close();
	if($count != 0)
	{
		$ins_stmt = $dbObj->prepare($ins_stmt);
		$ins_stmt->bind_param("si", $class_id, $user_id);
		$ins_stmt->execute();
		$affected_rows = $ins_stmt->affected_rows;
		$ins_stmt->close();
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

function searchForClassId($id, $array) {
	foreach ($array as $key => $val) {
		if ($val['class'] == $id) {
			return $key;
		}
	}
	return null;
}

if (!function_exists('array_column')) {
	function array_column($input = null, $columnKey = null, $indexKey = null)
	{
		$argc = func_num_args();
		$params = func_get_args();
	
		if ($argc < 2) {
			trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
			return null;
		}
	
		if (!is_array($params[0])) {
			trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
			return null;
		}
	
		if (!is_int($params[1])
		&& !is_float($params[1])
		&& !is_string($params[1])
		&& $params[1] !== null
		&& !(is_object($params[1]) && method_exists($params[1], '__toString'))
		) {
			trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
	
		if (isset($params[2])
		&& !is_int($params[2])
		&& !is_float($params[2])
		&& !is_string($params[2])
		&& !(is_object($params[2]) && method_exists($params[2], '__toString'))
		) {
			trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
	
		$paramsInput = $params[0];
		$paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
	
		$paramsIndexKey = null;
		if (isset($params[2])) {
			if (is_float($params[2]) || is_int($params[2])) {
				$paramsIndexKey = (int) $params[2];
			} else {
				$paramsIndexKey = (string) $params[2];
			}
		}
	
		$resultArray = array();
	
		foreach ($paramsInput as $row) {
	
			$key = $value = null;
			$keySet = $valueSet = false;
	
			if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
				$keySet = true;
				$key = (string) $row[$paramsIndexKey];
			}
	
			if ($paramsColumnKey === null) {
				$valueSet = true;
				$value = $row;
			} elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
				$valueSet = true;
				$value = $row[$paramsColumnKey];
			}
	
			if ($valueSet) {
				if ($keySet) {
					$resultArray[$key] = $value;
				} else {
					$resultArray[] = $value;
				}
			}
	
		}
	
		return $resultArray;
	}
	
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
	//echo $choice;
if($choice == 'SELECT')
{
	$result_array = checkConflict($user_id);
	//echo count($result_array);
	$class_ids = array_column($result_array, 'class');
	$class_ids = array_unique($class_ids);
	//echo "<br/> unique";
// 	foreach ($class_ids as $v)
// 		echo  "<br/>".$v;
	foreach($class_ids as $v)
	{
		echo '<div class = "bookmark-piece">
				  <div class = "bookmark-title-clear">
				  <p class = "bookmark-title">';
		//echo $i." ".$v." ".$key."<br/>";
		$key = searchForClassId($v, $result_array);
		echo $result_array[$key]['course'].
		'</p>
				  </div>
				  <div class = "bookmark-timing';
		foreach($result_array as $row)
		{
			if($row['class'] == $v
			&& $row['conflict'] == true)
			{
				echo " busy";
				break;
			}
		}
		echo '"><p>';
		foreach($result_array as $row)
		{
			if($row['class'] == $v)
			{
				if($row['conflict'])
				{
					echo "<span class='conflict'>".$row['day'].$row['start']."</span>";
				}
				else
				{
					echo "<span>".$row['day'].$row['start']."</span>";
				}
			}
		}
		echo '</p></div></div>';
	}
	
}
elseif($choice == 'ADD')
{	
 	if(addBookmark($class_id, $user_id) == 1)
 	{
		$result_array = checkConflict($user_id);
		echo count($result_array);
		$class_ids = array_column($result_array, 'class');
		$class_ids = array_unique($class_ids);
		echo "<br/> unique";
		foreach ($class_ids as $v)
			echo  "<br/>".$v;
		foreach($class_ids as $v)
		{
			echo '<div class = "bookmark-piece">
				  <div class = "bookmark-title-clear">
				  <p class = "bookmark-title">';
			echo $i." ".$v." ".$key."<br/>";
			$key = searchForClassId($v, $result_array);
			echo $result_array[$key]['course'].
				  '</p>
				  </div>
				  <div class = "bookmark-timing';
			foreach($result_array as $row)
			{
				if($row['class'] == $v
				&& $row['conflict'] == true)
				{
					echo " busy";
					break;
				}
			}
				  	echo '"><p>';
		  	foreach($result_array as $row)
		  	{
		  		if($row['class'] == $v)
		  		{
		  			if($row['conflict'])
		  			{
		  				echo "<span class='conflict'>".$row['day'].$row['start']."</span>";
		  			}
		  			else
		  			{
		  				echo "<span>".$row['day'].$row['start']."</span>";
		  			}
		  		}
		  	}	  		  	
				  	echo '</p></div></div>';
		}
 	}
}
elseif($choice == 'REMOVE')
{
	$user_id = $_SESSION['user_id'];
	removeBookmark($class_id, $user_id);
}