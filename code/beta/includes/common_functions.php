<?php
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

if (!function_exists('in_array_r')) {
	function in_array_r($needle, $haystack, $strict = false) {
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
				return true;
			}
		}

		return false;
	}
}
if (!function_exists('refValues')) {
function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}
}

if (!function_exists('get_user_dp')){
function get_user_dp($con, $id)
{
	$user_dp = $con->prepare("SELECT dp_flag, dp_link, dp_blob FROM user
						WHERE user_id = ?");
	$user_dp->bind_param('i',$id);
	if($user_dp->execute()){
		$user_dp->store_result();
		$user_dp->bind_result($dp_flag, $dp_link, $dp_blob);
		$user_dp->fetch();
		$user_dp->close();
	}

	if($dp_flag == 'blob'){
		return $blob = "includes/get_blob.php?img_id=".$dp_blob;
	}
	else if($dp_flag == 'link'){
		return $dp_link;
	}
}
}

if(!function_exists('get_current_semester')){
function get_current_semester($con,$university)
{
	$current_semester = "";
	$result = $con->query("SELECT semester from univ_semester where univ_id = $university and start_date <= (SELECT curdate()) and end_date >= (SELECT curdate()) ");
	if($result->num_rows > 0)
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$current_semester = $row['semester'];
		}
	else 
	{
		if($result = $con->query("SELECT semester from univ_semester where univ_id = $university and start_date >= (SELECT curdate()) order by start_date"))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$current_semester = $row['semester'];
				
			}
		}
	}
	return $current_semester;
}
}

if(!function_exists('mailto')){
function mailto($to,$subject,$message,$from)
{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Noreply <'.$from.'>' . "\r\n";
		mail($to, $subject, $message, $headers);
		
}
}
if(!function_exists('formatSingularPlural')){
function formatSingularPlural($count,$string)
{
	if($string == " person")
	{
		return $count>1?" people": ($count == 0)? " ":" person";
	}
	else if($string == "is")
	{
		return $count<=1?$string:" are";
	}
	else if($string == "has")
	{
		return $count<=1?$string:" have";
	}
	else
	{
		return $count>1?$string."s":$string;
	}
}
}
if(!function_exists('groupify')){
function groupify($row, $count = 1)
{
	$result = "";
	if(is_array($row) && count($row)>$count)
	{
		$i = 0;
		foreach($row as $k=>$v)
		{
			if($i<$count)
				$result.="<span class = 'keyword' data-id='".$k."'>".$v."</span>, ";
			$i++;
		}
		$result= substr($result, 0,strlen($result)-2)." and <span class='keyword'>".(count($row)-$count)."</span>".formatSingularPlural(count($result)," other");
// 		$result .= substr($result, 0,strlen($result)-2)." and <div class='mf_liked' id='".tar_tag($con,$qlist['tag_type'],$qlist['tag_id'])."'><span class='keyword'>".(count($row)-$count)."</span>".
// 		"<div class='noti_hid'><span class='keyword'>".implode("</span><br/><span class='keyword'>", array_slice($row, $count)).
// 		"</span></div></div> ".formatSingularPlural(count($result), "other");
	}
	else
	{
		$result = implode(", ", $row);
		$pos = strripos(", ", $result);
		if($pos > 0)
		{
			$result = "<span class='keyword'>".substr($result, 0, $pos)."</span> and <span class='keyword'>".substr($result, $pos+2)."</span>";
		}
		else
		{
			$result = "<span class='keyword'>".$result."</span>";
		}
	}
	return $result;
}
}
if(!function_exists('sanitize')){
function sanitize($value,$con){
       $value=htmlspecialchars($value);
       //$value=strip_tags($value);
       $value=mysqli_real_escape_string($con,$value);
       return $value;
}
}
if(!function_exists('get_alias_univ')){
function get_alias_univ($con,$university){
   		$alias="";
   		$result = $con->query("SELECT alias FROM university WHERE univ_id=$university");
   		while($row=$result->fetch_array(MYSQLI_ASSOC)){
       		$alias=$row['alias'];
		}
        return $alias;

}

}
if(!function_exists('get_name_univ')){
function get_name_univ($con,$university){
   		$univ_name="";
   		$result = $con->query("SELECT univ_name FROM university WHERE univ_id=$university");
   		while($row=$result->fetch_array(MYSQLI_ASSOC)){
       		$univ_name=$row['univ_name'];
		}
        return $univ_name;

}

}
if(!function_exists('get_alias_parent_univ')){
function get_alias_parent_univ($con,$university){
      $alias_parent="";
      $result = $con->query("SELECT parent_univ_id FROM university WHERE univ_id=$university");
   		while($row=$result->fetch_array(MYSQLI_ASSOC)){
       		$parent_univ_id=$row['parent_univ_id'];
		}
		 $result = $con->query("SELECT alias FROM parent_university 
		 	                     WHERE parent_univ_id=$parent_univ_id");
   		while($row=$result->fetch_array(MYSQLI_ASSOC)){
       		$alias_parent=$row['alias'];
		}
        return $alias_parent;


}
}
if(!function_exists('get_univ_weblink')){
function get_univ_weblink($con,$university){
		 $weblink="";
         $result = $con->query("SELECT weblink FROM university WHERE univ_id=$university");
   		while($row=$result->fetch_array(MYSQLI_ASSOC)){
       		$weblink=$row['weblink'];
		}
		return $weblink;

}

}
if(!function_exists('get_univ_add')){
function get_univ_add($con,$university){
		 $univ_location="";
         $result = $con->query("SELECT univ_location FROM university WHERE univ_id=$university");
   		while($row=$result->fetch_array(MYSQLI_ASSOC)){
       		$univ_location=$row['univ_location'];
		}
		return $univ_location;

}

}
if(!function_exists('get_department_count')){
function get_department_count($con,$university){
		 $department_count="";
         $result = $con->query("SELECT count(*) as department_count  FROM department WHERE univ_id=$university");
   		while($row=$result->fetch_array(MYSQLI_ASSOC)){
       		$department_count=$row['department_count'];
		}
		return $department_count;

}

}
if(!function_exists('get_member_count')){
function get_member_count($con,$university){
		 $member_count="";
         $result = $con->query("SELECT count(*) as member_count  FROM user WHERE univ_id=$university");
   		while($row=$result->fetch_array(MYSQLI_ASSOC)){
       		$member_count=$row['member_count'];
		}
		return $member_count;

}

}