<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>

<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/file_upload.js'></script>



I MADE A CHANGE

<?php
echo $type;

////
////
////var_dump($club);
////var_dump($user);
////
////var_dump($is_admin);
////
////
////var_dump($file_count);
////
////var_dump($club->users);
////
////
////var_dump($is_member);
////
////
////var_dump($connected_users);
////
////
////
////
////var_dump($club->events);
////
////
////
////
////
////echo "USER COURSES";
////var_dump($user->courses);
////
////
////echo "$ COURSES";
////var_dump($courses);
////
////
////
//
//echo Yii::getVersion();
//var_dump($department->pictureFile->file_url);
//
//var_dump($classes);
//?>


<script>
    $(document).ready(function(){
        var post_data = {
            event:{
                event_name: 'Test event',
                event_type: 'exam',
                origin_type:' club',
                origin_id: 1,
                title: 'Test Event',
                description: 'This is my test event description',
                start_time: '10:10:10',
                end_time: '11:11:11',
                start_date: '2014-12-01',
                end_date: '2014-12-01',
                location: 'Manhattan'
            }
        };
        //alert(JSON.stringify(post_data));
        $.post(
            'http://localhost/alpha/urlinqyii/event/create',
            post_data,
            function(json_response) {
                alert(JSON.stringify(json_response));
            }, 'json'
        );
    });
</script>

<form id='file_upload_form' action="<?php echo Yii::app()->getBaseUrl(true); ?>/api/fileUpload" method="post" enctype="multipart/form-data">
    <input type="text" name="origin_type" value="club">
    <input type="text" name="origin_id" value="1">
    Please choose a file: <input type="file" name="uploadFile"><br>
    <input type="submit" value="Upload File">
</form>