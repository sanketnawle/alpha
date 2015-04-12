<?php 
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

<link rel="stylesheet" type="text/css" href="css/search.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>

<script src="http://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
<script src="js/sly-master/dist/sly.js"></script>
<!--<script src="sly-master/dist/sly.min.js"></script>-->
<script type="text/javascript" src="js/ajaxtabs.js"></script>
<script src="js/banner_new_9_3.js"></script>
<link rel="stylesheet" type="text/css" href="css/banner.css">
<!--<script src="jquery-mousewheel-master/jquery.mousewheel.js"></script>-->
<script language="javascript" type="text/javascript">
jQuery(function ($) {
	$('#frame').sly({horizontal: 1,vertical: 0,itemNav: 'basic',scrollSource: $("#all"),scrollBy: 1,dragging: 1,speed: 150,scrollBar: null,mouseDragging: 1,activateOn: 'click',startAt: 0,dragHandle: 1,easing:'swing',prevPage: $("#prev"),nextPage: $("#next")});
});
$(document).ready(function() {
        
        if($.browser.version==='534.57.7'){
          $(".linqthis").css("margin-left","10px");
        }
        function thumbnail_init()
        {
                $.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';
                  
                  $('.play').embedly({
                                                            query: {
                                                            maxwidth:"500px",
                                                            maxheight:"250px",
                                                            autoplay:false
                                                            },
                                                            display: function(data, elem){
                                                            //Adds the image to the a tag and then sets up the sizing.
                                                            $(elem).html('<img src="'+data.thumbnail_url+'"/><span></span>')
                                                            .width(data.thumbnail_width)
                                                            .height(data.thumbnail_height)
                                                            .find('span').css('top', data.thumbnail_height/2-36)
                                                            .css('left', data.thumbnail_width/2 - 36);
                                                            }
                                                            }).on('click', function(){
                                                                  // Handles the click event and replaces the link with the video.
                                                                  var data = $(this).data('embedly');
                                                              var a=    data.html.replace("//cdn","http://cdn");
                                                                  //alert(a);
                                                                  $(this).replaceWith(a);
                                                                  return false;
                                                                  });
                        }

                        thumbnail_init();


                   $(document).delegate(".tabs","click",function(){
           thumbnail_init();

           if($(this).attr("id")==="tab_0"){
              $("#calendar").show();
           }else{
              $("#calendar").hide();
           }

           });
                   

$(document).delegate(".p-hide","click",function(){
                                                   del = confirm("Do you want to hide the post?"); 
                                                   if(del){
                                                   $(this).closest(".post").hide();
                                                   }
                                                   });
$(document).delegate(".likepic","click",function(){
                                               if($(this).hasClass("liked"))
                                               {
                                               $(this).removeClass("liked");
                                               $(this).attr("src","images/like.png");
                                               
                                               return false;
                                               }else{
                                               $(this).toggleClass('liked');
                                               $(this).attr("src","images/liked-button.png");
                                               return false;
                                               }
                                               }); 

$(document).delegate("#frame > *","mouseover",function(){
                                                   //$("#prev").stop().fadeTo(200,1);
                                                   //$("#next").stop().fadeTo(200,1);
                                                   
                                                   var matrix = $('.slidee').css('transform');
												   if(matrix=='none'){
												  var x=0;
												  }else{
												   var values = matrix.match(/-?[0-9\.]+/g);
												   if(typeof values[4]!='undefined'){var x = values[4];}else{ var x=0;}
                                                   }
                                                   if(x==0){
                                                   $("#prev").fadeOut();
                                                   }else{
                                                   $("#prev").fadeIn();
                                                   }
                                                   
                                                   });

$(document).delegate("#frame > *","mouseout",function(){
                                                   //$("#prev").stop().fadeTo(200,0);
                                                   //$("#next").stop().fadeTo(200,0);
                                                   
                                                   var matrix = $('.slidee').css('transform');
                                                  if(matrix=='none'){
												  var x=0;
												  }else{
												   var values = matrix.match(/-?[0-9\.]+/g);
                                                   if(typeof values[4]!='undefined'){var x = values[4];}else{ var x=0;}
                                                   }
                                                   if(x==0){
                                                   $("#prev").fadeOut();
                                                   }else{
                                                   $("#prev").fadeIn();
                                                   }
                                                   
                                                   });
                              
$(document).delegate("#next","click",function(){
                                                   $("#prev").fadeIn();
                                                   });
                              
$(document).mousewheel(function(e) {
                                                     
                                                     var matrix = $('.slidee').css('transform');
													 if(matrix=='none'){
													 var x=0;
													 }else{
                                                     var values = matrix.match(/-?[0-9\.]+/g);
                                                      if(typeof values[4]!='undefined'){var x = values[4];}else{ var x=0;}
                                                    }	 
                                                     //alert(matrix+" "+x);
                                                     
                                                     if(x==0){
                                                     $("#prev").fadeOut();
                                                     }else{
                                                     $("#prev").fadeIn();
                                                     }
                                                     
                                                     
                                                     });

$(document).delegate(".memmain","mouseover",function(){
   $(this).css({"background-color":"#ffffff"});
   $(this).find(".memicon").css({"width":"107%","height":"107%","opacity":"0.84"});
   
   $(this).find(".memicon").css({"margin-top":"-8px","margin-left":"-8px"});
   
   });
$(document).delegate(".memmain","mouseout",function(){
   $(this).css("background-color","#FFFFFF");
   $(this).find(".memicon").css({"width":"100%","height":"100%","opacity":"1"});
   
   $(this).find(".memicon").css({"margin-top":"0px","margin-left":"0px"});
   
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
   } });

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
  
   
   if($(this).val()===0){
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
<?php include_once('include/header.php'); ?>
<section id="searchinfo">
  <div id="si-mid">
  	<a class="blackhref1 tabs" id="tabs_all" rel="#default" href="#">All</a>
	<a class="blackhref1 tabs" id="tabs_people" rel="#iframe" href="search_people.php?univid=<?php echo $university_id; ?>">People</a>
	<a class="blackhref1 tabs" id="tabs_course" rel="#iframe" href="search_course.php?univid=<?php echo $university_id; ?>">Courses</a>
	<a class="blackhref1 tabs" id="tabs_community" rel="#iframe" href="search_club.php?univid=<?php echo $university_id; ?>">Clubs</a>
  </div>
</section>

<div id="midsearchsec">
<!-- Scroll Images section start here -->
<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){?>
<section id="all" class="taball">
  <div id="prev"> <span> <img class = "hor-scroll-arrows" src = "images/left-arrow.gif"> </span> </div>
  <div id="next"> <span> <img class = "hor-scroll-arrows" src = "images/right-arrow.gif"> </span></div>
  <div id="frame" class="frame">
    <ul class="slidee">
      <li class="slideeheader"> </li>
      <!--for every .memmain here, the unique id is required, this id should directly come from back end, unlike the id in calendar page, this unique id should be generated in backend I think-->
      <?php
	  ///// Get the student detail who is viewing this page means login student/////////////
	  $userdetail=getstudentdetail($_SESSION['student_id']);
	  $user_id=$userdetail['studentid'];
	  $user_deptid=$userdetail['deptid'];
	  $user_courses="";
	  
	  $search_student_cond="";
	  $search_course_cond="";
	  $search_professor_cond="";
	  $search_group_cond="";
	  if(isset($_POST['search']) && $_POST['search']!='')
	  {
		 $search_student_cond=" AND s.name LIKE '%".$_POST['search']."%'";
		 $search_course_cond=" AND c.name LIKE '%".$_POST['search']."%'";
	  	 $search_professor_cond=" AND p.name LIKE '%".$_POST['search']."%'";
	  	 $search_group_cond=" AND g.groupname LIKE '%".$_POST['search']."%' ";
	  }
	  
	  ////////// Get courses students to list here /////////////
	  $usercourse="SELECT GROUP_CONCAT(`course_id`) AS course_ids FROM `student_courses_1` WHERE `student_id` ='".$_SESSION['student_id']."' AND `universityid` ='".$university_id."' ORDER BY `enrolltime` DESC";
	  $usercourseRes = $dbObj->fireQuery($usercourse,'select');
	  if(isset($usercourseRes) && count($usercourseRes)>0 && $usercourseRes!=false)
	  {
	  	$user_courses=$usercourseRes[0]['course_ids'];
	  }
	  
	  if(isset($search_student_cond) && $search_student_cond!=''){
	  	 $StudentListQry = "select s.* from  student_1 s where s.studentid!='".$_SESSION['student_id']."' ".$search_student_cond." order by s.name asc";
	  }
	  elseif($user_courses!='')
	  {
		 $StudentListQry = "select s.* from  student_1 s,student_courses_1 sc where s.studentid!='".$_SESSION['student_id']."' and sc.student_id =s.studentid and sc.course_id IN (".$user_courses.") GROUP BY s.studentid order by s.name asc";
	  }	
	  if(isset($StudentListQry) && $StudentListQry!=''){
		 $StudentListRes = $dbObj->fireQuery($StudentListQry,'select');
		  if(isset($StudentListRes) && count($StudentListRes)>0 && $StudentListRes!=false)
		  {
			for($s=0;$s<count($StudentListRes);$s++)
			{
				$stud_id=$StudentListRes[$s]['studentid'];
				$name=$StudentListRes[$s]['name'];
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
				<li>
					<div class="memmain people itemtype" id="student_<?php echo $stud_id; ?>">
					<div class="iconframe"> <img src="<?php echo $imagepath; ?>" class="memicon"> </div>
					<div class="memdes"><a href="" class="blackhref itemname"><?php echo $name; ?></a><br>
						<a href="" id = "blackhref3" class="blackhref">Major: <span class="keyword">Politics</span></a> </div>
					<div class="memtails"> </div>
					<?php if($isstudentlinqed==1){ ?>
					<button class="linqthis linqed" id="m-student_<?php echo $stud_id; ?>" value="1">we are Linqed</button>
					<?php }else{?>
					<button value="0" id="m-student_<?php echo $stud_id; ?>" class="linqthis">Linq</button>
					<?php }?>
					</div>
				</li>
				<?php
			}
		  }
	 } 
	  ///////// Get professor List here//////////////
	  if(isset($search_professor_cond) && $search_professor_cond!=''){
	 	 $ProfessorListQry = "SELECT p.* FROM professor_1 p where 1=1 ".$search_professor_cond." order by p.profid asc";
	  }elseif($user_courses!=''){
	 	 $ProfessorListQry = "SELECT p.* FROM professor_1 p,course_1 c where c.profid=p.profid and c.cid IN (".$user_courses.") GROUP BY p.profid order by p.profid asc";
	  }
	  if(isset($ProfessorListQry) && $ProfessorListQry!='')
	  {
		  $ProfessorListRes = $dbObj->fireQuery($ProfessorListQry,'select');
		  if(isset($ProfessorListRes) && count($ProfessorListRes)>0 && $ProfessorListRes!=false)
		  {
			
			for($p=0;$p<count($ProfessorListRes);$p++)
			{
				$profid=$ProfessorListRes[$p]['profid'];
				$name=$ProfessorListRes[$p]['name'];
				$profilepic=$ProfessorListRes[$p]['profilepic'];
				$location=$ProfessorListRes[$p]['location'];
				$deptid=$ProfessorListRes[$p]['deptid'];
				$dept_name=getdepartmentdetail($deptid,'deptname');
				
				$imagepath=$SITE_URL.'images/noimage.jpg';
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
				<li>
					<div class="memmain people itemtype" id="professor_<?php echo $profid; ?>">
					<div class="iconframe"> <img src="<?php echo $imagepath; ?>" class="memicon"> </div>
					<div class="memdes"><a href="" class="blackhref itemname"><?php echo $name; ?></a><br>
						<a href="index.php?pg=department&deptid=<?php echo $deptid; ?>&univid=<?php echo $university_id; ?>" id = "blackhref3" class="blackhref"><span class="keyword"><?php echo $dept_name; ?></span></a> </div>
					<div class="memtails"> </div>
					<?php if($isprofessorlinqed==1){ ?>
					<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-professor_<?php echo $profid; ?>" value="1">we are Linqed</button>
					<?php }else{?>
					<button value="0" id="m-professor_<?php echo $profid; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
					<?php }?>
					</div>
				</li>
				<?php
			}
		  }
	  }
	  
	  ///////// Get Courses List here//////////////
	  if(isset($search_course_cond) && $search_course_cond!=''){
	  	$CoursesListQry = "select * from  course_1 c where c.universityid='".$university_id."' ". $search_course_cond." order by c.name asc";
	  }else{
	  	$CoursesListQry = "select * from  course_1 c where c.universityid='".$university_id."' and c.deptid='".$user_deptid."' order by c.name asc";
	  }		  
	  $CoursesListRes = $dbObj->fireQuery($CoursesListQry,'select');
	  if(isset($CoursesListRes) && count($CoursesListRes)>0 && $CoursesListRes!=false)
	  {
		for($c=0;$c<count($CoursesListRes);$c++)
		{
			$cid =$CoursesListRes[$c]['cid'];
			$courseid=$CoursesListRes[$c]['courseid'];
			$name=$CoursesListRes[$c]['name'];
			$coursepic=$CoursesListRes[$c]['coursepic'];
			$location=$CoursesListRes[$c]['imagepath'];
			
			$imagepath=$SITE_URL.'images/noimage.jpg';
			if(isset($coursepic) && $coursepic!='')
			{
				$filepath=$SITE_PATH.$location.'/'.$coursepic;
				if(file_exists($filepath))
				{
					$imagepath=$SITE_URL.$location.'/'.$coursepic;
				}
			}
			$iscoursenrolled=enrolledincourse($_SESSION['student_id'],$cid,$university_id);
			?>
			<li>
        		<div class="memmain course itemtype" id="courses_<?php echo $cid; ?>">
          		<div class="iconframe"> <img src="<?php echo $imagepath; ?>" class="memicon"> </div>
          		<div class="memdes"><a href="" class="blackhref itemname"><?php echo $name; ?></a><br></div>
          		<div class="memtails"> </div>
				<?php if($iscoursenrolled==1){ ?>
				<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-courses_<?php echo $cid; ?>" value="1">I am in this class</button>
				<?php }else{?>
				<button value="0" id="m-courses_<?php echo $cid; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Add</button>
				<?php }?>
        		</div>
     		</li>
			<?php
		}
	  }
	  
	 ///////// Get All clubs according to University /////////////////////////////////
	 if(isset($search_group_cond) && $search_group_cond!=''){
	  	$clubssel_sql="SELECT g.*,ga.* FROM groups_1 g,groups_admin_1 ga WHERE g.groupid=ga.groupid and g.universityid='".$university_id."' ".$search_group_cond."";
	 }else{
	  	$clubssel_sql="SELECT g.*,ga.* FROM groups_1 g,groups_admin_1 ga WHERE g.groupid=ga.groupid and g.universityid='".$university_id."' ";
	 }
	 $clubsRes = $dbObj->fireQuery($clubssel_sql,'select');
	 if(isset($clubsRes) && count($clubsRes)>0 && $clubsRes!=false)
	 {
		for($c=0;$c<count($clubsRes);$c++)
		{
			$club_id=$clubsRes[$c]['groupid'];
			$clubname=$clubsRes[$c]['groupname'];
			$profid=$clubsRes[$c]['profid'];
			$name=$clubsRes[$c]['name'];
			$club_desc=$clubsRes[$c]['groupdesc'];
			$imagepath=$SITE_URL.'images/noimage.jpg';
			$isclubjoined=clubjoined($club_id);
			?>
			<li>
			 <div class="memmain community itemtype" id="clubs_<?php echo $club_id; ?>">
             	<div class="iconframe"><img src="<?php echo $imagepath; ?>" class="memicon"></div>
                <div class="memdes"><a href="" class="blackhref itemname"><span class="keyword"><?php echo $clubname; ?></span></a><br></div>
                <div class="memtails"></div>
				<?php if($isclubjoined==1){ ?>
				<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-clubs_<?php echo $club_id; ?>" value="1">I am in this club</button>
				<?php }else{?>
				<button value="0" id="m-clubs_<?php echo $club_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Join</button>
				<?php }?>
             </div>
             </li>
			<?php
		}
	 }
	 ?>
	 </ul>
  </div>
</section>
<?php }
elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){?>
<section id="all" class="taball">
  <div id="prev"> <span> <img class = "hor-scroll-arrows" src = "images/left-arrow.gif"> </span> </div>
  <div id="next"> <span> <img class = "hor-scroll-arrows" src = "images/right-arrow.gif"> </span></div>
  <div id="frame" class="frame">
    <ul class="slidee">
      <li class="slideeheader"> </li>
      <!--for every .memmain here, the unique id is required, this id should directly come from back end, unlike the id in calendar page, this unique id should be generated in backend I think-->
      <?php
	  ///// Get the student detail who is viewing this page means login student/////////////
	  $userdetail=getprofessordetail($_SESSION['professor_id']);
	  $profid=$userdetail['profid'];
	  $prof_deptid=$userdetail['deptid'];
	  $prof_courses="";
	  
	  $search_course_cond="";
	  $search_student_cond="";
	  $search_group_cond="";
	  $search_professor_cond="";
	  if(isset($_POST['search']) && $_POST['search']!='')
	  {
		 $search_course_cond=" AND name LIKE '%".$_POST['search']."%'";
		 $search_student_cond=" AND s.name LIKE '%".$_POST['search']."%'";
		 $search_group_cond=" AND g.groupname LIKE '%".$_POST['search']."%' ";
		 $search_professor_cond=" AND name LIKE '%".$_POST['search']."%'";
	  }

	  
	  ////////// Get courses students to list here /////////////
	  $profcourse="SELECT GROUP_CONCAT(`cid`) AS course_ids FROM `course_1` WHERE `profid` ='".$_SESSION['professor_id']."' AND `universityid` ='".$university_id."'";
	  $profcourseRes = $dbObj->fireQuery($profcourse,'select');
	  if(isset($profcourseRes) && count($profcourseRes)>0 && $profcourseRes!=false)
	  {
	  	$prof_courses=$profcourseRes[0]['course_ids'];
	  }
	  if(isset($search_student_cond) && $search_student_cond!=''){
	  	$StudentListQry = "select s.* from  student_1 s where 1=1 ".$search_student_cond." order by s.name asc";
	  }elseif($prof_courses!=''){
		 $StudentListQry = "select s.* from  student_1 s,student_courses_1 sc where  sc.student_id =s.studentid and sc.course_id IN (".$prof_courses.") ".$search_student_cond." GROUP BY s.studentid order by s.name asc";
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
					<li>
						<div class="memmain people itemtype" id="student_<?php echo $stud_id; ?>">
						<div class="iconframe"> <img src="<?php echo $imagepath; ?>" class="memicon"> </div>
						<div class="memdes"><a href="" class="blackhref itemname"><?php echo $name; ?></a><br>
							<a href="" id = "blackhref3" class="blackhref">Major: <span class="keyword">Politics</span></a> </div>
						<div class="memtails"> </div>
						<?php if($isstudentlinqed==1){ ?>
						<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-student_<?php echo $stud_id; ?>" value="1">we are Linqed</button>
						<?php }else{?>
						<button value="0" id="m-student_<?php echo $stud_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
						<?php }?>
						</div>
					</li>
					<?php
				}
			  }
	  }
	  ////////// Get professor who have same department to list here /////////////
	  if(isset($search_professor_cond) && $search_professor_cond!=''){	
	  	$ProfessorListQry = "select * from  professor_1 where profid!='".$_SESSION['professor_id']."' ".$search_professor_cond." order by name asc";
	  }else{
	  	$ProfessorListQry = "select * from  professor_1 where deptid='".$prof_deptid."' and profid!='".$_SESSION['professor_id']."'  order by name asc";
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
				$deptid=$ProfessorListRes[$s]['deptid'];
				$dept_name=getdepartmentdetail($deptid,'deptname');
				$imagepath=$SITE_URL.'images/noimage.jpg';
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
				<li>
					<div class="memmain people itemtype" id="student_<?php echo $profid; ?>">
					<div class="iconframe"> <img src="<?php echo $imagepath; ?>" class="memicon"> </div>
					<div class="memdes"><a href="" class="blackhref itemname"><?php echo $name; ?></a><br>
						<a href="index.php?pg=department&deptid=<?php echo $deptid; ?>&univid=<?php echo $university_id; ?>" id = "blackhref3" class="blackhref"><span class="keyword"><?php echo $dept_name; ?></span></a> </div>
					<div class="memtails"> </div>
					<?php if($isprofessorlinqed==1){ ?>
					<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-professor_<?php echo $profid; ?>" value="1">we are Linqed</button>
					<?php }else{?>
					<button value="0" id="m-professor_<?php echo $profid; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
					<?php }?>
					</div>
				</li>
				<?php
			}
		  }
		  
	  ///////// Get Courses List here//////////////
	 if(isset($search_course_cond) && $search_course_cond!=''){
	 	$CoursesListQry = "select * from  course_1 where universityid='".$university_id."' ".$search_course_cond." order by name asc";
	 }else{
	 	$CoursesListQry = "select * from  course_1 where universityid='".$university_id."' and deptid='".$prof_deptid."' order by name asc";
	 }
	 $CoursesListRes = $dbObj->fireQuery($CoursesListQry,'select');
	 if(isset($CoursesListRes) && count($CoursesListRes)>0 && $CoursesListRes!=false)
	 {
		for($c=0;$c<count($CoursesListRes);$c++)
		{
			$cid =$CoursesListRes[$c]['cid'];
			$courseid=$CoursesListRes[$c]['courseid'];
			$name=$CoursesListRes[$c]['name'];
			$profid=$CoursesListRes[$c]['profid'];
			$coursepic=$CoursesListRes[$c]['coursepic'];
			$location=$CoursesListRes[$c]['imagepath'];
			
			$imagepath=$SITE_URL.'images/noimage.jpg';
			if(isset($coursepic) && $coursepic!='')
			{
				$filepath=$SITE_PATH.$location.'/'.$coursepic;
				if(file_exists($filepath))
				{
					$imagepath=$SITE_URL.$location.'/'.$coursepic;
				}
			}
			
			?>
			<li>
        		<div class="memmain course itemtype" id="courses_<?php echo $cid; ?>">
          		<div class="iconframe"> <img src="<?php echo $imagepath; ?>" class="memicon"> </div>
          		<div class="memdes"><a href="" class="blackhref itemname"><?php echo $name; ?></a><br></div>
          		<div class="memtails"> </div>
				<?php 
				if($_SESSION['professor_id']==$profid){?><button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="b-courses_<?php echo $cid; ?>" value="1">I am in this class</button><?php	
				}else{ ?><button value="0" id="b-courses_<?php echo $cid; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Add</button><?php } ?>
				</div>
     		</li>
			<?php
		}
	  }
	  
	  ///////// Get All clubs according to University /////////////////////////////////
	 $clubssel_sql="SELECT g.*,ga.* FROM groups_1 g,groups_admin_1 ga WHERE g.groupid=ga.groupid and g.universityid='".$university_id."' ".$search_group_cond." ";
	 $clubsRes = $dbObj->fireQuery($clubssel_sql,'select');
	 if(isset($clubsRes) && count($clubsRes)>0 && $clubsRes!=false)
	 {
		for($c=0;$c<count($clubsRes);$c++)
		{
			$club_id=$clubsRes[$c]['groupid'];
			$clubname=$clubsRes[$c]['groupname'];
			$profid=$clubsRes[$c]['profid'];
			$name=$clubsRes[$c]['name'];
			$club_desc=$clubsRes[$c]['groupdesc'];
			$imagepath=$SITE_URL.'images/noimage.jpg';
			$isclubjoined=clubjoined($club_id);
			?>
			<li>
			 <div class="memmain community itemtype" id="clubs_<?php echo $club_id; ?>">
             	<div class="iconframe"><img src="<?php echo $imagepath; ?>" class="memicon"></div>
                <div class="memdes"><a href="" class="blackhref itemname"><span class="keyword"><?php echo $clubname; ?></span></a><br></div>
                <div class="memtails"></div>
				<?php if($isclubjoined==1){ ?>
				<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="m-clubs_<?php echo $club_id; ?>" value="1">I am in this club</button>
				<?php }else{?>
				<button value="0" id="m-clubs_<?php echo $club_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Join</button>
				<?php }?>
             </div>
             </li>
			<?php
		}
	 }
	 ?>
	 </ul>
  </div>
</section><?php }?>
<!-- Scroll Images section end here -->
<section ><!-- class="midsec taball" -->
  <section class="resultname"><span>Posts about Politics</span></section>
  <div id="entry0">
    <div class="post havepic"> <img class="p-hide" src="images/exit-btn.png">
      <button class="post_tag tags">Urlinq Event
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img src="http://urlinq.com/DEMO//uploaded/student/rosskopes.jpg" class="post_photo">
        <div class="post_name">Ross</div>
        <div class="post_des">Shared in <span class="cname">Early American <span class="keyword">Politics</span></span>  &#183; 20 mins ago</div>
      </div>
      <div class="post_text">
        <div class="post_say">This is a great political article for everyone! <a href="http://www.youtube.com/watch?v=K305Vu7hFg0">http://www.youtube.com/watch?v=K305Vu7hFg0</a></div>
      </div>
      <div class="post_content"> <a class="play" href="http://www.nytimes.com/2014/01/21/opinion/brooks-the-art-of-presence.html?src=me&_r=0"></a> </div>
      <div class="like"> <a href=""><img src="images/like.png" class="likepic" class="like_butt"></a>
        <div class="likes">2</div>
      </div>
      <div class="comment">
        <div class="cmt-view">
          <div class="cmt_head"><img src="http://urlinq.com/DEMO//uploaded/student/shaleensphoto.jpg" class="cmt-photo"><span class="cmt-name">Ross</span> <span class="time">  &#183; 20 mins ago</span></div>
          <div class="cmt-tail">alalks</div>
        </div>
        <a href="">
        <div class="viewmore">View More</div>
        </a>
        
        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>

      </div>
    </div>
    <div class="post"> <img class="p-hide" src="images/exit-btn.png">
      <button class="post_tag tags">Urlinq Event
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img src="http://urlinq.com/DEMO//uploaded/student/rosskopes.jpg" class="post_photo">
        <div class="post_name">Ross</div>
        <div class="post_des">Shared in <span class="cname">Early American <span class="keyword">Politics</span></span>  &#183; 20 mins ago</div>
      </div>
      <div class="post_text">
        <div class="post_say">This is a great political article for everyone! </div>
      </div>
      <div class="post_content"> </div>
      <div class="like"> <a href=""><img src="images/like.png" class="likepic" class="like_butt"></a>
        <div class="likes">2</div>
      </div>
      <div class="comment">
        <div class="cmt-view">
          <div class="cmt_head"><img src="http://urlinq.com/DEMO//uploaded/student/shaleensphoto.jpg" class="cmt-photo"><span class="cmt-name">Ross</span> <span class="time">  &#183; 20 mins ago</span></div>
          <div class="cmt-tail">alalks</div>
        </div>
        <a href="">
        <div class="viewmore">View More</div>
        </a>

        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>

      </div>
    </div>
    <div class="post"> <img class="p-hide" src="images/exit-btn.png">
      <button class="post_tag tags">Urlinq Event
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img src="http://urlinq.com/DEMO//uploaded/student/rosskopes.jpg" class="post_photo">
        <div class="post_name">Ross</div>
        <div class="post_des">Shared in <span class="cname">Early American <span class="keyword">Politics</span></span>   &#183; 20 mins ago</div>
      </div>
      <div class="post_text">
        <div class="post_say">This is a great political article for everyone! </div>
      </div>
      <div class="post_content"> </div>
      <div class="like"> <a href=""><img src="images/like.png" class="likepic" class="like_butt"></a>
        <div class="likes">2</div>
      </div>
      <div class="comment">
        <div class="cmt-view">
          <div class="cmt_head"><img src="http://urlinq.com/DEMO//uploaded/student/shaleensphoto.jpg" class="cmt-photo"><span class="cmt-name">Ross</span> <span class="time">  &#183; 20 mins ago</span></div>
          <div class="cmt-tail">alalks</div>
        </div>
        <a href="">
        <div class="viewmore">View More</div>
        </a>

        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>


      </div>
    </div>
  </div>
  <div id="entry1">
    <div class="post"> <img class="p-hide" src="images/exit-btn.png">
      <button class="post_tag tags">Urlinq Event
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img src="http://urlinq.com/DEMO//uploaded/student/rosskopes.jpg" class="post_photo">
        <div class="post_name">Ross</div>
        <div class="post_des">Shared in <span class="cname">Early American <span class="keyword">Politics</span></span>   &#183; 20 mins ago</div>
      </div>
      <div class="post_text">
        <div class="post_say">This is a great political article for everyone! </div>
      </div>
      <div class="post_content"> </div>
      <div class="like"> <a href=""><img src="images/like.png" class="likepic" class="like_butt"></a>
        <div class="likes">2</div>
      </div>
      <div class="comment">
        <div class="cmt-view">
          <div class="cmt_head"><img src="http://urlinq.com/DEMO//uploaded/student/shaleensphoto.jpg" class="cmt-photo"><span class="cmt-name">Ross</span> <span class="time">  &#183; 20 mins ago</span></div>
          <div class="cmt-tail">alalks</div>
        </div>
        <a href="">
        <div class="viewmore">View More</div>
        </a>

        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>

      </div>
    </div>
    <div class="post"> <img class="p-hide" src="images/exit-btn.png">
      <button class="post_tag tags">Urlinq Event
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img src="http://urlinq.com/DEMO//uploaded/student/rosskopes.jpg" class="post_photo">
        <div class="post_name">Ross</div>
        <div class="post_des">Shared in <span class="cname">Early American <span class="keyword">Politics</span></span>  &#183; 20 mins ago</div>
      </div>
      <div class="post_text">
        <div class="post_say">This is a great political article for everyone! </div>
      </div>
      <div class="post_content"> </div>
      <div class="like"> <a href=""><img src="images/like.png" class="likepic" class="like_butt"></a>
        <div class="likes">2</div>
      </div>
      <div class="comment">
        <div class="cmt-view">
          <div class="cmt_head"><img src="http://urlinq.com/DEMO//uploaded/student/shaleensphoto.jpg" class="cmt-photo"><span class="cmt-name">Ross</span> <span class="time">  &#183; 20 mins ago</span></div>
          <div class="cmt-tail">alalks</div>
        </div>
        <a href="">
        <div class="viewmore">View More</div>
        </a>

        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>

      </div>
    </div>
    <div class="post"> <img class="p-hide" src="images/exit-btn.png">
      <button class="post_tag tags">Urlinq Event
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img src="http://urlinq.com/DEMO//uploaded/student/rosskopes.jpg" class="post_photo">
        <div class="post_name">Ross</div>
        <div class="post_des">Shared in <span class="cname">Early American <span class="keyword">Politics</span></span>  &#183; 20 mins ago</div>
      </div>
      <div class="post_text">
        <div class="post_say">This is a great political article for everyone! </div>
      </div>
      <div class="post_content"> </div>
      <div class="like"> <a href=""><img src="images/like.png" class="likepic" class="like_butt"></a>
        <div class="likes">2</div>
      </div>
      <div class="comment">
        <div class="cmt-view">
          <div class="cmt_head"><img src="http://urlinq.com/DEMO//uploaded/student/shaleensphoto.jpg" class="cmt-photo"><span class="cmt-name">Ross</span> <span class="time">  &#183; 20 mins ago</span></div>
          <div class="cmt-tail">alalks</div>
        </div>
        <a href="">
        <div class="viewmore">View More</div>
        </a>

        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>

        </div>
    </div>
    <div class="post"> <img class="p-hide" src="images/exit-btn.png">
      <button class="post_tag tags">Urlinq Event
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img src="http://urlinq.com/DEMO//uploaded/student/rosskopes.jpg" class="post_photo">
        <div class="post_name">Ross</div>
        <div class="post_des">Shared in <span class="cname">Early American <span class="keyword">Politics</span>  &#183; 20 mins ago</div>
      </div>
      <div class="post_text">
        <div class="post_say">This is a great political article for everyone! </div>
      </div>
      <div class="post_content"> </div>
      <div class="like"> <a href=""><img src="images/like.png" class="likepic" class="like_butt"></a>
        <div class="likes">2</div>
      </div>
      <div class="comment">
        <div class="cmt-view">
          <div class="cmt_head"><img src="http://urlinq.com/DEMO//uploaded/student/shaleensphoto.jpg" class="cmt-photo"><span class="cmt-name">Ross</span> <span class="time">  &#183; 20 mins ago</span></div>
          <div class="cmt-tail">alalks</div>
        </div>
        <a href="">
        <div class="viewmore">View More</div>
        </a>
        
        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>


        </div>
    </div>
  </div>
</section>
</div>

<section id="blackcanvas">
  <div class="dropconfirm"><img src="images/exit-btn.png" id="dexit">
    <div id="dtext">Are you sure you want to</div>
    <button id="confirm-d" class="dbuttons-can" value="1">Drop</button>
    <button id="confirm-c" class="dbuttons" value="0">Cancel</button>
  </div>
</section>
</body>
</html>
<script type="text/javascript">
$("#tabs_all").addClass("blackhref1 tabs");
$("#tabs_people").addClass("blackhref1 tabs");
$("#tabs_course").addClass("blackhref1 tabs");
$("#tabs_community").addClass("blackhref1 tabs");
var countries=new ddajaxtabs("si-mid", "midsearchsec")
countries.setpersist(false)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()
<?php if(isset($_GET['act']) && $_GET['act']=='course'){ ?>
countries.expandit('tabs_course')
<?php }elseif(isset($_GET['act']) && $_GET['act']=='club'){ ?>
countries.expandit('tabs_community')
<?php }elseif(isset($_GET['act']) && $_GET['act']=='people'){?>
countries.expandit('tabs_people')
<?php }elseif(isset($_GET['act']) && $_GET['act']=='all'){?>
countries.expandit('tabs_all')
<?php }else{?>
countries.expandit('tabs_all')
<?php }?>
</script>