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
<link rel="stylesheet" type="text/css" href="css/home.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>

<!--<script type="text/javascript" src="js/lib/jquery-1.10.1.min.js"></script>-->
<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />


<!--<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />-->

<script src="http://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
<script src="js/banner.js"></script>
<link rel="stylesheet" type="text/css" href="css/banner.css">
<script language="javascript" type="text/javascript">
$(document).ready(function() {
                  
                  $.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';
                  
                  $('.play').embedly({
                                                            query: {
                                                            maxwidth:"500px",
                                                            maxheight:"250px",
                                                            autoplay:true
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
                                                                var data = $(this).data('embedly');
                                                                
                                                                if(data.type==='video'){
																$(this).replaceWith(data.html);

																return false;
																}
																
                                                                  });
                  
                  $(document).delegate(".cc","mouseover",function(){
                                       $(this).css("background-color","#ddddda");
                                       });           
                  $(document).delegate(".cc","mouseout",function(){
                                       $(this).css("background-color","#e5e5e4");
                                       });  
                  
                  $(document).delegate(".pastclasslink","mouseover",function(){
                                       $("#pcwedge").css("opacity","0.7");
                                       });           
                  $(document).delegate(".pastclasslink","mouseout",function(){
                                   $("#pcwedge").css("opacity","1");
                                       }); 
                  
                  $('.button-block button').live('click', function(){
	   var $this = $(this).parent();
	   var $a= $(this).parents(".wrapper");
	   if($a.hasClass("checked")){
	   $a.removeClass('checked');
	   }else{
	   $a.addClass('checked');
	   var event_arr=$a.attr('id').split("-");
	   ///////// Save events data
		//alert(event_arr[0]+" "+event_arr[1]);
		$.ajax({
		type: "POST",
		beforeSend: function(){startloading();},
		url: "checkevents.php",
		data: { eventtype: event_arr[0],event_id:event_arr[1],university_id:university_id}
		})
		.done(function(msg){
		if(msg!='')
		{
			document.getElementById('cd-contents').innerHTML=msg;
			stoploading();
		}
		else
		{
			alert("There is some problem while checking thie event,Please try again.");
			stoploading();
		}

		});
	    }
	   
	   $this.toggleClass('canceled');
	   
	   return false;
	   });      
              
                  /*$('.likepic').on('click', function(){
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
                                               }); */
                  
                  
                  var st= $("#sidebar").offset().left+$("#sidebar").outerWidth();
                  $("#midsec").offset({ left: st });
                  
                  $(window).on('resize', function(){
                               var st= $("#sidebar").offset().left+$("#sidebar").outerWidth();
                               $("#midsec").offset({ left: st });
                               
                               var st2= $("#panel-pi").offset().left;
                               
                               if($("#sidebar").outerWidth()<=280)
                               {
                               $("#midsec").offset({ left: st-20 });
                               }
                               //$("#logo").offset({ left: 30 });
                               });
                  
                  $(document).delegate(".cmt-view","mouseover",function(){
                                       $(this).css("background-color","#f7f7f7");
                                       }); 

                   $(document).delegate(".cmt-view","mouseout",function(){
                                       $(this).css("background-color","white");
                                       });                            

                   /*
                  $(document).delegate(".post","mouseover",function(){
                                       $(this).css("transform","scale(1.01)");
                                       });   
                  
                  $(document).delegate(".post","mouseout",function(){
                                       $(this).css("transform","scale(1)");
                                       }); 
					*/
					
                  $(document).delegate("#notification_tab","mouseover",function(){
                                       $(this).css("transform","scale(1.01)");
                                       });   
                  
                  $(document).delegate("#notification_tab","mouseout",function(){
                                       $(this).css("transform","scale(1)");
                                       }); 

                  

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

});
function startloading() {
        document.getElementById('modal').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
}

function stoploading() {
    document.getElementById('modal').style.display = 'none';
    document.getElementById('fade').style.display = 'none';
}
</script>
</head>
<body>
<?php include_once('include/header.php'); ?>
<style type="text/css">
#fade {
    display: none;
    position:absolute;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #ababab;
    z-index: -1001;
    -moz-opacity: 0.0;
    opacity: .0;
}
#modal {
    display: none;
    position: absolute;
    top: 45%;
    left: 45%;
    width: 64px;
    height: 64px;
    padding:30px 15px 0px;
    border: 3px solid #ababab;
    box-shadow:1px 1px 10px #ababab;
    border-radius:20px;
    background-color: white;
    z-index: 1002;
    text-align:center;
    overflow: auto;
}
</style>
<div id="fade"></div>

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
		<!--- section for student course listing Start Here--->
		 <div id="cclass">
      <div id="cc-head">
        <div id="cc-text">Your Classes</div>
        <?php if(isset($courses_res) && count($courses_res)<4){?>
        <a id="cc-join" href="?pg=search&univid=<?php echo $university_id; ?>&act=course">Browse <img src = "images/right-arrow.png" id = "right-arrow"></a>
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
      
      <div class="mimicbutton cc"> <img src="<?php echo $imagepath; ?>" class="cc-i" width="30" height="30">
        <div class="cc-n"><a href="" class="blackhref"><?php echo substr($course_name,0,15); ?></a></div>
        <div class="cc-p"><a href="" class="blackhref">
          <?php  echo substr($prof_name,0,15);?>
          </a></div>
      </div>
      
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
		<!--- section for student course listing End Here--->
		<?php
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$professor_id=$_SESSION['professor_id'];
		$professor_course_sql="select * from   course_1 where profid='".$professor_id."' and universityid='".$university_id."'";
		$courses_res=$dbObj->fireQuery($professor_course_sql,'select');
	?>
	<!--- section for Professor course listing Start Here--->
	<div id="cclass">
      <div id="cc-head">
        <div id="cc-text">Your Classes</div>
        <a id="cc-join" href="?pg=search&univid=<?php echo $university_id; ?>&act=course">Browse <img src = "images/right-arrow.png" id = "right-arrow"> </a>
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
	<!--- section for Professor course listing End Here--->
	<?php 
	}
	?>
    <div id="club">
      <div id="cb-head">
        <div id="cb-text">Your Clubs</div>
        <a id="cb-join" href="?pg=search&univid=<?php echo $university_id; ?>&act=club">Browse <img src = "images/right-arrow.png" id = "right-arrow"></a>
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
			        <div class="cc-p"><?php if($profid!=0){echo "<a href='professor_profile.php?profid=$profid'>".getprofessordetail($profid,'name')."</a>";}else{ echo $name;} ?></div>
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
			        <div class="cc-p"><?php if($profid!=0){echo "<a href='professor_profile.php?profid=$profid'>".getprofessordetail($profid,'name')."</a>";}else{ echo $name;} ?></div>
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
<script language="javascript" type="text/javascript">
var university_id='<?php echo $university_id; ?>';
$(document).ready(function(){
    $('div#controls').hide();
    
    $('textarea[name="message"]').keypress(function(){
        $('div#controls').show();
    });
});
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
	beforeSend: function(){startloading();},
	url: "saveforums_home.php",
	data: {university_id: university_id,message: message,visibility: visibility}
	})
	.done(function(msg){
		if(msg==1)
		{
			stoploading();
			document.getElementById("postarea").value='';
			document.getElementById('visibility').value='Public';
			document.getElementById('controls').style.display='none';
			Forum();
		}
		else
		{
			stoploading();
			alert("There is some problem while adding forum,Please try again.");
		}

	});
} 
function Forum()
{
	$.ajax({
	type: "POST",
	beforeSend: function(){startloading();},
	url: "gethomeforums.php",
	data: { univid: university_id}
	})
	.done(function( msg ) {
	//alert( "Data Saved: " + msg );
	 if(msg=='not_login')
	 {
		 stoploading();
	 	$( "#topics" ).html();
		$("#topics").html("<div style='margin-top:15px;'>Please <a href='index.php' target='_parent'>login</a> to view all forums and comments.</div>");
	 }
	 else
	 {
		 stoploading();
	 	//alert(msg);
	 	$( "#topics" ).html();
		$("#topics").html(msg);
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
		beforeSend: function(){startloading();},
		url: "savecomments_home.php",
		data: { messageid: messageid,comment:comment,univid: university_id}
		})
		.done(function( msg ) {
			if(msg>0)
			{
				 stoploading();
				Forum();
				
			}
		});
}
function likethepost(messageid,type)
{

	$.ajax({
		type: "POST",
		beforeSend: function(){startloading();},
		url: "likethepost_home.php",
		data: { messageid: messageid,type:type,univid: university_id}
		})
		.done(function( msg ) {
			if(msg>0)
			{
				stoploading();
				if($('.likepic').hasClass("liked"))
				{
				$('.likepic').removeClass("liked");
				$('.likepic').attr("src","images/like.png");
				}else{
				$('.likepic').toggleClass('liked');
				$('.likepic').attr("src","images/liked-button.png");
				}
                                          
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
		beforeSend: function(){startloading();},
		url: "deletehomeforums.php",
		data: { messageid: messageid,univid: university_id}
		})
		.done(function( msg ) {
			if(msg==1)
			{
				stoploading();
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

setInterval("autorefresh();",10000);
</script>
<section id="midsec">
  <div id="poster">
    <form id="frmpost" name="frmpost" method="post">
      <div id="postborder">
        <textarea name="message" id="postarea" placeholder="Share your notes..."></textarea>
        <div id="controls">
          <p>Who can see this post?</p>
          <select name="visibility" id="visibility">
            <option value="Public">Everyone</option>
            <option value="Student">Just Students</option>
            <option value="Faculty">Just Faculty</option>
          </select>
          <input id="post" type="button" name="btnpost" value="Post" onClick="saveforum();" />
        </div>
      </div>
      <div id="wedge"></div>
      <div id="outerwedge"></div>
      <div id="t-post"><a href="" onClick="return false" class="here_pst">POST</a></div>
      <div id="t-upload"><a class="fancy_div rest_pst" data-fancybox-type="iframe" href="<?php echo $SITE_URL; ?>post_upload.php?univid=<?php echo $university_id; ?>&fromwhere=home">UPLOAD</a></div>
      <!--<div class="postto"><button class="posttobutton">Post</button></div>-->
    </form>
  </div>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script language="javascript" type="text/javascript">
   $(document).ready(function() {
	/// Collapse all sections by default
	$(".accordion .sprate_div").slideUp("slow");
	$(".accordion .sprate_header").click(function() {
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
			beforeSend: function(){startloading();},
			url: "deletenotification.php",
			data: { notification_id: notification_id}
			})
			.done(function( msg ) {
				if(msg==1)
				{
					stoploading();
					window.location.reload();
				}
			});
		}
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
									$like_img='<img class="likepic liked" id="leclike-1" src="images/liked-button.png">';
								}
								else
								{
									$like_img='<img src="images/like.png" id="leclike-1" class="likepic" alt="">';
								}
								?>
              <a href="Javascript:void(0)" onClick="likethepost('<?php echo $messageid; ?>','post');" ><?php echo $like_img; ?></a> <a href="<?php echo $SITE_URL.'download.php?filename='.base64_encode($filelocation); ?>" class="external-link" target="_blank"><img src="images/download-button.png" class="download" id="docdown_0"></a> <br class="clear" />
              &nbsp;&nbsp; </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <div class="post_content">
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
											$like_img='<img class="like liked" id="likecomment_0" src="images/liked-button.png">';
										}
										else
										{
											$like_img='<img src="images/like.png" id="likecomment_0" class="like" alt="">';
										}
										?>
                <br class="clear" />
                <a class="cmt_likes" href="Javascript:void(0)" onClick="likethepost('<?php echo $replyid; ?>','reply');"><?php echo $like_img; ?></a> <span><?php echo $reply_like_cnt; ?></span> </div>
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
											$like_img='<img class="like liked" id="likecomment_0" src="images/liked-button.png">';
										}
										else
										{
											$like_img='<img src="images/like.png" id="likecomment_0" class="like" alt="">';
										}
										?>
                <br class="clear" />
                <a class="cmt_likes" href="Javascript:void(0)" onClick="likethepost('<?php echo $replyid; ?>','reply');"><?php echo $like_img; ?></a> <span><?php echo $reply_like_cnt; ?></span> </div>
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
    
  </div>
</section>
<section id="calendar">
  <div id="cd-head">
    <div id="cd-text">Your Calendar</div>
    <button id="cd-join">Create an Event</button>
    <button id="cal-view">View Calendar</button>
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
		echo 'No Events Available';
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
</body>
</html>
