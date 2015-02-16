<?php $university_id=1; ?>
<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/p0.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
var university_id='<?php echo $university_id; ?>';
$(document).ready(function() {
$('.button-block button').live('click', function(){
	   var $this = $(this).parent();
	   var $a= $(this).parents(".wrapper");
	   if($a.hasClass("checked")){
	   $a.removeClass('checked');
	   }else{
	   $a.addClass('checked');
	   var event_arr=$a.attr('id').split("-");
	   ///////// Save events data
		$.ajax({
		type: "POST",
		url: "checkevents.php",
		data: { eventtype: event_arr[0],event_id:event_arr[1],university_id:university_id}
		})
		.done(function(msg){
		if(msg!='')
		{
			document.getElementById('cd-contents').innerHTML=msg;
		}
		else
		{
			alert("There is some problem while checking thie event,Please try again.");
		}

		});
	    }
	   
	   $this.toggleClass('canceled');
	   
	   return false;
	   });   
                  
});
</script>
</head>
<body>

    <section id="calendar">
        <div id="cd-head"><div id="cd-text">Your Calendar</div><button id="cd-join">Create an Event</button><button id="cal-view">View Calendar</button>
        </div>
        
    <div id="cd-contents">
	<?php
	if(isset($_SESSION['usertype']) && $_SESSION['usertype']=='Student'){
	$student_id=$_SESSION['student_id'];
	///////////// Get the total events result to display for this panel ////////
	$events_sql="select  eventid, eventname, eventdesc, start_time, end_time,eventype from(
	select eventid,eventname,eventdesc,start_time,end_time,CONCAT_WS(  '',  'course',  '' ) AS eventype from course_event_1 where eventid not in (select event_id from course_event_check_1 where studid=".$student_id." and uid=".$university_id.")
	UNION select eventid,eventname,eventdesc,starttime,endtime,CONCAT_WS(  '',  'department',  '' ) AS eventype from dept_event_1 where eventid not in (select eventid from dept_event_check_1 where studid=".$student_id." and uid=".$university_id.") UNION select eventid,eventname,eventdesc,start_time,end_time,CONCAT_WS(  '',  'student',  '' ) AS eventype from student_event_1 where ischeck = 0 and studid = ".$student_id."
	) results where end_time >NOW()order by end_time LIMIT 0,7";
		$eventsres=$dbObj->fireQuery($events_sql,'select');
	}
	if(isset($eventsres) && count($eventsres)>0 && $eventsres!=false)
	{
		$event_list=array();
		for($e=0;$e<count($eventsres);$e++)
		{
			$eventid=$eventsres[$e]['eventid'];
			$eventname=$eventsres[$e]['eventname'];
			$eventdesc=$eventsres[$e]['eventdesc'];
			$start_time=$eventsres[$e]['start_time'];
			$end_time=$eventsres[$e]['end_time'];
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
	else
	{
		echo 'No Events Available';
	}
	?>
    </div>
    <div id="seemore"><a href="">See more of your week &#9662;</a></div>
    </section>
    
    
    
</body>    
</html>