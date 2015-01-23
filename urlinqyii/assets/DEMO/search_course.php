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
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="js/sly-master/dist/sly.js"></script>
<script src="js/banner.js"></script>

<link rel="stylesheet" href="css/jquery-ui-1.10.4.custom.min.css">
<link rel="stylesheet" type="text/css" href="css/search.css">
<link rel="stylesheet" type="text/css" href="css/banner.css">
<script type="text/javascript">

$(document).ready(function() {
$("#searchdept").show();
var depts= new Array();
$( ".adept" ).each(function( index ) {
 depts[index]= $(this).attr("id");

 if($(this).attr("id").length>20){
 //alert($(this).attr("id"));
 $(this).find(".deptname").text($(this).find(".deptname").text().substr(0,20)+"...");
 }});


var st= $(".infofield").offset().left-50-$("#searchdept").outerWidth();
$("#searchdept").offset({ left: st });
var st2= $(".infofield").offset().left-70;
$("#searchborder").offset({ left: st2 });

$(window).on('resize', function(){
var st= $(".infofield").offset().left-50-$("#searchdept").outerWidth();
$("#searchdept").offset({ left: st });
var st2= $(".infofield").offset().left-70;
$("#searchborder").offset({ left: st2 });
  });
                              
$(document).delegate("#dept-search-bar","keyup",function(){
var str=$(this).val().trim().split(" ").join("_").toLowerCase();
$(".adept").hide();
$.each(depts, function( index, value ) {
	 if (value.toLowerCase().indexOf(str) >= 0){
	  $("#"+depts[index]).show();
	  }
});});
                              
$(document).delegate(".depttoolcell","click",function(){
                                                   var tag=$(this).attr("id");
                                                   var str=$("#dept-search-bar").val().trim().split(" ").join("_").toLowerCase();
                                                   
                                                   $(".adept").hide();
                                                   $.each(depts, function( index, value ) {
                                                          
                                                          if ((value.toLowerCase().indexOf(str) >= 0)&&($("#"+depts[index]).hasClass(tag))){
                                                          $("#"+depts[index]).show();
                                                          }
                                                          
                                                          });
                                                   $("#depttoolbar").hide();
                                                   
                                                   });
                              
$(document).delegate(".adept","mouseover",function(){
                                                   $(this).css("background-color","#272c34");
                                                   
                                                   $(this).find(".hb").css({"background-color":"#272c34","height":"40px"});
                                                   });
                              
$(document).delegate(".adept","mouseout",function(){
                                                   $(this).css("background-color","transparent");
                                                   $(this).find(".hb").css({"background-color":"#3e4046","height":"41px"});
                                                   });

$("#searchdept").height($(window).height()-480);
$("#depttail").height($("#searchdept").height()-20);
$( window ).resize(function() {
				 $(".frame").sly('reload');
				 $("#searchdept").height($(window).height()-480);
				 $("#depttail").height($("#searchdept").height-20);
				 });
                            
         
$(document).delegate("#depttools","click",function(){
					 $("#depttoolbar").show();
					 });
$(document).delegate(".depttoolcell","mouseover",function(){
					 $(this).css("background-color","rgb(57, 60, 66)");
					 });
$(document).delegate(".depttoolcell","mouseout",function(){
					 $(this).css("background-color","transparent");
					 });
                              
                              
$(document).click(function(e)
{                


if(!$(e.target).hasClass("depttools")){
$("#depttoolbar").hide();
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
function filterResults()
{
	var url = "";
	<?php 
		if (isset($_GET['deptid']))
		{ 
	?>
		url = "search_filter.php?deptid=<?php echo $_GET['deptid']?>&univid=<?php echo $_GET['univid']?>";
	<?php
		}
		else
		{
	?>
			url = "search_filter.php?univid=<?php echo $_GET['univid']?>";
	<?php 
		}
	?>
	var data = "";

	/*get all filter criteria*/
	var filter_opts = "";
	if($("#profFilter .clickable.selected").length)
		filter_opts = " and profid = '"+$("#profFilter .clickable.selected").data('value')+"'";
	if($("#slider-range").slider != null)
		filter_opts = filter_opts + " and credits between "+ $("#slider-range").slider('values',0) +" and "+ $("#slider-range").slider('values',1);
	
	<?php 
		if (isset($_POST['search']))
		{ 
	?>
			data = "filter=" + filter_opts + "&search=<?php echo $_POST['search']?>" + "&usertype=<?php echo $_SESSION['usertype']?>";
	<?php
		}
		else
		{
	?>
			data = "filter=" + filter_opts + "&usertype=<?php echo $_SESSION['usertype']?>";
	<?php 
		}
	?>

	/*userid is the one who is viewing this page*/
	var userid;
   <?php 
   if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){
   		?>
		userid= <?php echo $_SESSION['student_id']; ?>;
     	var whoislogin='Student';
   		<?php
   }elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){
   		?>
		userid= <?php echo $_SESSION['professor_id']; ?>;
		var whoislogin='Professor';
		<?php
   }
   ?>
	data = data + "&userId=" + userid;   
	var tagID = "searchResult";
	
	document.getElementById(tagID).innerHTML = "Processing";
	$.ajax({
		url: url,
		data: data.toString(),
		type: 'POST',
		async: true,
		cache: false,
		timeout: 30000,
		error: function(){
			return true;
		},
		success: function(responseText){
			document.getElementById(tagID).innerHTML = responseText;
		}
	})
}
$(function() {
	var startPos , endPos, max= $( "#slider-range" ).data('value');
	$( "#slider-range" ).slider({
	range: true,
	min: 0,
	max: max,
	values: [ 0, max ],
	step: 0.5,
	slide: function( event, ui ) {
	$( "#credit" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
	},
	start:function (event, ui){
		startPos = ui.values;
	},
	stop: function (event, ui){
		endPos = ui.values;
		if(startPos[0] != endPos[0] || startPos[1] != endPos[1])
		{
			filterResults();
		}
	}
	});
	$( "#credit" ).val( $( "#slider-range" ).slider( "values", 0 ) +
	" - " + $( "#slider-range" ).slider( "values", 1 ) );

	$("#profFilter .clickable").click(function() {
		$("#profFilter .clickable").removeClass("selected");
		$(this).addClass("selected");
		$("#clear-filter-button").css("display","block");
		filterResults();
	});
	$("#clear-filter-button").css("display","none");
	$("#clear-filter-button").click(
			function() {
				$("#profFilter .clickable").removeClass("selected");
				$(this).css("display","none");
				filterResults();
	});
});
</script>

</head>
<body>


<section class="midsec tabcourse">

  <!-- Department search and course section start here -->
<div id="searchdept" >
  <div id="deptheader">
    <input id = "dept-search-bar" type = "text" placeholder = "Search"/>
    <a id="depttools" class="depttools"></a>
    <div id="depttitle">
      <div>DEPARTMENTS</div>
    </div>
  </div>
  <div id="depttoolbar">
    <div id="deptwedge"></div>
    <div id="depttoolcontent">
      <div class="depttoolcell" id="adept">All Divisions</div>
      <div class="depttoolcell" id="hm">Humanities</div>
      <div class="depttoolcell" id="ss">Social Science</div>
      <div class="depttoolcell" id="ns">Natural Science</div>
      <div class="depttoolcell" id="eg">Engineering</div>
    </div>
  </div>
  <div id="depttail">
    <?php 
  $first_deptid=0;
  /////////Get all departments for university here /////////////////////////////
  $deptsql="SELECT * FROM `department_1` where `universityid`='".$university_id."';";
  $deptListRes = $dbObj->fireQuery($deptsql,'select');
  if(isset($deptListRes) && count($deptListRes)>0 && $deptListRes!=false)
  {
    for($d=0;$d<count($deptListRes);$d++)
    {
      $deptid=$deptListRes[$d]['deptid'];
      if($d==0){$first_deptid=$deptid;}
      $department_name=$deptListRes[$d]['deptname'];
      $deptpic=$deptListRes[$d]['deptpic'];
      $location=$deptListRes[$d]['location'];
      $imagepath=$SITE_URL.'images/noimage.jpg';
      if(isset($deptpic) && $deptpic!='')
      {
        $filepath=$SITE_PATH.$location.'/'.$deptpic;
        if(file_exists($filepath))
        {
          $imagepath=$SITE_URL.$location.'/'.$deptpic;
        }
      }
      ?>
      <!--<div class="adept ns ss eg hm sc" id="computer_science"> -->
      <div class="adept" id="<?php echo str_replace(" ","_",$department_name); ?>">
      <a href="" class="silverhref"><img src="<?php echo $imagepath; ?>" class="deptpic">
         <div class="dcname"><a href="<?php echo $_SERVER['REQUEST_URI']."&deptid=".$deptid."&act=course"; ?>" class="silverhref deptname"><?php echo $department_name; ?></a></div>
        </a>
          <div class="hb"></div>
        </div>
      <?php
    }
  } 
  ?>
  </div>
</div>

<!--search dept end-->

<?php 
$search="";
if(isset($_POST['search']) && $_POST['search']!=''){
	$search=$_POST['search'];
}
?>

	<div id="searchborder">
	<form name="frmsearch" id="frmsearch" method="post" action="">
	<input type="text" id="searchbar" name="search" placeholder="search by keywords" value="<?php echo $search; ?>" />
	<a href="Javascript:void(0)" onClick="Javascript:document.getElementById('frmsearch').submit();"><img src="images/search.png" id="searchbutton"></a>
	</form>
	</div>


<div class="clear"></div>
<div id="searchResult">
<?php 
/////// First check if deptid set in url then display those courses otherwise display first dept course ////////////
if(isset($_GET['deptid']) && $_GET['deptid']!=''){
	$sel_deptid=$_GET['deptid'];
}else{
	$sel_deptid=$first_deptid;
}
if(isset($sel_deptid) && $sel_deptid!='')
{
	$search_course_cond="";
	if(isset($_POST['search']) && $_POST['search']!='')
	{
		$search_course_cond=" AND name LIKE '%".$_POST['search']."%'";
	}
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		if(isset($search_course_cond) && $search_course_cond!=""){
			$course_dept_sql="SELECT * FROM `course_1` where `universityid`='".$university_id."' ".$search_course_cond." ";		
		}else{
			$course_dept_sql="SELECT * FROM `course_1` where `universityid`='".$university_id."' and deptid='".$sel_deptid."'";
		}
		
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		if(isset($search_course_cond) && $search_course_cond!=""){
			$course_dept_sql="SELECT * FROM `course_1` where `universityid`='".$university_id."' ".$search_course_cond." ";	
		}else{
			$course_dept_sql="SELECT * FROM `course_1` where `universityid`='".$university_id."' and deptid='".$sel_deptid."'";	
		}
	}
	$CoursesListRes = $dbObj->fireQuery($course_dept_sql,'select');
	$max = 0;
	$profs_name = array();
	if(isset($CoursesListRes) && count($CoursesListRes)>0 && $CoursesListRes!=false)
	{
		for($cs=0;$cs<count($CoursesListRes);$cs++)
		{
			$cid=$CoursesListRes[$cs]['cid'];
			$name=$CoursesListRes[$cs]['name'];
			$courseid=$CoursesListRes[$cs]['courseid'];
			if($max < $CoursesListRes[$cs]['credits'])
				$max = $CoursesListRes[$cs]['credits'];
			$section=$CoursesListRes[$cs]['section'];
			$deptid=$CoursesListRes[$cs]['deptid'];
			$profid=$CoursesListRes[$cs]['profid'];
			array_push($profs_name,$profid);
			$coursepic=$CoursesListRes[$cs]['coursepic'];
			$location=$CoursesListRes[$cs]['imagepath'];
			$desc=$CoursesListRes[$cs]['desc'];
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
			<div class="infofield course itemtype">
					<img src="<?php echo $imagepath; ?>" class="infopic">
				<div class="infotail">
					<div class="tailhead itemname">
					<a><?php echo $name; ?></a>
					</div>
					<div class="moreinfo">
						<img class="prof-icon" src="images/professor-icon.png">Taught by <span class="more-info-real">
						<?php 
						if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor' && $_SESSION['professor_id']==$profid){echo "You";}
						else{ if(is_numeric($profid)){echo getprofessordetail($profid,'name');}else{ echo $profid;} }
						?></span>
						
					</div>
					<div class="subinfo">
						<div class="subinfo_0">
						<img class="prof-icon" src="images/students-icon.png"><a href=""><?php echo gettotalcoursemembercount($cid); ?> members</a>
						<?php $final_students=getlastjoincoursemember($cid); 
						if(isset($final_students) && count($final_students)>0)
						{
							echo ',including ';
							foreach($final_students as $student)
							{
								echo '<a href="student_profile.php?studid='.$student['studid'].'">'.$student['name'].'</a>,';
							}
						}
						?>
					</div>
					<div class="subinfo_1">
					<img class="prof-icon" src="images/departments-icon.png">
					<a href="index.php?pg=department&deptid=<?php echo $deptid; ?>&univid=<?php echo $university_id; ?>"><?php echo getdepartmentdetail($deptid,'deptname'); ?></a> department
					</div>
					Section <span class="more-info-real"><?php echo $section; ?></span>
					<div class="subinfo_2">
					<img class="prof-icon" src="images/descriptions-icon.png"><?php echo $desc; ?>
					</div>
					
				</div>
				<?php 
				if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
				{
					$iscoursenrolled=enrolledincourse($_SESSION['student_id'],$cid,$university_id);
					if($iscoursenrolled==1){ ?>
					<button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="b-courses_<?php echo $cid; ?>" value="1">I am in this class</button>
					<?php }else{?>
					<button value="0" id="b-courses_<?php echo $cid; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Add</button>
					<?php }
				}
				elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
				{
					if($_SESSION['professor_id']==$profid){?><button style="background: linear-gradient(rgb(96, 214, 45), rgb(61, 165, 13)) repeat-x scroll 0% 0% rgb(96, 214, 45); color: white; border: 1px solid rgb(59, 110, 34); width: auto;" class="linqthis" id="b-courses_<?php echo $cid; ?>" value="1">I am in this class</button><?php	
					}else{ ?><button value="0" id="b-courses_<?php echo $cid; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Add</button><?php }
				}	
				?>
				</div>
			</div>
			<?php
		}
	}
	else

	{?><div class="infofield course itemtype" style="height:50px !important;"><center style="margin-top:10px;"><strong>No Course Found in this Department.</strong></center></div><?php }

}
?>
</div>
</section>
<!-- Filters for search -->
<section class="leftsec" style="display: block; left: 163.5px; height: 0px;">
	<?php
		if($max > 0)
		{
			
			echo "<input type='text' id='credit' />
					<div id='slider-range' data-value = '".$max."'style = 'max-width:100px;'></div>";
		}
	?>
	<div id="prof-filter-container">
		<div id="clear-filter-button">Clear Filter</div>
		<ul id="profFilter">
	<?php 
		$profs_name = array_unique($profs_name);
		for($i=0; $i<count($profs_name); $i++)
		{
			if($profs_name[$i] == '')
				continue;
			$displayName = is_numeric($profs_name[$i])?getprofessordetail($profs_name[$i],'name'): $profs_name[$i];
			echo "<li class='clickable' data-value='".$profs_name[$i]."'>
						<a href='#profFilter'><span class='refinementLink'>".$displayName."</span></a>
				  	</li>";
		}
	?>
		</ul>
	</div>
</section>
<!-- Department search and course section end here -->
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
window.parent.$(".tabcontentiframe").css("width","100%");
window.parent.$(".tabcontentiframe").css('overflow','auto');
</script>