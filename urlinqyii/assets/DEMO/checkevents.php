<?php 
ob_start();
session_start();
include_once("include/includefiles.php");
$includepage = getInclucdePageFront(); 
if(isset($_POST['eventtype']) && $_POST['eventtype']!='' && isset($_POST['event_id']) && $_POST['event_id']!='' )
{
	$eventtype=$_POST['eventtype'];
	$event_id=$_POST['event_id'];
	$university_id=$_POST['university_id'];
	$studentid=0;
	$professorid=0;
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student')
	{
		$studentid=$_SESSION['student_id'];
		
	}
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Professor')
	{
		$professorid=$_SESSION['professor_id'];
		
	}
	if($eventtype=='course')
	{
		$ins_sql="INSERT INTO `course_event_check_1` (`studid`, `profid`,`uid`, `event_id`) VALUES ('".$studentid."','".$professorid."','".$university_id."', '".$event_id."');";
		$dbObj->fireQuery($ins_sql,'insert');
	}
	if($eventtype=='department')
	{
		$ins_sql="INSERT INTO `dept_event_check_1` (`studid`,`profid`,`uid`, `eventid`) VALUES ('".$studentid."','".$professorid."', '".$university_id."', '".$event_id."');";
		$dbObj->fireQuery($ins_sql,'insert');
	}
	if($eventtype=='group')
	{
		$ins_sql="INSERT INTO `group_event_check` (`studid`,`profid`,`uid`, `eventid`) VALUES ('".$studentid."','".$professorid."', '".$university_id."', '".$event_id."');";
		$dbObj->fireQuery($ins_sql,'insert');
	}
	if($eventtype=='student')
	{
		$ins_sql="UPDATE `personal_event` SET `ischeck` = '1' WHERE `eventid` ='".$event_id."' and s_id ='".$studentid."';";
		$dbObj->fireQuery($ins_sql,'update');
	}
	if($eventtype=='professor')
	{
		$ins_sql="UPDATE `professor_event_1` SET `ischeck` = '1' WHERE `eventid` ='".$event_id."' and profid ='".$professorid."';";
		$dbObj->fireQuery($ins_sql,'update');
	}
	
	
	///////////// Get the total events result to display for this panel ////////
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
			$event_list[$evtdate][]=array('eventid'=>$eventid,'eventname'=>$eventname,'eventdesc'=>$eventdesc,'start_time'=>$start_time,'end_time'=>$end_time,'eventype'=>$eventype);
		}
		foreach($event_list as $evtdate=>$eventdet)
		{
			$iscurrentdate=0;
			if($evtdate==date("Y-m-d")){$iscurrentdate=1;}else{$iscurrentdate=0;}
			?>
			<div class="cd <?php echo ($iscurrentdate?'today-cd':''); ?>">
				<div class="cd-head"><?php echo date("l",strtotime($evtdate)); ?><br>
				<span class="date"> <?php echo date("m/d",strtotime($evtdate)); ?></span>
				</div>
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
                    <button type="button">
                        <i class="mark x"></i>
                        <i class="mark xx"></i>
					</button>
                </div>
            </div>
       		</div>
				<?php
			}
			?></div><?php
		}
	}
	else{
		echo 'NO Events Avilable';
	}
}
?>