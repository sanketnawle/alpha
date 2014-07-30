<HTML>
<HEAD><TITLE>What?</TITLE></HEAD>
<BODY>
<?php
	
	include_once 'dbconnection.php';
	include_once 'Google/Client.php';
	include_once 'Google/Service/Calendar.php';
	session_start();
	print_r($connection);
	
	$tbl_name = "google_events";

	$client_id="921793683816-v9t43fr5do7p190svvbg9tvtesu3qntr.apps.googleusercontent.com";
	$client_secret = "297QlIpV4FFQsmBE8OUIcho4";
	$client_key = "AIzaSyB-TlvBXAgIbLaqEDuGFGCpZbSCd3hNKxg";
	$scriptUri = "https://urlinq.com/zheng/test.php";
	$scope = "https://www.googleapis.com/auth/calendar";

	$client = new Google_Client();
	$client ->setApplicationName("My Calendar");
	
	//Config client
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setDeveloperKey($client_key); 
	$client->setRedirectUri($scriptUri);
	$client -> setScopes($scope);
	
// $service implements the client interface, has to be set before auth call
	$service = new Google_Service_Calendar($client);
	
if (isset($_GET['logout'])) { // logout: destroy token
	echo "Log out";
    unset($_SESSION['token']);
	die('Logged out.');
	}

if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
	$client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
	}

if (isset($_SESSION['token'])) { // extract token from session and configure client
	$token = $_SESSION['token'];
    $client -> setAccessToken($token);
}


if (!$client->getAccessToken()) { // auth call to google
    $authUrl = $client->createAuthUrl();
    header("Location: ".$authUrl);
    die;
}

echo "Events from Google Calendar:<br>";
$events = $service->events->listEvents('primary');
$index = 0;

while(true) {
  foreach ($events->getItems() as $event) {
	$title = $event -> getSummary();
	$event_id = $event -> getId();
	$description = $event -> getDescription();
	$location = $event -> getLocation();
	if($event->getStart()->getDate() !== null) {
		$start_date = $event->getStart()->getDate();
		$start_date = date_create_from_format('Y-m-d',$start_date);
		$start_time = date_create_from_format('H:i:s', "00:00:00");
	} else {
		$start_date = substr($event->getStart()->getDateTime(), 0, 10);
		$start_date = date_create_from_format('Y-m-d',$start_date);
		$start_time = substr($event->getStart()->getDateTime(), -14, 8);
		$start_time = date_create_from_format('H:i:s', $start_time);
	}
	
	//All day event end date will be the same day as the start date
	if($event->getEnd()->getDate() !== null) {
		$end_date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
		$end_time = date_create_from_format('H:i:s', "23:59:59");
	} else {
		$end_date = substr($event->getStart()->getDateTime(), 0, 10);
		$end_date = date_create_from_format('Y-m-d', $end_date);
		$end_time = substr($event->getEnd()->getDateTime(), -14, 8);
		$end_time = date_create_from_format('H:i:s', $end_time);
	}
	
	//Recurrence Complexion 14 possible recurrence
	if($event->getRecurrence() !== null) {
		$recur_str= implode("", $event->getRecurrence());
		//3 Daily recurrence
		if(strpos($recur_str, "DAILY")) {
			$recurrence = "DAILY";
			if(strpos($recur_str, "COUNT")) {
				$count = substr($recur_str, strpos($recur_str,"COUNT")+6)-1;
				$date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
				$date -> add(new DateInterval('P'.$count.'D'));
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			} elseif(strpos($recur_str, "UNTIL")) {
				$until = substr($recur_str, strpos($recur_str,"UNTIL")+6);
				$date = date_create_from_format('Ymd', $until);
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			} else {
				$date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
				$date -> add(new DateInterval('P1Y'));
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			}
		//3 Weekly recurrence
		} elseif(strpos($recur_str, "WEEKLY")) {
			$recurrence = "WEEKLY";
			if(strpos($recur_str, "COUNT")) {
				$count = substr(substr($recur_str, strpos($recur_str,"COUNT")+6),0,-9)-1;
				$date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
				$date -> add(new DateInterval('P'.$count.'W'));
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			} elseif(strpos($recur_str, "UNTIL")) {
				$until = substr(substr($recur_str, strpos($recur_str,"UNTIL")+6),0,-9);
				$date = date_create_from_format('Ymd', $until);
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			} else {
				$date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
				$date -> add(new DateInterval('P1Y'));
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			}
		//3 Monthly recurrence
		} elseif(strpos($recur_str, "MONTHLY")) {
			$recurrence = "MONTHLY";
			if(strpos($recur_str, "COUNT")) {
				$count = substr($recur_str, strpos($recur_str,"COUNT")+6)-1;
				$date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
				$date -> add(new DateInterval('P'.$count.'M'));
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			} elseif(strpos($recur_str, "UNTIL")) {
				$until = substr($recur_str, strpos($recur_str,"UNTIL")+6);
				$date = date_create_from_format('Ymd', $until);
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			} else {
				$date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
				$date -> add(new DateInterval('P1Y'));
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			}
		//3 Yearly recurrence
		} elseif(strpos($recur_str, "YEARLY")) {
			$recurrence = "YEARLY";
			if(strpos($recur_str, "COUNT")) {
				$count = substr($recur_str, strpos($recur_str,"COUNT")+6)-1;
				$date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
				$date -> add(new DateInterval('P'.$count.'Y'));
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			} elseif(strpos($recur_str, "UNTIL")) {
				$until = substr($recur_str, strpos($recur_str,"UNTIL")+6);
				$date = date_create_from_format('Ymd', $until);
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			} else {
				$date = date_create_from_format('Y-m-d',$event->getStart()->getDate());
				$date -> add(new DateInterval('P10Y'));
				$end_date = $date;
				echo $end_date->format('Y-m-d');
			}
		//1 Unknown recurrence
		} else {
			echo "Unknown recurrence!!!";
		} 
	//No recurrence
	} else {
		$recurrence = "NONE";
	}
	
	echo "This is the No.".$index." event.<br>";
	echo "Event: ".$title."<br>"; 
	echo "Event ID: ".$event_id."<br>";
	echo "Created on:".$event -> getCreated()."<br>";
	echo "Link: ".$event -> getHtmlLink()."<br>";
	echo $description."<br>";
	echo $location."<br>";
	echo $start_date->format('Y-m-d')."<br>"; 
	echo $start_time->format('H:i:s')."<br>";
	echo $end_date->format('Y-m-d')."<br>"; 
	echo $end_time->format('H:i:s')."<br>";
	echo $recurrence;
	echo "<p>";
	$index = $index + 1;
	
	
	$ti = mysqli_real_escape_string($con, $title);
	$de = mysqli_real_escape_string($con, $description);
	$lo = mysqli_real_escape_string($con, $location);
	$re = mysqli_real_escape_string($con, $recurrence);
	$ei = mysqli_real_escape_string($con, $event_id);
	$sd=$start_date->format('Y-m-d');
	$ed=$end_date->format('Y-m-d');
	$st=$start_time->format('H:i:s');
	$et=$end_time->format('H:i:s');
	$sqli="INSERT INTO $tbl_name (title, description, location, event_id,
	start_date, start_time, end_date, end_time, recurrence)
	VALUES('$ti', '$de', '$lo', '$sd', '$st',
	'$ed', '$et', '$re')";
	$result = mysqli_query($con,$sqli) or die(mysql_error());
  
  }
  $pageToken = $events->getNextPageToken();
  if ($pageToken) {
    $optParams = array('pageToken' => $pageToken);
    $events = $service->events->listEvents('primary', $optParams);
  } else {
    break;
  }
}

//echo "Updated in database!";
session_destroy();
?>
</BODY>
</HTML>