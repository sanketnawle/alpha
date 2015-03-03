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
include 'Google/Utils.php';
include 'Google/Service/Resource.php';
include 'Google/Service/Calendar.php';
include 'Google/Auth/Abstract.php';
include 'Google/Auth/OAuth2.php';
include 'Google/Auth/Exception.php';
include 'Google/Http/Request.php';
include 'Google/Http/Rest.php';
include 'Google/Http/CacheParser.php';
include 'Google/Logger/Abstract.php';
include 'Google/Logger/Null.php';
include 'Google/IO/Abstract.php';
include 'Google/IO/Curl.php';
include 'Google/Task/Runner.php';
include 'Google/Utils/URITemplate.php';

/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/user-example.php
 ************************************************/
 $client_id = '960881917908-rgb9ujp6v6rf3ufmbfbg8nadb41f9tdl.apps.googleusercontent.com';
 $client_secret = 'W3U_-nJF1LFgLD1NWacK2a-_';
 $redirect_uri = 'http://127.0.0.1/alpha/urlinqyii/calendar';
/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/calendar.readonly");

/************************************************
  We are going to create both YouTube and Drive
  services, and query both.
 ************************************************/
$yt_service = new Google_Service_Calendar($client);
$event_service = new Google_Service_Calendar_Events($client);


/************************************************
  Boilerplate auth management - see
  user-example.php for details.
 ************************************************/
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $_SESSION["store"] = true;
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}

/************************************************
  If we're signed in, retrieve channels from YouTube
  and a list of files from Drive.
 ************************************************/
if ($client->getAccessToken()) {
  $_SESSION['access_token'] = $client->getAccessToken();
  $calList = $yt_service->calendarList->listCalendarList();
}

?>
<div class="box">
  <div class="request">
<?php 
if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Sync Google</a>";
} else {

  $complete_events = array();
  foreach ($calList->getItems() as $calendarListEntry) {
    $id = $calendarListEntry->getId();
    $list_events = $yt_service->events->listEvents($id)->getItems();
    foreach ($list_events as $list_event) {
      $out_array = array();  
      $out_array["created"] = $list_event->getCreated();
      $out_array["description"] = $list_event->getDescription();
      $out_array["location"] = $list_event->getLocation();
      $out_array["summary"] = $list_event->getSummary();
      if($out_array["summary"]){
        $out_array["title"] = $out_array["summary"];
      }
      elseif ($out_array["description"]) {
        $out_array["title"] = $out_array["description"];
      }
      else{
        $out_array["title"] = "Google Calendar event";
      }
      $start = $list_event->getStart();
      $end = $list_event->getEnd();
      if(isset($start->dateTime)){
        $out_array["start"] = $start->dateTime;
      }
      elseif(isset($start->date)){
        $out_array["start"] = $start->date;
      }
      else{
        $out_array["start"] = null;
      }
      if(isset($end->dateTime)){
        $out_array["end"] = $end->dateTime;
      }
      elseif(isset($start->date)){
        $out_array["end"] = $end->date;
      }
      else{
        $out_array["end"] = null;
      }
      array_push($complete_events, $out_array);
    }
  }
  if(isset($_SESSION["store"]) and $_SESSION["store"]){
      $user_id = $this->get_current_user_id();

      foreach ($complete_events as $key => $value) {
             # code...
           $event_entry = new Event;
          $event_entry->event_type = "";
          $event_entry->origin_type = "";
          $event_entry->origin_id = "";
          $event_entry->user_id = $user_id;
          $event_entry->title = $value["title"];
          $event_entry->start_time = (new DateTime($value["start"]))->format("H:i:s");
          $event_entry->end_time = (new DateTime($value["end"]))->format("H:i:s");
          $event_entry->start_date = (new DateTime($value["start"]))->format("Y-m-d");
          $event_entry->end_date = (new DateTime($value["end"]))->format("Y-m-d");
          $event_entry->time_added = $value["created"];
          $event_entry->location = $value["location"];
          $event_check = Event::model()->exists("title=:title and user_id=:user_id and start_date=:start_date and end_date=:end_date and location=:location", array(":title"=>$event_entry->title, ":user_id" => $event_entry->user_id, ":start_date" => $event_entry->start_date, ":end_date" => $event_entry->end_date, ":location" => $event_entry->location));
          if(!$event_check){
            $event_entry->save(false);
          }
          }
          $_SESSION["store"] = false;
      }
echo "Synced!";
} 
?>
  </div>
</div>


