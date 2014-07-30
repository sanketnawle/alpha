<?php
/*gets all notifications by grouping them if they are of type post */
require_once('includes/dbconfig.php');
require_once('includes/common_functions.php');

if(!isset($_SESSION['user_id']))
	$_SESSION['user_id'] = 1;
//Set user id
$user_id = $_SESSION['user_id'];

//To get the first page of notifications
if(isset($_GET['type']) && $_GET['type'] == 'pa')
{
	$stmt = $con->prepare("UPDATE general_notifications SET group_check_pt = NULL where owner_id = ? and status != 5");
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$stmt->close();
}
$data = getNewData($user_id);

if(isset($data))
{
	// Send data to client; you may want to precede it by a mime type definition header, eg. in the case of JSON or XML
  	echo $data;
}

function getNewData($user_id, $limit = 6)
{
	GLOBAL $con;
	$data = "";
	$stmt = $con->prepare("Select max(group_check_pt) from general_notifications where owner_id = ?");
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$stmt->bind_result($notif_no);
	$stmt->fetch();
	$stmt->close();
	
// use $notif_no to update group_check_pt so that notifications 
// are grouped and infinite scrolling is possible
	if($notif_no == NULL)
		$notif_no = 0;
	
	$stmt = $con->prepare("Select owner_id, actor_id, notification_type, id,
							  status, notification_id, check_point, group_check_pt,
							  TIMESTAMPDIFF(YEAR,created_time,NOW()),TIMESTAMPDIFF(MONTH,created_time,NOW()),
							  TIMESTAMPDIFF(DAY,created_time,NOW()),TIMESTAMPDIFF(HOUR,created_time,NOW()),
							  TIMESTAMPDIFF(MINUTE,created_time,NOW())
								 from general_notifications
								where owner_id = ?
								  and group_check_pt IS NULL
								  and status != 5
								order by created_time DESC
								limit 0,1");
	$stmt->bind_param("i", $user_id);
	
	$check_pt_stmt = $con->prepare("Select owner_id, actor_id, notification_type, id,
							  			   status, notification_id, check_point, group_check_pt
								 from general_notifications
								where owner_id = ?
								  and notification_type = ?
								  and check_point = ?
								  and status != 5
								order by created_time DESC");
	
	$check_null_stmt = $con->prepare("Select owner_id, actor_id, notification_type, id,
							  			   status, notification_id, check_point, group_check_pt
								 from general_notifications
								where owner_id = ?
								  and notification_type = ?
								  and check_point IS NULL
								  and status != 5
								order by created_time DESC");
	
	$id_stmt = $con->prepare("Select owner_id, actor_id, notification_type, id,
							  		 status, notification_id, check_point, group_check_pt
								 from general_notifications
								where owner_id = ?
								  and notification_type = ?
								  and id = ?
								  and status != 5
								order by created_time DESC");
	
	$ck_pt_id_stmt = $con->prepare("Select owner_id, actor_id, notification_type, id,
							  			   status, notification_id, check_point, group_check_pt
								 from general_notifications
								where owner_id = ?
								  and notification_type = ?
								  and check_point =?
								  and id = ?
								  and status != 5
								order by created_time DESC");
	
	$ck_pt_id_null_stmt = $con->prepare("Select owner_id, actor_id, notification_type, id,
							  			   status, notification_id, check_point, group_check_pt
								 from general_notifications
								where owner_id = ?
								  and notification_type = ?
								  and check_point IS NULL
								  and id = ?
								  and status != 5
								order by created_time DESC");
	
	for($i=0;$i<$limit; $i++)
	{
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
			$notification_id, $check_point, $group_check_pt, $year, $month, $day, $hour, $minute);
		if($stmt->fetch())
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
			
			$notifications = array();
			$notify_ids = array();
			$notify_ids[]=$notification_id;
			//echo $notification_id, $status, $check_pt;
			switch($notification_type)
			{
				case "follow":
					// $notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 'check_pt'=>$check_point,
										// 'group_chk_pt'=>$group_check_pt);
					// $notify_ids[] = $notification_id;
					if($check_point != NULL)
					{
						$check_pt_stmt->bind_param("isi", $owner_id, $notification_type, $check_point);
						if($check_pt_stmt->execute())
						{
							$check_pt_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
														$notification_id, $check_point, $group_check_pt);
							while($check_pt_stmt->fetch())
							{
							$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 'check_pt'=>$check_point,
									'group_chk_pt'=>$group_check_pt);
							$notify_ids[] = $notification_id;
							}
							$check_pt_stmt->reset();
						}
					}
					else
					{
						$check_null_stmt->bind_param("is", $owner_id, $notification_type);
						if($check_null_stmt->execute())
						{
							$check_null_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
									$notification_id, $check_point, $group_check_pt);
							while($check_null_stmt->fetch())
							{
							$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 'check_pt'=>$check_point,
									'group_chk_pt'=>$group_check_pt);
							$notify_ids[] = $notification_id;
							}
							$check_null_stmt->reset();
							$result = $con->query("Update general_notifications set check_point = 
									(SELECT max(check_point) from (SELECT check_point FROM general_notifications) AS gn) 
									where notification_id IN (".implode(",", $notify_ids).")");
						}
					}
					$name_stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname) 
						 from `user` where user_id IN (".implode(",", array_column($notifications,'actor')).")");
					$follow_names = array();
					$name_stmt->execute();
					$name_stmt->bind_result($id, $name);
					while($name_stmt->fetch())
					{
						$follow_names[$id] = $name;
					}
					$name_stmt->close();
					$data .= "<a ";
					if(array_search(1,array_column(notifications,"status"))!== FALSE)
					{
						$data .= "class='unseen_notifications'";
					}
						$data .= "><div class='noti_gen'>
									<div class='gen_left'>
									<div class='gen_noti_icon' style='background-image:url(".get_user_dp($con,$notifications[0]['actor']).");'>
									</div>
								</div>
								<div class='gen_right'>
									<div class='notievent_des'>".groupify($follow_names).formatSingularPlural(count($follow_names)-1," person").
									formatSingularPlural(count($follow_names)-2," is")." following you
									</div>
								</div>
								<div class='notievent_time'>".$ago."</div>
									<div class='noti_remove' data-type='follow' data-value='".$notifications[0]['actor']."'>
										<i class='remove_icon'></i>
										<div class = 'card-tag'>
											<div class = 'tag-wedge'></div>
											<div class = 'tag-box'>
												<span>Hide</span>
											</div>
										</div>
									</div>
								</div>
								</a>";
					break;	
					
				case "upvote":
					// $notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 'id'=>$id,
							// 'group_chk_pt'=>$group_check_pt);
					// $notify_ids[] = $notification_id;
					$id_stmt->bind_param("iss", $owner_id, $notification_type, $id);
						if($id_stmt->execute())
						{
							$id_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
									$notification_id, $check_point, $group_check_pt);
							while($id_stmt->fetch())
							{
							$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 
									'id'=>$id,'group_chk_pt'=>$group_check_pt);
							$notify_ids[] = $notification_id;
							}
							$id_stmt->reset();
							$name_stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname)
						 from `user` where user_id IN (".implode(",", array_column($notifications,'actor')).")");
							$upvote_names = array();
							$name_stmt->execute();
							$name_stmt->bind_result($id, $name);
							while($name_stmt->fetch())
							{
								$upvote_names[$id] = $name;
							}
							$name_stmt->close();
							
							$data .= "<a ";
					if(array_search(1,array_column(notifications,"status"))!== FALSE)
					{
						$data .= "class='unseen_notifications'";
					}
						$data .= "><div class='noti_gen'>
										<div class='gen_left'>
											<div class='gen_noti_icon' style='background-image:url(".get_user_dp($con,$notifications[0]['actor']).");'></div>
										</div>
										<div class='gen_right'>
											<div class='notievent_des'>".groupify($upvote_names).formatSingularPlural(count($upvote_names)-1," person")
											." upvoted your comment
											</div>
										</div>
										<div class='notievent_time'>".$ago."</div>
											<div class='noti_remove' data-type='upvote' data-value='".$notifications[0]['id']."'>
												<i class='remove_icon'></i>
												<div class = 'card-tag'>
													<div class = 'tag-wedge'></div>
													<div class = 'tag-box'>
														<span>Hide</span>
													</div>
												</div>
											</div>
										</div>
									</a>";
					}
					break;
				case "gr_member":
					// $notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 
										 // 'check_pt'=>$check_point,'group_chk_pt'=>$group_check_pt);
					// $notify_ids[] = $notification_id;
					if($check_pt == NULL)
					{
						$ck_pt_id_null_stmt->bind_param("iss", $owner_id, $notification_type, $id);
						if($ck_pt_id_null_stmt->execute())
						{
							$ck_pt_id_null_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
									$notification_id, $check_point, $group_check_pt);
							while($ck_pt_id_null_stmt->fetch())
							{
							$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 
									'check_pt'=>$check_point,'group_chk_pt'=>$group_check_pt);
							$notify_ids[] = $notification_id;
							}
							$ck_pt_id_null_stmt->reset();
						}
						$result = $con->query("Update general_notifications set check_point =
									(SELECT max(check_point) from (SELECT check_point FROM general_notifications) AS gn)
									where notification_id IN (".implode(",", $notify_ids).")");
					}
					else
					{
						$ck_pt_id_stmt->bind_param("isis", $owner_id, $notification_type,$check_point, $id);
						if($ck_pt_id_stmt->execute())
						{
							$ck_pt_id_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, 
									$status, $notification_id, $check_point, $group_check_pt);
							while($ck_pt_id_stmt->fetch())
							{
							$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 
									'check_pt'=>$check_point,'group_chk_pt'=>$group_check_pt);
							$notify_ids[] = $notification_id;
							}
							$ck_pt_id_stmt->reset();
						}
					}
					$name_stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname)
						 from `user` where user_id IN (".implode(",", array_column($notifications,'actor')).")");
					$gr_mem_names = array();
					$name_stmt->execute();
					$name_stmt->bind_result($id, $name);
					while($name_stmt->fetch())
					{
						$gr_mem_names[$id] = $name;
					}
					$name_stmt->close();
/*-------------------------- get group name -------------------------------------------------------------*/
						$name_stmt = $con->prepare("SELECT group_name 
													  FROM groups 
													 WHERE group_id = ?");
						$name_stmt->bind_param("i",$notifications[0]['id']);
						$name_stmt->execute();
						$name_stmt->bind_result($gname);
						$name_stmt->fetch();
						$name_stmt->close();
/*-------------------------------------------------------------------------------------------------------*/					
					$data .= "<a ";
					if(array_search(1,array_column(notifications,"status"))!== FALSE)
					{
						$data .= "class='unseen_notifications'";
					}
						$data .= "><div class='noti_gen'>
								<div class='gen_left'>
									<div class='gen_noti_icon' style='background-image:url(".get_user_dp($con,$notifications[0]['actor']).");'></div>
								</div>
								<div class='gen_right'>
									<div class='notievent_des'>".groupify($gr_mem_names).
									formatSingularPlural(count($gr_mem_names)," is")." a part of your group ".$gname."
									</div>
								</div>
								<div class='notievent_time'>".$ago."</div>
									<div class='noti_remove' data-type='gr_member' data-value='".$notifications[0]['id']."'>
										<i class='remove_icon'></i>
										<div class = 'card-tag'>
											<div class = 'tag-wedge'></div>
											<div class = 'tag-box'>
												<span>Hide</span>
											</div>
										</div>
									</div>
								</div>
							</a>";
					break;
				case "post_tag":
					$name_stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname)
						 from `user` where user_id = ?");
					$name_stmt->bind_param("i",$actor_id);
					$name_stmt->execute();
					$name_stmt->bind_result($name_id, $name);
					$name_stmt->fetch();
					$name_stmt->close();
					$data .= "<a ";
					if(array_search(1,array_column(notifications,"status"))!== FALSE)
					{
						$data .= "class='unseen_notifications'";
					}
						$data .= "><div class='noti_gen'>
								<div class='gen_left'>
									<div class='gen_noti_icon' style='background-image:url(".get_user_dp($con,$notifications[0]['actor']).");'></div>
								</div>
								<div class='gen_right'>
									<div class='notievent_des' data-post='".$id."'>
										<span class='keyword'>".$name."</span>  tagged you in a post
									</div>
								</div>
								<div class='notievent_time'>".$ago."</div>
									<div class='noti_remove' data-type='post' data-value='".$id."'>
										<i class='remove_icon'></i>
										<div class = 'card-tag'>
											<div class = 'tag-wedge'></div>
											<div class = 'tag-box'>
												<span>Hide</span>
											</div>
										</div>
									</div>
								</div>
							</a>";
						break;
				case "post_reply":
					// $notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 'id'=>$id,
							// 'group_chk_pt'=>$group_check_pt);
					// $notify_ids[] = $notification_id;
					$id_stmt->bind_param("iss", $owner_id, $notification_type, $id);
					if($id_stmt->execute())
					{
						$id_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
								$notification_id, $check_point, $group_check_pt);
						while($id_stmt->fetch())
						{
							$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago,
									'id'=>$id,'group_chk_pt'=>$group_check_pt);
							$notify_ids[] = $notification_id;
						}
						$id_stmt->reset();
						$name_stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname)
						 from `user` where user_id IN (".implode(",", array_column($notifications,'actor')).")");
						$upvote_names = array();
						$name_stmt->execute();
						$name_stmt->bind_result($id, $name);
						while($name_stmt->fetch())
						{
							$upvote_names[$id] = $name;
						}
						$name_stmt->close();
						$data .= "<a ";
					if(array_search(1,array_column(notifications,"status"))!== FALSE)
					{
						$data .= "class='unseen_notifications'";
					}
						$data .= "><div class='noti_gen'>
										<div class='gen_left'>
											<div class='gen_noti_icon' style='background-image:url(".get_user_dp($con,$notifications[0]['actor']).");'></div>
										</div>
										<div class='gen_right'>
											<div class='notievent_des'>".groupify($upvote_names).formatSingularPlural(count($upvote_names)-1," person").
											" replied on a post
											</div>
										</div>
										<div class='notievent_time'>".$ago."</div>
											<div class='noti_remove' data-type='upvote' data-value='".$notifications[0]['id']."'>
												<i class='remove_icon'></i>
												<div class = 'card-tag'>
													<div class = 'tag-wedge'></div>
													<div class = 'tag-box'>
														<span>Hide</span>
													</div>
												</div>
											</div>
										</div>
									</a>";
					}
					break;
				case "post_like":
					// $notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago, 
											 // 'id'=>$id, 'group_chk_pt'=>$group_check_pt);
					// $notify_ids[] = $notification_id;
					$id_stmt->bind_param("iss", $owner_id, $notification_type, $id);
					if($id_stmt->execute())
					{
						$id_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
								$notification_id, $check_point, $group_check_pt);
						while($id_stmt->fetch())
						{
							$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago,
									'id'=>$id,'group_chk_pt'=>$group_check_pt);
							$notify_ids[] = $notification_id;
						}
						$id_stmt->reset();
						$name_stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname)
						 from `user` where user_id IN (".implode(",", array_column($notifications,'actor')).")");
						$upvote_names = array();
						$name_stmt->execute();
						$name_stmt->bind_result($id, $name);
						while($name_stmt->fetch())
						{
							$upvote_names[$id] = $name;
						}
						$name_stmt->close();
						$data .= "<a ";
					if(array_search(1,array_column(notifications,"status"))!== FALSE)
					{
						$data .= "class='unseen_notifications'";
					}
						$data .= "><div class='noti_gen'>
										<div class='gen_left'>
											<div class='gen_noti_icon' style='background-image:url(".get_user_dp($con,$notifications[0]['actor']).");'></div>
										</div>
										<div class='gen_right'>
											<div class='notievent_des'>".groupify($upvote_names).formatSingularPlural(count($upvote_names)-1," person").
											" liked a post
											</div>
										</div>
										<div class='notievent_time'>".$ago."</div>
											<div class='noti_remove' data-type='upvote' data-value='".$notifications[0]['id']."'>
												<i class='remove_icon'></i>
												<div class = 'card-tag'>
													<div class = 'tag-wedge'></div>
													<div class = 'tag-box'>
														<span>Hide</span>
													</div>
												</div>
											</div>
										</div>
									</a>";
					}
					break;
				case "gr_post":
					$gr_stmt = $con->prepare("SELECT g.group_id, g.group_name 
												from groups g JOIN posts p
												  on g.group_id = p.target_id
											   where p.post_id = ?");
					$gr_stmt->bind_param("i", $id);
					$gr_stmt->execute();
					$gr_stmt->bind_result($group_id, $group_name);
					$gr_stmt->fetch();
					$gr_stmt->close();
					
					/* $notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago,
							'check_pt'=>$check_point,'group_chk_pt'=>$group_check_pt, 
							'group_id'=>$group_id, 'group_name'=>$group_name);
					$notify_ids[] = $notification_id; */
					if($check_pt == NULL)
					{
						$gr_post_stmt = $con->prepare("SELECT gn.owner_id, gn.actor_id, gn.notification_type, gn.id,
							  			   gn.status, gn.notification_id, gn.check_point, gn.group_check_pt
								 from general_notifications
								where owner_id = ?
								  and notification_type = ?
								  and id IN (SELECT post_id from posts where target_type = 'group' and target_id = ?) 
								  and check_point IS NULL
								  and status != 5
								order by created_time DESC");
						if($gr_post_stmt)
						{
							$gr_post_stmt->bind_param("isi", $user_id, "gr_post", $group_id);
							$gr_post_stmt->execute();
							$gr_post_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
							$notification_id, $check_point, $group_check_pt);
							while ($gr_post_stmt->fetch())
							{
								$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago,
										'check_pt'=>$check_point,'group_chk_pt'=>$group_check_pt,
										'group_id'=>$group_id, 'group_name'=>$group_name);
								$notify_ids[] = $notification_id;	
							}
							$gr_post_stmt->close();	
						}
						$result = $con->query("Update general_notifications set check_point =
									(SELECT max(check_point) from (SELECT check_point FROM general_notifications) AS gn)
									where notification_id IN (".implode(",", $notify_ids).")");
					}
					else
					{
					$gr_post_stmt = $con->prepare("SELECT gn.owner_id, gn.actor_id, gn.notification_type, gn.id,
							  			   gn.status, gn.notification_id, gn.check_point, gn.group_check_pt
								 from general_notifications
								where owner_id = ?
								  and notification_type = ?
								  and id IN (SELECT post_id from posts where target_type = 'group' and target_id = ?) 
								  and check_point = ?
								  and status != 5
								order by created_time DESC");
						if($gr_post_stmt)
						{
							$gr_post_stmt->bind_param("isii", $user_id, "gr_post", $group_id, $check_point);
							$gr_post_stmt->execute();
							$gr_post_stmt->bind_result($owner_id, $actor_id, $notification_type, $id, $status,
							$notification_id, $check_point, $group_check_pt);
							while ($gr_post_stmt->fetch())
							{
								$notifications[] = array('actor'=>$actor_id, 'status'=>$status, 'ago'=>$ago,
										'check_pt'=>$check_point,'group_chk_pt'=>$group_check_pt,
										'group_id'=>$group_id, 'group_name'=>$group_name);
								$notify_ids[] = $notification_id;	
							}
							$gr_post_stmt->close();	
						}
					}
					$name_stmt = $con->prepare("SELECT user_id, CONCAT(firstname,' ',lastname)
						 from `user` where user_id IN (".implode(",", array_column($notifications,'actor')).")");
					$gr_mem_names = array();
					$name_stmt->execute();
					$name_stmt->bind_result($id, $name);
					while($name_stmt->fetch())
					{
						$gr_mem_names[$id] = $name;
					}
					$name_stmt->close();
					$data .= "<a ";
					if(array_search(1,array_column(notifications,"status"))!== FALSE)
					{
						$data .= "class='unseen_notifications'";
					}
						$data .= "><div class='noti_gen'>
								<div class='gen_left'>
								<div class='gen_noti_icon' style='background-image:url(".get_user_dp($con,$notifications[0]['actor']).");'></div>
							</div>
							<div class='gen_right'>
								<div class='notievent_des' data-group='".$notifications[0]['group_id']."' 
										data-post='".$notifications[0]['id']."'>"
															.groupify($gr_mem_names)." posted on ".$notifications[0]['group_name']."
								</div>
									</div>
									<div class='notievent_time'>".$notifications[0]['ago']."</div>
								<div class='noti_remove' data-type='post' data-value='".$notifications[0]['group_id']."'>
									<i class='remove_icon'></i>
									<div class = 'card-tag'>
										<div class = 'tag-wedge'></div>
										<div class = 'tag-box'>
											<span>Hide</span>
										</div>
									</div>
								</div>
							</div>
						</a>";
					break;
			}
			$notif_no +=1;
			$upd_stmt= $con->prepare("UPDATE general_notifications SET group_check_pt = ? 
							 where notification_id IN (".implode(",", $notify_ids).")");
			$upd_stmt->bind_param("i", $notif_no);
			$upd_stmt->execute();
			$upd_stmt->close();
			$upd_stmt = $con->prepare("UPDATE general_notifications SET status = 2 WHERE notification_id IN 
			(SELECT * FROM (SELECT notification_id FROM general_notifications WHERE status = 1 
			AND notification_id IN (".implode(",", $notify_ids).")) as gn)");
			$upd_stmt->execute();
			$upd_stmt->close();
		}
		else
		{
			break;
		}
		$stmt->free_result();
	}
	$stmt->close();
	return $data;
}