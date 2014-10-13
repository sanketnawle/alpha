<?php


echo "<div class='feed-tab-content'>";

echo "<div class='group_fbar_wrap'>";

    echo $this->renderPartial('/partial/status_bar',array('pg_src'=>'club.php','target_type'=>'group','target_id'=>$club->group_id));

echo "</div>";

echo "<div class='group_feed_wrap'>";

    Yii::app()->runController('partial/feeds',array('user'=>$user));

echo "</div>";

echo "<div class='feed-tab-rightsec'>";


    echo $this->renderPartial('club_feed_right_about',array('club'=>$club));

echo "</div>";

echo "</div>";
?>