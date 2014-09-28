<?php
$_SESSION['user_id'] = 1;
include_once('includes/dbconfig.php');
$user_id = $_SESSION['user_id'];
if(isset($_GET["type"])&& $_GET['type']=="remove")
{
	switch ($_GET['ftype'])
	{
		case 'follow':
			echo ("follow");
			$stmt = $con->prepare("UPDATE general_notifications SET status = 5 WHERE check_point = ?");
			$stmt->bind_param("i", $_GET['fd']);
			$stmt->execute();
			$stmt->close();
			break;
		case 'post':
			$stmt = $con->prepare("UPDATE general_notifications SET status = 5 WHERE id = ?");
			$stmt->bind_param("i", $_GET['fd']);
			$stmt->execute();
			$stmt->close();
			$stmt = $con->prepare("DELETE posts_user_inv WHERE post_id = ? and user_id = ?");
			$stmt->bind_param("ii", $_GET['fd'], $user_id);
			$stmt->execute();
			$stmt->close();
			break;
		case 'upvote':
			$stmt = $con->prepare("UPDATE general_notifications SET status = 5 WHERE id = ? and notification_type = ?");
			$stmt->bind_param("is", $_GET['fd'],$_GET['ftype']);
			$stmt->execute();
			$stmt->close();
			break;
		default:
			$stmt = $con->prepare("UPDATE general_notifications SET status = 5 WHERE notification_id = ?");
			if(isset($_GET['fd']))
			{		
				$stmt->bind_param("i", $_GET['fd']);
				$stmt->execute();
			}
			$stmt->close();
			break;
	}
}
elseif(isset($_GET["type"])&& $_GET['type']=="mark_all")
{
	$stmt = $con->prepare("UPDATE general_notifications SET status = 3 WHERE user_id = ? 
							and status = 1");
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$stmt->close();
}

elseif(isset($_GET["type"])&& $_GET['type']=="mark_seen")
{
	switch ($_GET['ftype'])
	{
		case 'follow':
			echo ("follow");
			$stmt = $con->prepare("UPDATE general_notifications SET status = 3 WHERE check_point = ?");
			$stmt->bind_param("i", $_GET['fd']);
			$stmt->execute();
			$stmt->close();
			break;
		case 'post':
		case 'upvote':
			$stmt = $con->prepare("UPDATE general_notifications SET status = 3 WHERE id = ? and notification_type = ?");
			$stmt->bind_param("is", $_GET['fd'],$_GET['ftype']);
			$stmt->execute();
			$stmt->close();
			break;
		default:
			$stmt = $con->prepare("UPDATE general_notifications SET status = 3 WHERE notification_id = ?");
			if(isset($_GET['fd']))
			{		
				$stmt->bind_param("i", $_GET['fd']);
				$stmt->execute();
			}
			$stmt->close();
			break;
	}
}
$con->close();