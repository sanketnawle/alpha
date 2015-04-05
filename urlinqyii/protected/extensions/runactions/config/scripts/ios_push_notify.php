<?php

$notification = $params['notification'];

$user_id = $notification->user_id;
$user = User::model()->find('user_id=:user_id', array(':user_id'=>$user_id));
$notification_text = getiOSNotificationText($notification, $user);
notifyAlliOSDevicesForUserID($user_id, $notification_text, $notification);

			function notifyAlliOSDevicesForUserID($user_id, $message, $notification) {

	        $sql = "SELECT * FROM ios_notifications WHERE user_id = $user_id;";
	            $device_notifications = IosNotifications::model()->findAllBySql($sql);

	            $result = pushNotify($message, $device_notifications, $notification);

	        }

	        function getiOSNotificationText($notification, $user) {
	            $base_path = dirname(Yii::app()->request->scriptFile);
	            $file_url = $base_path . '/protected/components/notification/notification-helper.php';
	            require $file_url;

	            $data = get_notifications_data($user, array($notification))['notifications'][0];

	            $origin = $data['origin'];
	            $actor = $data['actor'];
	            $normal_name = $actor['firstname'] . ' ' . $actor['lastname'];
	            $professor_name = "Professor " . $actor['lastname'];
	            $type = $data['type'];

	            $notification_text = "New Urlinq notification.";

	            if ($type == 'follow') {
	            	$notification_text = "$normal_name is now following you.";
	            } else if ($type == 'like') {
	            	$notification_text = "$normal_name liked your post.";
	            } else if ($type == 'reply') {
	            	if ($origin['user_id'] == $user->user_id) {
	            		if ($data['reply']['anon'] == true) {
	            			if ($origin['post_origin']) {
	            				$origin_name = $origin['post_origin']['name'];
	            				$notification_text = "Anonymous replied to your post in $origin_name.";
	            			} else {
								$notification_text = "Anonymous replied to your post.";
	            			}
	            		} else {
	            			if ($origin['post_origin']) {
	            				$origin_name = $origin['post_origin']['name'];
	            				$notification_text = "$normal_name replied to your post in $origin_name.";
	            			} else {
								$notification_text = "$normal_name replied to your post.";
	            			}
	            		}
	            	} else {
						if ($data['reply']['anon'] == true) {
	            			if ($origin['post_origin']) {
	            				$origin_name = $origin['post_origin']['name'];
	            				$notification_text = "Anonymous replied to a post in $origin_name.";
	            			} else {
								$notification_text = "Anonymous replied to a post.";
	            			}
	            		} else {
	            			if ($origin['post_origin']) {
	            				$origin_name = $origin['post_origin']['name'];
	            				$notification_text = "$normal_name replied to a post in $origin_name.";
	            			} else {
								$notification_text = "$normal_name replied to a post.";
	            			}
	            		}
	            	}
	            } else if ($type == 'post') {
	            	if ($origin['post_type'] == 'event') {
	            		$event_title = $data['event']['title'];
	            		if ($origin['anon'] == true) {
	            			if ($origin['post_origin']['name']) {
								$origin_name = $origin['post_origin']['name'];
	           					$notification_text = "Anonymous posted the event $event_title to $origin_name.";
	            			} else {
								$notification_text = "Anonymous posted the event $event_title.";
	            			}
	            		} else {
	           				if ($origin['post_origin']['name']) {
								$origin_name = $origin['post_origin']['name'];
	           					$notification_text = "$normal_name posted the event $event_title to $origin_name.";
	           				} else {
								$notification_text = "$normal_name posted the event $event_title.";
	            			}
	            		}
	            		
	            	} else {
	            		if ($origin['anon'] == true) {
	            			if ($origin['post_origin']['name']) {
								$origin_name = $origin['post_origin']['name'];
	           					$notification_text = "Anonymous posted in $origin_name.";
	           				} else {
								$notification_text = "Anonymous posted.";
	           				}
	           			} else {
	           				if ($origin['post_origin']['name']) {
								$origin_name = $origin['post_origin']['name'];
	            				$notification_text = "$normal_name posted in $origin_name.";
	            			} else {
								$notification_text = "$normal_name posted.";
	            			}
	            		}
	            	}
	            } else if ($type == 'invite') {
	        		$origin_type = $data['origin_type'];
	        		if ($origin_type == 'event') {
	        			$title = $origin['title'];
	        			$notification_text = "$origin_name invited you to $title";
	        		} else if ($origin_type == 'class') {
						$title = $origin['class_name'];
	        			$notification_text = "$origin_name invited you to $title";
	        		} else if ($origin_type == 'group' || $origin_type == 'club') {
	        			$title = $origin['group_name'];
						$notification_text = "$origin_name invited you to $title";
	        		}
	        	} else if ($type == 'event') {
	        		$title = $origin['title'];
	        		$origin_title = $origin['event_origin']['name'];
	        		$notification_text = "$origin_name created the event $title in $origin_title";
	        	} else if ($type == 'announcement') {
	        		$class_name = $origin['class_name'];
	        		$notification_text = "$professor_name has made an announcement in your class, $class_name";
	        	}
	        	
	        	return $notification_text;
	        }

	        function pushNotify($message, $device_notifications, $notification) {

	            $passphrase = 'URPNCC@MondayCertificate';
	            $message = $message;

	            $base_path = dirname(Yii::app()->request->scriptFile);
	            $certificate_url = $base_path . '/protected/components/notification/ck.pem';

	            $ctx = stream_context_create();
	            stream_context_set_option($ctx, 'ssl', 'local_cert', $certificate_url);
	            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

	            $fp = stream_socket_client(
	                'ssl://gateway.sandbox.push.apple.com:2195', $err,
	                $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	            if (!$fp) {
	                error_log("Failed to connect - iOS push notifications - error one");
	                return array('success'=>false,'error_id'=>2,'error_msg'=>"Failed to connect: $err $errstr" . PHP_EOL);
	            }

	            foreach ($device_notifications as $device_notification) {
					$body['aps'] = array(
	                	'alert' => $message,
	                	'sound' => 'default',
	                	'notification' => $notification
	                );

	            	$payload = json_encode($body);

	            	$msg = chr(0) . pack('n', 32) . pack('H*', $device_notification->notification_id) . pack('n', strlen($payload)) . $payload;

	            	$result = fwrite($fp, $msg, strlen($msg));

	            }

	            fclose($fp);
	        }

?>