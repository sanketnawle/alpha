<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=''){
		$imagepath=$SITE_URL.'images/noimage.jpg';
		$student_id='';
		$professor_id='';
		if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
		{
			$student_id=$_SESSION['student_id'];
			$userdetail=getstudentdetail($student_id);
		}
		elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
		{
			$professor_id=$_SESSION['professor_id'];
			$userdetail=getprofessordetail($professor_id);
		}
		$imagepath=$SITE_URL.'images/noimage.jpg';
		$username='';
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
	 }?>
<!-- onLoad="Forum();"-->
<input type="hidden" name="hide_professor_id" id="hide_professor_id"  value="<?php echo $professor_id; ?>"/>
<input type="hidden" name="hide_student_id" id="hide_student_id"  value="<?php echo $student_id; ?>"/>
<input type="hidden" name="hide_university_id" id="hide_university_id"  value="<?php echo $university_id; ?>"/>
<section id="banner">
	<a href="?pg=home&univid=<?php echo $university_id; ?>">
	<img src = "images/logo.png" id = "logo" border="0">
	</a>
	<?php 
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student' && isset($_SESSION['student_id']) && $_SESSION['student_id']!='')
	{
		 	$stud_id=$_SESSION['student_id'];
			/////// get unchecked notification for this student //////////
			$noti_cnt=0;
			$noti_cntQry = "select count(*) as total_cnt from  student_notifications where univ_id='".$university_id."' and notify_student_id='".$stud_id."' and is_checked=0 and is_deleted='No'";
			$noti_cntRes = $dbObj->fireQuery($noti_cntQry,'select');
			if(isset($noti_cntRes) && count($noti_cntRes)>0 && $noti_cntRes!=false)
			{
				$noti_cnt=$noti_cntRes[0]['total_cnt'];
			}
			/////// get all notification for this student ////////////
			$notificationQry = "select * from  student_notifications where univ_id='".$university_id."' and notify_student_id='".$stud_id."' and is_deleted='No' order by updatedon DESC";
			$notificationRes = $dbObj->fireQuery($notificationQry,'select');
	}
	elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor' && isset($_SESSION['professor_id']) && $_SESSION['professor_id']!='')
	{
		 	$professor_id=$_SESSION['professor_id'];
			/////// get unchecked notification for this student //////////
			$noti_cnt=0;
			$noti_cntQry = "select count(*) as total_cnt from  professor_notifications where univ_id='".$university_id."' and notify_professor_id='".$professor_id."' and is_checked=0 and is_deleted='No'";
			$noti_cntRes = $dbObj->fireQuery($noti_cntQry,'select');
			if(isset($noti_cntRes) && count($noti_cntRes)>0 && $noti_cntRes!=false)
			{
				$noti_cnt=$noti_cntRes[0]['total_cnt'];
			}
			/////// get all notification for this student ////////////
			$notificationQry = "select * from  professor_notifications where univ_id='".$university_id."' and notify_professor_id='".$professor_id."' and is_deleted='No' order by updatedon DESC";
			$notificationRes = $dbObj->fireQuery($notificationQry,'select');
	}
	?>
	<a class="university clickable"><?php if($noti_cnt>0){ ?><span id="u-notification" class="notifications"><?php echo $noti_cnt; ?></span><?php }?></a>
	<?php 
	  $startdate=date("Y-m-d");
	  $enddate=date("Y-m-d",strtotime($startdate." 1 Days"));
	  
	  $paststartdate=date("Y-m-d h:i:s");
	  $pastenddate=date("Y-m-d h:i:s",strtotime($paststartdate." -1 Days"));
	  $upcoming_eventsres=upcomingeventnotification($university_id,$startdate,$enddate);
	  $newaddedeventres=recentlynewaddedeventnoficiation($university_id,$paststartdate,$pastenddate);
	  if(isset($upcoming_eventsres) && $upcoming_eventsres!=false && count($upcoming_eventsres)>0)
	  {
		$allupcomingeventcounter=count($upcoming_eventsres);
	  }
	  else
	  {
		$allupcomingeventcounter=0;
	  }
	 $incompleteevt_cnt=upcomingeventnotification($university_id,$startdate,$enddate,'Yes');
	 
  ?>
	<a class ="calendar clickable">
	<?php if($allupcomingeventcounter>0 && !isset($_SESSION['calender_notified'])){ ?><span id="c-notification" class="notifications"><?php echo $allupcomingeventcounter; ?></span><?php }?>
	<img class="chv ic" ><img class="cnm ic"><img class="cac ic"></a> 
	<a id="profile-icon">
 	 <div style = "display:inline-block;" id = "border"><img id = "profile-pic" src = "<?php echo $imagepath; ?>"></div>
 	</a>
 	 <div id = "search-container">
	 <?php 
	 $search="";
	  if(isset($_POST['search']) && $_POST['search']!='')
	  {
		 $search=$_POST['search'];
		 
	  }
	 ?>
 	   <form name="frmsearch" id="frmsearch" method="post" action="?pg=search&univid=<?php echo $university_id; ?>">
	   <input id="search-bar" name="search" type="text" value="<?php echo $search; ?>" placeholder="Search groups and faculty"/>
	   </form>
 	 </div>
 	<div id="university-menu" class="menus">
    <div class="caret"></div>
    <div id="u-menu-content">
      <div id="menu-content-header">
        <div id="rfloat">
		<a href="?pg=university&univid=<?php echo $university_id; ?>" role="button" id="u-link">Go to University Page</a>
		 <span id="separator">&#183;</span><a href ="#" role ="button" id ="settings-link">Settings</a>
		 </div>
         <a id = "notifications-header"> Campus Feed </a>
         </h3>
      </div>
      		 <div class="notification_sec">
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
						?><div class="notification_msg"><?php echo $notification_msg;?></div><?php
					}
					elseif($message=='ENROLL')
					{
						if($student_id>0){$who_join=getstudentdetail($student_id,'name');}else{$who_join=getprofessordetail($professor_id,'name');}	
						if($course_id>0){$course_name=getcoursedetail($course_id,'name');}
						$notification_msg= $who_join.' has enrolled in '.$course_name;
						?><div class="notification_msg"><?php echo $notification_msg;?></div><?php
					}
					elseif($message=='JOIN')
					{
						if($student_id>0){$who_join=getstudentdetail($student_id,'name');}else{$who_join=getprofessordetail($professor_id,'name');}	
						if($club_id>0){$club_name=getclubdetail($club_id,'groupname');}
						$notification_msg= $who_join.' has joined in '.$club_name;
						?><div class="notification_msg"><?php echo $notification_msg;?></div><?php
					}
				}
		 }
		 ?>
		 </div>
    </div>
  </div>
  	<div id = "profile-menu">
    <div class = "caret-3"> </div>
    <div id = "p-menu-content">
      <div id = "menu-content-header"> <a id = "profile-header"> Visit My Profile </a>
        </h3>
      </div>
      <div id="profile-edit"> Edit Profile </div>
      <div id="signout">
        <?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=''){?>
        <a href="<?php echo $SITE_URL;?>logout.php">Sign Out</a>
        <?php }else{?>
        <div class="logout_tab"><a href="<?php echo $SITE_URL;?>index.php">Sign In</a></div>
        <?php }?>
      </div>
    </div>
  </div>
    <div id = "calendar-menu" class="menus">
    <div class = "caret-2"> </div>
    <div id = "c-menu-content">
      <div id = "menu-content-header">
        <div id = "rfloat"> <a href = "#" role = "button" id = "settings-link">New Event +</a> </div>
        <a id = "notifications-header"> Upcoming (<?php echo $allupcomingeventcounter; ?>) </a>&nbsp; &nbsp;&nbsp;<a id = "incomplete-header"> Incomplete (<?php echo $incompleteevt_cnt; ?>) </a>

		</div>
				<div class="notification_sec cal_notification"><?php
		if(isset($upcoming_eventsres) && $upcoming_eventsres!=false && count($upcoming_eventsres)>0)
		{
			
			for($u=0;$u<count($upcoming_eventsres);$u++)
			{
				$eventname=$upcoming_eventsres[$u]['title'];
				$eventdesc=$upcoming_eventsres[$u]['description'];
				$start_time=$upcoming_eventsres[$u]['start'];
				$end_time=$upcoming_eventsres[$u]['end'];
					
				?><div class="notification_msg"><?php echo $eventname." at ".date("h:i A",strtotime($end_time)); ?></div><?php
			}
			
		}
		?>
		<?php
		if(isset($newaddedeventres) && count($newaddedeventres)>0)
		{
			for($n=0;$n<count($newaddedeventres);$n++)
			{
				$eventid=$newaddedeventres[$n]['event_id'];
				if(isset($newaddedeventres[$n]['course_id']) && $newaddedeventres[$n]['course_id']!=''){
				$course_id=$newaddedeventres[$n]['course_id'];}else{$course_id=0;}
				if(isset($newaddedeventres[$n]['dept_id']) && $newaddedeventres[$n]['dept_id']!=''){
				$dept_id=$newaddedeventres[$n]['dept_id'];}else{$dept_id=0;}
				$profid=$newaddedeventres[$n]['profid'];
				$title=$newaddedeventres[$n]['title'];
				$message="";
				if($profid!='NONE')
				{
					$prof_name=getprofessordetail($profid,'name');
					$course_name=getcoursedetail($course_id,'name');
					$message=$prof_name." has added ".$title." in course ".$course_name;
					?><div class="notification_msg" id="course_<?php echo $eventid; ?>"><?php echo $message; ?></div><?php
				}
				elseif($dept_id>0)
				{
					$dept_name=getdepartmentdetail($dept_id,'deptname');
					$message=$title." has been added in ".$dept_name;
					?><div class="notification_msg" id="dept_<?php echo $dept_id;?>"><?php echo $message; ?></div><?php
				}
				
			}
		}
		?>
		</div>
    </div>
  </div>
</section>