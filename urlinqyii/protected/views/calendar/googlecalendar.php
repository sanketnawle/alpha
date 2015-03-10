<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


include 'Google/Client.php';
include 'Google/Config.php';
include 'Google/Model.php';
include 'Google/Collection.php';
include 'Google/Exception.php';
include 'Google/Service.php';
include 'Google/Task/Retryable.php';
include 'Google/Service/Exception.php';
include 'Google/Utils.php';
include 'Google/Service/Resource.php';
include 'Google/Service/Calendar.php';
include 'Google/Auth/Abstract.php';
include 'Google/Auth/OAuth2.php';
include 'Google/Auth/Exception.php';
include 'Google/Http/Request.php';
include 'Google/Http/REST.php';
include 'Google/Http/CacheParser.php';
include 'Google/Logger/Abstract.php';
include 'Google/Logger/Null.php';
include 'Google/IO/Abstract.php';
include 'Google/IO/Curl.php';
include 'Google/Task/Runner.php';
include 'Google/Utils/URITemplate.php';
include 'Google/Http/Batch.php';


/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/user-example.php
 ************************************************/
  //Uncomment the three lines for running on local and make sure you uncomment the live ones
 /*$client_id = '960881917908-rgb9ujp6v6rf3ufmbfbg8nadb41f9tdl.apps.googleusercontent.com';
 $client_secret = 'W3U_-nJF1LFgLD1NWacK2a-_';
 $redirect_uri = 'http://127.0.0.1/alpha/urlinqyii/calendar';*/
 //uncomment three lines for running on live and make sure you uncomment the local ones
 $client_id = "566213768963-rbdpvbo33oe0dn4rdhmj83que4f13vuc.apps.googleusercontent.com";
 $client_secret = "_HFKQAsU2GNSAp7yUE4n2BVv";
 $redirect_uri = 'http://beta.urlinq.com/calendar';
/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$user_id = $this->get_current_user_id([]);
$has_refresh_token = false;
$google_user = GoogleUser::model()->find('user_id=:id', array(':id'=>$user_id));
if($google_user){
  if($google_user->last_updated){
    $has_refresh_token = true;
  }
}

$user_last_updated = Event::model()->find('user_id=:user_id order by time_added DESC', array(':user_id' => $user_id));
$last_updated = false;
if($user_last_updated){
  $last_updated = $user_last_updated->time_added;
}

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setAccessType("offline");
$client->addScope("https://www.googleapis.com/auth/calendar");

$client_batch = new Google_Client();
$client_batch->setClientId($client_id);
$client_batch->setClientSecret($client_secret);
$client_batch->setRedirectUri($redirect_uri);
$client_batch->setAccessType("offline");
$client_batch->setUseBatch(true);
$client_batch->addScope("https://www.googleapis.com/auth/calendar");

/************************************************
  We are going to create both YouTube and Drive
  services, and query both.
 ************************************************/
$yt_service = new Google_Service_Calendar($client);
$yt_service_batch = new Google_Service_Calendar($client_batch);

 $batch = new Google_Http_Batch($client_batch);

 
/************************************************
  Boilerplate auth management - see
  user-example.php for details.
 ************************************************/
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();

  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $client_batch->setAccessToken($_SESSION['access_token']);
  if(!$has_refresh_token){
  $calList = $yt_service->calendarList->listCalendarList();
  var_dump($calList);
  $refreshtoken = $client->getRefreshToken();
  $google_calendar = new GoogleUser();
  $google_calendar->user_id = $user_id;
  $google_calendar->last_updated = NULL;
  $google_calendar->refreshtoken = $refreshtoken;
  $google_calendar->email = $calList->getItems()[0]->getId();
  $google_calendar->save(false);
  unset($_SESSION["access_token"]);
  }

} else {
  if($has_refresh_token){
    $client->refreshToken($google_user->refreshtoken);
    $client_batch->refreshToken($google_user->refreshtoken);
  }
  else{
  $authUrl = $client->createAuthUrl();
  }
}

/************************************************
  If we're signed in, retrieve channels from YouTube
  and a list of files from Drive.
 ************************************************/
if (isset($authUrl)) {
  ?>
  <div class="create google_sync">
        <div class="button left_panel_create_button">
                    <div id="google_cal_button" class="full"><a href="<?php echo $authUrl; ?>">Sync Google</a> </div>
                </div>
            </div>
<?php
} elseif($last_updated && $has_refresh_token && $last_updated > $google_user->last_updated) {

  $complete_events = array();
  $u_personal_events = Yii::app()->db->createCommand("SELECT * FROM `event` WHERE event.user_id = " . $user_id." and time_added > '".$google_user->last_updated."'")->queryAll();
  $u_attending_events = Yii::app()->db->createCommand("SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = " . $user_id . " and event.time_added > '".$google_user->last_updated."'")->queryAll();
  $u_events = array_merge($u_personal_events,$u_attending_events);


  if($u_events){
    foreach ($u_events as $u_event){
        $event = new Google_Service_Calendar_Event();
        $event->setSummary($u_event["title"]);

        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime(date(DATE_RFC3339, (new DateTime($u_event["start_date"]."T".$u_event["start_time"]))->getTimestamp()));//((new DateTime($u_event["start_time"]))->format("H:i:sP"));
        $event->setStart($start);

        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime(date(DATE_RFC3339, (new DateTime($u_event["end_date"]." ".$u_event["end_time"]))->getTimestamp()));//((new DateTime($u_event["end_time"]))->format("H:i:sP"));
        $event->setEnd($end);


        /* add event inserts in the batch spool */
        $req = $yt_service_batch->events->insert($google_user->email, $event);

        $batch->add($req, false);
        $req = null;
      }
    $resultsBatch = $batch->execute();

  $google_user->last_updated = $last_updated;
  $google_user->save(false);
  }


} 
?>
