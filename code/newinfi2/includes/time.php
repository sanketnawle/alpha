    <?php

    // date_default_timezone_set("America/New_York");
    // $_SESSION['user_tz'] = "America/New_York";

    // $_POST['user_tz_offset'] = "240";

    if(isset($_POST['user_tz_offset'])){
        if(!isset($_SESSION['user_tz'])){
            $isDST = 1; // Daylight Saving 1 - on, 0 - off
            echo $_SESSION['user_tz'] = timezone_name_from_abbr('', intval($_POST['user_tz_offset']) * 60, $isDST);
        }
        else echo "lol";
    }

    function formattime($timestamp)
    {
        $current_tz = 'America/Denver';
        if(!isset($_SESSION['user_tz'])) $_SESSION['user_tz'] = "America/New_York";

        if(empty($timestamp)) {
            return "No date provided";
        }

        $time = new DateTime($timestamp, new DateTimeZone($current_tz));
        $time->format('Y-m-d H:i:sP') . "<br>";

        $time->setTimezone(new DateTimeZone($_SESSION['user_tz']));
        $new_time = $time->format('Y-m-d H:i:sP');
     
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");
     
        // $now = time();
        $now_ts = new DateTime('now', new DateTimeZone($_SESSION['user_tz']));
        // echo "<br>";
        $now = strtotime($now_ts->format('Y-m-d H:i:sP'));
        $unix_time = strtotime($new_time);
     
        // check validity of date
        if(empty($unix_time)) {
            return "Bad date";
        }
     
        // is it future date or past date
        if($now > $unix_time) {
            $difference = $now - $unix_time;
            $tense = "ago";     
        }
        else {
            $difference = $unix_time - $now;
            $tense = "from now";
        }
     
        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }
     
        $difference = round($difference);
     
        if($difference != 1) {
            $periods[$j].= "s";
        }
     
        return "$difference $periods[$j] {$tense}";
    }
     
    // echo $timestamp = "2014-06-24 10:45";
    // echo "<br>";
    // echo $result = formattime($timestamp); // 2 days ago
     
?>