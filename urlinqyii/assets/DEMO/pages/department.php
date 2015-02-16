<?php
if(isset($_GET['univid']) && $_GET['univid']!='' && isset($_GET['deptid']) && $_GET['deptid']!=''  )
{
	$university_id=$_GET['univid'];
	$department_id=$_GET['deptid'];
}else{
	$university_id=0;
	$department_id=0;
}

?>
<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/style_new.css">
<link rel="stylesheet" type="text/css" href="css/banner.css">
<link rel="stylesheet" type="text/css" href="css/dropdown.css">

<!--<link rel="stylesheet" type="text/css" href="css/ajaxtabs.css" />-->

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script src="js/modernizr.custom.63321.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script src="http://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>



<script type="text/javascript" src="js/jquery.dropdown.js"></script>


<!--<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />-->
<script type="text/javascript" src="js/ajaxtabs.js"></script>
<script src="js/banner_new_9_3.js"></script>

<script language="javascript" type="text/javascript">

	
$(document).ready(function() {
	$( '#cd-dropdown' ).dropdown( {
			stack : false,
			});

	   $(document).delegate('.likepic',"mouseover", function(){
    	if($(this).hasClass('liked')){}else{
    	$(this).attr("src","images/liked-button.png");
    	$(this).css("opacity","0.8");
    	}
    });
        $(document).delegate('.likepic',"mouseout", function(){
        if($(this).hasClass('liked')){}else{
    	$(this).attr("src","images/like.png");
    	$(this).css("opacity","1");
    	}
    });

        $(document).delegate('.like',"mouseover", function(){
    	if($(this).hasClass('liked')){}else{
    	$(this).attr("src","images/liked-button.png");
    	$(this).css("opacity","0.8");
    	}
    });
        $(document).delegate('.like',"mouseout", function(){
        if($(this).hasClass('liked')){}else{
    	$(this).attr("src","images/like.png");
    	$(this).css("opacity","1");
    	}
    });


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

$(".fancy_div").fancybox(
{
	maxWidth	: 800,
	maxHeight	: 600,
	fitToView	: false,
	width		: '50%',
	height		: '40%',
	autoSize	: false,
	closeClick	: false,
	openEffect	: 'none',
	closeEffect	: 'none'
}
	);
$(document).delegate(".rest_pst","click",function(){
				   $(".here_pst").addClass("rest_pst");
				   $(".here_pst").removeClass("here_pst");
				   $(this).addClass("here_pst");
				   $(this).removeClass("rest_pst");
				   
				   var wt= $("#wedge").offset().top;
				   var ot= $("#outerwedge").offset().top;
				   var l= $(".here_pst").offset().left-35;
				   
				   
				   $("#wedge").offset({ top: wt, left: l });
				   $("#outerwedge").offset({ top: ot, left: l });
				   });

$(document).delegate(".mimicbutton","mouseover",function(){
				   $(this).css("background-color","#ddddda");
				   });           
$(document).delegate(".mimicbutton","mouseout",function(){
				   $(this).css("background-color","#e5e5e4");
				   });  

$(document).delegate(".pastclasslink","mouseover",function(){
				   $("#pcwedge").css("opacity","0.7");
				   });           
$(document).delegate(".pastclasslink","mouseout",function(){
			   $("#pcwedge").css("opacity","1");
				   }); 



$(".evts").mouseover(function(){
				   var tid= $(this).attr("id");
				   var arr= tid.split("-");
				   var nid= "w-"+arr[2]+"-"+arr[3];
				   
				   $("#"+nid).stop().fadeTo(250,1);
				   
				   }).mouseout(function() {
							   var tid= $(this).attr("id");
							   var arr= tid.split("-");
							   var nid= "w-"+arr[2]+"-"+arr[3];
							   
							   
							   if($("#"+nid).hasClass("checked")){
							   $("#"+nid).css("opacity",0.8);
							   }else{
							   
							   $("#"+nid).stop().fadeTo(200,0.6);
								
							   }
								});


$('.button-block button').on('click', function(){
						   var $this = $(this).parent();
						   var $a= $(this).parents(".wrapper");
						   if($a.hasClass("checked")){
						   $a.removeClass('checked');
						   }else{
						   $a.addClass('checked');
						   }
						   
						   $this.toggleClass('canceled');
						   return false;
						   });   

$('.like').on('click', function(){
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

$('.download').on('click', function(){
			if($(this).hasClass("downloaded"))
			{
			
			return false;
			}else{
			$(this).toggleClass('downloaded');
			$(this).attr("src","images/downloaded-button.png");
			return false;
			}
			}); 

var st= $("#sidebar").offset().left+$("#sidebar").outerWidth();
$("#main").offset({ left: st });

$(window).on('resize', function(){
		   var st= $("#sidebar").offset().left+$("#sidebar").outerWidth();
		   $("#main").offset({ left: st });
		   
		   var st2= $("#panel-pi").offset().left;
		   
		   });



$(document).delegate(".pb","mouseover",function(){
				   var a= $(this).attr("id").split("_");
				   var n= a[1];
				   var m= parseInt(n);
				   if(isOdd(m)){
				   m=m-1;
				   }else{
				   m=m+1;
				   }
				   idname1= "#pb_"+n;
				   idname2= "#pb_"+m;
				   $(idname1).css("opacity","0.8");
				   $(idname2).css("opacity","0.8");
				   
				   });

                   $(document).delegate(".tabs","click",function(){
				   thumbnail_init();
				       $('div#controls').hide();
				       $( '#cd-dropdown' ).dropdown( {
						stack : false,
						});
				   if($(this).attr("id")==="tab_0"){
				   		$("#calendar").show();
				   }else{
				   		$("#calendar").hide();
				   }
				   $(".accordion .sprate_div").slideUp("slow");

				   });
				   

$(document).delegate(".pb","mouseout",function(){
				   
				   var a= $(this).attr("id").split("_");
				   var n= a[1];
				   var m= parseInt(n);
				   if(isOdd(m)){
				   m=m-1;
				   }else{
				   m=m+1;
				   }
				   idname1= "#pb_"+n;
				   idname2= "#pb_"+m;
				   $(idname1).css("opacity","1");
				   $(idname2).css("opacity","1");
				   
				   });


function isOdd(x) {
return ( x & 1 ) ? true : false;
}
});
$(document).ready(function(){
    $('div#controls').hide();
    
    $(document).delegate('textarea[name="message"]',"keypress", function(){
        $('div#controls').show();
    });


});

<!--- Global variable set here for department and university id --->
var department_id='<?php echo $department_id; ?>';
var university_id='<?php echo $university_id; ?>';
	
<!---- FORUM FUNCTIONS START HERE --->
function saveforum()
{
	var message=document.getElementById("postarea").value;
	var visibility=document.getElementById('visibility').value;
	if(message=='')
	{
		alert("Please enter post message.");
		document.getElementById('postarea').focus();
		return false;
	}
	///////// Save Post data
	$.ajax({
	type: "POST",
	url: "saveforums.php",
	data: { department_id: department_id,university_id: university_id,message: message,visibility: visibility}
	})
	.done(function(msg){
		if(msg==1)
		{
			document.getElementById("postarea").value='';
			document.getElementById('visibility').value='Public';
			document.getElementById('controls').style.display='none';
			Forum();
		}
		else
		{
			alert("There is some problem while adding forum,Please try again.");
		}

	});
} 
function Forum()
{
	$.ajax({
	type: "POST",
	url: "getdepartmentforums.php",
	data: { deptid: department_id,univid: university_id}
	})
	.done(function( msg ) {
	//alert( "Data Saved: " + msg );
	 if(msg=='not_login')
	 {
	 	$( "#topics" ).html();
		$("#topics").html("<div style='margin-top:15px;'>Please <a href='index.php' target='_parent'>login</a> to view all forums and comments.</div>");
	 }
	 else
	 {
	 	//alert(msg);
	 	$( "#topics" ).html();
		$("#topics").html(msg);
	 }
	});
} 
function savecomments(messageid)
{
	var comment=document.getElementById('mc_'+messageid).value;
	if(comment=='')
	{
		alert("Please enter the comments.");
		document.getElementById('mc_'+messageid).focus();
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
				Forum();
				
			}
		});
}
function likethepost(messageid,type)
{
	$.ajax({
		type: "POST",
		url: "likethepost.php",
		data: { messageid: messageid,type:type}
		})
		.done(function( msg ) {
			if(msg>0)
			{
				Forum();
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
var stillTyping = 0;
function autorefresh()
{
	var allbalnk=true;
	$(".comment-textarea").each(function(){
    var self = $(this),
        thisVal = self.val();
    if($.trim(thisVal) === "" || thisVal.length === 0)
    {
       
    }
	else
	{
		allbalnk=false;
		stillTyping=1;
	}
	if(allbalnk)
	{
		stillTyping=0;
	}
	});
	if(stillTyping==0)
	{
		Forum();
	}
}

//the departmentforum.php should be like home page forum or university page forum
//then activate the set interval
//setInterval("autorefresh();",10000);

<!---- FORUM FUNCTIONS END HERE --->

</script>


</head>

<body>
<?php include_once('include/header.php'); ?>    
    
<section id="sidebar">
  <div id="panel-pi">
    <div id="header">
      
      <a href=""><img src="<?php echo $imagepath; ?>" id="photo"></a>
      <div id="name"><a class="whitehref" href=""><?php echo $username; ?></a></div>
      
    </div>
    
	<?php 
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		$sem_sql="SELECT startperiod, endperiod,name FROM `semester_schedule` WHERE univid = ".$university_id." and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP)>=MONTH(startperiod)*100+DAY(startperiod) and MONTH(CURRENT_TIMESTAMP)*100+DAY(CURRENT_TIMESTAMP) <= MONTH(endperiod)*100+DAY(endperiod) "; 
		$sem_res=$dbObj->fireQuery($sem_sql,'select');
		if(isset($sem_res) && $sem_res!=false && count($sem_res)>0)
		{
			$startperiod=$sem_res[0]['startperiod'];
			$endperiod=$sem_res[0]['endperiod'];
		}
		$student_id=$_SESSION['student_id'];
		$student_course_sql="select * from  student_courses_1 where enrolltime>='".$startperiod."' and enrolltime<='".$endperiod."' and student_id='".$student_id."'";
		$courses_res=$dbObj->fireQuery($student_course_sql,'select');
		
		$student_past_course_sql="select * from  student_courses_1 where enrolltime<'".$startperiod."' and enrolltime<'".$endperiod."' and student_id='".$student_id."'";
		$past_courses_res=$dbObj->fireQuery($student_past_course_sql,'select');
		?>
<!--- section for student course listing Start Here-->
		 <div id="cclass">
      <div id="cc-head">
        <div id="cc-text">Your Classes</div>
        <?php if(isset($courses_res) && count($courses_res)<4){?>
        <a id="cc-join" href="?pg=search&univid=<?php echo $university_id; ?>&act=course">Browse</a>
        <?php }?>
      </div>
      <?php
				if(isset($courses_res) && $courses_res!=false && count($courses_res)>0)
				{
					for($i=0;$i<count($courses_res);$i++)
					{
						$prof_name='';
						$course_name='';
						$course_id=$courses_res[$i]['course_id'];
						$course_detail=getcoursedetail($course_id);
						$course_name=$course_detail['name'];
						$coursepic= $course_detail['coursepic'];
						$location= $course_detail['imagepath'];
						$imagepath=$SITE_URL.'images/noimage.jpg';
						$profid= $course_detail['profid'];
						if (is_numeric($profid)) {
							$profdetail=getprofessordetail($profid);
							$prof_name=$profdetail['name'];
						} else {
							$prof_name=$profid;
						}
						if(isset($coursepic) && $coursepic!='')
						{
							$filepath=$SITE_PATH.$location.'/'.$coursepic;
							if(file_exists($filepath))
							{
								$imagepath=$SITE_URL.$location.'/'.$coursepic;
							}
						}
						?>
      <a href="" class="blackhref">
      <div class="mimicbutton cc"> <img src="<?php echo $imagepath; ?>" class="cc-i" width="30" height="30">
        <div class="cc-n"><?php echo substr($course_name,0,15); ?></div>
        <div class="cc-p"><a href="" class="blackhref">
          <?php  echo substr($prof_name,0,15);?>
          </a></div>
      </div>
      </a>
      <?php
					}
				} 
				?>
      <div id="past_classes" style="display:none;">
        <?php
				if(isset($past_courses_res) && $past_courses_res!=false && count($past_courses_res)>0)
				{
					for($i=0;$i<count($past_courses_res);$i++)
					{
						$prof_name='';
						$course_name='';
						$course_id=$past_courses_res[$i]['course_id'];
						$course_detail=getcoursedetail($course_id);
						$course_name=$course_detail['name'];
						$coursepic= $course_detail['coursepic'];
						$location= $course_detail['imagepath'];
						$imagepath=$SITE_URL.'images/noimage.jpg';
						$profid= $course_detail['profid'];
						$profdetail=getprofessordetail($profid);
						$prof_name=$profdetail['name'];
						if(isset($coursepic) && $coursepic!='')
						{
							$filepath=$SITE_PATH.$location.'/'.$coursepic;
							if(file_exists($filepath))
							{
								$imagepath=$SITE_URL.$location.'/'.$coursepic;
							}
						}
						?>
        <a href="" class="blackhref">
        <div class="mimicbutton cc"> <img src="<?php echo $imagepath; ?>" class="cc-i" width="30" height="30">
          <div class="cc-n"><?php echo substr($course_name,0,15); ?></div>
          <div class="cc-p"><a href="#" class="blackhref">
            <?php  echo $prof_name;?>
            </a></div>
        </div>
        </a>
        <?php
					}
				} 
				?>
      </div>
      <div id="cc-end"><a href="javascript:void(0);" class="pastclasslink bluehref">See my past classes &#9662;</a></div>
      <script language="javascript" type="text/javascript">
		$(".pastclasslink").click(function(){
			//$(".pastclasslink").val()='See my current classes &#9652;';
			$("#past_classes").slideToggle("slow");
		});
		</script>
    </div>
		<!-- section for student course listing End Here-->
		<?php
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$professor_id=$_SESSION['professor_id'];
		$professor_course_sql="select * from   course_1 where profid='".$professor_id."' and universityid='".$university_id."'";
		$courses_res=$dbObj->fireQuery($professor_course_sql,'select');
	?>
	<!-- section for Professor course listing Start Here-->
	<div id="cclass">
      <div id="cc-head">
        <div id="cc-text">Your Classes</div>
        <a id="cc-join" href="?pg=search&univid=<?php echo $university_id; ?>&act=course">Browse</a>
      </div>
      <?php
	  if(isset($courses_res) && $courses_res!=false && count($courses_res)>0)
	  {
		 for($i=0;$i<count($courses_res);$i++)
		 {
			$prof_name='';
			$course_name='';
			$courseid=$courses_res[$i]['courseid'];
			$course_name=$courses_res[$i]['name'];
			$coursepic= $courses_res[$i]['coursepic'];
			$location= $courses_res[$i]['imagepath'];
			$imagepath=$SITE_URL.'images/noimage.jpg';
			$profid= $courses_res[$i]['profid'];
			if (is_numeric($profid)) {
				$profdetail=getprofessordetail($profid);
				$prof_name=$profdetail['name'];
			} else {
				$prof_name=$profid;
			}
			if(isset($coursepic) && $coursepic!='')
			{
				$filepath=$SITE_PATH.$location.'/'.$coursepic;
				if(file_exists($filepath))
				{
					$imagepath=$SITE_URL.$location.'/'.$coursepic;
				}
			}
			if($i==4){?><div id="more_classes" style="display:none;"><?php }
			?>
			  <a href="" class="blackhref">
			  <div class="mimicbutton cc"> <img src="<?php echo $imagepath; ?>" class="cc-i" width="30" height="30">
				<div class="cc-n"><?php echo substr($course_name,0,15); ?></div>
				<div class="cc-p"><a href="" class="blackhref">
				  <?php  echo substr($prof_name,0,15);?>
				  </a></div>
			  </div>
			  </a>
	      <?php
		  }
	  } 
	  if(count($courses_res)>3){?></div><?php }
	  ?>
      <div id="cc-end"><a href="javascript:void(0);" class="moreclasslink bluehref">See my more classes &#9662;</a></div>
      <script language="javascript" type="text/javascript">
		$(".moreclasslink").click(function(){
			$("#more_classes").slideToggle("slow");
			if($(".moreclasslink").text()=='Hide Classes')
			{
				$(".moreclasslink").text('See my more classes');
			}
			else
			{
				$(".moreclasslink").text('Hide Classes');
			}
		});
		</script>
    </div>
	<!-- section for Professor course listing End Here-->
	<?php 
	}
	?>
    <div id="club">
      <div id="cb-head">
        <div id="cb-text">Your Clubs</div>
        <a id="cb-join" href="?pg=search&univid=<?php echo $university_id; ?>&act=club">Browse</a>
      </div>
	  <?php 
	  if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	  {
	  $student_id=$_SESSION['student_id'];	
	  ///////// get all club list in which user joined /////////////////////////////////
	  $clubssel_sql="SELECT g.*,ga.* FROM groups_1 g,groups_admin_1 ga,groups_student_1 gs WHERE gs.groupid=g.groupid and gs.studid='".$student_id."' and g.groupid=ga.groupid and g.universityid='".$university_id."'";
	  $clubsRes = $dbObj->fireQuery($clubssel_sql,'select');
	  if(isset($clubsRes) && count($clubsRes)>0 && $clubsRes!=false)
	  {
			for($c=0;$c<count($clubsRes);$c++)
			{
				$club_id=$clubsRes[$c]['groupid'];
				$clubname=$clubsRes[$c]['groupname'];
				$profid=$clubsRes[$c]['profid'];
				$name=$clubsRes[$c]['name'];
				$imagepath=$SITE_URL.'images/noimage.jpg';
				?>
				<a href="" class="blackhref">
			      <div class="mimicbutton cc"> <img src="<?php echo $imagepath; ?>" class="cc-i" width="30" height="30">
			        <div class="cc-n"><?php echo substr($clubname,0,15);?></div>
			        <div class="cc-p"><?php if($profid!=0){echo "<a class='blackhref'href='professor_profile.php?profid=$profid'>".getprofessordetail($profid,'name')."</a>";}else{ echo $name;} ?></div>
      				</div>
			    </a>
				<?php
			}
		}else{
	 	 ?>
	 	 <div id="cb-no-club">
        	<div id="cb-alert"><img src="images/alert.png" id="alert-icon">
        	  <div id="alert-text">You aren't in any clubs.</div>
          	<a href="?pg=search&univid=<?php echo $university_id; ?>&act=club" class="button">Join or Create a Club</a> </div>
      	</div>
		<?php }?>
	  <br class="clear"/>
	  <?php }
	  elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	  {
	  $professor_id=$_SESSION['professor_id'];
	  ///////// get all club list in which professor joined /////////////////////////////////
	  $clubssel_sql="SELECT g.*,ga.* FROM groups_1 g,groups_admin_1 ga,groups_professor_1 gp WHERE gp.groupid=g.groupid and gp.profid='".$professor_id."' and g.groupid=ga.groupid and g.universityid='".$university_id."'";
	  $clubsRes = $dbObj->fireQuery($clubssel_sql,'select');
	  if(isset($clubsRes) && count($clubsRes)>0 && $clubsRes!=false)
	  {
			for($c=0;$c<count($clubsRes);$c++)
			{
				$club_id=$clubsRes[$c]['groupid'];
				$clubname=$clubsRes[$c]['groupname'];
				$profid=$clubsRes[$c]['profid'];
				$name=$clubsRes[$c]['name'];
				$imagepath=$SITE_URL.'images/noimage.jpg';
				?>
				<a href="" class="blackhref">
			      <div class="mimicbutton cc"> <img src="<?php echo $imagepath; ?>" class="cc-i" width="30" height="30">
			        <div class="cc-n"><?php echo substr($clubname,0,15);?></div>
			        <div class="cc-p"><?php if($profid!=0){echo "<a class='blackhref' href='professor_profile.php?profid=$profid'>".getprofessordetail($profid,'name')."</a>";}else{ echo $name;} ?></div>
      				</div>
			    </a>
				<?php
			}
		}else{
	 	 ?>
	 	 <div id="cb-no-club">
        	<div id="cb-alert"><img src="images/alert.png" id="alert-icon">
        	  <div id="alert-text">You aren't in any clubs.</div>
          	<a href="?pg=search&univid=<?php echo $university_id; ?>&act=club" class="button">Join or Create a Club</a> </div>
      	</div>
		<?php }
	  ?>
	  <br class="clear"/>
	  <?php }?>
    </div>
  </div>
</section>

    
<section id="main">


<div id="head">
<div id="univ-cov" style="background-image:url('images/NYU_cover.JPG');">
<a class="iconborder">
<img id="univicon" src="images/NYU_logo.png">
</a>
<div id="univname">Dummy name for Department</div>
    
</div>
    
<div id="tab">
    <a href="#" rel="#default" id="tab_0" class="greyhref maintab">Feed</a>
    <a href="faculty.php?univid=<?php echo $university_id; ?>&deptid=<?php echo $department_id;?>" rel="#iframe" id="tab_1" class="greyhref3 maintab">Faculty</a>
    <a href="course.php?univid=<?php echo $university_id; ?>&deptid=<?php echo $department_id;?>" rel="#iframe" id="tab_2" class="greyhref3 maintab">Courses</a>
    <a href="file_upload.php?univid=<?php echo $university_id; ?>&deptid=<?php echo $department_id;?>" rel="#iframe" id="tab_3" class="greyhref3 maintab">File</a>
</div>

</div>
   
<section id="midsec">
  <div id="poster">
    <form id="frmpost" name="frmpost" method="post">
      <div id="postborder">
        <textarea name="message" id="postarea" onclick="expandPost()" placeholder="Share your notes..."></textarea>
        <div id="controls">
          <p>Who can see this post?</p>
         
          <div class="visibility">
			<select id="cd-dropdown" class="cd-select" name="visibility" >
				<option value="Public" class="icon-globe" selected>Everyone</option>
				<option value="Student" class="icon-users">Only Students</option>
				<option value="Faculty" class="icon-briefcase">Only Faculty</option>
			</select>
		   </div>

          <input id="post" type="button" name="btnpost" value="Post" onClick="saveforum();" />
        </div>
      </div>
      <div id="wedge"></div>
      <div id="outerwedge"></div>
      <div id="t-post"><img class = "icon" id = "posticon" src = "images/post.png" >Write Post</div>
      <div id="t-upload"><img class = "icon" id = "uploadicon" src = "images/upload.png" ><a class="fancy_div upload" data-fancybox-type="iframe" href="<?php echo $SITE_URL; ?>post_upload.php?univid=<?php echo $university_id; ?>&fromwhere=home">Upload File</a></div>
      <!--<div class="postto"><button class="posttobutton">Post</button></div>-->
    </form>
  </div>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script language="javascript" type="text/javascript">
   $(document).ready(function() {

   	        $(window).scroll(function() {
			if($(this).scrollTop()>235){
				$('#calendar').css({'position':'fixed',"margin-top":"10px"});
			}else{
				$('#calendar').css({'position':'absolute',"margin-top":"245px"});
			}
		});
	/// Collapse all sections by default

	$(".accordion .sprate_div").slideUp("slow");

	$(document).delegate(".accordion .sprate_header","mousedown",function(){
		if($(this).next("div").is(":visible")){
			$(this).next("div").slideUp("slow");
		} else {
		//$(".accordion .sprate_div").slideUp("slow");
		$(this).next("div").slideToggle("slow");
		}
		});
	
	$(document).delegate(".linqthis","mousedown",function(){
	   var $linqid= $(this).attr("id").substring(2);
	   action_vals=$linqid.split("_");
	   /*userid is the one who is viewing this page*/
		<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){?>
				var userid= <?php echo $_SESSION['student_id']; ?>;
				var whoislogin='Student';
				<?php
		  }elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor'){?>
				var userid= <?php echo $_SESSION['professor_id']; ?>;
				var whoislogin='Professor';
		<?php }?>
	   var action= action_vals[0];
	   var linqid= action_vals[1];														
   		/*Ajax , end info to backend, to inform that user and this object has linqed*/
   		$.ajax({
		  url: 'linq.php',
		  data: 'user='+ userid +'&linqid='+ linqid +'&action=' + action +'&univ_id=<?php echo $university_id; ?>'+'&whoislogin='+whoislogin,
		  type: "POST",
		  success: function(msg) {
			result=msg.split("|||");
			if(result[0]==1){
				//alert(result[1]);
				window.location.reload();
			}
			if(result[0]==0){
				alert(result[1]);
				
				/*change the button css*/
				/*$('#'+button_id).val(0);
 			    $('#'+button_id).text(v00);
				$('#'+button_id).css({"background":"linear-gradient(#fff,#ddd)","background-color":"#ddd","color":"black","border":"1px solid #ccc"});*/
   
			}
		  }
		  });
   });
	
	});
	function deletenotification(notification_id)
	{
		if(confirm("are you sure want to delete this notification?"))
		{
			$.ajax({
			type: "POST",
			url: "deletenotification.php",
			data: { notification_id: notification_id}
			})
			.done(function( msg ) {
				if(msg==1)
				{
					window.location.reload();
				}
			});
		}
	}

	function expandPost() {
    $('#postarea').animate({height:'43px'}, 500);
    $('#poster').animate({height:'100px'}, 500);
    setTimeout(function(){
	    document.getElementById('t-post').style.visibility="visible";
	    document.getElementById('t-upload').style.visibility="visible";
	},501);
	document.getElementById('wedge').style.visibility="visible";
	document.getElementById('outerwedge').style.visibility="visible";

	}

  </script>
    <div class="accordion" id="notification_tab">
  <div class="sprate_header">Notifications</div>
  <div class="sprate_div">
   <?php 
		 if(isset($notificationRes) && count($notificationRes)>0 && $notificationRes!=false)
		 {
				$notification_msg='';
				for($i=0;$i<count($notificationRes);$i++)
				{
					$notification_id=$notificationRes[$i]['notification_id'];
					$message=$notificationRes[$i]['message'];
					$student_id=$notificationRes[$i]['student_id'];
					$professor_id=$notificationRes[$i]['professor_id'];
					$linqed_professor_id=$notificationRes[$i]['linqed_professor_id'];
					$linqed_student_id=$notificationRes[$i]['linqed_student_id'];
					$course_id=$notificationRes[$i]['course_id'];
					$club_id=$notificationRes[$i]['club_id'];
					if($message=='LINQ')
					{
						if($student_id>0){$who_follow=getstudentdetail($student_id,'name');}else{$who_follow=getprofessordetail($professor_id,'name');}	
						if($_SESSION['usertype']=='Student' && $linqed_student_id==$_SESSION['student_id']){$whom_follow='you';}
						elseif($_SESSION['usertype']=='Student' &&  $linqed_student_id>0){$whom_follow=getstudentdetail($linqed_student_id,'name');}
						elseif($_SESSION['usertype']=='Student' &&  $linqed_professor_id>0){$whom_follow=getprofessordetail($linqed_professor_id,'name');}	
						
						if($_SESSION['usertype']=='Professor' && $linqed_professor_id==$_SESSION['professor_id']){$whom_follow='you';}
						elseif($_SESSION['usertype']=='Professor' && $linqed_professor_id>0){$whom_follow=getprofessordetail($linqed_professor_id,'name');}
						elseif($_SESSION['usertype']=='Professor' && $linqed_student_id>0){$whom_follow=getstudentdetail($linqed_student_id,'name');}	
						$notification_msg= $who_follow.' has linqed '.$whom_follow;
						?>
						<div class="noti-view"><?php echo $notification_msg;?>
						<?php if($student_id>0 && $linqed_professor_id>0 && professorlinqedstudent($_SESSION['professor_id'],$student_id)==0){ ?>
						<button value="0" id="m-student_<?php echo $student_id; ?>" class="linqthis" style="background: linear-gradient(#60D62D, #3DA50D) repeat-x scroll 0 0 #60D62D;border: 1px solid #3B6E22;color: #FFFFFF;width: auto;">Linq</button>
						<?php }elseif($student_id>0 && $linqed_student_id>0 && isstudentlinqed($_SESSION['student_id'],$student_id)==0){?>
						<button value="0" id="m-student_<?php echo $student_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
						<?php }elseif($professor_id>0 && $linqed_student_id>0 && isprofessorlinqed($_SESSION['student_id'],$professor_id)==0){ ?>
						<button value="0" id="m-professor_<?php echo $professor_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
						<?php }elseif($professor_id>0 && $linqed_professor_id>0 && professorlinqedprofessor($_SESSION['professor_id'],$professor_id)==0){?>
						<button value="0" id="m-professor_<?php echo $professor_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Linq</button>
						<?php } ?>
						<a onClick="deletenotification('<?php echo $notification_id; ?>');" href="javascript:void(0)"><img class="n-hide" src="images/exit-btn.png"></a>
						</div><?php
						
					}
					elseif($message=='ENROLL')
					{
						if($student_id>0){$who_join=getstudentdetail($student_id,'name');}else{$who_join=getprofessordetail($professor_id,'name');}	
						if($course_id>0){$course_name=getcoursedetail($course_id,'name');}
						$notification_msg= $who_join.' has enrolled in '.$course_name;
						if($_SESSION['usertype']=='Student'){$coursedjoin=enrolledincourse($_SESSION['student_id'],$course_id,$university_id);}
						if($_SESSION['usertype']=='Professor'){ $course_prof_id=getcoursedetail($course_id,'profid'); if($course_prof_id==$_SESSION['professor_id']){$coursedjoin=1;}else{$coursedjoin=0;}}
						?><div class="noti-view"><?php echo $notification_msg;?>
						<?php if($coursedjoin==0){ ?>
						<button value="0" id="m-courses_<?php echo $course_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Add</button>
						<?php } ?>
						<a onClick="deletenotification('<?php echo $notification_id; ?>');" href="javascript:void(0)"><img class="n-hide" src="images/exit-btn.png"></a>
						</div><?php
					}
					elseif($message=='JOIN')
					{
						if($student_id>0){$who_join=getstudentdetail($student_id,'name');}else{$who_join=getprofessordetail($professor_id,'name');}	
						if($club_id>0){$club_name=getclubdetail($club_id,'groupname');}
						$notification_msg= $who_join.' has joined in '.$club_name;
						$isclubjoined=clubjoined($club_id);
						?><div class="noti-view"><?php echo $notification_msg;?>
						<?php if($isclubjoined==0){ ?>
						<button value="0" id="m-clubs_<?php echo $club_id; ?>" class="linqthis" style="background: linear-gradient(rgb(255, 255, 255), rgb(221, 221, 221)) repeat scroll 0% 0% rgb(221, 221, 221); color: black; border: 1px solid rgb(204, 204, 204); width: auto;">Join</button>
						<?php } ?>
						<a onClick="deletenotification('<?php echo $notification_id; ?>');" href="javascript:void(0)"><img class="n-hide" src="images/exit-btn.png"></a>
						</div><?php
					}
				}
		 }
	?>
  </div>
  </div>
  <div id="topics">
    <?php
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']!='')
	{
		if(isset($university_id) && $university_id!='')
		{
			$univid=$university_id;
			if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
			{
				$visibility='Student';
				$user_id=$_SESSION['student_id'];
				$field_name='studentid';
			}
			elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
			{
				$visibility='Faculty';
				$user_id=$_SESSION['professor_id'];
				$field_name='profid';
			}
			///////// get all forums for professor /////////
			$forumListQry = "select * from  home_posts where univid='".$univid."' and (visibility='".$visibility."' OR visibility='Public') OR (`".$field_name."`='".$user_id."') order by update_timestamp desc ";
			$forumListRes = $dbObj->fireQuery($forumListQry,'select');
			if(isset($forumListRes) && count($forumListRes)>0 && $forumListRes!=false)
			{
				for($i=0;$i<count($forumListRes);$i++){
				$messageid=$forumListRes[$i]['messageid'];
					$studentid=$forumListRes[$i]['studentid'];
					$profid=$forumListRes[$i]['profid'];
					$univid=$forumListRes[$i]['univid'];
					$message=$forumListRes[$i]['message'];
					
					$file=$forumListRes[$i]['file'];
					$file_ext=$forumListRes[$i]['file_ext'];
					$file_name=$forumListRes[$i]['file_name'];
					$filelocation=$forumListRes[$i]['filelocation'];
					$file_description=$forumListRes[$i]['file_description'];
						
					$update_timestamp=$forumListRes[$i]['update_timestamp'];
					$like_cnt=$forumListRes[$i]['like_cnt'];
					if($profid>0)
					{
						$userdetail=getprofessordetail($profid);
					}
					elseif($studentid>0)
					{
						$userdetail=getstudentdetail($studentid);
					}
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
				//////////// get all replay of the post update desc
				$forumreplyListQry = "select * from  home_reply where messageid='".$messageid."' order by update_timestamp desc ";
				$forumreplyListRes = $dbObj->fireQuery($forumreplyListQry,'select');
					if(isset($file) && $file!=''){ ?>
    <div class="post">
      <?php if(($_SESSION['usertype']=='Student' && $user_id==$studentid) || ($_SESSION['usertype']=='Professor' && $user_id==$profid)){?>
      <a href="javascript:void(0)" onClick="deletepost('<?php echo $messageid; ?>');"><img class="p-hide" src="images/exit-btn.png"></a>
      <?php }?>
      <button class="post_tag tags">Document
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img width="52" height="52" src="<?php echo $imagepath; ?>" class="post_photo">
        <div class="post_name"><?php echo $username; ?></div>
        <div class="post_des">Posted <?php echo time_passed(strtotime($update_timestamp));?></div>
      </div>
      <div class="post_text">
        <div class="post_say">
          <div class="doc"> <img src="images/doc-icon-2.png" class="docicon">
            <div class="docdes">
              <?php if($file_name!=''){ echo $file_name;}else{ echo $file;} ?>
            </div>
            <div class="doctail">
              <?php 
								//////// Check if user already like this post then unlike it 
								$sel_sql="SELECT count(*) as total_likes,home_post_lkid  FROM `home_posts_likes` where postid='".$messageid."' and studentid='".$studentid."' and profid='".$profid."' and univid='".$univid."'";
								$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
								if($sel_cnt[0]['total_likes']>0)
								{
									$like_img='<img class="likepic likeinfile liked" id="leclike-1" src="images/liked-button.png">';
								}
								else
								{
									$like_img='<img src="images/like.png" id="leclike-1" class="likepic likeinfile" alt="">';
								}
								?>
              <a href="Javascript:void(0)" onClick="likethepost('<?php echo $messageid; ?>','post');" ><?php echo $like_img; ?></a> <a href="<?php echo $SITE_URL.'download.php?filename='.base64_encode($filelocation); ?>" class="external-link" target="_blank"><img src="images/download-button.png" class="download" id="docdown_0"></a> <br class="clear" />
              &nbsp;&nbsp; </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <div class="post_content">
        <div class="like"></div>
        <?php 
						if(isset($forumreplyListRes) && $forumreplyListRes!=false && count($forumreplyListRes)>0)
						{
							?>
        <div class="comment">
          <?php
							$cmt=0;
							foreach($forumreplyListRes as $repcnt=>$replymsg)
							{
								$replyid=$replymsg['replyid'];
								$reply_msg=$replymsg['replymessage'];
								$reply_update_timestamp=$replymsg['update_timestamp'];
								$reply_studid=$replymsg['studentid'];
								$reply_profid=$replymsg['profid'];
								$reply_like_cnt=$replymsg['like_cnt'];
								if($reply_profid>0)
								{
									$reply_userdetail=getprofessordetail($reply_profid);
								}
								elseif($reply_studid>0)
								{
									$reply_userdetail=getstudentdetail($reply_studid);
								}
								$reply_imagepath=$SITE_URL.'images/noimage.jpg';
								if(isset($userdetail) && count($userdetail)>0)
								{
									
									$profilepic= $reply_userdetail['profilepic'];
									$location   = $reply_userdetail['location'];
									if(isset($profilepic) && $profilepic!='')
									{
										$filepath=$SITE_PATH.$location.'/'.$profilepic;
										if(file_exists($filepath))
										{
											$reply_imagepath=$SITE_URL.$location.'/'.$profilepic;
										}
									}
								}
								if($cmt==1){ ?>
          <div id="comment_<?php echo $messageid; ?>" style="display:none;">
            <?php }?>
            <div class="cmt-view">
              <div class="cmt_head"> <img src="<?php echo $reply_imagepath;?>" width="52" height="52" class="cmt-photo"><span class="cmt-name"><?php echo $reply_userdetail['name']; ?></span> <span class="time"><?php echo time_passed(strtotime($reply_update_timestamp));?></span> </div>
              <div class="cmt-tail"> <?php echo $reply_msg; ?>
                <?php
										/////// Check if user already like this comment then unlike it 
										$sel_sql="SELECT count(*) as total_likes,home_reply_lkid FROM `home_reply_likes` where replyid='".$replyid."' and studentid='".$studentid."' and profid='".$profid."'  and univid='".$univid."'";
										$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
										if($sel_cnt[0]['total_likes']>0)
										{
											$like_img='<img class="like liked" id="likecomment_0" style="width:25px !important; height:25px !important;margin-left:0px !important; margin-top:0px !important;" src="images/liked-button.png">';
										}
										else
										{
											$like_img='<img src="images/like.png" id="likecomment_0" style="width:25px !important; height:25px !important;margin-left:0px !important; margin-top:0px !important" class="like" alt="">';
										}
										?>
                <br class="clear" />
                <a href="Javascript:void(0)" onClick="likethepost('<?php echo $replyid; ?>','reply');"><?php echo $like_img; ?></a> <span><?php echo $reply_like_cnt; ?></span> </div>
            </div>
            <?php
								$cmt++;
							}
							if($cmt>1){?>
          </div>
          <?php }
							?>
        </div>
        <?php
						}
		?>
        <?php if(count($forumreplyListRes)>1){ ?>
        <div class="view_more"> <a href="Javascript:void(0);" id="message_<?php echo $messageid; ?>">
          <div class="viewmore">View More</div>
          </a>
          <script language="javascript" type="text/javascript">
						$("#message_<?php echo $messageid; ?>").click(function(){
							//$(".pastclasslink").val()='See my current classes &#9652;';
							$("#comment_<?php echo $messageid; ?>").slideToggle("slow");
						});
						</script>
        </div>
        <?php }?>
        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>
      </div>
    </div>
    <?php }else{?>
    <div class="post">
      <?php if(($_SESSION['usertype']=='Student' && $user_id==$studentid) || ($_SESSION['usertype']=='Professor' && $user_id==$profid)){?>
      <a href="javascript:void(0)" onClick="deletepost('<?php echo $messageid; ?>');"><img class="p-hide" src="images/exit-btn.png"></a>
      <?php }?>
      <button class="post_tag tags">Urlinq Event
      <div class="outpart"></div>
      </button>
      <div class="post_head"> <img width="52" height="52" src="<?php echo $imagepath; ?>" class="post_photo">
        <div class="post_name"><?php echo $username; ?></div>
        <div class="post_des">Posted <?php echo time_passed(strtotime($update_timestamp));?></div>
      </div>
      <div class="post_text">
        <div class="post_say"><?php echo $message;?></div>
      </div>
      <div class="post_content">
        <?php 
						$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
						if(preg_match($reg_exUrl, $message, $url)) 
						{
							if($url[0]!='')
							{
								echo '<a class="play" href="'.$url[0].'"></a>';
							}
						}
						
						?>
        <div class="like">
          <?php 
					//////// Check if user already like this post then unlike it 
					$sel_sql="SELECT count(*) as total_likes,home_post_lkid  FROM `home_posts_likes` where postid='".$messageid."' and studentid='".$studentid."' and profid='".$profid."' and univid='".$univid."'";
					$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
					if($sel_cnt[0]['total_likes']>0)
					{
						$like_img='<img class="likepic liked" id="leclike-1" src="images/liked-button.png">';
					}
					else
					{
						$like_img='<img src="images/like.png" id="leclike-1" class="likepic" alt="">';
					}
					?>
          <a href="Javascript:void(0)" onClick="likethepost('<?php echo $messageid; ?>','post');"><?php echo $like_img; ?></a>
          <div class="likes"><?php echo $like_cnt; ?></div>
        </div>
        <?php 
						if(isset($forumreplyListRes) && $forumreplyListRes!=false && count($forumreplyListRes)>0)
						{
							?>
        <div class="comment">
          <?php
							$cmt=0;
							foreach($forumreplyListRes as $repcnt=>$replymsg)
							{
								$replyid=$replymsg['replyid'];
								$reply_msg=$replymsg['replymessage'];
								$reply_update_timestamp=$replymsg['update_timestamp'];
								$reply_studid=$replymsg['studentid'];
								$reply_profid=$replymsg['profid'];
								$reply_like_cnt=$replymsg['like_cnt'];
								if($reply_profid>0)
								{
									$reply_userdetail=getprofessordetail($reply_profid);
								}
								elseif($reply_studid>0)
								{
									$reply_userdetail=getstudentdetail($reply_studid);
								}
								$reply_imagepath=$SITE_URL.'images/noimage.jpg';
								if(isset($userdetail) && count($userdetail)>0)
								{
									
									$profilepic= $reply_userdetail['profilepic'];
									$location   = $reply_userdetail['location'];
									if(isset($profilepic) && $profilepic!='')
									{
										$filepath=$SITE_PATH.$location.'/'.$profilepic;
										if(file_exists($filepath))
										{
											$reply_imagepath=$SITE_URL.$location.'/'.$profilepic;
										}
									}
								}
								?>
          <?php if($cmt==1){ ?>
          <div id="comment_<?php echo $messageid; ?>" style="display:none;">
            <?php }?>
            <div class="cmt-view">
              <div class="cmt_head"> <img src="<?php echo $reply_imagepath;?>" width="52" height="52" class="cmt-photo"><span class="cmt-name"><?php echo $reply_userdetail['name']; ?></span> <span class="time"><?php echo time_passed(strtotime($reply_update_timestamp));?></span> </div>
              <div class="cmt-tail"> <?php echo $reply_msg; ?>
                <?php
										/////// Check if user already like this comment then unlike it 
										$sel_sql="SELECT count(*) as total_likes,home_reply_lkid FROM `home_reply_likes` where replyid='".$replyid."' and studentid='".$studentid."' and profid='".$profid."'  and univid='".$univid."'";
										$sel_cnt=$dbObj->fireQuery($sel_sql,'select');
										if($sel_cnt[0]['total_likes']>0)
										{
											$like_img='<img class="like liked" id="likecomment_0" style="width:25px !important; height:25px !important;margin-left:0px !important; margin-top:0px !important;" src="images/liked-button.png">';
										}
										else
										{
											$like_img='<img src="images/like.png" id="likecomment_0" style="width:25px !important; height:25px !important;margin-left:0px !important; margin-top:0px !important" class="like" alt="">';
										}
										?>
                <br class="clear" />
                <a href="Javascript:void(0)" onClick="likethepost('<?php echo $replyid; ?>','reply');"><?php echo $like_img; ?></a> <span><?php echo $reply_like_cnt; ?></span> </div>
            </div>
            <?php
								$cmt++;
							}
							if($cmt>1){?>
          </div>
          <?php }
							?>
        </div>
        <?php
						}
					?>
        <?php if(count($forumreplyListRes)>1){ ?>
        <div class="view_more"> <a href="Javascript:void(0);" id="message_<?php echo $messageid; ?>">
          <div class="viewmore">View More</div>
          </a>
          <script language="javascript" type="text/javascript">
						$("#message_<?php echo $messageid; ?>").click(function(){
							//$(".pastclasslink").val()='See my current classes &#9652;';
							$("#comment_<?php echo $messageid; ?>").slideToggle("slow");
						});
						</script>
        </div>
        <?php }?>
        <div class="p-comment-1">
          <div class="makecomment_1">
            <input name="comment" class="comment-textarea mc_1" type="text" id="mc_<?php echo $messageid; ?>" placeholder="Add a comment..."/>
            <div class="mcp_1"><a href="Javascript:void(0)" onClick="savecomments('<?php echo $messageid; ?>')" class="greyhref2">Post</a></div>
          </div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
    <?php
				  }
				}
			}
		 }
	}
	?>
    <div id="post_end"></div>
  </div>

</section>	 <!--- Calender HTML START HERE ---->

	<section id="calendar">
  <div id="cd-head">
    <div id="cd-text">Upcoming at NYU</div>
    <button id="cd-join">Add Event</button>
    <button id="cal-view"><img src = "images/calview2.png" class = "calview-icon"> </button>
  </div>
  <div id="cd-contents">
    <?php
	$lasteventdate='';
	$eventsres=gettopseveneventforhomepage($university_id);
	if(isset($eventsres) && count($eventsres)>0 && $eventsres!=false)
	{
		$event_list=array();
		for($e=0;$e<count($eventsres);$e++)
		{
			$eventid=$eventsres[$e]['eventid'];
			$eventname=$eventsres[$e]['title'];
			$eventdesc=$eventsres[$e]['description'];
			$start_time=$eventsres[$e]['start'];
			$end_time=$eventsres[$e]['end'];
			$eventype=$eventsres[$e]['eventype'];
			$evtdate=date("Y-m-d",strtotime($end_time));
			if($e==(count($eventsres)-1)){$lasteventdate=date("Y-m-d",strtotime($end_time));}
			$event_list[$evtdate][]=array('eventid'=>$eventid,'eventname'=>$eventname,'eventdesc'=>$eventdesc,'start_time'=>$start_time,'end_time'=>$end_time,'eventype'=>$eventype);
		}
		foreach($event_list as $evtdate=>$eventdet)
		{
			$iscurrentdate=0;
			if($evtdate==date("Y-m-d")){$iscurrentdate=1;}else{$iscurrentdate=0;}
			?>
    <div class="cd <?php echo ($iscurrentdate?'today-cd':''); ?>">
      <div class="cd-head"><?php echo date("l",strtotime($evtdate)); ?><br>
        <span class="date"> <?php echo date("m/d",strtotime($evtdate)); ?></span> </div>
      <?php
			for($e=0;$e<count($eventdet);$e++)
			{
			
				$eventid=$eventdet[$e]['eventid'];
				$eventname=$eventdet[$e]['eventname'];
				$eventdesc=$eventdet[$e]['eventdesc'];
				$start_time=$eventdet[$e]['start_time'];
				$end_time=$eventdet[$e]['end_time'];
				$eventype=$eventdet[$e]['eventype'];
				?>
      <div class="cd-evt evts">
        <div class="evt-head now-evt-head"><?php echo date("H:i",strtotime($end_time)); ?></div>
        <div class="evt-tail"><?php echo $eventname; ?></div>
        <div class="wrapper" id="<?php echo $eventype."-".$eventid; ?>">
          <div class="button-block">
            <button type="button"> <i class="mark x"></i> <i class="mark xx"></i> </button>
          </div>
        </div>
      </div>
      <?php
			}
			?>
    </div>
    <?php
		}
	}
	else
	{
		echo "<span class='noeventsalert'>No Events Available</span>";
	}
	?>
	<div id="nextweeksec" style="display:none;">
	<?php 
	if($lasteventdate!='')
	{
		$startdate=date("Y-m-d",strtotime($lasteventdate." 1 Days"));
		$enddate=date("Y-m-d",strtotime($lasteventdate." 7 Days"));
		if($startdate!='' && $enddate!='')
		{
			$nextweekeventres=gettopseveneventforhomepage($university_id,$startdate,$enddate);
			if(isset($nextweekeventres) && $nextweekeventres!=false && count($nextweekeventres)>0)
			{
				for($n=0;$n<count($nextweekeventres);$n++)
				{
					$eventid=$nextweekeventres[$n]['eventid'];
					$eventname=$nextweekeventres[$n]['title'];
					$eventdesc=$nextweekeventres[$n]['description'];
					$start_time=$nextweekeventres[$n]['start'];
					$end_time=$nextweekeventres[$n]['end'];
					$eventype=$nextweekeventres[$n]['eventype'];
					$evtdate=date("Y-m-d",strtotime($end_time));
					?>
					<div class="cd">
					  <div class="cd-head"><?php echo date("l",strtotime($evtdate)); ?><br>
						<span class="date"> <?php echo date("m/d",strtotime($evtdate)); ?></span> </div>
					  	 <div class="cd-evt evts">
						<div class="evt-head now-evt-head"><?php echo date("H:i",strtotime($end_time)); ?></div>
						<div class="evt-tail"><?php echo $eventname; ?></div>
						<div class="wrapper" id="<?php echo $eventype."-".$eventid; ?>">
						  <div class="button-block">
							<button type="button"> <i class="mark x"></i> <i class="mark xx"></i> </button>
						  </div>
						</div>
					  </div>
					</div>
					<?php
				}
			}
		}
	}
	?>
	</div>
  </div>
  <?php if($lasteventdate!='' && count($nextweekeventres)>0 && $nextweekeventres!=false){ ?>
  <div id="seemore"><a href="javascript:void(0);" class="nextweeklink">See more of your week &#9662;</a></div>
   <script language="javascript" type="text/javascript">
		$(".nextweeklink").click(function(){
			$("#nextweeksec").slideToggle("slow");
			if($(".nextweeklink").text()=="Hide Week Event")
			{
				$(".nextweeklink").text("See more of your week");
			}
			else
			{
				$(".nextweeklink").text("Hide Week Event");
			}		
		});
	</script>
  <?php }?>
</section>

  <script type="text/javascript">
var countries=new ddajaxtabs("tab", "midsec")
countries.setpersist(false)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()
countries.expandit('tab_0')
</script>

</section>

</body>    
</html>