<?php

function server_time($timestamp) {
    $server_tz = 'America/Denver';
    if (!isset($_SESSION['user_tz']))
        $_SESSION['user_tz'] = "America/New_York"; if (empty($timestamp)) {
        return "No date provided";
    } $time = new DateTime($timestamp, new DateTimeZone($_SESSION['user_tz']));
    $time->format('Y-m-d H:i:sP');
    $time->setTimezone(new DateTimeZone($server_tz));
    $new_time = $time->format('Y-m-d H:i:sP');
    return $new_time;
}

function user_time($timestamp) {
    $server_tz = 'America/Denver';
    if (!isset($_SESSION['user_tz']))
        $_SESSION['user_tz'] = "America/New_York"; if (empty($timestamp)) {
        return "No date provided";
    } $time = new DateTime($timestamp, new DateTimeZone($server_tz));
    $time->format('Y-m-d H:i:sP');
    $time->setTimezone(new DateTimeZone($_SESSION['user_tz']));
    $new_time = $time->format('Y-m-d H:i:sP');
    return $new_time;
}

?>