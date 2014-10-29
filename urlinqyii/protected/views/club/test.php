<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>

<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/file_upload.js'></script>

<?php
//
//
//var_dump($club);
//var_dump($user);
//
//var_dump($is_admin);
//
//
//var_dump($file_count);
//
//var_dump($club->users);
//
//
//var_dump($is_member);
//
//
//var_dump($connected_users);
//
//
//
//
//var_dump($club->events);
//
//
//
//
//
//echo "USER COURSES";
//var_dump($user->courses);
//
//
//echo "$ COURSES";
//var_dump($courses);
//
//
//
//?>

<form id='file_upload_form' action="<?php echo Yii::app()->getBaseUrl(true); ?>/file/upload" method="post" enctype="multipart/form-data">
    <input type="text" name="origin_type" value="club">
    <input type="text" name="origin_id" value="1">
    Please choose a file: <input type="file" name="uploadFile"><br>
    <input type="submit" value="Upload File">
</form>