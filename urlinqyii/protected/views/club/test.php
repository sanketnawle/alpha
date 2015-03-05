<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>



<script>
    var globals = {};
    globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
    globals.user_id = '<?php echo $user->user_id; ?>';


</script>

<!--<script src='--><?php //echo Yii::app()->getBaseUrl(true); ?><!--/js/file_upload.js'></script>-->
<link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/messaging/messaging.css' rel='stylesheet' type='text/css'>



<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/messaging/messaging.js'></script>

<!---->
<!---->
<!---->
<!--<form id='file_upload_form' action="--><?php //echo Yii::app()->getBaseUrl(true); ?><!--/api/fileUpload" method="post" enctype="multipart/form-data">-->
<!--    <input type="text" name="origin_type" value="club">-->
<!--    <input type="text" name="origin_id" value="1">-->
<!--    Please choose a file: <input type="file" name="uploadFile"><br>-->
<!--    <input type="submit" value="Upload File">-->
<!--</form>-->
<script id="this_user_message_template" type="text/x-handlebars-template">
    <div class="this_user_message" data-user_id='{{user_id}}'>
    {{text}}
    </div>
</script>

<script id="other_user_message_template" type="text/x-handlebars-template">
    <div class="other_user_message" data-user_id='{{user_id}}'>
    {{text}}
    </div>
</script>

<div class="chat_box" data-target_id="2" data-target_type="user">
    <div class="chat_box_text">

    </div>


    <div class="chat_input_box">
        <textarea class="chat_input autogrow"></textarea>
    </div>

</div>