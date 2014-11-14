<!-- <div class='department_feed_tab.php'> -->

<?php



echo "

<div class='feed-tab-content'>";

echo "<div class='group_fbar_wrap'>";

include_once('department_status_bar.php');

echo "</div>";



echo "<div class='group_feed_wrap'>";

include_once('feeds.php');

echo "</div>";


echo "<div class='feed-tab-rightsec'>";

include_once('department_feed_right_about.php');
	echo "<div class='feed_planner_bag'>";
		include_once('planner_beta.php');
	echo "</div>";
echo "</div>";



echo "
    </div>
";



?>