<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<?php 
$university_id=1;
$department_id=$_GET['deptid'];

$enrollcouListRes='';
$enrollclubListRes='';
$facultyListRes='';
$coursesListRes='';
if(isset($_SESSION['usertype']) && $_SESSION['usertype']!='')
{
//////// Get all faculaty profressor for this department.
$facultyListQry = "select * from professor_1 where deptid='".$department_id."' order by name asc ";
$facultyListRes = $dbObj->fireQuery($facultyListQry,'select');

//////// Get all courses for this department.
$coursesListQry = "select * from course where deptid='".$department_id."' order by name asc ";
$coursesListRes = $dbObj->fireQuery($coursesListQry,'select');

}

if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
{
	$student_id=$_SESSION['student_id'];
	$userdetail=getstudentdetail($student_id);
	
	//////// Get all courses in which login user enrolled ////////
	$enrollcouListQry = "select c.* from  student_courses_1 sc,course c where sc.course_id=c.cid and sc.student_id='".$student_id."' and sc.status='Active' order by c.name asc ";
	$enrollcouListRes = $dbObj->fireQuery($enrollcouListQry,'select');
	//////// Get all clubs in which login user enrolled ////////
	$enrollclubListQry = "select c.* from   student_clubs_1 sc,clubs c where sc.club_id=c.clubid and sc.student_id='".$student_id."' and sc.status='Active' order by c.name asc ";
	$enrollclubListRes = $dbObj->fireQuery($enrollclubListQry,'select');
}
elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
{
	$professor_id=$_SESSION['professor_id'];
	$userdetail=getprofessordetail($professor_id);
	
	//////// Get all courses in which login user enrolled ////////
	$enrollcouListQry = "select c.* from  professor_courses_1 pc,course c where pc.course_id=c.cid and pc.prof_id='".$professor_id."' and pc.status='Active' order by c.name asc ";
	$enrollcouListRes = $dbObj->fireQuery($enrollcouListQry,'select');
	
	//////// Get all clubs in which login user enrolled ////////
	$enrollclubListQry = "select c.* from   professor_clubs_1 pc,clubs c where pc.club_id=c.clubid and pc.professor_id='".$professor_id."' and pc.status='Active' order by c.name asc ";
	$enrollclubListRes = $dbObj->fireQuery($enrollclubListQry,'select');

}

?>
<script language="javascript" type="text/javascript">
var facultyLists=new Array();
var coursesLists=new Array();
var enrollcourse= new Array();
var enrollclubs= new Array();
var deptid=<?php echo $department_id;?>;

<?php
if(isset($facultyListRes) && count($facultyListRes)>0 && $facultyListRes!=false)
{
		for($i=0;$i<count($facultyListRes);$i++) 
		{
			$profid = $facultyListRes[$i]['profid'];
			$name   = $facultyListRes[$i]['name'];
			$email   = $facultyListRes[$i]['email'];
			$contact   = $facultyListRes[$i]['contact'];
			$profilepic   = $facultyListRes[$i]['profilepic'];
			$location   = $facultyListRes[$i]['location'];
			$profdesc   = $facultyListRes[$i]['profdesc'];
			$imagepath=$SITE_URL.'images/noimage.jpg';
			if(isset($profilepic) && $profilepic!='')
			{
				$filepath=$SITE_PATH.$location.'/'.$profilepic;
				if(file_exists($filepath))
				{
					$imagepath=$SITE_URL.$location.'/'.$profilepic;
				}
			}
			?>
			facultyLists[<?php echo $i; ?>]="<?php echo $name; ?>==<?php echo $profdesc;?>==<?php echo $imagepath;?>";
			<?php
		}
	}
?>
<?php
if(isset($coursesListRes) && count($coursesListRes)>0 && $coursesListRes!=false)
{
		for($i=0;$i<count($coursesListRes);$i++) 
		{
			$profid = $coursesListRes[$i]['profid'];
			$courseid 	=$coursesListRes[$i]['courseid'];
			$name   = $coursesListRes[$i]['name'];
			$coursepic   = $coursesListRes[$i]['coursepic'];
			$location   = $coursesListRes[$i]['imagepath'];
			$coursedesc   = $coursesListRes[$i]['desc'];
			
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
			coursesLists[<?php echo $i; ?>]="<?php echo $name; ?>==<?php echo $coursedesc;?>==<?php echo $imagepath;?>==<?php echo $courseid ;?>";
			<?php
		}
	}
?>
<?php
if(isset($enrollcouListRes) && count($enrollcouListRes)>0 && $enrollcouListRes!=false)
{
		for($i=0;$i<count($enrollcouListRes);$i++) 
		{
			$cid = $enrollcouListRes[$i]['cid'];
			$courseid 	=$enrollcouListRes[$i]['courseid'];
			$name   = $enrollcouListRes[$i]['name'];
			$coursepic   = $enrollcouListRes[$i]['coursepic'];
			$location   = $enrollcouListRes[$i]['imagepath'];
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
			enrollcourse[<?php echo $i; ?>]="<?php echo $name; ?>==<?php echo $imagepath;?>==<?php echo $courseid ;?>";
			<?php

		}
	}
?>
<?php
if(isset($enrollclubListRes) && count($enrollclubListRes)>0 && $enrollclubListRes!=false)
{
		for($i=0;$i<count($enrollclubListRes);$i++) 
		{
			$clubid = $enrollclubListRes[$i]['clubid'];
			$name   = $enrollclubListRes[$i]['name'];
			$clubpic   = $enrollclubListRes[$i]['clubpic'];
			$location   = $enrollclubListRes[$i]['location'];
			$imagepath=$SITE_URL.'images/noimage.jpg';
			if(isset($clubpic) && $clubpic!='')
			{
				$filepath=$SITE_PATH.$location.'/'.$clubpic;
				if(file_exists($filepath))
				{
					$imagepath=$SITE_URL.$location.'/'.$clubpic;
				}
			}
			?>
			enrollclubs[<?php echo $i; ?>]="<?php echo $name; ?>==<?php echo $imagepath;?>==<?php echo $clubid ;?>";
			<?php
		}
	}
?>
</script>
<script language="javascript" type="text/javascript">
function saveforum()
{
	var department_id='<?php echo $department_id; ?>';
	var university_id='<?php echo $university_id; ?>';
	var message=document.getElementById("text").value;
	if(message=='')
	{
		alert("Please enter post message.");
		document.getElementById('text').focus();
		return false;
	}
	var visibility='';
	if (document.getElementById('visibility_1').checked) {
 		 visibility = document.getElementById('visibility_1').value;
	}
	else if (document.getElementById('visibility_2').checked) {
 		 visibility = document.getElementById('visibility_2').value;
	}
	else if (document.getElementById('visibility_3').checked) {
 		 visibility = document.getElementById('visibility_3').value;
	}	
	
	///////// Save Post data
	$.ajax({
	type: "POST",
	url: "saveforums.php",
	data: { department_id: department_id,university_id: university_id,message: message,visibility: visibility}
	})
	.done(function(msg) {
		if(msg==1)
		{
			Forum();
			$("#text").val('');
			var h=$("#poster").height()-50;
			$("#poster").height(h);
						
			var h2= $("#text").height()-25;
			$("#text").height(h2);
			
			$("#text").attr("placeholder","Post an announcement, or ask a question.");                
			var newtop = $('#topics').position().top - 60;
			var visibilitytop = $('#postervisibility').position().top - 30;
		    $('#postervisibility').css('top',visibilitytop + 'px');
			$('#topics').css('top', newtop + 'px');
			flagp=0;             
		}
		else
		{
			alert("There is some problem while adding forum,Please try again.");
		}

	});
}   
//Forum doer    
function Forum(){
		
		$.ajax({
		type: "POST",
		url: "getdepartmentforums.php",
		data: { deptid: deptid}
		})
		.done(function( msg ) {
		//alert( "Data Saved: " + msg );
		 if(msg=='not_login')
		 {
		 	$("#loader").append("<div style='margin-top:15px;'>Please <a href='index.php'>login</a> to view all forums and comments.</div>");
		 }
		 else
		 {
		 	$( "#topics" ).remove();
		 	$("#loader").append("<div id='topics'></div>");
		 	$("#topics").text('');
		 	$("#topics").append(msg);
		}
		 
		});
}
function deletepost(messageid)
{
	if(confirm("Are you sure want to delete this post?"))
	{
		$.ajax({
		type: "POST",
		url: "deleteforums.php",
		data: { messageid: messageid}
		})
		.done(function( msg ) {
			if(msg==1)
			{
				Forum();
			}
		});
	}
	
}
function showcomment(messageid)
{
	if(document.getElementById('commentsection_'+messageid).style.display=='none')
	{
		document.getElementById('commentsection_'+messageid).style.display='';
	}
	else
	{
		document.getElementById('commentsection_'+messageid).style.display='none';
	}
	
}
function savecomments(messageid)
{
	var comment=document.getElementById('comment_'+messageid).value;
	if(comment=='')
	{
		alert("Please enter the comments.");
		document.getElementById('comment_'+messageid).focus();
		return false;
	}
	$.ajax({
		type: "POST",
		url: "savecomments.php",
		data: { messageid: messageid,comment:comment}
		})
		.done(function( msg ) {
			if(msg>0)
			{
				document.getElementById('commentsection_'+messageid).style.display='none';
				Forum();
				
			}
		});
}
function likethepost(messageid)
{
	$.ajax({
		type: "POST",
		url: "likethepost.php",
		data: { messageid: messageid}
		})
		.done(function( msg ) {
			if(msg>0)
			{
				Forum();
			}
		});
}
function Poster(){
	  $("#loader").append("<div id='poster'></div>");
	  $("#poster").append("<div id='chaticon'></div>");
	  $("#poster").append("<div id='chattext'></div>");
	  $("#poster").append("<div id='wedge'></div>");
	  $("#poster").append("<div id='innerwedge'></div>");
	  $("#poster").append("<form id='frmpost' name='frmpost' method='post'>");
	  $("#poster").append("<div id='posterwrap'></div>");
	  $("#posterwrap").append("<textarea placeholder = 'Post an announcement, or ask a question.' name='message' id='text'></textarea>");
	  $("#posterwrap").append("<input type='button' name='btnpost' id='pbutton' value='Post' onClick='saveforum()' >");
	  $("#poster").append("<div id='postervisibility'></div>");
	  $("#postervisibility").append("<input type='radio' name='visibility' value='Student' id='visibility_1' /> Student");
	  $("#postervisibility").append("<input type='radio' name='visibility' value='Faculty' id='visibility_2' /> Faculty");
	  $("#postervisibility").append("<input type='radio' name='visibility' value='Public' id='visibility_3' checked='checked' /> Public");
	  $("#postervisibility").append("<a class='fancy_div' href='<?php echo $SITE_URL; ?>post_upload.php?deptid=<?php echo $department_id; ?>&univid=<?php echo $university_id; ?>'>Upload</a>");
	  $("#postervisibility .fancy_div").fancybox(
		{
			'autoDimensions'		: false,
			'height'				: 200,
			'width'					: 600,
			'autoScale'				: false,
			'scrolling'	            : 'true',
			'hideOnOverlayClick' 	: false
		}
	);
	  $("#pbutton").append("Post");
	  $("#chattext").append("Make Posts");
	  $("#poster").append("</form>");
}

//tab Courses
function Courses(){
 $("#loader").append("<div id='courses'></id>");
  var k=1;
  if(coursesLists.length>0)
  {
	  for (var i=0;i<coursesLists.length;i++)
	  {
		var details= coursesLists[i].split("==");
		$("#courses").append("<div class='cours_box left'><table width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td><div class='cours_box_1'><table class='table'><tbody><tr><td><a title='"+details[0]+"' href='#'><img width='70' height='70' alt='"+details[0]+"' src='"+details[2]+"'></a></td></tr></tbody></table></div></td></tr><tr><td height='40' class='align_center'><a class='more_news' href='#'>"+details[3]+"</a></td></tr><tr><td class='align_center'>"+details[0]+"</td></tr></tbody></table></div>");
		if(k%5==0)
		{
		$("#courses").append("<br clear='all'/>");
		}
		k++;
	  } 
  }
  else
  {
  	$("#courses").append("Please <a href='index.php'>login</a> to view all courses and it's detail.");
  }
         
}
//Tab faculty
function Faculty(){
  $("#loader").append("<div id='faculty'></id>");
  var k=1;
  if(facultyLists.length>0)
  {
	  for (var i=0;i<facultyLists.length;i++)
	  {
		var details= facultyLists[i].split("==");
		$("#faculty").append("<div class='photo_album_box left'><table width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td><div class='photo_album_box_1'><table class='table'><tbody><tr><td><a title='"+details[0]+"' href='#'><img width='150' height='150' alt='"+details[0]+"' src='"+details[2]+"'></a></td></tr></tbody></table></div></td></tr><tr><td height='40' class='align_center'><a class='more_news' href='#'>"+details[0]+"</a></td></tr><tr><td class='align_center'>"+details[1]+"</td></tr></tbody></table></div>");
		if(k%3==0)
		{
		$("#faculty").append("<br clear='all'/>");
		}
		k++;
	  } 
   }
   else
   {
   		$("#faculty").append("Please <a href='index.php'>login</a> to view all faculty and it's detail.");
   }
} 
$(document).ready(function() {
//navigator listener    
var flagp=0;
/////// four tab clicking ////////                  
$(".tab").click(function()
{
    flagp=0;
    $("#loader").remove();
    $(".here").addClass("tab");
    $(".here").removeClass("here");
    $(this).addClass("here");
    $(this).removeClass("tab");
                
    flag= $(this).attr("id");
    
	$("#tabs").append("<div id='loader'></div>");
    if(flag=="t0"){
		<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=''){?>
        Poster();
		<?php }?>
        Forum();      
    }
    if(flag=="t1"){
        Courses();            
    }            
    if(flag=="t2"){
        Faculty();
    }
    if(flag=="t3"){
		<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=''){?>
		 $("#loader").append("<iframe height='700px;' frameborder='0' scrolling='auto' width='570px;' src=\"<?php echo $SITE_URL; ?>file_upload.php?univid=<?php echo $university_id;  ?>&deptid=<?php echo $department_id;  ?>\"></iframe>"); 
		 <?php }else{?>
		 $("#loader").append("<div id='courses'>Please <a href='index.php'>login</a> to upload and download file.</div>");
		 <?php }?>
	}            
    //appearance: border dynamic
    if((flag=="t0")||(flag=="t1")){
        $(".tab").css({"border-right":"1px solid #595959"});
        $(".tab").css({"border-left":"none"});
        $("#t0").css({"border-left":"1px solid #595959"});
        $(".here").css({"border-left":"1px solid #595959","border-right":"0.5px solid #595959"});
    }
    if((flag=="t2")||(flag=="t3")){
        $(".tab").css({"border-left":"1px solid #595959"});
        $(".tab").css({"border-right":"none"});
        $("#t3").css({"border-right":"1px solid #595959"});
        $(".here").css({"border-left":"1px solid #595959","border-right":"0.5px solid #595959"});
    }    
});
           
//css dynamic
function dynamicCSS()
{var ac= $("#tabs").offset().left+$("#tabs").outerWidth(true);
$("#calender-nonfix").offset({ top: 305, left: ac });
$("#calender-fix").offset({ top: 0, left: ac });
        
//sticky calender
$(document).scroll(function() { 
    if($(document).scrollTop()>=305){
    $("#calender-nonfix").css({"position":"fixed","top":"0"});
    }
                                
    if($(document).scrollTop()<=305){
    $("#calender-nonfix").css({"position":"absolute","top":"305px"});
    }
});       
}

dynamicCSS();
$( window ).resize(function() {                             
  dynamicCSS();                 
});
                  
                  
                  
$("#tabs").delegate("#text","click",function()
{
		if(flagp==0){
		var h=$("#poster").height()+50;
		$("#poster").height(h);
		var h2= $("#text").height()+25;
		$("#text").height(h2);
		$("#text").attr("placeholder","");                   
		var newtop = $('#topics').position().top + 60;
		var visibilitytop = $('#postervisibility').position().top + 30;
		$('#postervisibility').css('top',visibilitytop + 'px');
		$('#topics').css('top', newtop + 'px');
		flagp=1;
		}
});
  
                    
$(document).click(function(e){
	if($(e.target).is("#poster *"))return;
	if(flagp==1){
			var h=$("#poster").height()-50;
			$("#poster").height(h);
						
			var h2= $("#text").height()-25;
			$("#text").height(h2);
			
			$("#text").attr("placeholder","Post an announcement, or ask a question.");                
			var newtop = $('#topics').position().top - 60;
			var visibilitytop = $('#postervisibility').position().top - 30;
		    $('#postervisibility').css('top',visibilitytop + 'px');
			$('#topics').css('top', newtop + 'px');
			flagp=0;             
	}
});          
        

//Tabs part
//default forum
<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=''){?>
Poster();
<?php }?>
Forum();   
//sidebar course section
$("#sidebarcourse").css("position","absolute");
var userwrapend = $("#userwrap").position().top + $("#userwrap").outerHeight(true);
$("#sidebarcourse").css({"top":userwrapend,"right":"0px"});
  for (var i=0;i<enrollcourse.length;i++)
  {
  
	var details= enrollcourse[i].split("==");
	$("#sidebarcourse").append("<a href='#'><div id='sc_"+i+"' class='enrollcur'><div class='sc'><div id='courseimg_"+i+"' class='enrollcur_inner' style='background-image: url("+details[1]+");'></div><div id='coursename_"+i+"' class='enrollcur_title'>"+details[0]+"</div></div></div></a>");
  }

$(".sc").mouseover(function()
{
	$(this).css({"padding-left": "10px"});
	$(this).parent().css({"background-color":"#cccccc",});			  
}); 
$(".sc").mouseout(function()
{
	$(this).css({"padding-left": "0px"});
	$(this).parent().css({"background-color":"white"});
});
	

//sidebar club sections
$("#sidebarclub").css("position","absolute");
var coursewrapend = $("#sidebarcourse").position().top + $("#sidebarcourse").outerHeight(true)+25;
$("#sidebarclub").css({"top":coursewrapend,"right":"0px"});
  for (var i=0;i<enrollclubs.length;i++)
  {
  
	var details= enrollclubs[i].split("==");
	$("#sidebarclub").append("<a href='#'><div id='cb_"+i+"' class='enrollcur'><div class='cb'><div id='clubimg_"+i+"' class='enrollcur_inner' style='background-image: url("+details[1]+");'></div><div id='clubname_"+i+"' class='enrollcur_title'>"+details[0]+"</div></div></div></a>");
  }
$(".cb").mouseover(function()
{
	$(this).css({"padding-left": "10px"});
	$(this).parent().css({"background-color":"#cccccc",});			  
}); 			  
$(".cb").mouseout(function()
{
	$(this).css({"padding-left": "0px"});
	$(this).parent().css({"background-color":"white"});
});
});

function calltimeline()
{
	<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=''){?>
	if($(".here").attr("id")=='t0'){
		Forum();
	}
	<?php }?>
}
setInterval("calltimeline();",10000);
</script>
</head>
<body>

<section id="banner">
    <div id = "frame-logo-img"><a href="#"><img id = "gradcap" src = "images/gradcap.png"></a></div> 
    <div id="logo"><div id="temporaryLogo">Urlinq</div></div>
    <div id="searchwrap">
	<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=''){?>
	<div class="logout_tab"><a href="<?php echo $SITE_URL;?>logout.php">Logout</a></div>
	<?php }else{?>
	<div class="logout_tab"><a href="<?php echo $SITE_URL;?>index.php">Login</a></div>
	<?php }?>
	<br /><input id="search" type="text"></input>
    </div>
</section>

<section id="sidebar-fix">
</section>

<section id="sidebar-nonfix">
    <div id="userwrap">
        <?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=''){
		$imagepath=$SITE_URL.'images/noimage.jpg';
		if(isset($userdetail) && count($userdetail)>0)
		{
			$username= $userdetail['name'];
			$profilepic= $userdetail['profilepic'];
			$location   = $userdetail['location'];
			if(isset($profilepic) && $profilepic!='')
			{
				$filepath=$SITE_PATH.$location.'/'.$profilepic;
				if(file_exists($filepath))
				{
					$imagepath=$SITE_URL.$location.'/'.$profilepic;
				}
			}
		}
		?>
		<div id="frame"><a href="#"><img id="photo" src="<?php echo $imagepath; ?>"></a>
        </div> 
        <div id="description">
            <div id="name"><a style = "font-size:1.05em;" id="channel" href="#"><?php echo $username; ?></a></div>
        </div>
		<?php }?>
    </div>
    <div id="sidebarcourse">
        <div id="coursehead"><div id="tcourse">COURSES</div>
        <button href="#">+</button>
        </div>
		<br clear="all"/><br clear="all"/>
    </div>
    <div id="sidebarclub">
        <div id="clubhead"><div id="tclub">CLUBS</div>
            <button href="#">+</button>
        </div>
		<br clear="all"/><br clear="all"/>
    </div>
	
</section>    
<section id="content">
</section>
    
<section id="cover">
    <div id="titlewrap">
        <div id="title">Department of Cognitive Science</div>
        <div id="cover-frame"><a href="#"><img id="department-photo" src="images/dpphoto.png"></a>
        </div> 
    </div> 
</section>

<section id="navigator">
<a href="#"><div class="tab here" id="t0">Forum</div></a>
<a href="#"><div class="tab" id="t1" >Courses</div></a>
<a href="#"><div class="tab" id="t2" >Faculty</div></a>
<a href="#"><div class="tab" id="t3" >Files</div></a>
</section>

<section id="tabs">
<div id="loader">
</div>
</section>

<!-- Event section start from Here ---->
<section id="calender-fix">
</section>
  
<?php	
	$start_date=date('Y-m-01 00:00:00',strtotime('this month')) ;
	$end_date=date('Y-m-t 12:59:59',strtotime('this month'));
	
	$eventListQry = "select * from department_events_1 where deptid='".$department_id."' and starttime>='".$start_date."' and  endtime <= '".$end_date."' order by starttime asc ";
	$eventListRes = $dbObj->fireQuery($eventListQry,'select');
?>
<script language="javascript" type="text/javascript">
var evts=new Array();

//temp arr initialization, will be replaced once database is ready
<?php
if(isset($eventListRes) && count($eventListRes)>0 && $eventListRes!=false)
	{
		for($i=0;$i<count($eventListRes);$i++) 
		{
			$eventname = $eventListRes[$i]['eventname'];
			$even_place   = $eventListRes[$i]['even_place'];
			$starttime   = $eventListRes[$i]['starttime'];
			?>
			evts[<?php echo $i; ?>]="<?php echo date("m/d",strtotime($starttime)); ?>==<?php echo $eventname;?>==<?php echo $even_place;?>, <?php echo date("h:i a",strtotime($starttime)); ?>";
			<?php
		}
	}
?>
$(document).ready(function() {
var nevts= evts.length;
var c=0;
while(nevts>0)
{
    var details= evts[c].split("==");
    $("#events").append("<div class='anevent' id='anevent_"+c+"'></div>");
    $("#anevent_"+c).append("<div class='anicon' id='anicon_"+c+"'></div>");
    $("#anicon_"+c).append(details[0]);
    $("#anevent_"+c).append("<div class='what' id='what_"+c+"'></div>");
    $("#what_"+c).append(details[1]);
    $("#anevent_"+c).append("<div class='where' id='where_"+c+"'></div>");
    $("#where_"+c).append(details[2]);    
    $("anicon_"+c).append("<img id='bg_"+c+"' src='images/event.png'>");
    $("#anevent_"+c).css("position","absolute");
    var etop=c*90;
    $("#anevent_"+c).css({"top":etop,"left":"0px"});
    $("#anevent_"+c).css({"width":"100%","height":"80px"});
    $("#anevent_"+c).css({"font-family":"Verdana, Geneva, sans-serif","color":"#323232", "font-size":"0.9em"});
    $("#anicon_"+c).css("position","absolute");
    $("#anicon_"+c).css({"top":"20px","left":"10px"});
    $("#anicon_"+c).css({"width":"45px","height":"45px"});
    $("#anicon_"+c).css({"background-image":"url(images/event.png)","background-size":"cover","background-repeat":"no-repeat"});
    $("#anicon_"+c).css({"text-align":"center","line-height":"55px"});
    $("#what_"+c).css("position","absolute");
    $("#what_"+c).css({"top":"20px","left":"65px"});
    $("#where_"+c).css("position","absolute");
    $("#where_"+c).css({"top":"45px","left":"65px"});
    nevts=nevts-1;
    c=c+1;
}
});
</script>    
<section id="calender-nonfix">
    <div id="title">
        <div id="make">
            <a href="#"><img id="titleicon" src="images/makecalender.png"></a>
        </div>    
        <div id="today"><?php echo date("F d,Y"); ?></div>
    </div>
    <div id="events">
	</div>
</section>      
    
<!-- Event section End Here ---->
</body>    
</html>