<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
////////check if user login or not //////////
if(!isset($_SESSION['usertype']))
{
	header("Location:index.php?pg=login");
	exit;
}
if(isset($_GET['univid']) && $_GET['univid']!='' )
{
	$university_id=$_GET['univid'];
}else{
	$university_id=0;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/banner.js"></script>
<title>People I May Know Urlinq</title>
<link rel = "icon" href = "images/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/home.css">
<link rel="stylesheet" type="text/css" href="css/search.css">
<link rel="stylesheet" type="text/css" href="css/banner.css">
<script language="javascript" type="text/javascript">
$(document).ready(function() {

var st2= $(".infofield").offset().left-70;
$("#searchborder").offset({ left: st2 });
$(window).on('resize', function(){
var st2= $(".infofield").offset().left-70;
$("#searchborder").offset({ left: st2 });
  });

$(document).delegate(".linqthis","mousedown",function(){
   
   var del=1;
   var thisname= $(this).closest(".itemtype").find(".itemname").text();
   var flag= $(this).val();
   var $linqid= $(this).attr("id").substring(2);
   action_vals=$linqid.split("_");
   
   var v00="";
   var v0="";
   var v1="";
   var v2="";
   if($(this).closest(".itemtype").hasClass("course")){
   v00="Add";
   v0="drop";
   v1="Drop";
   v2="I am in this class"
   }
   if($(this).closest(".itemtype").hasClass("community")){
   v00="Join";
   v0="drop";
   v1="Drop";
   v2="I am in this club"
   }
   if($(this).closest(".itemtype").hasClass("people")){
   v00="Linq";
   v0="drop";
   v1="Drop";
   v2="we are Linqed"
   }
  
   /*userid is the one who is viewing this page*/
   <?php 
   if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){
   		?>
		var userid= <?php echo $_SESSION['student_id']; ?>;
     	var whoislogin='Student';
   		<?php
   }elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){
   		?>
		var userid= <?php echo $_SESSION['professor_id']; ?>;
		var whoislogin='Professor';
		<?php
   }
   ?>
   var action= action_vals[0];
   var linqid= action_vals[1];														
   
   if(flag==0){
   var button_id=$(this).attr("id");
   $(this).val(1);
   $(this).text(v2);
   $(this).css({"background-color":"#60D62D","background-repeat":"repeat-x","background-image":"linear-gradient(#60D62D,#3DA50D)","color":"white","border":"1px solid #3B6E22"});
   /*Ajax , end info to backend, to inform that user and this object has linqed*/
   $.ajax({
		  url: 'linq.php',
		  data: 'user='+ userid +'&linqid='+ linqid +'&action=' + action +'&univ_id=<?php echo $university_id; ?>'+'&whoislogin='+whoislogin,
		  type: "POST",
		  success: function(msg) {
			result=msg.split("|||");
			if(result[0]==1){
				//alert(result[1]);
			}
			if(result[0]==0){
				alert(result[1]);
				/*change the button css*/
				$('#'+button_id).val(0);
 			    $('#'+button_id).text(v00);
				$('#'+button_id).css({"background":"linear-gradient(#fff,#ddd)","background-color":"#ddd","color":"black","border":"1px solid #ccc"});
   
			}
		  }
		  });
   

   }else{
  	 var pid= "kw="+$(this).attr("id");
   	 $("#blackcanvas").show();
   	 $(".dropconfirm").attr("id",pid);
   	 $("#dtext").text("Do you want to "+v0+" "+thisname+"?");
  	 //alert($linqid);	
   }
});

$(document).delegate("#confirm-c","click",function(){
   
   var oid= $(".dropconfirm").attr("id").split("=");
   var $obj=$("#"+oid[1]);
   
   var v00="";
   var v0="";
   var v1="";
   var v2="";
   if($obj.closest(".itemtype").hasClass("course")){
   v00="Add";
   v0="drop";
   v1="Drop";
   v2="I am in this class"
   }
   if($obj.closest(".itemtype").hasClass("community")){
   v00="Join";
   v0="drop";
   v1="Drop";
   v2="I am in this club"
   }
   if($obj.closest(".itemtype").hasClass("people")){
   v00="Linq";
   v0="drop";
   v1="Drop";
   v2="we are Linqed"
   }
   
   $("#blackcanvas").hide();
   
   $obj.css({"background-color":"#60D62D","background-repeat":"repeat-x","background-image":"linear-gradient(#60D62D,#3DA50D)","color":"white","border":"1px solid #3B6E22"});
   $obj.text(v2);
   $obj.width("auto");
   });
$(document).delegate("#confirm-d","click",function(){
  
   var oid= $(".dropconfirm").attr("id").split("=");
   var $obj=$("#"+oid[1]);
   var v00="";
   var v0="";
   var v1="";
   var v2="";
   if($obj.closest(".itemtype").hasClass("course")){
   v00="Add";
   v0="drop";
   v1="Drop";
   v2="I am in this class"
   }
   if($obj.closest(".itemtype").hasClass("community")){
   v00="Join";
   v0="drop";
   v1="Drop";
   v2="I am in this club"
   }
   if($obj.closest(".itemtype").hasClass("people")){
   v00="Linq";
   v0="drop";
   v1="Drop";
   v2="we are Linqed"
   }

   $("#blackcanvas").hide();
   $obj.val(0);
   $obj.text(v00);
   $obj.width("auto");
   $obj.css({"background":"linear-gradient(#fff,#ddd)","background-color":"#ddd","color":"black","border":"1px solid #ccc"});
   
   /*Ajax , end info to backend, to inform that user and this object has linqed*/
   var $linqid= $obj.attr("id").substring(2);
   action_vals=$linqid.split("_");
   /*userid is the one who is viewing this page*/
   <?php 
   if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){
   ?>
   	var userid= <?php echo $_SESSION['student_id']; ?>;
   	var whoislogin='Student';
   <?php
   }elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){
   ?>
   	var userid= <?php echo $_SESSION['professor_id']; ?>;
	var whoislogin='Professor';
   <?php
   }
   ?>

   var action= action_vals[0];
   var linqid= action_vals[1];	
   
   $.ajax({
		  url: 'drop.php',
		  data: 'user='+ userid +'&linqid='+ linqid +'&action=' + action +'&univ_id=<?php echo $university_id; ?>'+'&whoislogin='+whoislogin,
		  type: "POST",
		  success: function(json) {
		  //alert("Updated Successfully");
		  }
		  });
   });


$(document).delegate(".linqthis","mouseover",function(){
   
   var w = $(this).width();
  
   
   if($(this).val()==0){
   $(this).css({"background-color":"#88E062","background-repeat":"repeat-x","background-image":"linear-gradient(#88E062,#4FB91E)","color":"white","border":"1px solid #3B6E22","filter":"progid:DXImageTransform.Microsoft.gradient(startColorstr='#60D62D',endColorstr='#3DA50D',GradientType=0)"});
   }else{
   $(this).css({"background":"linear-gradient(#ff6666,#ff4d4d)","background-color":"#ff6666","color":"white","border":"1px solid #ff6666"});
	$(this).width(w);
	$(this).text("Drop");
   }
   
   
   
   });
$(document).delegate(".linqthis","mouseout",function(){
   var v00="";
   var v0="";
   var v1="";
   var v2="";
   if($(this).closest(".itemtype").hasClass("course")){
   v00="Add";
   v0="drop";
   v1="Drop";
   v2="I am in this class"
   }
   if($(this).closest(".itemtype").hasClass("community")){
   v00="Join";
   v0="drop";
   v1="Drop";
   v2="I am in this club"
   }
   if($(this).closest(".itemtype").hasClass("people")){
   v00="Linq";
   v0="drop";
   v1="Drop";
   v2="we are Linqed"
   }
   
   
   $(this).width("auto");
   
   
   if($(this).val()==0){
   $(this).css({"background":"linear-gradient(#fff,#ddd)","background-color":"#ddd","color":"black","border":"1px solid #ccc"});
   $(this).text(v00);
   }else{
   $(this).css({"background-color":"#60D62D","background-repeat":"repeat-x","background-image":"linear-gradient(#60D62D,#3DA50D)","color":"white","border":"1px solid #3B6E22"});
   $(this).text(v2);
   }
   
   
   
   });
   
$(document).delegate("#blackcanvas","click",function(e){
   
   if(($(e.target).is(".dropconfirm > *"))||($(e.target).is(".dropconfirm"))){return false;
   
   }
   
   $(this).hide();
   
   });
$(document).delegate("#dexit","mouseover",function(){
   
   $(this).css("opacity","1");
   });
$(document).delegate("#dexit","mouseout",function(){
   
   $(this).css("opacity","0.7");
   });
$(document).delegate("#dexit","click",function(){
   
   $("#blackcanvas").hide();
   });
});
</script>

</head>
<body>
<!-- People section start here -->
<?php 
$search="";
if(isset($_POST['search']) && $_POST['search']!=''){
	$search=$_POST['search'];
}
?>
	<div id="searchborder" class="peoplesearchborder">
	<form name="frmsearch" id="frmsearch" method="post" action="">
	<input type="text" id="searchbar"  placeholder="search by keywords" name="search" value="<?php echo $search; ?>" />
	<a href="Javascript:void(0)" onClick="Javascript:document.getElementById('frmsearch').submit();"><img src="images/search.png" id="searchbutton"></a>
	</form>
	</div>


<div class="clear"></div>
<section class="midsec tabpeople">
<?php
if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){
 ///// Get the student detail who is viewing this page means login student/////////////
	  $userdetail=getstudentdetail($_SESSION['student_id']);
	  $user_id=$userdetail['studentid'];
	  $user_deptid=$userdetail['deptid'];
	  $user_courses="";
	  $recordfound=0;
	  $search_student_cond="";
	  $search_course_cond="";
	  $search_professor_cond="";
	  if(isset($_POST['search']) && $_POST['search']!='')
	  {
		 $search_student_cond=" AND s.name LIKE '%".$_POST['search']."%'";
		 $search_professor_cond=" AND p.name LIKE '%".$_POST['search']."%'";
	  }
	  
	  ////////// Get courses students to list here /////////////
	  $usercourse="SELECT GROUP_CONCAT(`course_id`) AS course_ids FROM `student_courses_1` WHERE `student_id` ='".$_SESSION['student_id']."' AND `universityid` ='".$university_id."' ORDER BY `enrolltime` DESC";
	  $usercourseRes = $dbObj->fireQuery($usercourse,'select');
	  if(isset($usercourseRes) && count($usercourseRes)>0 && $usercourseRes!=false)
	  {
	  	$user_courses=$usercourseRes[0]['course_ids'];
	  }
	  
	  if(isset($search_student_cond) && $search_student_cond!=''){
	 	$StudentListQry = "select s.* from  student_1 s where s.studentid!='".$_SESSION['student_id']."' ".$search_student_cond." GROUP BY s.studentid order by s.name asc"; 
	  }
	  elseif($user_courses!='')
	  {
		$StudentListQry = "select s.* from  student_1 s,student_courses_1 sc where s.studentid!='".$_SESSION['student_id']."' and sc.student_id =s.studentid and sc.course_id IN (".$user_courses.") GROUP BY s.studentid order by s.name asc";
	  }
	  if(isset($StudentListQry) && $StudentListQry!='')	
	  {
	 	  $StudentListRes = $dbObj->fireQuery($StudentListQry,'select');
		  if(isset($StudentListRes) && count($StudentListRes)>0 && $StudentListRes!=false)
		  {
			for($s=0;$s<count($StudentListRes);$s++)
			{
				$stud_id=$StudentListRes[$s]['studentid'];
				$name=$StudentListRes[$s]['name'];
				$studdesc=$StudentListRes[$s]['studdesc'];
				$profilepic=$StudentListRes[$s]['profilepic'];
				$location=$StudentListRes[$s]['location'];
				$imagepath=$SITE_URL.'images/noimage.jpg';
				if(isset($profilepic) && $profilepic!='')
				{
					$filepath=$SITE_PATH.$location.'/'.$profilepic;
					if(file_exists($filepath))
					{
						$imagepath=$SITE_URL.$location.'/'.$profilepic;
					}
				}
				$isstudentlinqed=isstudentlinqed($_SESSION['student_id'],$stud_id);
				?>
				<div class="infofield people  itemtype" id="student_<?php echo $stud_id; ?>">
				<img src="<?php echo $imagepath; ?>" class="infopic">
				<div class="infotail">
					<div class="tailhead itemname"><a><?php echo $name; ?></a></div>
					<div class="moreinfo">Major: Politics</div>
					<div class="subinfo">
						<div class="subinfo_0"><?php echo $studdesc; ?></div>
						<div class="subinfo_1">Dummy info 2</div>
						<div class="subinfo_2">Dummy info 3</div>
					</div>
				<?php if($isstudentlinqed==1){ ?>
					<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-student_<?php echo $stud_id; ?>" value="1">we are Linqed</button>
				<?php }else{?>
					<button value="0" id="m-student_<?php echo $stud_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
				<?php }?>	
			   </div>
			 	</div>
			 <?php
			}
		  }
		  else{ $recordfound=1;}
	  }
	  
	  ///////// Get professor List here//////////////
	  if(isset($search_professor_cond) && $search_professor_cond!=''){
	  	$ProfessorListQry = "SELECT p.* FROM professor_1 p where 1=1 ".$search_professor_cond." GROUP BY p.profid order by p.profid asc";
	  }else{
	  	$ProfessorListQry = "SELECT p.* FROM professor_1 p,course_1 c where c.profid=p.profid and c.cid IN (".$user_courses.") GROUP BY p.profid order by p.profid asc";
	  }
	  $ProfessorListRes = $dbObj->fireQuery($ProfessorListQry,'select');
	  if(isset($ProfessorListRes) && count($ProfessorListRes)>0 && $ProfessorListRes!=false)
	  {
	  	$recordfound=0;
		for($p=0;$p<count($ProfessorListRes);$p++)
		{
			$profid=$ProfessorListRes[$p]['profid'];
			$name=$ProfessorListRes[$p]['name'];
			$profilepic=$ProfessorListRes[$p]['profilepic'];
			$profdesc=$ProfessorListRes[$p]['profdesc'];
			$location=$ProfessorListRes[$p]['location'];
			$deptid=$ProfessorListRes[$p]['deptid'];
			$imagepath=$SITE_URL.'images/noimage.jpg';
			$dept_name=getdepartmentdetail($deptid,'deptname');
			if(isset($profilepic) && $profilepic!='')
			{
				$filepath=$SITE_PATH.$location.'/'.$profilepic;
				if(file_exists($filepath))
				{
					$imagepath=$SITE_URL.$location.'/'.$profilepic;
				}
			}
			$isprofessorlinqed=isprofessorlinqed($_SESSION['student_id'],$profid);
			?>
			<div class="infofield people  itemtype" id="professor_<?php echo $profid; ?>">
				<img src="<?php echo $imagepath; ?>" class="infopic">
				<div class="infotail">
					<div class="tailhead itemname"><a><?php echo $name; ?></a></div>
					<div class="moreinfo">Major: <a href="index.php?pg=department&deptid=<?php echo $deptid; ?>&univid=<?php echo $university_id; ?>"><?php echo $dept_name; ?></a></div>
					<div class="subinfo">
						<div class="subinfo_0"><?php echo $profdesc; ?></div>
						<div class="subinfo_1">Dummy info 2</div>
						<div class="subinfo_2">Dummy info 3</div>
					</div>
				<?php if($isprofessorlinqed==1){ ?>
				<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="b-professor_<?php echo $profid; ?>" value="1">we are Linqed</button>
				<?php }else{?>
				<button value="0" id="b-professor_<?php echo $profid; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
				<?php }?>
			   </div>
			</div>
			<?php
		}
	  }

	  if($recordfound==1){
	  ?>
	  <div class="infofield people itemtype" style="height:50px !important;">
	  <center style="margin-top:10px;"><strong>No People Found.</strong></center>
	  </div>
	  <?php
	  }}
elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){
	  
	  $recordfound=1;
	  $userdetail=getprofessordetail($_SESSION['professor_id']);
	  $profid=$userdetail['profid'];
	  $prof_deptid=$userdetail['deptid'];
	  $prof_courses="";
	   
	   
	  $search_student_cond="";
	  $search_course_cond="";
	  $search_professor_cond="";
	  if(isset($_POST['search']) && $_POST['search']!='')
	  {
		 $search_student_cond=" AND s.name LIKE '%".$_POST['search']."%'";
		 $search_course_cond=" OR name LIKE '%".$_POST['search']."%'";
		 $search_professor_cond=" AND name LIKE '%".$_POST['search']."%'";
	  }
	  
	  ////////// Get courses students to list here /////////////
	  $profcourse="SELECT GROUP_CONCAT(`cid`) AS course_ids FROM `course_1` WHERE `profid` ='".$_SESSION['professor_id']."' AND `universityid` ='".$university_id."' ".$search_course_cond." ";
	  $profcourseRes = $dbObj->fireQuery($profcourse,'select');
	  if(isset($profcourseRes) && count($profcourseRes)>0 && $profcourseRes!=false)
	  {
	  	$prof_courses=$profcourseRes[0]['course_ids'];
	  }
	  if(isset($search_student_cond) && $search_student_cond!='')
	  {
	  	$StudentListQry = "select s.* from  student_1 s where 1=1 ".$search_student_cond." GROUP BY s.studentid order by s.name asc";
	  }
	  elseif($prof_courses!='')
	  {
		$StudentListQry = "select s.* from  student_1 s,student_courses_1 sc where  sc.student_id =s.studentid and sc.course_id IN (".$prof_courses.") ".$search_student_cond." GROUP BY s.studentid order by s.name asc";
	  }	
	  if(isset($StudentListQry) && $StudentListQry!='')
	  {
		 $StudentListRes = $dbObj->fireQuery($StudentListQry,'select');
		  if(isset($StudentListRes) && count($StudentListRes)>0 && $StudentListRes!=false)
		  {
		  	$recordfound=0;
			for($s=0;$s<count($StudentListRes);$s++)
			{
				$stud_id=$StudentListRes[$s]['studentid'];
				$name=$StudentListRes[$s]['name'];
				$studdesc=$StudentListRes[$s]['studdesc'];
				$profilepic=$StudentListRes[$s]['profilepic'];
				$location=$StudentListRes[$s]['location'];
				$imagepath=$SITE_URL.'images/noimage.jpg';
				if(isset($profilepic) && $profilepic!='')
				{
					$filepath=$SITE_PATH.$location.'/'.$profilepic;
					if(file_exists($filepath))
					{
						$imagepath=$SITE_URL.$location.'/'.$profilepic;
					}
				}
				$isstudentlinqed=professorlinqedstudent($_SESSION['professor_id'],$stud_id);
				?>
				<div class="infofield people  itemtype" id="student_<?php echo $stud_id; ?>">
				<img src="<?php echo $imagepath; ?>" class="infopic">
				<div class="infotail">
					<div class="tailhead itemname"><a><?php echo $name; ?></a></div>
					<div class="moreinfo">Major: Politics</div>
					<div class="subinfo">
						<div class="subinfo_0"><?php echo $studdesc; ?></div>
						<div class="subinfo_1">Dummy info 2</div>
						<div class="subinfo_2">Dummy info 3</div>
					</div>
				<?php if($isstudentlinqed==1){ ?>
					<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-student_<?php echo $stud_id; ?>" value="1">we are Linqed</button>
				<?php }else{?>
					<button value="0" id="m-student_<?php echo $stud_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
				<?php }?>	
			   </div>
			 	</div>
				<?php
			}
		  }
	  }	  
	 
	  ////////// Get professor who have same department to list here /////////////
	  if(isset($search_professor_cond) && $search_professor_cond!=''){
	 	 $ProfessorListQry = "SELECT p.* FROM professor_1 p where 1=1 ".$search_professor_cond." order by p.profid asc";
	  }else{
	 	 $ProfessorListQry = "select * from  professor_1 where deptid='".$prof_deptid."' and profid!='".$_SESSION['professor_id']."' order by name asc";
	  }
	  
	  $ProfessorListRes = $dbObj->fireQuery($ProfessorListQry,'select');
	  if(isset($ProfessorListRes) && count($ProfessorListRes)>0 && $ProfessorListRes!=false)
	  {
		  	$recordfound=0;
			for($s=0;$s<count($ProfessorListRes);$s++)
			{
				$profid=$ProfessorListRes[$s]['profid'];
				$name=$ProfessorListRes[$s]['name'];
				$profilepic=$ProfessorListRes[$s]['profilepic'];
				$location=$ProfessorListRes[$s]['location'];
				$imagepath=$SITE_URL.'images/noimage.jpg';
				$deptid=$ProfessorListRes[$s]['deptid'];
				$dept_name=getdepartmentdetail($deptid,'deptname');
				if(isset($profilepic) && $profilepic!='')
				{
					$filepath=$SITE_PATH.$location.'/'.$profilepic;
					if(file_exists($filepath))
					{
						$imagepath=$SITE_URL.$location.'/'.$profilepic;
					}
				}
				$isprofessorlinqed=professorlinqedprofessor($_SESSION['professor_id'],$profid);
				?>
				<div class="infofield people  itemtype" id="professor_<?php echo $profid; ?>">
				<img src="<?php echo $imagepath; ?>" class="infopic">
				<div class="infotail">
					<div class="tailhead itemname"><a><?php echo $name; ?></a></div>
					<div class="moreinfo"><a href="index.php?pg=department&deptid=<?php echo $deptid; ?>&univid=<?php echo $university_id; ?>"><?php echo $dept_name; ?></a></div>
					<div class="subinfo">
						<div class="subinfo_0">Dummy info 1</div>
						<div class="subinfo_1">Dummy info 2</div>
						<div class="subinfo_2">Dummy info 3</div>
					</div>
				<?php if($isprofessorlinqed==1){ ?>
					<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-professor_<?php echo $profid; ?>" value="1">we are Linqed</button>
				<?php }else{?>
					<button value="0" id="m-professor_<?php echo $profid; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
				<?php }?>	
			   </div>
			 	</div>
				<?php
			}
		  }
	  
	  
	  if($recordfound==1){
	  ?>
	  <div class="infofield people itemtype" style="height:50px !important;">
	  <center style="margin-top:10px;"><strong>No People Found.</strong></center>
	  </div>
	  <?php
	  } 
	  }
?>
</section>
<section id="blackcanvas">
  <div class="dropconfirm"><img src="images/exit-btn.png" id="dexit">
    <div id="dtext">Are you sure you want to</div>
    <button id="confirm-d" class="dbuttons-can" value="1">Drop</button>
    <button id="confirm-c" class="dbuttons" value="0">Cancel</button>
  </div>
</section>
</body>
</html>
<!-- People section end here -->
<script language="javascript" type="text/javascript">
window.parent.$(".tabcontentiframe").css("width","100%");
window.parent.$(".tabcontentiframe").css("min-height","1200px");
window.parent.$(".tabcontentiframe").css('overflow','auto');
</script>