<?php
$_SESSION['user_id'] = 1;
include_once('includefiles.php');
// How often to poll, in microseconds (1,000,000 μs equals 1 s)
define('MESSAGE_POLL_MICROSECONDS', 500000);

// How long to keep the Long Poll open, in seconds
define('MESSAGE_TIMEOUT_SECONDS', 30);

// Timeout padding in seconds, to avoid a premature timeout in case the last call in the loop is taking a while
define('MESSAGE_TIMEOUT_SECONDS_BUFFER', 5);

// Hold on to any session data you might need now, since we need to close the session before entering the sleep loop
$user_id = $_SESSION['user_id'];

if(isset($_GET['type']))
{
	$type = $_GET['type'];
}
if($type == "latest")
{
	// Close the session prematurely to avoid usleep() from locking other requests
	session_write_close();
	
	// Automatically die after timeout (plus buffer)
	set_time_limit(MESSAGE_TIMEOUT_SECONDS+MESSAGE_TIMEOUT_SECONDS_BUFFER);
	
	// Counter to manually keep track of time elapsed (PHP's set_time_limit() is unrealiable while sleeping)
	$counter = MESSAGE_TIMEOUT_SECONDS;
	
	
	// Poll for messages and hang if nothing is found, until the timeout is exhausted
	while($counter > 0)
	{
		// Check for new data (not illustrated)
		if($data = getNewData($user_id, $status = 1, $limit = NULL))
		{
			// Break out of while loop if new data is populated
			break;
		}
		else
		{
			// Otherwise, sleep for the specified time, after which the loop runs again
			usleep(MESSAGE_POLL_MICROSECONDS);
	
			// Decrement seconds from counter (the interval was set in μs, see above)
			$counter -= MESSAGE_POLL_MICROSECONDS / 1000000;
		}
	}
	$con->close();
}
else if($type == "all")
{
	$data = getNewData($user_id, $status = NULL, $limit = 50);
	$con->close();
}

// If we've made it this far, we've either timed out or have some data to deliver to the client
if(isset($data))
{
	// Send data to client; you may want to precede it by a mime type definition header, eg. in the case of JSON or XML
  	echo $data;
}

function getNewData($user_id, $status = NULL, $limit = NULL)
{
	GLOBAL $con;
	$data = false;
	$upvote = array(array());
	$notify_ids = array(); $follow = ""; $post_reply = "";
	$post_like="";$gr_post=""; $post_tag = ""; $gr_member = "";
	if($status != NULL)
	{
		$stmt = $con->prepare("SELECT owner_id, actor_id, notification_type, id,
							  status, notification_id, check_point,
							  TIMESTAMPDIFF(YEAR,created_time,NOW()),TIMESTAMPDIFF(MONTH,created_time,NOW()),
							  TIMESTAMPDIFF(DAY,created_time,NOW()),TIMESTAMPDIFF(HOUR,created_time,NOW()),
							  TIMESTAMPDIFF(MINUTE,created_time,NOW()) 
						 FROM general_notifications 
						WHERE owner_id = ? 
						  AND status = ?
					ORDER BY created_time DESC");
		$stmt->bind_param('ii',$user_id, $status);
	}
	else if($limit != NULL)
	{
		$stmt = $con->prepare("SELECT owner_id, actor_id, notification_type, id,
						  status, notification_id, check_point,
						  TIMESTAMPDIFF(YEAR,created_time,NOW()),TIMESTAMPDIFF(MONTH,created_time,NOW()),
						  TIMESTAMPDIFF(DAY,created_time,NOW()),TIMESTAMPDIFF(HOUR,created_time,NOW()),
						  TIMESTAMPDIFF(MINUTE,created_time,NOW())
					 FROM general_notifications
					WHERE owner_id = ?
					  AND status != 5
				 ORDER BY created_time DESC
					LIMIT 0,?");
		$stmt->bind_param('ii',$user_id, $limit);
	}
	$stmt->execute();
	$stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
			$notification_id, $check_point, $year, $month, $day, $hour, $minute);
	while($stmt->fetch())
	{
		if($year > 0)
			$ago = $year.formatSingularPlural($year," year");
		else if($month > 0)
			$ago = $month.formatSingularPlural($month," month");
		else if($day > 0)
			$ago = $day.formatSingularPlural($day," day");
		else if($hour > 0)
			$ago = $hour.formatSingularPlural($hour," hour");
		else if($minute > 0)
			$ago = $minute.formatSingularPlural($minute," minute");
		else
			$ago = "just now";
		
		switch($notification_type)
		{
			case "follow":
				$follow[] = array($actor_id, 'ago'=>$ago, 'check_pt'=>$check_point);
				$notify_ids['follow'][]=$notification_id;
				break;
			case "upvote":
				$upvote[$id][] = array($actor_id,'ago'=> $ago, 'notification'=>$notification_id);
				$notify_ids['upvote'][]=$notification_id;
				break;
			case "gr_member":
				$gr_member[$id][] = $actor_id;
				$gr_member[$id]['ago'] = $ago;
				$gr_member[$id]['notification'] = $notification_id;
				$notify_ids['gr_member'][]=$notification_id;
				break;
			case "post_tag":
				$post_tag[$id] = array($actor_id, 'ago'=>$ago, 'notification'=>$notification_id); 
				$notify_ids['post_tag'][]=$notification_id;
				break;
			case "post_reply":
				$post_reply[$id][] = $actor_id;
				$post_reply[$id]['ago'] = $ago;
				$post_reply[$id]['notification'] = $notification_id;
				$notify_ids['post_reply'][]=$notification_id;
				break;
			case "post_like":
				$post_like[$id][] = $actor_id;
				$post_like[$id]['ago'] = $ago;
				$post_like[$id]['notification'] = $notification_id;
				$notify_ids['post_like'][]=$notification_id;
				break;
			case "gr_post":
				$gr_post[$id][] = $actor_id;
				$gr_post[$id]['ago'] = $ago;
				$gr_post[$id]['notification'] = $notification_id;
				$notify_ids['gr_post'][]=$notification_id;
				break; 
		}
	}
	$stmt->close();
	updateCheckPoints($notify_ids);
	return formatNotifications($follow,$upvote,$gr_member,$post_tag,$post_reply, $post_like, $gr_post);
}
function formatNotifications($follow,$upvote,$gr_member,$post_tag,
		$post_reply, $post_like, $gr_post)
{
	GLOBAL $con;
	$data = "";
	if(isset($follow) && is_array($follow) && count($follow)>0)
	{
		$check_pt = array_unique(array_column($follow,"check_pt")); 
		$stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname)
						 from `user` where user_id IN (".implode(",", array_column($follow,0)).")");
		$follow_names = array();
		$stmt->execute();
		$stmt->bind_result($id, $name);
		while($stmt->fetch())
		{
			$follow_names[$id] = $name;
		}
		$stmt->close();
		foreach ($check_pt as $v)
		{
			$gr_follow=array();
			$ago = array();
			foreach($follow as $k=>$row)
			{
				if($row['check_pt'] == $v)
				{
					$gr_follow[] = $follow_names[$row[0]];
					$ago[] = $row['ago'];
				}	
			}
			$data .= "<div class='noti_gen'>
			<div class='gen_left'>
				<div class='gen_noti_icon' style='background-image:url(testpic/dummypic.png);'></div>
			</div>
			<div class='gen_right'>
				<div class='notievent_des'>".groupify($gr_follow).formatSingularPlural(count($gr_follow),"is")."following you
				</div>
			</div>
			<div class='notievent_time'>".max($ago)."</div>
				<div class='noti_remove' data-type='follow' data-value='".$v."'>
					<i class='remove_icon'></i>
					<div class = 'card-tag'>
						<div class = 'tag-wedge'></div>
						<div class = 'tag-box'>
							<span>Hide</span>
						</div>
					</div>
				</div>
			</div>";
		}
	}
	if(isset($upvote) && is_array($upvote))
	{
		$stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname)
						 from `user` where user_id IN (".implode(",", array_column($upvote,0)).")");
		$upvote_names = array();
		$stmt->execute();
		$stmt->bind_result($id, $name);
		while($stmt->fetch())
		{
			$upvote_names[$id] = $name;
		}
		$stmt->close();
		foreach(array_keys($upvote) as $key)
		{
			$gr_upvote=array();
			$ago = array();
			foreach($upvote as $k=>$row)
			{
				if($k == $key)
				{
					$gr_upvote[] = $upvote_names[$row[0]];
					$ago[] = $row['ago'];
				} 
			}
			
			$data .= "<div class='noti_gen'>
			<div class='gen_left'>
				<div class='gen_noti_icon' style='background-image:url(testpic/dummypic.png);'></div>
			</div>
			<div class='gen_right'>
				<div class='notievent_des'>".groupify($gr_upvote).formatSingularPlural(count($gr_upvote),"is")."following you
				</div>
			</div>
			<div class='notievent_time'>".max($ago)."</div>
				<div class='noti_remove' data-type='follow' data-value='".$key."'>
					<i class='remove_icon'></i>
					<div class = 'card-tag'>
						<div class = 'tag-wedge'></div>
						<div class = 'tag-box'>
							<span>Hide</span>
						</div>
					</div>
				</div>
			</div>";
		}
	}
	if(isset($gr_member) && is_array($gr_member))
	{
	
		foreach ($gr_member as $key=>$row)
		{
			$ago = $row['ago'];
			unset($row['ago']);
			$stmt = $con->prepare("SELECT CONCATE(firstname,' ',lastname)
							 from `user` where user_id IN (".implode(",", $row).")");
			$mem = array();
			$stmt->execute();
			$stmt->bind_result($name);
			while($stmt->fetch())
			{
				$mem[] = $name;
			}
			$stmt->close();
			$data .= "<div class='noti_gen'>
		<div class='gen_left'>
			<div class='gen_noti_icon' style='background-image:url(testpic/dummypic.png);'></div>
		</div>
		<div class='gen_right'>
			<div class='notievent_des' data-group='".$key."'>".groupify($mem)." are part of your group
			</div>
		</div>
		<div class='notievent_time'>".$ago."</div>
			<div class='noti_remove' data-type='group' data-value='".$row['notification']."'>
				<i class='remove_icon'></i>
				<div class = 'card-tag'>
					<div class = 'tag-wedge'></div>
					<div class = 'tag-box'>
						<span>Hide</span>
					</div>
				</div>
			</div>
		</div>";
		}
	}
	if(isset($post_tag) && is_array($post_tag))
	{
	
		$stmt = $con->prepare("SELECT user_id,CONCAT(firstname,' ',lastname)
						 from `user` where user_id IN (".implode(",", array_column($post_tag,0)).")");
		$stmt->execute();
		$stmt->bind_result($id,$name);
		$names = array();
		while($stmt->fetch())
		{
			$names[$id] = $name;
		}
		$stmt->close();
		foreach($post_tag as $key=>$row)
		{
			$data .= "<div class='noti_gen'>
		<div class='gen_left'>
			<div class='gen_noti_icon' style='background-image:url(testpic/dummypic.png);'></div>
		</div>
		<div class='gen_right'>
			<div class='notievent_des' data-post='".$key."'>
				<span class='keyword'>".$names[$post_tag[$key][0]]."</span>  tagged you in a post
			</div>
		</div>
		<div class='notievent_time'>".$post_tag[$key]['ago']."</div>
			<div class='noti_remove' data-type='post' data-value='".$post_tag[$key]['notification']."'>
				<i class='remove_icon'></i>
				<div class = 'card-tag'>
					<div class = 'tag-wedge'></div>
					<div class = 'tag-box'>
						<span>Hide</span>
					</div>
				</div>
			</div>
		</div>";
		}
	}
	if(isset($post_reply) && is_array($post_reply))
	{
		foreach ($post_reply as $key=>$row)
		{
			$ago = $row['ago'];
			$not = $row['notification'];
			unset($row['ago']);
			unset($row['notification']);
			$stmt = $con->prepare("SELECT CONCATE(firstname,' ',lastname)
							 from `user` where user_id IN (".implode(",", $row).")");
			$mem = array();
			$stmt->execute();
			$stmt->bind_result($name);
			while($stmt->fetch())
			{
				$mem[] = $name;
			}
			$stmt->close();
			$data .= "<div class='noti_gen'>
		<div class='gen_left'>
			<div class='gen_noti_icon' style='background-image:url(testpic/dummypic.png);'></div>
		</div>
		<div class='gen_right'>
			<div class='notievent_des' data-post='".$key."'>".groupify($mem)." replied on a post
			</div>
		</div>
		<div class='notievent_time'>".$ago."</div>
			<div class='noti_remove' data-type='post' data-value='".$not."'>
				<i class='remove_icon'></i>
				<div class = 'card-tag'>
					<div class = 'tag-wedge'></div>
					<div class = 'tag-box'>
						<span>Hide</span>
					</div>
				</div>
			</div>
		</div>";
		}
	}
	if(isset($post_like) && is_array($post_like))
	{
		foreach ($post_like as $key=>$row)
		{
			$ago = $row['ago'];
			unset($row['ago']);
			$stmt = $con->prepare("SELECT CONCAT(firstname,' ',lastname)
							 from `user` where user_id IN (".implode(",", $row).")");
			$mem = array();
			$stmt->execute();
			$stmt->bind_result($name);
			while($stmt->fetch())
			{
				$mem[] = $name;
			}
			$stmt->close();
			$data .= "<div class='noti_gen'>
		<div class='gen_left'>
			<div class='gen_noti_icon' style='background-image:url(testpic/dummypic.png);'></div>
		</div>
		<div class='gen_right'>
			<div class='notievent_des' data-post='".$key."'>".groupify($mem)." liked your post
			</div>
		</div>
		<div class='notievent_time'>".$ago."</div>
			<div class='noti_remove' data-type='post' data-value='".$key."'>
				<i class='remove_icon'></i>
				<div class = 'card-tag'>
					<div class = 'tag-wedge'></div>
					<div class = 'tag-box'>
						<span>Hide</span>
					</div>
				</div>
			</div>
		</div>";
		}
	}
	if(isset($gr_post) && is_array($gr_post))
	{
		foreach ($gr_post as $key=>$row)
		{
			$ago = $row['ago'];
			unset($row['ago']);
			$stmt = $con->prepare("SELECT CONCAT(firstname,' ',lastname)
							 from `user` where user_id IN (".implode(",", $row).")");
			$mem = array();
			$stmt->execute();
			$stmt->bind_result($name);
			while($stmt->fetch())
			{
				$mem[] = $name;
			}
			$stmt->close();
			$result = $con->query("SELECT p.target_id, g.group_name
					FROM post p JOIN group g
					ON (p.target_id = g.group_id)
					WHERE p.post_id = $key");
					while($val = $result->fetch_array(MYSQLI_ASSOC))
			{
			$group_id = $val['target_id'];
			$group_name = $val['group_name'];
			}
			$data .= "<div class='noti_gen'>
			<div class='gen_left'>
			<div class='gen_noti_icon' style='background-image:url(testpic/dummypic.png);'></div>
		</div>
		<div class='gen_right'>
			<div class='notievent_des' data-group='".$group_id."' data-post='".$key."'>"
					.groupify($mem)." posted on ".$group_name."
			</div>
				</div>
				<div class='notievent_time'>".$ago."</div>
			<div class='noti_remove' data-type='post' data-value='".$key."'>
				<i class='remove_icon'></i>
				<div class = 'card-tag'>
					<div class = 'tag-wedge'></div>
					<div class = 'tag-box'>
						<span>Hide</span>
					</div>
				</div>
			</div>
		</div>";
		}
	}
	return $data;
}
function updateCheckPoints($ids)
{
	GLOBAL $con;
	$stmt = $con->prepare("SELECT max(check_point) from general_notifications");
	$stmt->execute();
	$stmt->bind_result($var1);
	if($stmt->fetch())
	{
		if($var1 == NULL)
			$count = 0;
		else
			$count = $var1;
	}
	$stmt->close();
	foreach($ids as $key=>$row)
	{
		if(is_array($row))
		{
			$count = $count + 1;
			$query =  "UPDATE general_notifications
					SET check_point = ?, status = 2 
				  where notification_id IN (".implode(",", $row).") 
					and status = 1";
			if($stmt = $con->prepare($query))
			{
				$stmt->bind_param("i", $count);
				$stmt->execute();
				$stmt->close();
			}
			else
			{
				echo $con->error;
			}
		}
	}
}
