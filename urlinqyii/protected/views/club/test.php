<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script type="text/javascript" src="http://<?php echo Yii::app()->nodeSocket->host;?>:<?php echo Yii::app()->nodeSocket->port;?>/socket.io/socket.io.js" > </script>
<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/messaging/YiiNodeSocket.js" > </script>
<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>



<script>
    var messaging_globals = {};
    messaging_globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
    messaging_globals.user_id = '<?php echo $user->user_id; ?>';

    messaging_globals.socket_io_url = 'http://<?php echo Yii::app()->nodeSocket->host;?>:<?php echo Yii::app()->nodeSocket->port;?>/client';

    console.log('socket io url');
    console.log(globals.socket_io_url);
</script>

<!--<script src='--><?php //echo Yii::app()->getBaseUrl(true); ?><!--/js/file_upload.js'></script>-->
<link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/messaging/messaging.css' rel='stylesheet' type='text/css'>



<script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/messaging/messaging.js'></script>



<script>

    $(document).ready(function(){



        $('#generate_password_button').click(function(){

            var password = $('#password_input').val();



            var post_url = globals.base_url + '/admin/generatePassword';
            var post_data = {password: password};

            $.post(
                post_url,
                post_data,
                function(response){
                    if(response['success']){
                        $('#hashed_password').val(response['hashed_password']);
                        $('#salt').val(response['salt']);
                    }else{
                        alert('Error hashing password');
                        console.log(response);
                    }
                },'json'
            );

        });
    });

</script>


<div id="generate_password">
    <label for="hashed_password">Hashed password</label>
    <br>
    <textarea type="text" id="hashed_password" value="" readonly style="height: 150px; width: 300px;"></textarea>
    <br>
    <label for="salt">Salt</label>
    <br>
    <input type="text" id="salt" value="" readonly style="width: 300px;">
    <br>
    <div>Input password</div>
    <input type="text" id="password_input" name="password" value="" placeholder="cleartext password here">
    <br>
    <button type="submit" id="generate_password_button">GENERATE</button>
    <br>
    <br>
    <br>
</div>




<!---->
<!---->
<!---->





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



<!---->
<?php
//    $email = 'lol@med.nyu.edu';
//
//    $supported_email = 'nyu.edu';
//
//    $b = false;
//    if(strpos($email, $supported_email)){
//        $b = true;
//    }
//
//?>









<?php
$id = 1;
if($user->user_id == 1){
    $id = 2;
}
?>



<div class="chat_box" data-id="<?php echo $id; ?>" data-type="user">
    <div class="chat_box_text">
        <div class="chat_message_wrap">

        </div>
    </div>


    <div class="chat_input_box">
        <textarea class="chat_input autogrow"></textarea>
    </div>

</div>