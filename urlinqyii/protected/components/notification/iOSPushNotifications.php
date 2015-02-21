<?php

        function notifyAlliOSDevicesForUserID($user_id, $message) {

            $sql = "SELECT * FROM ios_notifications WHERE user_id = $user_id;";
            $device_notification_ids = IosNotifications::model()->findAllBySql($sql);

            foreach($device_notification_ids as $notification_id) {
                pushNotify($message, $notification_id->notification_id);
            }
        }
         
        function pushNotify($message, $notification_id) {

            $deviceToken = $notification_id;
            $passphrase = 'URPNCC@MondayCertificate';
            $message = $message;

            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', '/Applications/MAMP/htdocs/alpha/urlinqyii/protected/components/notification/7ed48ded2e412732011227722ff356e9ca5bca05ck.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

            if (!$fp)
                error_log("Failed to connect - iOS push notifications - error one");
                return array('success'=>false,'error_id'=>2,'error_msg'=>"Failed to connect: $err $errstr" . PHP_EOL);

            $body['aps'] = array(
                'alert' => $message,
                'sound' => 'default'
                );

            $payload = json_encode($body);

            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

            $result = fwrite($fp, $msg, strlen($msg));

            if (!$result)
                error_log("Failed to connect - iOS push notifications - error two");
                return array('success'=>false,'error_id'=>3,'error_msg'=>"Failed to connect: $err $errstr" . PHP_EOL);
            else
                return array('success'=>true);

            fclose($fp);
        }

?>