

<script type="text/javascript" src="http://<?php echo Yii::app()->nodeSocket->host;?>:<?php echo Yii::app()->nodeSocket->port;?>/socket.io/socket.io.js" > </script>


<script>
    var messaging_globals = {};
    messaging_globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
    messaging_globals.user_id = '<?php echo $user->user_id; ?>';

    messaging_globals.socket_io_url = 'http://<?php echo Yii::app()->nodeSocket->host;?>:<?php echo Yii::app()->nodeSocket->port;?>/client';

    console.log('socket io url');
    console.log(messaging_globals.socket_io_url);
</script>




<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/messaging/YiiNodeSocket.js" > </script>

<!--<script src='--><?php //echo Yii::app()->getBaseUrl(true); ?><!--/js/file_upload.js'></script>-->
<link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/messaging/messaging.css' rel='stylesheet' type='text/css'>
<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/messaging/messaging.js'></script>


<script id="messaging_list_item_template" type="text/x-handlebars-template">
    <div class="messaging_list_item" data-id='{{id}}' data-type='{{type}}' data-name="{{name}}">
        <div class="messaging_list_item_left_holder">
            <div class='messaging_list_item_pic' style="background-image: url('<?php echo Yii::app()->getBaseUrl(true); ?>{{pictureFile.file_url}}');">
                {{#if is_online}}
                <div class='online_indicator'></div>
                {{/if}}
            </div>
        </div>


        <div class="messaging_list_item_right_holder">
            <div class='messaging_list_item_name'>{{name}}</div>
        </div>

    </div>
</script>



<div id="messaging_panel">
    <div id="header">
        <div id="messaging_pic" style="
            background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $user->pictureFile->file_url;?>');"></div>

        <div id="messaging_button" style="">


            <div id="messaging_button_text">MESSAGES ></div>
        </div>

    </div>

    <div id="messaging_list">
        <div id="messaging_list_recent_header">Recent</div>
        <div id="messaging_list_recent"></div>

        <div id="messaging_list_user_header">Students</div>
        <div id="messaging_list_user"></div>

        <div id="messaging_list_professor_header">Professors</div>
        <div id="messaging_list_professor"></div>

        <div id="messaging_list_class_header">Classes</div>
        <div id="messaging_list_class"></div>


        <div id="messaging_list_group_header">Groups</div>
        <div id="messaging_list_group"></div>

        <div id="messaging_list_custom_header">Group Chats</div>
        <div id="messaging_list_custom"></div>
    </div>

</div>



<script id="extra_chat_boxes_template" type="text/x-handlebars-template">
    <div id="extra_chat_boxes" style="display: none;">
        <div id="extra_chat_boxes_list" style="display: none;"></div>
        <div id="extra_chat_boxes_text">More chats</div>
        <div id="extra_chat_boxes_count"></div>
    </div>
</script>



<script id="extra_chat_box_template" type="text/x-handlebars-template">
    <div class="extra_chat_box" data-type="{{type}}" data-id="{{id}}" data-name="{{name}}">
        {{name}}
    </div>
</script>




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




<script id="chat_box_template" type="text/x-handlebars-template">


    <div class="chat_box" data-id="{{id}}" data-type="{{type}}" data-name="{{name}}">
        <div class="chat_box_text">
            <div class="chat_message_wrap">

            </div>
        </div>


        <div class="chat_input_box">
            <textarea class="chat_input autogrow"></textarea>
        </div>

    </div>


</script>