<?php 
function getInclucdePageFront()
{
	ini_set("session.bug_compat_42",1);
	ini_set("session.bug_compat_warn",0);
	
	global $PAGEWITHOUTLOGIN;
	if(USEBASE64ENCDEC == 1)
	{
		$qrystrdecode = base64_decode($_SERVER['QUERY_STRING']);
	}
	else
	{
		$tmpqrystr = base64_decode($_SERVER['QUERY_STRING']);
		if(strstr($tmpqrystr,"encode"))
		{
			$qrystrdecode = $tmpqrystr;
		}
		else
		{
			$qrystrdecode = $_SERVER['QUERY_STRING'];
		}
	}
	
	$qrystrArr = array();
	
	if(trim($qrystrdecode) != "")
	{
		$qrystrArr = explode("&",$qrystrdecode);
	}
	//print_r($qrystrArr);die;
	foreach($qrystrArr as $key=>$val)
	{
		$tmpArr = array();
		$tmpArr = explode("=",$val);
		
		if(count($tmpArr) == 2)
		{
			global $$tmpArr["0"];
			if(USEBASE64ENCDEC == 1)
			$_REQUEST[$tmpArr["0"]]=$tmpArr["1"];
			$$tmpArr["0"] = $tmpArr["1"];
		}
	}

	if(isset($pg))
	{
		$includepage = $pg;
		
	}
	else
	{
		$includepage = "home";
	}
	
	return $includepage;
}
function displayErrorMessage()
{

	global $errormsg;
	
	$messagetext = '';
	if(strlen($errormsg) > 0)
	{
		$messagetext .= $errormsg;
	}
	
	return $messagetext;
}


function displaySuccessMessage()
{

	global $successmsg;
	
	$messagetext = '';
	if(strlen($successmsg) > 0)
	{
		$messagetext .= $successmsg;
	}
	
	return $messagetext;
}
function getbase64encode($str)
{
	if(USEBASE64ENCDEC == 1)
	{
		return base64_encode($str);
	}
	else
	{
		return $str;
	}
}

function getbase64decode($str)
{
	if(USEBASE64ENCDEC == 1)
	{
		return base64_decode($str);
	}
	else
	{
		return $str;
	}
}
function getErrorMessage()
{
	$errormsg = "";
	if(isset($_SESSION["errormsg"]) && !empty($_SESSION["errormsg"]))
	{
		$errormsg = $_SESSION["errormsg"];
		unset($_SESSION["errormsg"]);
	}
	
	return $errormsg;
}

function getSuccessMessage()
{
	$successmsg = "";
	if(isset($_SESSION["successmsg"]) && !empty($_SESSION["successmsg"]))
	{
		$successmsg = $_SESSION["successmsg"];
		unset($_SESSION["successmsg"]);
	}
	
	return $successmsg;
}
function validateuploadfile($field)
{
	$is_success = 1;
	if(count($_FILES) == 0)
	{
		$is_success = 0;
		$_SESSION["errormsg"] = "Form does not support HTTP file upload";
	}
	
	if($is_success == 1)
	{
		if($_FILES[$field]["error"] == 4)
		{
			$is_success = 0;
			$_SESSION["errormsg"] = "Please provide file to upload";
		}
	}
	
	if($is_success == 1)
	{
		if($_FILES[$field]["error"] != 0)
		{
			$is_success = 0;
			$_SESSION["errormsg"] = "There was en error while uploading file on server";
		}
	}
	
	return $is_success;
}
function isuploadfile($field)
{
	global $FILEMIMETYPE,$FILEEXTENSION;
	
	$is_success = 1;
	if($is_success == 1)
	{
		$ext = get_file_extension($_FILES[$field]['name']);
		if(!in_array($ext,$FILEEXTENSION))
		{
			$is_success = 0;
			
			if(count($FILEEXTENSION) > 1)
			{
				$_SESSION["errormsg"] = MSG_INVALIDFILE;
			}
			else
			{
				$_SESSION["errormsg"] = MSG_INVALIDFILE;
			}
		}
	}
	
	return $is_success;
}

function get_file_extension($file_name)
{
	return strtolower(substr(strrchr($file_name,'.'),1));
}
function redirect($url)
{
	header("location:".$url);
	exit;
}

function moveuploadedfile($field,$uploadpath,$pref='',$staticname='no')
{
	chdir($uploadpath);
	
	$signs = array("'", "(", ")", "$", "#", "!", "?", "%" ," ");
	if($staticname=='no')
	{
		if(trim($pref)<>'')
		{
			$retfilename = $pref.time().str_replace($signs,'_',$_FILES[$field]['name']);
		}
		else
		{
			$retfilename = time().str_replace($signs,'_',$_FILES[$field]['name']);
		}
	}
	elseif($staticname=='yes')
	{
		$retfilename = str_replace($signs,'_',$_FILES[$field]['name']);
	}
	//$retfilename = time().str_replace($signs,'_',$_FILES[$field]['name']);
	if(move_uploaded_file($_FILES[$field]['tmp_name'],$retfilename))
	{
		return $retfilename;
	}
	else
	{
		$_SESSION["errormsg"] = "Uploaded folder does not have write permission";
		return 0;
	}
}
function getprofessordetail($profid,$fieldname='')
{
	global $dbObj;
	$facultyListQry = "select * from professor_1 where profid='".$profid."' order by name asc ";
	$facultyListRes = $dbObj->fireQuery($facultyListQry,'select');
	if(isset($facultyListRes) && $facultyListRes!=false && count($facultyListRes)>0)
	{
		if($fieldname!='')
		{
			return $facultyListRes[0][$fieldname];
		}
		else
		{
			return $facultyListRes[0];
		}
	}
}
function getstudentdetail($studentid,$fieldname='')
{
	global $dbObj;
	$studentListQry = "select * from student_1 where studentid ='".$studentid."' order by name asc ";
	$studentListRes = $dbObj->fireQuery($studentListQry,'select');
	if(isset($studentListRes) && $studentListRes!=false && count($studentListRes)>0)
	{
		if($fieldname!='')
		{
			return $studentListRes[0][$fieldname];
		}
		else
		{
			return $studentListRes[0];
		}
	}
}
function getcoursedetail($courseid,$fieldname='')
{
	global $dbObj;
	$courseListQry = "select * from course_1 where cid ='".$courseid."' order by name asc ";
	$courseListRes = $dbObj->fireQuery($courseListQry,'select');
	if(isset($courseListRes) && $courseListRes!=false && count($courseListRes)>0)
	{
		if($fieldname!='')
		{
			return $courseListRes[0][$fieldname];
		}
		else
		{
			return $courseListRes[0];
		}
		
	}
}
function getclubdetail($groupid,$fieldname='')
{
	global $dbObj;
	$clubListQry = "select * from groups_1 where groupid ='".$groupid."' order by groupname asc ";
	$clubListRes = $dbObj->fireQuery($clubListQry,'select');
	if(isset($clubListRes) && $clubListRes!=false && count($clubListRes)>0)
	{
		if($fieldname!='')
		{
			return $clubListRes[0][$fieldname];
		}
		else
		{
			return $clubListRes[0];
		}
		
	}
}
function getdepartmentdetail($deptid,$fieldname='')
{
	global $dbObj;
	$departmentListQry = "select * from department_1 where deptid ='".$deptid."' order by deptname asc ";
	$departmentListRes = $dbObj->fireQuery($departmentListQry,'select');
	if(isset($departmentListRes) && $departmentListRes!=false && count($departmentListRes)>0)
	{
		if($fieldname!='')
		{
			return $departmentListRes[0][$fieldname];
		}
		else
		{
			return $departmentListRes[0];
		}
		
	}
}
function gettotalclubmembercount($groupid)
{
	global $dbObj;
	$totalmember=0;
	$clubjoin_sql="SELECT count(*) as total FROM `groups_student_1` WHERE groupid='".$groupid."';";
	$clubjoinRes = $dbObj->fireQuery($clubjoin_sql,'select');
	if(isset($clubjoinRes) && count($clubjoinRes)>0 && $clubjoinRes!=false)
	{
		$totalmember+=$clubjoinRes[0]['total'];
	}
	
	$clubjoin_sql="SELECT count(*) as total FROM `groups_professor_1` WHERE groupid='".$groupid."';";
	$clubjoinRes = $dbObj->fireQuery($clubjoin_sql,'select');
	if(isset($clubjoinRes) && count($clubjoinRes)>0 && $clubjoinRes!=false)
	{
		$totalmember+=$clubjoinRes[0]['total'];
	}
	return $totalmember;
}

function gettotalcoursemembercount($courseid)
{
	global $dbObj;
	$totalmember=0;
	$coursejoin_sql="SELECT count(*) as total FROM `student_courses_1` WHERE course_id='".$courseid."';";
	$coursejoinRes = $dbObj->fireQuery($coursejoin_sql,'select');
	if(isset($coursejoinRes) && count($coursejoinRes)>0 && $coursejoinRes!=false)
	{
		$totalmember+=$coursejoinRes[0]['total'];
	}
	return $totalmember;
}

function isstudentlinqed($stud_id,$linqed_id)
{
	global $dbObj;
	$studjoin_sql="SELECT count(*) as total FROM `student_student_1` WHERE from_studid='".$stud_id."' and to_studid='".$linqed_id."';";
	$studjoinRes = $dbObj->fireQuery($studjoin_sql,'select');
	if(isset($studjoinRes) && count($studjoinRes)>0 && $studjoinRes!=false)
	{
		return $studjoinRes[0]['total'];
	}
	else
	{
		return 0;
	}
}
function isprofessorlinqed($stud_id,$linqed_id)
{
	global $dbObj;
	$profjoin_sql="SELECT count(*) as total FROM `student_professor_1` WHERE from_studid='".$stud_id."' and to_profid='".$linqed_id."';";
	$profjoinRes = $dbObj->fireQuery($profjoin_sql,'select');
	if(isset($profjoinRes) && count($profjoinRes)>0 && $profjoinRes!=false)
	{
		return $profjoinRes[0]['total'];
	}
	else
	{
		return 0;
	}
}
function professorlinqedstudent($prof_id,$linqed_id)
{
	global $dbObj;
	$profjoin_sql="SELECT count(*) as total FROM `professor_student_1` WHERE from_profid='".$prof_id."' and to_studid='".$linqed_id."';";
	$profjoinRes = $dbObj->fireQuery($profjoin_sql,'select');
	if(isset($profjoinRes) && count($profjoinRes)>0 && $profjoinRes!=false)
	{
		return $profjoinRes[0]['total'];
	}
	else
	{
		return 0;
	}
}
function professorlinqedprofessor($prof_id,$linqed_id)
{
	global $dbObj;
	$profjoin_sql="SELECT count(*) as total FROM `professor_professor_1` WHERE from_profid='".$prof_id."' and to_profid='".$linqed_id."';";
	$profjoinRes = $dbObj->fireQuery($profjoin_sql,'select');
	if(isset($profjoinRes) && count($profjoinRes)>0 && $profjoinRes!=false)
	{
		return $profjoinRes[0]['total'];
	}
	else
	{
		return 0;
	}
}

function enrolledincourse($stud_id,$course_id,$universityid)
{
	global $dbObj;
	$coursejoin_sql="SELECT count(*) as total FROM `student_courses_1` WHERE student_id='".$stud_id."' and course_id='".$course_id."' and universityid='".$universityid."';";
	$coursejoinRes = $dbObj->fireQuery($coursejoin_sql,'select');
	if(isset($coursejoinRes) && count($coursejoinRes)>0 && $coursejoinRes!=false)
	{
		return $coursejoinRes[0]['total'];
	}
	else
	{
		return 0;
	}
}
function clubjoined($club_id)
{
	global $dbObj;
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		$student_id=$_SESSION['student_id'];
		$clubjoin_sql="SELECT count(*) as total FROM `groups_student_1` WHERE studid='".$student_id."' and groupid='".$club_id."';";
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$professor_id=$_SESSION['professor_id'];
		$clubjoin_sql="SELECT count(*) as total FROM `groups_professor_1` WHERE profid='".$professor_id."' and groupid='".$club_id."';";
	}	
	$clubjoinRes = $dbObj->fireQuery($clubjoin_sql,'select');
	if(isset($clubjoinRes) && count($clubjoinRes)>0 && $clubjoinRes!=false)
	{
		return $clubjoinRes[0]['total'];
	}
	else
	{
		return 0;
	}
}
function getcountorresultset($table,$fields="*",$is_count="0",$orderby="",$ordertype="",$wherefieldarray="",$wherefieldvalarray="",$operatorarray="=",$andorarray="AND",$start="",$end="",$groupbyfields="")
{	
	global $dbObj;
	$totalrecord = 0;
	$where = "";
	$order = "";
	
	$singularoparray = array("=","!=",">",">=","<","<=");
	
	if($orderby != "")
	{
	
	   $order .= " ORDER BY ".$orderby." ".$ordertype; 
	}
	
	if(is_array($wherefieldarray) && count($wherefieldarray) > 0)
	{
		for($i=0;$i<count($wherefieldarray);$i++)
		{
			if(is_array($operatorarray[$i]))
			{
				$subwhere = " AND (";
				for($j=0;$j<count($operatorarray[$i]);$j++)
				{
					$andor = "";
					if(isset($andorarray[$i][$j]))
					{
						$andor = $andorarray[$i][$j];
					}
					
					if(count($operatorarray[$i])-1 == $j)
					{
						$andor = "";
					}
					
					if(in_array($operatorarray[$i][$j],$singularoparray))
					{
						$subwhere .= "".$wherefieldarray[$i][$j]." ".$operatorarray[$i][$j]." '".$wherefieldvalarray[$i][$j]."' ".$andor." ";
					}
					else if($operatorarray[$i][$j] == "IN" || $operatorarray[$i][$j] == "NOT IN")
					{
						$subwhere .= "".$wherefieldarray[$i][$j]." ".$operatorarray[$i][$j]." ('".@implode("','",$wherefieldvalarray[$i][$j])."') ".$andor." ";
					}
					else if($operatorarray[$i][$j] == "LIKE" || $operatorarray[$i][$j] == "NOT LIKE")
					{
						$subwhere .= "".$wherefieldarray[$i][$j]." ".$operatorarray[$i][$j]." '%".$wherefieldvalarray[$i][$j]."%' ".$andor." ";
					}
				}
				$subwhere .= ")";
				$where .= $subwhere;
			}
			else
			{
				$andor = "";
				if(isset($andorarray[$i]))
				{
					$andor = $andorarray[$i];
				}
				
				if(in_array($operatorarray[$i],$singularoparray))
				{
					$where .= " ".$andor." ".$wherefieldarray[$i]." ".$operatorarray[$i]." '".$wherefieldvalarray[$i]."'";
				}
				else if($operatorarray[$i] == "IN" || $operatorarray[$i] == "NOT IN")
				{
					$where .= " ".$andor." ".$wherefieldarray[$i]." ".$operatorarray[$i]." ('".@implode("','",$wherefieldvalarray[$i])."')";
				}
				else if($operatorarray[$i] == "LIKE" || $operatorarray[$i] == "NOT LIKE")
				{	
					$where .= " ".$andor." ".$wherefieldarray[$i]." ".$operatorarray[$i]." '%".$wherefieldvalarray[$i]."%'";
				}
			}
		}
	}
	else
	{
		if($wherefieldarray != "" && $operatorarray != "" && $wherefieldvalarray != "")
		{
			if(in_array($operatorarray,$singularoparray))
			{
				$where .= " ".$andorarray." ".$wherefieldarray." ".$operatorarray." '".$wherefieldvalarray."'";
			}
			else if($operatorarray == "IN" || $operatorarray == "NOT IN")
			{
				$where .= " ".$andorarray." ".$wherefieldarray." ".$operatorarray." ('".@implode("','",$wherefieldvalarray)."')";
			}
			else if($operatorarray == "LIKE" || $operatorarray == "NOT LIKE")
			{	
				$where .= " ".$andorarray." ".$wherefieldarray." ".$operatorarray." '%".$wherefieldvalarray."%'";
			}
		}
	}
	
	if($is_count == 1)
	{
		$selectfields = "COUNT(".$fields.") AS total";
	}
	
	if($is_count == 0)
	{
		$selectfields = $fields;
	}
	
	$limit = "";
	if($end > 0 && $start >= 0)
	{
		$limit = " LIMIT ".$start.",".$end;
	}
	
	$groupby = "";
	if($groupbyfields != "")
	{
		$groupby = " GROUP BY ".$groupbyfields;
	}
	
	$sel = "SELECT ".$selectfields." FROM ".$table." WHERE 1=1 ".$where.$groupby.$order.$limit;
	//print $sel.'<br>';
	$res = $dbObj->fireQuery($sel);
	if($is_count == 1)
	{
		return $res["0"]["total"];
	}
	if($is_count == 0)
	{
		return $res;
	}
	
}

function updatetabledata($table,$updatefields,$updatefieldsval,$wherefield,$wherefieldval)
{
	global $dbObj;
	
	$is_success = 1;
	$updatesets = "";
	if(is_array($updatefields))	
	{
		$length = count($updatefields);
		for($i=0;$i<$length;$i++)
		{
			$and = " ,";
			if($i == $length-1)
			{
				$and = " ";
			}
			
			if(is_array($updatefieldsval[$i]))
			{
				$tmparray = array();
				for($j=0;$j<count($updatefieldsval[$i]);$j++)
				{
					$tmparray[] = addslashes(trim($updatefieldsval[$i][$j]));
				}
				
				$updatefieldsval[$i] = array();
				$updatefieldsval[$i] = $tmparray;
				
				$updatesets .= "".$updatefields[$i]." = '".implode(",",$updatefieldsval[$i])."' ".$and;
			}
			else
			{
				$updatesets .= "".$updatefields[$i]." = '".addslashes(trim($updatefieldsval[$i]))."'".$and;
			}
		}
	}
	else
	{
		$updatesets .= "".$updatefields." = '".addslashes(trim($updatefieldsval))."'";
	}
	
	$upd = "UPDATE ".$table." SET ".$updatesets." WHERE ".$wherefield." IN (".$wherefieldval.")";
	//print $upd; exit;
	$res = $dbObj->fireQuery($upd,"update");
	if($res === false)
	{
		$is_success = 0;
	}
	
	return $is_success;
}

function inserttabledata($table,$insertfields,$insertfieldsval)
{
	global $dbObj;
	
	$is_success = 1;
	$insertfieldset = "";
	$insertvalueset = "";
	
		
	if(is_array($insertfields))	
	{
		for($i=0;$i<count($insertfields);$i++)
		{
			if($insertfieldset != "")
			{
				$insertfieldset .= ",";
			}
			$insertfieldset .= "".$insertfields[$i]."";
			
			if($insertvalueset != "")
			{
				$insertvalueset .= ",";
			}
			
			if($insertfields[$i] == "createdon" || $insertfields[$i] == "posteddate")
			{
				$insertvalueset .= $insertfieldsval[$i];
			}
			else
			{
				$insertvalueset .= "'".addslashes(trim($insertfieldsval[$i]))."'";
			}
			
		}
		/*$tmpinsertfieldsval = array();
		for($i=0;$i<count($insertfieldsval);$i++)
		{
			$tmpinsertfieldsval[] = addslashes($insertfieldsval[$i]);
		}
		
		$insertfieldsval = array();
		$insertfieldsval = $tmpinsertfieldsval;
		
		$insertfieldset .= @implode(",",$insertfields);
		$insertvalueset .= @implode("','",$insertfieldsval);*/
	}
	else
	{
		$insertfieldset .= "".$insertfields."";
		$insertvalueset .= "'".addslashes(trim($insertfieldsval))."'";
	}
	
	$ins = "INSERT INTO ".$table." (".$insertfieldset.") VALUES(".$insertvalueset.")";

	$res = $dbObj->fireQuery($ins,"insert");

	return $res;
	
}

function deletetabledata($table,$wherefield=array(),$wherefieldval=array(),$operatorarray=array())
{
	global $dbObj;
	$is_success = 1;
	$where = "";
	
	if(is_array($wherefield))
	{
		$length = count($wherefield);
		for($i=0;$i<$length;$i++)
		{
			$and = " AND ";
			if($i == $length-1)
			{
				$and = " ";
			}
			
			if(is_array($wherefieldval[$i]))
			{
				$where .= $wherefield[$i]." ".$operatorarray[$i]." ('".implode("','",$wherefieldval[$i])."')".$and;
			}
			else
			{
				$where .= $wherefield[$i]." ".$operatorarray[$i]." '".$wherefieldval[$i]."'".$and;
			}
		}
	}
	else
	{
		$operator = "IN";
		if(is_array($operatorarray) && count($operatorarray) > 0)
		{
			$operator = $operatorarray["0"];
		}
		$where .= $wherefield." ".$operator." (".$wherefieldval.")";
	}
	
	echo $del = "DELETE FROM ".$table." WHERE ".$where;
	$res = $dbObj->fireQuery($del,"delete");
	
	return $res;
}

function removePaginationvarfromqrystr()
{
	$ret_qrystr = "";
	if(USEBASE64ENCDEC == 1)
	{
		$qrystr = base64_decode($_SERVER['QUERY_STRING']);
	}
	else
	{
		$qrystr = $_SERVER['QUERY_STRING'];
	}
	$qryarr = explode("&",$qrystr);
	
	$ESCAPEPAGINATIONVARARR = array("page");
	
	$newqryarr = array();
	foreach($qryarr as $key=>$val)
	{
		$tmparr = @explode("=",$val);
		if(!in_array($tmparr[0],$ESCAPEPAGINATIONVARARR))
		{
			$newqryarr[] = $val;
		}
	}
	
	if(count($newqryarr) > 0)
	{
		$ret_qrystr = implode("&",$newqryarr);
	}
	
	return $ret_qrystr;
}

function getPaginationString($recordperpage,$adjacentspages)
{
	global $page,$rstotal;

	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = 0;
	if($recordperpage != 0 && $recordperpage != "")
	{
		$lastpage = ceil($rstotal/$recordperpage);	//lastpage is = total pages / items per page, rounded up.
	}
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	
	$pagination = "";
	$pagqrystr = "";
	$rpagestr = removePaginationvarfromqrystr();
	
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
		{
			$pagqrystr = getbase64encode($rpagestr."&page=$prev");
			$pagination.= "<a href=\"index.php?$pagqrystr\">&laquo; previous</a>";
		}
		else
		{
			$pagination.= "<span class=\"disabled\">&laquo; previous</span>";	
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacentspages * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
				{
					$pagination.= "<span class=\"current\">$counter</span>";
				}
				else
				{
					$pagqrystr = getbase64encode($rpagestr."&page=$counter");
					$pagination.= "<a href=\"index.php?$pagqrystr\">$counter</a>";					
				}
			}
		}
		elseif($lastpage > 5 + ($adjacentspages * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacentspages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacentspages * 2); $counter++)
				{
					if ($counter == $page)
					{
						$pagination.= "<span class=\"current\">$counter</span>";
					}
					else
					{
						$pagqrystr = getbase64encode($rpagestr."&page=$counter");
						$pagination.= "<a href=\"index.php?$pagqrystr\">$counter</a>";					
					}
				}
				
				$pagination.= "...";
				
				$pagqrystr = getbase64encode($rpagestr."&page=$lpm1");
				$pagination.= "<a href=\"index.php?$pagqrystr\">$lpm1</a>";
				
				$pagqrystr = getbase64encode($rpagestr."&page=$lastpage");
				$pagination.= "<a href=\"index.php?$pagqrystr\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacentspages * 2) > $page && $page > ($adjacentspages * 2))
			{
				$pagqrystr = getbase64encode($rpagestr."&page=1");
				$pagination.= "<a href=\"index.php?$pagqrystr\">1</a>";
				
				$pagqrystr = getbase64encode($rpagestr."&page=2");
				$pagination.= "<a href=\"index.php?$pagqrystr\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacentspages; $counter <= $page + $adjacentspages; $counter++)
				{
					if ($counter == $page)
					{
						$pagination.= "<span class=\"current\">$counter</span>";
					}
					else
					{
						$pagqrystr = getbase64encode($rpagestr."&page=$counter");
						$pagination.= "<a href=\"index.php?$pagqrystr\">$counter</a>";					
					}
				}
				$pagination.= "...";

				$pagqrystr = getbase64encode($rpagestr."&page=$lpm1");
				$pagination.= "<a href=\"index.php?$pagqrystr\">$lpm1</a>";
				
				$pagqrystr = getbase64encode($rpagestr."&page=$lastpage");
				$pagination.= "<a href=\"index.php?$pagqrystr\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagqrystr = getbase64encode($rpagestr."&page=1");
				$pagination.= "<a href=\"index.php?$pagqrystr\">1</a>";
				
				$pagqrystr = getbase64encode($rpagestr."&page=2");
				$pagination.= "<a href=\"index.php?$pagqrystr\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacentspages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
					{
						$pagination.= "<span class=\"current\">$counter</span>";
					}
					else
					{
						$pagqrystr = getbase64encode($rpagestr."&page=$counter");
						$pagination.= "<a href=\"index.php?$pagqrystr\">$counter</a>";					
					}
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
		{
			$pagqrystr = getbase64encode($rpagestr."&page=$next");
			$pagination.= "<a href=\"index.php?$pagqrystr\">next &raquo;</a>";
		}
		else
		{
			$pagination.= "<span class=\"disabled\">next &raquo;</span>";
		}
		$pagination.= "</div>\n";		
	}
	
	return $pagination;
}

function getSelected($value1,$value2)
{
	$selected = "";
	if($value1 == $value2)
	{
		$selected = "SELECTED";
	}
	
	return $selected;
}

function getChecked($value1,$value2)
{
	$checked = "";
	if($value1 == $value2)
	{
		$checked = "CHECKED";
	}
	
	return $checked;
}

function getMultiChecked($array,$selectval)
{
	$checked = "";
	if(in_array($selectval,$array))
	{
		$checked = "CHECKED";
	}
	
	return $checked;
}

function getMultiSelected($array,$selectval)
{
	$selected = "";
	if(in_array($selectval,$array))
	{
		$selected = "SELECTED";
	}
	
	return $selected;
}

function validateEmail($field)
{
	$is_success = 1;
	$email = $_POST[$field];
	// checks proper syntax
	$reg = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
	if(!eregi($reg,trim($email)))
	{
		$is_success = 0;
		$_SESSION["errorfield"] = $field;
	}
	
	/*if($is_success == 1)
	{
		// gets domain name
		list($username,$domain)=split('@',$email);
  		// checks for if MX records in the DNS
		
		if(!checkdnsrr($domain, 'MX'))
		{
			
			$is_success = 0;
		}
	}*/
	
	/*if($is_success == 1)
	{	
		if(!fsockopen($domain,25,$errno,$errstr,10))
		{
			$is_success = 0;
		}
	}*/
	
	return $is_success;
}
function validateEmailAddress($email)
{
	$is_success = 1;
	// checks proper syntax
	$reg = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$^";
	if(!preg_match($reg,trim($email)))
	{
		$is_success = 0;
	}
	return $is_success;
}

function chtmlentities($str)
{
	return htmlentities($str);
}

function getArrayFromResultSet($array,$basefield)
{
	$retArray = array();
	for($i=0;$i<count($array);$i++)
	{
		$retArray[] = $array[$i]["$basefield"];
	}
	
	return $retArray;
}

function UploadandSaveThumbImgs($field,$path,$width=array(),$height=array(),$concatstr=array())
{
$ret="";

$ext=explode(".",$_FILES[$field]['name']);
			switch(strtolower($ext[count($ext)-1]))
			{
				case 'png':
					$ret .="";
					break;
				case 'jpg':
					$ret .="";
					break;
				case 'gif':
					$ret .="";
					break;
				case 'jpeg':
					$ret .="";
					break;	
				case 'bmp':
					$ret .= "Please provide right format file for Image(gif or jpeg or png only)<br />";
					break;	
				
				default:
					$ret .= "Please provide right format file for Image(gif or jpeg or png only)<br />";
					break;
			}
	if($ret=='')
	{
	$ret=array();
	$imgname=time().$_FILES[$field]['name'];
 
   
			
           if(move_uploaded_file($_FILES[$field]['tmp_name'],$path.$imgname))
				{
				 foreach($width as $key=>$val)
               {
			   $obj="chk".$key;
	    $$obj=new imageProcessing($path.$imgname,$path.$concatstr[$key].$imgname,true,$width[$key],$height[$key]); 
					   if($$obj->msg!='')
					    
						{
						$ret[$key]['error']=$_FILES[$field]['name']." : ".$$obj->msg;
						}
					
					
				}
				}
			/*else
			{
			            $ret[$key]['error']=$path.$imgname." image cannot be uploaded";
			}	*/
				
     }

 return $ret;			
}

function genDbFileNm($field)
{
 $name=time().$_FILES[$field]['name'];
 return $name;
}
function getpaginationmessage($recordperpage)
{
	global $startpage,$rstotal;

	$message = LABLE_PAGINATIONMESSAGE;

	$message = str_replace("PAGE_START",($startpage+1),$message);
	if($recordperpage == "" || $recordperpage == 0)
	{
		$message = str_replace("PAGE_END",$rstotal,$message);
	}
	else
	{
		$message = str_replace("PAGE_END",($startpage+$recordperpage > $rstotal)?$rstotal:($startpage+$recordperpage),$message);
	}
	$message = str_replace("TOTAL_RECS",$rstotal,$message);
	
	return $message;
}


function encodestring($string)
{
	$encodestr = base64_encode($string);
	return $encodestr;
}

function decodestring($string)
{
	$decodestr = base64_decode($string);
	return $decodestr;
}


function getUSDateFormat($date)
{	
	return date(US_DATE_FORMAT,strtotime($date));
}

function myTruncate($string, $limit, $break=" ", $pad="...") { // return with no change if string is shorter than $limit 
  if(strlen($string) <= $limit) 
  return $string; $string = substr($string, 0, $limit);
   if(false !== ($breakpoint = strrpos($string, $break))) { 
   $string = substr($string, 0, $breakpoint);
    } 
   return $string . $pad;
    }
	
	
function restoreTags($input) { $opened = array(); // loop through opened and closed tags in order  
if(preg_match_all("/<(\/?[a-z]+)>?/i", $input, $matches)) {
 foreach($matches[1] as $tag) {
  if(preg_match("/^[a-z]+$/i", $tag, $regs)) { 
// a tag has been opened  
if(strtolower($regs[0]) != 'br')
 $opened[] = $regs[0]; 
} elseif(preg_match("/^\/([a-z]+)$/i", $tag, $regs)) { 
// a tag has been closed  
unset($opened[array_pop(array_keys($opened, $regs[1]))]); } } } 
// close tags that are still open  
if($opened) { 
$tagstoclose = array_reverse($opened); 
foreach($tagstoclose as $tag) 
$input .= "</$tag>"; 
} 
return $input; 
}

function sendcustomerinvoice($invoiceid)
{
	$invoice = generate_invoice($invoiceid);
	
	$invres = getcountorresultset(TABLE_ORDERS,"transaction_number,billing_firstname,billing_lastname,billing_email","0","","","orders_id",$invoiceid);
	
	$mail=new PHPMailer();
	$mail->IsHTML(true);
	$mail->IsSMTP();
	
	@$mail->AddAddress(trim($invres["0"]["billing_email"]));		
	
	$mail->Subject=addslashes(SITE_NAME_ON_EMAIL." - Order invoice details");
	$mail->Body="Hello ".$invres["0"]["billing_firstname"]." ".$invres["0"]["billing_lastname"].", <br/><br/>
		Paypal transaction number is ".$invres["0"]["transaction_number"].". <br/><br/>
		Thank You for purchasing  from ".SITE_NAME_ON_EMAIL.". <br/> <br/>
		
		Please find your order invoice and detail below. <br/><br/>
		
		Thank You, <br/>
		".SITE_NAME_ON_EMAIL."<br/><br/>
		
		
		<center><b>Order Invoice Detail</b></center><br/>";
	
	$mail->Body .= $invoice;
		
	$mail->FromName=EMAIL_FROM_NAME;
	$mail->From = FROM_EMAIL;
	$mail->send();
	
}

function sendadmininvoice($invoiceid)
{
	$invoice = generate_invoice($invoiceid);
	
	$mail=new PHPMailer();
	$mail->IsHTML(true);
	$mail->IsSMTP();
	
	$invres = getcountorresultset(TABLE_ORDERS,"transaction_number,billing_firstname,billing_lastname,billing_email","0","","","orders_id",$invoiceid);
	
	$emails_array = explode(",",ORDER_EMAIL);
	
	for($i=0;$i<count($emails_array);$i++)
	{
		$mail->ClearAddresses();
		@$mail->AddAddress(trim($emails_array[$i]));		
	
		$mail->Subject=addslashes(SITE_NAME_ON_EMAIL." - A new order placed by customer");
		$mail->Body="Hello, <br/><br/>
	
			A new order has been placed by ".$invres["0"]["billing_firstname"]." ".$invres["0"]["billing_lastname"]."(".$invres["0"]["billing_email"]."). <br/> <br/>
			
			Paypal transaction number is ".$invres["0"]["transaction_number"].". <br/><br/>
			
			Thank You, <br/>
			".SITE_NAME_ON_EMAIL."<br/><br/>
			<center><b>Order Invoice Detail</b></center><br/>";
		
		$mail->Body .= $invoice;
			
		$mail->FromName=EMAIL_FROM_NAME;
		$mail->From = FROM_EMAIL;
		$mail->send();
	}
}

function generate_invoice($invoiceid)
{

	$invres = getcountorresultset(TABLE_ORDERS,"*","0","","","orders_id",$invoiceid);
	$resinvoice = getcountorresultset(TABLE_INVOICE,"*","0","","","order_id",$invoiceid);


	$out='<table width="100%" border="0" cellspacing="0" cellpadding="10">  
	  <tr>
		<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border:#CCCCCC 1px solid;">
		  <tr>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
		  <td colspan="2">
		  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
			  <tr>
				<td width="150" align="left" valign="top"><strong>Order No. :</strong></td>
				<td align="left" valign="top"> '. $invres[0]['orders_id'].'</td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Order Date : </strong></td>
				<td align="left" valign="top">'.getUSDateFormat($invres[0]['orderdate']).'</td>
			  </tr>
			 
			  
			  <tr>
				<td align="left" valign="top"><strong>Payment Status : </strong></td>
				<td align="left" valign="top">'.$invres[0]['orders_status'].'</td>
			  </tr>
			 

			</table>
		  </td>';
		  
		  $out.=' </tr>
		  <tr>
		   <td colspan="2" style="height:10px;"></td>
		  </tr>
		  <tr>
			<td width="50%" align="left" valign="top">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td><strong>Billing information</strong></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><b>Name</b> : '.$invres[0]['billing_firstname']." ".$invres[0]['billing_lastname'].'</td>
			  </tr>
			  <tr>
	 <td><b>Address</b> :'.$invres[0]['billing_address1']." ".$invres[0]['billing_address2'].'</td>
			  </tr>
			  <tr>
				<td><b>Country</b> :'.$invres[0]['billing_country'].'</td>
			  </tr>
			  <tr>
				<td><b>State</b> :'. $invres[0]['billing_state'].' </td>
			  </tr>
			  <tr>
				<td><b>City</b> : '.$invres[0]['billing_city'].'</td>
			  </tr>
			  <tr>
				<td><b>Zip code </b> : '.$invres[0]['billing_zipcode'].'</td>
			  </tr>
			   <tr>
				<td><b>Phone </b> : '.$invres[0]['billing_phone'].'</td>
			  </tr>
			   <tr>
				<td><b>Email </b> : '.$invres[0]['billing_email'].'</td>
			  </tr>
			  ';
			  
		   $out.=' </table></td>
			<td align="left" valign="top"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td><strong>Shipping Address</strong></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><b>Name</b> : '. $invres[0]['shipping_firstname']." ".$invres[0]['shipping_lastname'].'</td>
			  </tr>
			  <tr>
				<td><b>Address</b> : '. $invres[0]['shipping_address1']." ".$invres[0]['shipping_address2'].'</td>
			  </tr>
			  <tr>
				<td><b>Country</b> :'. $invres[0]['shipping_country'].'</td>
			  </tr>
			  <tr>
				<td><b>State</b> :'.$invres[0]['shipping_state'].' </td>
			  </tr>
			  <tr>
				<td><b>City</b> : '. $invres[0]['shipping_city'].'</td>
			  </tr>
			  <tr>
				<td><b>Zip code </b> : '. $invres[0]['shipping_zipcode'].'</td>
			  </tr>
			   <tr>
				<td><b>Phone </b> : '. $invres[0]['shipping_phone'].'</td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
		  </tr>
		</table></td>
	  </tr>';
	  
	  $out.='<tr>
		<td align="left" valign="top"><table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
		  <tr bgcolor="#E8E8E8">
			<td width="50" align="center" valign="top" bordercolor="#CCCCCC"><strong>No.</strong></td>
		   
			<td align="center" valign="top" bordercolor="#CCCCCC"><strong>ITEM NAME</strong></td>
			 
			<td width="100" align="center" valign="top" bordercolor="#CCCCCC"><strong>QUANTITY</strong></td>
			<td align="center" valign="top" bordercolor="#CCCCCC"><strong>PRICE</strong></td>
			<td align="center" valign="top" bordercolor="#CCCCCC"><strong>TOTAL</strong></td>
		  </tr>';
		 if(isset($resinvoice) && count($resinvoice)>0 && $resinvoice != false)
		 {
					 
			   for($i=0;$i<count($resinvoice);$i++)
			   {
				  
					 $productname = $resinvoice[$i]['products_name'];
					
				  
				   
					$sno=$i+1;
						 
					 $out.=' <tr>
							<td align="center" valign="top" bordercolor="#CCCCCC">'.$sno.'</td>
							<td align="left" valign="top" bordercolor="#CCCCCC">'.$productname.'</td>
						  
					 <td align="center" valign="top" bordercolor="#CCCCCC">'.$resinvoice[$i]["products_quantity"].'</td>
							<td align="right" valign="top" bordercolor="#CCCCCC">$'.number_format($resinvoice[$i]["products_price"],2).'</td>
							<td align="right" valign="top" bordercolor="#CCCCCC">$'.number_format($resinvoice[$i]["final_price"],2).'</td>
						  </tr>';
				 }
			}
		  
		  
		  $out.='<tr bgcolor="#F2F2F2">
			<td colspan="4" align="right" valign="top" bordercolor="#CCCCCC"><strong>Sub Total</strong></td>
			<td align="right" valign="top" bordercolor="#CCCCCC">$'.number_format($invres[0]['order_subtotal'],2).'</td>
		  </tr>';
		  
		  if(isset($invres[0]['shipping_charge']) && $invres[0]['shipping_charge'] != "" && $invres[0]['shipping_charge'] > 0)
		  {
		  
		  $out.='<tr bgcolor="#F2F2F2">
			<td colspan="4" align="right" valign="top" bordercolor="#CCCCCC"><strong>Shipping Charge</strong></td>
			<td align="right" valign="top" bordercolor="#CCCCCC">$'.number_format($invres[0]['shipping_charge'],2).' </td>
		  </tr>';
		  }
		  
		  if(isset($invres[0]['tax_charge']) && $invres[0]['tax_charge'] != "" && $invres[0]['tax_charge'] > 0)
		  {
		  $out.='<tr bgcolor="#F2F2F2">
			<td colspan="4" align="right" valign="top" bordercolor="#CCCCCC"><strong>Tax Charge</strong></td>
			<td align="right" valign="top" bordercolor="#CCCCCC">$'. number_format($invres[0]['tax_charge'],2).' </td>
		  </tr>';
		  }
		  $out.='<tr bgcolor="#F2F2F2">
			<td colspan="4" align="right" valign="top" bordercolor="#CCCCCC"><strong>Order Total</strong></td>
			<td align="right" valign="top" bordercolor="#CCCCCC">$'.number_format($invres[0]['order_total'],2).'</td>
		  </tr>';
		 $out.='<tr bgcolor="#F2F2F2">
			<td colspan="4" align="right" valign="top" bordercolor="#CCCCCC"><strong>Total Items</strong></td>
			<td align="right" valign="top" bordercolor="#CCCCCC">'.$invres["0"]["total_quantity"].'</td>
		  </tr>';
		$out.='</table></td>
	  </tr>
	  
	</table>';
		
	return $out;
}
function time_passed($timestamp){
    //type cast, current time, difference in timestamps
    $timestamp      = (int) $timestamp;
    $current_time   = time();
    $diff           = $current_time - $timestamp;
   
    //intervals in seconds
    $intervals      = array (
        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
    );
    //now we just find the difference
    if ($diff == 0)
    {
        return 'just now';
    }   
    elseif ($diff < 60)
    {
        return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
    }       
	elseif ($diff >= 60 && $diff < $intervals['hour'])
    {
        $diff = floor($diff/$intervals['minute']);
        return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
    }       
	elseif ($diff >= $intervals['hour'] && $diff < $intervals['day'])
    {
        $diff = floor($diff/$intervals['hour']);
        return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
    }   
	elseif ($diff >= $intervals['day'] && $diff < $intervals['week'])
    {
        $diff = floor($diff/$intervals['day']);
        return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
    }   
	elseif($diff >= $intervals['week'])
    {
        $diff = floor($diff/$intervals['week']);
        return date("d M,Y H:i",$timestamp);
    }   
}
function gettopseveneventforhomepage($university_id,$startdate='',$enddate='')
{
	global $dbObj;
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
	$student_id=$_SESSION['student_id'];
	$course_ids=0;
	////////get the student enrolled course for current semester ////////////////////
	$sem_sql="SELECT startperiod, endperiod,name FROM `semester_schedule` WHERE univid = ".$university_id." and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP)>=MONTH(startperiod)*100+DAY(startperiod) and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP) <= MONTH(endperiod)*100+DAY(endperiod) "; 
	$sem_res=$dbObj->fireQuery($sem_sql,'select');
	if(isset($sem_res) && $sem_res!=false && count($sem_res)>0)
	{
		$startperiod=$sem_res[0]['startperiod'];
		$endperiod=$sem_res[0]['endperiod'];
		if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
		{
			$student_id=$_SESSION['student_id'];
			$student_course_sql="select GROUP_CONCAT(course_id) as courseids  from  student_courses_1 where enrolltime>='".$startperiod."' and enrolltime<='".$endperiod."' and student_id='".$student_id."'";
			$courses_res=$dbObj->fireQuery($student_course_sql,'select');
			if(isset($courses_res) && count($courses_res)>0 && $courses_res!=false)
			{
				if($courses_res[0]['courseids']!='')
				{
					$course_ids=$courses_res[0]['courseids'];
				}
			}
		}
		
	}
	////////// fetch all departments from coureds ids /////////////////////////
	$dept_ids=0;
	$student_department_sql="select GROUP_CONCAT(deptid) as deptids  from  course_1 where cid IN (".$course_ids.") group by deptid";
	$department_res=$dbObj->fireQuery($student_department_sql,'select');
	if(isset($department_res) && count($department_res)>0 && $department_res!=false)
	{
		if($department_res[0]['deptids']!='')
		{
			$dept_ids=$department_res[0]['deptids'];
		}
	}
	$group_ids=0;
	/////////////////// Fetch all group ids for selected tables/////////////////////////
	$student_groups_sql="select GROUP_CONCAT(groupid) as groupids  from  groups_student_1 where studid = '".$student_id."'";
	$groups_res=$dbObj->fireQuery($student_groups_sql,'select');
	if(isset($groups_res) && count($groups_res)>0 && $groups_res!=false)
	{
		if($groups_res[0]['groupids']!='')
		{
		$group_ids=$groups_res[0]['groupids'];
		}
	}
	
	////////////Check if startdate and enddate set then get those range events else get current date events.
	$wherecond='';
	if($startdate!=''&& $enddate!='')
	{
		$wherecond=" end >'".$startdate."' and end <='".$enddate."' ";
	}
	else
	{
		$wherecond=" end>NOW() ";
	}
	
	///////////// Get the total events result to display for this panel ////////
	$events_sql="select  eventid,title,description,start,end,eventype from(
	select eventid,title,description,start,end,CONCAT_WS('','course',  '' ) AS eventype from course_event where cid IN (".$course_ids.") and universityid=".$university_id." and eventid not in (select event_id from course_event_check_1 where studid=".$student_id." and uid=".$university_id.")
	UNION ALL select eventid,eventname,eventdesc,starttime,endtime,CONCAT_WS(  '',  'department',  '' ) AS eventype from dept_event_1 where deptid IN (".$dept_ids.") and univid=".$university_id." and eventid not in (select eventid from dept_event_check_1 where studid=".$student_id." and uid=".$university_id.") 
	UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'group',  '' ) AS eventype from group_event where g_id IN (".$group_ids.") and universityid=".$university_id." and eventid not in (select eventid from group_event_check where studid=".$student_id." and uid=".$university_id.") 
	UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'student',  '' ) AS eventype from personal_event where ischeck = 0 and s_id = ".$student_id." and universityid=".$university_id."
	)results where ".$wherecond." order by end LIMIT 0,7";
	
	return $eventsres=$dbObj->fireQuery($events_sql,'select');
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$professor_id=$_SESSION['professor_id'];
		$course_ids=0;
		$dept_ids=0;
		////////get the professor teachse course ////////////////////
		$professor_course_sql="select GROUP_CONCAT(cid) as courseids,GROUP_CONCAT(deptid) as deptids from course_1 where profid='".$professor_id."'";
		$courses_res=$dbObj->fireQuery($professor_course_sql,'select');
		if(isset($courses_res) && count($courses_res)>0 && $courses_res!=false)
		{
			if($courses_res[0]['courseids']!='')
			{
				$course_ids=$courses_res[0]['courseids'];
			}
			if($courses_res[0]['deptids']!='')
			{
				$dept_ids=$courses_res[0]['deptids'];
			}
		}
		$group_ids=0;
		/////////////////// Fetch all group ids for selected tables/////////////////////////
		$professor_groups_sql="select GROUP_CONCAT(groupid) as groupids  from  groups_professor_1 where profid = '".$professor_id."'";
		$groups_res=$dbObj->fireQuery($professor_groups_sql,'select');
		if(isset($groups_res) && count($groups_res)>0 && $groups_res!=false)
		{
			if($groups_res[0]['groupids']!='')
			{
			$group_ids=$groups_res[0]['groupids'];
			}
		}
	
	////////////Check if startdate and enddate set then get those range events else get current date events.
	$wherecond='';
	if($startdate!=''&& $enddate!='')
	{
		$wherecond=" end >'".$startdate."' and end <='".$enddate."' ";
	}
	else
	{
		$wherecond=" end>NOW() ";
	}
	/*echo "<br />";
	echo "<br />courseid===>".$course_ids;
	echo "<br />deptids===>".$dept_ids;
	echo "<br />groupids===>".$group_ids;*/
	
	///////////// Get the total events result to display for this panel ////////
	$events_sql="select  eventid,title,description,start,end,eventype from(
	select eventid,title,description,start,end,CONCAT_WS('','course',  '' ) AS eventype from course_event where cid IN (".$course_ids.") and universityid=".$university_id." and eventid not in (select event_id from course_event_check_1 where profid=".$professor_id." and uid=".$university_id.")
	UNION ALL select eventid,eventname,eventdesc,starttime,endtime,CONCAT_WS(  '',  'department',  '' ) AS eventype from dept_event_1 where deptid IN (".$dept_ids.") and univid=".$university_id." and eventid not in (select eventid from dept_event_check_1 where profid=".$professor_id." and uid=".$university_id.") 
	UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'group',  '' ) AS eventype from group_event where g_id IN (".$group_ids.") and universityid=".$university_id." and eventid not in (select eventid from group_event_check where profid=".$professor_id." and uid=".$university_id.") 
	UNION ALL select eventid,eventname,eventdesc,start_time,end_time,CONCAT_WS(  '',  'professor',  '' ) AS eventype from professor_event_1 where ischeck = 0 and profid = ".$professor_id."
	)results where ".$wherecond." order by end LIMIT 0,7";
	return $eventsres=$dbObj->fireQuery($events_sql,'select');
	
	}
}
function recentlynewaddedeventnoficiation($university_id,$startdate,$enddate)
{
	global $dbObj;
	$final_event_arr=array();
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		$student_id=$_SESSION['student_id'];
		$course_ids=0;
		////////get the student enrolled course for current semester ////////////////////
		$sem_sql="SELECT startperiod, endperiod,name FROM `semester_schedule` WHERE univid = ".$university_id." and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP)>=MONTH(startperiod)*100+DAY(startperiod) and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP) <= MONTH(endperiod)*100+DAY(endperiod) "; 
		$sem_res=$dbObj->fireQuery($sem_sql,'select');
		if(isset($sem_res) && $sem_res!=false && count($sem_res)>0)
		{
			$startperiod=$sem_res[0]['startperiod'];
			$endperiod=$sem_res[0]['endperiod'];
			if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
			{
				$student_id=$_SESSION['student_id'];
				$student_course_sql="select GROUP_CONCAT(course_id) as courseids  from  student_courses_1 where enrolltime>='".$startperiod."' and enrolltime<='".$endperiod."' and student_id='".$student_id."'";
				$courses_res=$dbObj->fireQuery($student_course_sql,'select');
				if(isset($courses_res) && count($courses_res)>0 && $courses_res!=false)
				{
					if($courses_res[0]['courseids']!='')
					{
						$course_ids=$courses_res[0]['courseids'];
					}
				}
			}
			
		}
		////////// fetch all departments from coureds ids /////////////////////////
		$dept_ids=0;
		$student_department_sql="select GROUP_CONCAT(deptid) as deptids  from  course_1 where cid IN (".$course_ids.") group by deptid";
		$department_res=$dbObj->fireQuery($student_department_sql,'select');
		if(isset($department_res) && count($department_res)>0 && $department_res!=false)
		{
			if($department_res[0]['deptids']!='')
			{
				$dept_ids=$department_res[0]['deptids'];
			}
		}
		
		if($course_ids!=0)
		{
			$select_new_events="SELECT eventid,cid,profid,title  FROM `course_event` where eventid not in (select eventid from alert_event_check where type='course' and studid='".$student_id."') and creatednt >= '".$enddate."' and creatednt <= '".$startdate."' and cid IN (".$course_ids.") and universityid='".$university_id."'";
			$courseevent_res=$dbObj->fireQuery($select_new_events,'select');
			if(isset($courseevent_res) && count($courseevent_res)>0 && $courseevent_res!=false)
			{
				for($c=0;$c<count($courseevent_res);$c++)
				{
					$final_event_arr[]=array("event_id"=>$courseevent_res[$c]['eventid'],"course_id"=>$courseevent_res[$c]['cid'],"profid"=>$courseevent_res[$c]['profid'],"title"=>$courseevent_res[$c]['title']);
				}
			}
		}
		if($dept_ids!=0)
		{
			$select_new_events="SELECT eventid,deptid,eventname  FROM `dept_event_1` where eventid not in (select eventid from alert_event_check where type='dept' and studid='".$student_id."') and creatednt >='".$enddate."' and creatednt <='".$startdate."' and deptid IN (".$dept_ids.") and univid='".$university_id."'";
			$deptevent_res=$dbObj->fireQuery($select_new_events,'select');
			if(isset($deptevent_res) && count($deptevent_res)>0 && $deptevent_res!=false)
			{
				for($c=0;$c<count($deptevent_res);$c++)
				{
					$final_event_arr[]=array("event_id"=>$deptevent_res[$c]['eventid'],"dept_id"=>$deptevent_res[$c]['deptid'],"profid"=>'NONE',"title"=>$deptevent_res[$c]['eventname']);
				}
			}
		}
		
	}
	return $final_event_arr;
	
}
function upcomingeventnotification($university_id,$startdate='',$enddate='',$incomplete='No')
{
	global $dbObj;
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
	$student_id=$_SESSION['student_id'];
	$course_ids=0;
	////////get the student enrolled course for current semester ////////////////////
	$sem_sql="SELECT startperiod, endperiod,name FROM `semester_schedule` WHERE univid = ".$university_id." and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP)>=MONTH(startperiod)*100+DAY(startperiod) and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP) <= MONTH(endperiod)*100+DAY(endperiod) "; 
	$sem_res=$dbObj->fireQuery($sem_sql,'select');
	if(isset($sem_res) && $sem_res!=false && count($sem_res)>0)
	{
		$startperiod=$sem_res[0]['startperiod'];
		$endperiod=$sem_res[0]['endperiod'];
		if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
		{
			$student_id=$_SESSION['student_id'];
			$student_course_sql="select GROUP_CONCAT(course_id) as courseids  from  student_courses_1 where enrolltime>='".$startperiod."' and enrolltime<='".$endperiod."' and student_id='".$student_id."'";
			$courses_res=$dbObj->fireQuery($student_course_sql,'select');
			if(isset($courses_res) && count($courses_res)>0 && $courses_res!=false)
			{
				if($courses_res[0]['courseids']!='')
				{
					$course_ids=$courses_res[0]['courseids'];
				}
			}
		}
		
	}
	////////// fetch all departments from coureds ids /////////////////////////
	$dept_ids=0;
	$student_department_sql="select GROUP_CONCAT(deptid) as deptids  from  course_1 where cid IN (".$course_ids.") group by deptid";
	$department_res=$dbObj->fireQuery($student_department_sql,'select');
	if(isset($department_res) && count($department_res)>0 && $department_res!=false)
	{
		if($department_res[0]['deptids']!='')
		{
			$dept_ids=$department_res[0]['deptids'];
		}
	}
	$group_ids=0;
	/////////////////// Fetch all group ids for selected tables/////////////////////////
	$student_groups_sql="select GROUP_CONCAT(groupid) as groupids  from  groups_student_1 where studid = '".$student_id."'";
	$groups_res=$dbObj->fireQuery($student_groups_sql,'select');
	if(isset($groups_res) && count($groups_res)>0 && $groups_res!=false)
	{
		if($groups_res[0]['groupids']!='')
		{
		$group_ids=$groups_res[0]['groupids'];
		}
	}
	
	////////////Check if startdate and enddate set then get those range events else get current date events.
	$wherecond='';
	if($startdate!=''&& $enddate!='')
	{
		$wherecond=" end >='".$startdate."' and end <='".$enddate."' ";
	}
	else
	{
		$wherecond=" end>NOW() ";
	}
	
	///////////// Get the total events result to display for this panel ////////
	if($incomplete=='No')
	{
		$events_sql="select  eventid,title,description,start,end,eventype from(
		select eventid,title,description,start,end,CONCAT_WS('','course',  '' ) AS eventype from course_event where cid IN (".$course_ids.") and universityid=".$university_id."
		UNION ALL select eventid,eventname,eventdesc,starttime,endtime,CONCAT_WS(  '',  'department',  '' ) AS eventype from dept_event_1 where deptid IN (".$dept_ids.") and univid=".$university_id." 
		UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'group',  '' ) AS eventype from group_event where g_id IN (".$group_ids.") and universityid=".$university_id."
		UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'student',  '' ) AS eventype from personal_event where s_id = ".$student_id." and universityid=".$university_id."
		)results where ".$wherecond." order by end";
		return $eventsres=$dbObj->fireQuery($events_sql,'select');
	}
	if($incomplete=='Yes')
	{
		$incomplete_events_sql="select  eventid,title,description,start,end,eventype from(
		select eventid,title,description,start,end,CONCAT_WS('','course',  '' ) AS eventype from course_event where cid IN (".$course_ids.") and universityid=".$university_id." and eventid not in (select event_id from course_event_check_1 where studid=".$student_id." and uid=".$university_id.")
		UNION ALL select eventid,eventname,eventdesc,starttime,endtime,CONCAT_WS(  '',  'department',  '' ) AS eventype from dept_event_1 where deptid IN (".$dept_ids.") and univid=".$university_id." and eventid not in (select eventid from dept_event_check_1 where studid=".$student_id." and uid=".$university_id.")
		UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'group',  '' ) AS eventype from group_event where g_id IN (".$group_ids.") and universityid=".$university_id." and eventid not in (select eventid from group_event_check where studid=".$student_id." and uid=".$university_id.")
		UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'student',  '' ) AS eventype from personal_event where s_id = ".$student_id." and universityid=".$university_id." and ischeck=0
		)results where ".$wherecond." order by end";
		$eventsres=$dbObj->fireQuery($incomplete_events_sql,'select');
		if(isset($eventsres) && $eventsres!=false)
		{
			return count($eventsres);
		}
		else
		{
			return 0;
		}
		
		
	}
	
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$professor_id=$_SESSION['professor_id'];
		$course_ids=0;
		$dept_ids=0;
		////////get the professor teachse course ////////////////////
		$professor_course_sql="select GROUP_CONCAT(cid) as courseids,GROUP_CONCAT(deptid) as deptids from course_1 where profid='".$professor_id."'";
		$courses_res=$dbObj->fireQuery($professor_course_sql,'select');
		if(isset($courses_res) && count($courses_res)>0 && $courses_res!=false)
		{
			if($courses_res[0]['courseids']!='')
			{
				$course_ids=$courses_res[0]['courseids'];
			}
			if($courses_res[0]['deptids']!='')
			{
				$dept_ids=$courses_res[0]['deptids'];
			}
		}
		$group_ids=0;
		/////////////////// Fetch all group ids for selected tables/////////////////////////
		$professor_groups_sql="select GROUP_CONCAT(groupid) as groupids  from  groups_professor_1 where profid = '".$professor_id."'";
		$groups_res=$dbObj->fireQuery($professor_groups_sql,'select');
		if(isset($groups_res) && count($groups_res)>0 && $groups_res!=false)
		{
			if($groups_res[0]['groupids']!='')
			{
			$group_ids=$groups_res[0]['groupids'];
			}
		}
	
	////////////Check if startdate and enddate set then get those range events else get current date events.
	$wherecond='';
	if($startdate!=''&& $enddate!='')
	{
		$wherecond=" end >'".$startdate."' and end <='".$enddate."' ";
	}
	else
	{
		$wherecond=" end>NOW() ";
	}
	/*echo "<br />";
	echo "<br />courseid===>".$course_ids;
	echo "<br />deptids===>".$dept_ids;
	echo "<br />groupids===>".$group_ids;*/
	
	///////////// Get the total events result to display for this panel ////////
		if($incomplete=='No')
		{
			$events_sql="select  eventid,title,description,start,end,eventype from(
			select eventid,title,description,start,end,CONCAT_WS('','course',  '' ) AS eventype from course_event where cid IN (".$course_ids.") and universityid=".$university_id."
			UNION ALL select eventid,eventname,eventdesc,starttime,endtime,CONCAT_WS(  '',  'department',  '' ) AS eventype from dept_event_1 where deptid IN (".$dept_ids.") and univid=".$university_id."
			UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'group',  '' ) AS eventype from group_event where g_id IN (".$group_ids.") and universityid=".$university_id."
			UNION ALL select eventid,eventname,eventdesc,start_time,end_time,CONCAT_WS(  '',  'professor',  '' ) AS eventype from professor_event_1 where profid = ".$professor_id."
			)results where ".$wherecond." order by end";
			return $eventsres=$dbObj->fireQuery($events_sql,'select');
		}
		if($incomplete=='Yes')
		{
			$incomplete_events_sql="select  eventid,title,description,start,end,eventype from(
			select eventid,title,description,start,end,CONCAT_WS('','course',  '' ) AS eventype from course_event where cid IN (".$course_ids.") and universityid=".$university_id." and eventid not in (select event_id from course_event_check_1 where profid=".$professor_id." and uid=".$university_id.")
			UNION ALL select eventid,eventname,eventdesc,starttime,endtime,CONCAT_WS(  '',  'department',  '' ) AS eventype from dept_event_1 where deptid IN (".$dept_ids.") and univid=".$university_id." and eventid not in (select eventid from dept_event_check_1 where profid=".$professor_id." and uid=".$university_id.") 
			UNION ALL select eventid,title,description,start,end,CONCAT_WS(  '',  'group',  '' ) AS eventype from group_event where g_id IN (".$group_ids.") and universityid=".$university_id." and  eventid not in (select eventid from group_event_check where profid=".$professor_id." and uid=".$university_id.")
			UNION ALL select eventid,eventname,eventdesc,start_time,end_time,CONCAT_WS(  '',  'professor',  '' ) AS eventype from professor_event_1 where ischeck = 0 and profid = ".$professor_id."
			)results where ".$wherecond." order by end";
			$incomplete_events_res=$dbObj->fireQuery($incomplete_events_sql,'select');
			if(isset($incomplete_events_res) && $incomplete_events_res!=false)
			{
				return count($incomplete_events_res);
			}
			else
			{
				return 0;
			}
		}
		
	}
}
function getlastjoincoursemember($courseid)
{
	$final_students=array();
	global $dbObj;
	/////// get all student of course ////////////////////
	$student_course="select student_id from student_courses_1 where course_id ='".$courseid."' order by enrolltime desc";
	$student_course_res=$dbObj->fireQuery($student_course,'select');
	if(isset($student_course_res) && $student_course_res!=false && count($student_course_res)>0)
	{
		for($s=0;$s<count($student_course_res);$s++)
		{
			$student_id=$student_course_res[$s]['student_id'];
			////// Check if this student linqqed with it/////////
			if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){
				$stude_linqed="SELECT count(*) as total FROM `student_student_1` where from_studid='".$_SESSION['student_id']."' and to_studid='".$student_id."'";
				$stude_linqed_res=$dbObj->fireQuery($stude_linqed,'select');
				if(isset($stude_linqed_res) && count($stude_linqed_res)>0 && $stude_linqed_res!=false)
				{
					if($stude_linqed_res[0]['total']==1)
					{
						if(count($final_students)<2)
						{
							$final_students[]=array("studid"=>$student_id,"name"=>getstudentdetail($student_id,'name'));
						}
					}
				}
			}
			elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){
			
				$profes_linqed="SELECT count(*) as total FROM `professor_student_1` where from_profid='".$_SESSION['professor_id']."' and to_studid='".$student_id."'";
				$profes_linqed_res=$dbObj->fireQuery($profes_linqed,'select');
				if(isset($profes_linqed_res) && count($profes_linqed_res)>0 && $profes_linqed_res!=false)
				{
					if($profes_linqed_res[0]['total']==1)
					{
						if(count($final_students)<2)
						{
							$final_students[]=array("studid"=>$student_id,"name"=>getstudentdetail($student_id,'name'));
						}
					}
				}
			}
			
		}
	}
	return $final_students;
	
}
?>