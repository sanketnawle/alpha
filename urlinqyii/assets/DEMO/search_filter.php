<?php
	include_once("include/includefiles.php");
	
	$host = "localhost";
	$user = "campusla_UrlinqU";
	$password = "PASSurlinq@word9";
	$database = "campusla_urlinq_demo";
	
	$con = mysqli_connect($host, $user, $password, $database);
	 
	//echo "Connected";
	 
	if(isset($_GET['univid']) && $_GET['univid']!='' )
	{
		$university_id=$_GET['univid'];
	}else{
		$university_id=0;
	}
	
	if($con->connect_error)
	{
		die('Connect Error:'.$con->connect_error);
	}
	
	//echo "Connected";
	
	$first_deptid=0;
	/////////Get all departments for university here /////////////////////////////
	$deptsql="SELECT * FROM `department_1` where `universityid`='".$university_id."';";
	
	if($deptListRes = $con->query($deptsql))
	{
		$deptRow = $deptListRes->fetch_array(MYSQLI_ASSOC);
		$first_deptid=$deptRow['deptid'];
	}

	//echo "Dept".$first_deptid;
	
	if(isset($_GET['deptid']) && $_GET['deptid']!=''){
				$sel_deptid=$_GET['deptid'];
		}else{
				$sel_deptid=$first_deptid;
				}
				//echo "Dept".$sel_deptid;
				if(isset($sel_deptid) && $sel_deptid!='')
				{
				$search_course_cond="";
				if(isset($_POST['search']) && $_POST['search']!='')
				{
					$search_course_cond=" AND name LIKE '%".$_POST['search']."%'";
				}
				$course_dept_sql = "";
				if(isset($_POST['usertype']) && $_POST['usertype']=='Student')
					{
					if(isset($search_course_cond) && $search_course_cond!=""){
					$course_dept_sql="SELECT * FROM course_1 where universityid ='".$university_id."' ".$search_course_cond." ";
					}else{
					$course_dept_sql="SELECT * FROM course_1 where universityid ='".$university_id."' and deptid='".$sel_deptid."'";
					//echo "SQL".$course_dept_sql;
				}
				}
				elseif(isset($_POST['usertype']) && $_POST['usertype']=='Professor')
				{
				if(isset($search_course_cond) && $search_course_cond!=""){
						$course_dept_sql="SELECT * FROM course_1 where universityid ='".$university_id."' ".$search_course_cond." ";
							}else{
							$course_dept_sql="SELECT * FROM course_1 where universityid ='".$university_id."' and deptid='".$sel_deptid."'";
						}
					}
				}
				
	$query = "";			
	if(isset($_POST['filter']) && $_POST['filter'] != '')
		{
			
			$query = $course_dept_sql.convToSearchString($_POST['filter']);
			
		}
		else
		{
			$query = $course_dept_sql;
		}
		
		//echo "Final".$query;
		
		if($result = $con->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$cid=$row['cid'];
				$name=$row['name'];
				$courseid=$row['courseid'];
				$section=$row['section'];
				$deptid=$row['deptid'];
				$profid=$row['profid'];
				$credit = $row['credits'];
				$coursepic=$row['coursepic'];
				$location=$row['imagepath'];
				$desc=$row['desc'];
				$imagepath='images/noimage.jpg';
				if(isset($coursepic) && $coursepic!='')
				{
					$filepath=$location.'/'.$coursepic;
					if(file_exists($filepath))
					{
						$imagepath=$location.'/'.$coursepic;
					}
				}
				
				echo "<div class='infofield course itemtype'>
					<img src=".$imagepath." class='infopic'>
				<div class='infotail'>
					<div class='tailhead itemname'>
					<a>".$name."</a>
					</div>
					<div class='moreinfo'>
						<img class='prof-icon' src='images/professor-icon.png'>Taught by <span class='more-info-real'>";
				
						if(isset($_SESSION["usertype"]) && $_SESSION["usertype"]=="Professor" && $_SESSION["professor_id"]==$profid){echo "You";}
						else{ if(is_numeric($profid)){echo getprofessordetail($profid,'name');}else{ echo $profid;} }
					echo "</span>
					</div>
					<div class='subinfo'>
						<div class='subinfo_0'>
						<img class='prof-icon' src='images/students-icon.png'><a href=''>".gettotalcoursemembercount($cid)." members</a>";
						$final_students=getlastjoincoursemember($cid); 
						if(isset($final_students) && count($final_students)>0)
						{
							echo ',including ';
							foreach($final_students as $student)
							{
								echo '<a href="student_profile.php?studid='.$student['studid'].'">'.$student['name'].'</a>,';
							}
						}
					echo"
					</div>
					<div class='subinfo_1'>
					<img class='prof-icon' src='images/departments-icon.png'>
					<a href='index.php?pg=department&deptid=".$deptid."&univid=".$university_id."'>".getdepartmentdetail($deptid,'deptname')."</a> department
					</div>
					Credits <span class = 'subinfo_2'>".$credit."</span>
					Section <span class='more-info-real'>".$section."</span>
					<div class='subinfo_2'>
					<img class='prof-icon' src='images/descriptions-icon.png'>".$desc."
					</div>
					
				</div>";
				if(isset($_POST['usertype']) && $_POST['usertype']=='Student')
				{
					$iscoursenrolled=enrolledincourse($_POST['userId'],$cid,$university_id);
					if($iscoursenrolled==1){ 
					echo "<button style='background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;' class='linqthis' id='b-courses_".$cid."' value='1'>I am in this class</button>";
					}
					else{
					echo "<button value='0' id='b-courses_".$cid."' class='linqthis' style='background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;'>Add</button>";
					 }
				}
				elseif(isset($_POST['usertype']) && $_POST['usertype']=='Professor')
				{
					if($_POST['userId']==$profid)
					{
						echo "<button style='background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;' class='linqthis' id='b-courses_".$cid."' value='1'>I am in this class</button>";
	
					}
					else
					{ 
						echo "<button value='0' id='b-courses_".$cid."' class='linqthis' style='background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;'>Add</button>";
					}
				}	
				echo "
				</div>
			</div>";
			}
		}	

function convToSearchString($str){
	return str_replace("\'", "'", $str);
}		
?>