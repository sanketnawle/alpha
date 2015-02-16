<?php
echo"
    <div class='feed-tab-content'>
        <div class='group_fbar_wrap'>
";
            include_once('department_status_bar.php');
echo "
        </div>

        <div class='group_feed_wrap'>
        </div>

        <div class='feed-tab-rightsec'>
";
            include_once('department_feed_right_about.php');
echo "
            <div class='feed_planner_bag'>";
                //include_once('planner_beta.php');
echo "
            </div>
        </div>
    </div>
";
?>