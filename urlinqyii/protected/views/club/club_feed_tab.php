<?php
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/5/14
 * Time: 2:58 PM
 */

echo "<div class='feed-tab-content'>";

echo "<div class='group_fbar_wrap'>";
include_once('status_bar.php');
echo "</div>";

echo "<div class='group_feed_wrap'>";
include_once('feeds.php');
echo "</div>";

echo "<div class='feed-tab-rightsec'>";
include_once('php/club_feed_right_about.php');
echo "</div>";

echo "</div>";
?>