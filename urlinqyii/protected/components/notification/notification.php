<?php

function send_notification($notification_type, $actor_id, $user_id, $origin_id, $origin_type){
    $notification = new Notification;
    $notification->type = $notification_type;
    $notification->actor_id = $actor_id;
    $notification->user_id = $user_id;
    $notification->origin_id = $origin_id;
    $notification->origin_type = $origin_type;

    $notification->save(false);

    include_once 'iOSPushNotifications.php';
    $notification = Notification::model()->find('notification_id=:id', array(':id'=>$notification->notification_id));
    $user = User::model()->find('user_id=:id', array(':id'=>$user_id));
    $notification_array = array_for_notification_model($notification);

    $notification = get_notifications_data($user, array($noti))[0];

    $message = get_notification_text($notification_array, $user, $notification);

    notifyAlliOSDevicesForUserID($user_id, $message, $notification['origin']);

}

function array_for_notification_model($notification) {
    return array("type"=>$notification->type, "actor_id"=>$notification->actor_id, "user_id"=>$notification->user_id, "origin_id"=>$notification->origin_id, "origin_type"=>$notification->origin_type);
}

function get_notification_text($noti, $user, $notification) {

    $origin = $notification['origin'];
    $type = $noti['type'];
    $actor = $notification['actor'];
    $notification_text = '';

        if ($type == 'follow') {
            $notification_text = $actor['firstname'] . " " . $actor['lastname'] . " is now following you.";

        } else if ($type == 'like') {
            $notification_text = $actor['firstname'] . " " . $actor['lastname'] . " liked your post: " . $origin['text'];

        } else if ($type == 'reply') {
            $notification_text = $actor['firstname'] . " " . $actor['lastname'] . " replied to your post: " . $origin['reply_msg'];
        } else if ($type == 'post') {
            $notification_text = $actor['firstname'] . " " . $actor['lastname'] . " posted " . $origin['post_origin'] . " in " . $origin['post_origin']['name'] . ": " . $origin['text'];
        } else if ($type == 'invite') {

            $origin_type = $noti->origin_type;

            if ($origin_type == 'event') {
                $notification_text = $actor['firstname'] . " " . $actor['lastname'] . " invited you to the event " . $origin['title'];
            } else if ($origin_type == 'class') {
                $notification_text = $actor['firstname'] . " " . $actor['lastname'] . " invited you to the class " . $origin['class_name'];
            } else if ($origin_type == 'club') {
                $notification_text = $actor['firstname'] . " " . $actor['lastname'] . " invited you to the club " . $origin['group_name'];
            } else if ($origin_type == 'group') {
                $notification_text = $actor['firstname'] . " " . $actor['lastname'] . " invited you to the group " . $origin['group_name'];
            } else {
                $notification_text = "Notification not supported yet.";
            }


        } else if ($type == 'announcement') {
            $notification_text = "Professor " . $actor['lastname'] . " has made announcement in your class, " . $origin['class_name'];
        } else {
            $notification_text = "Notification not supported yet.";
        }
        return $notification_text;
}

function get_notifications_data($user, $notifications){


        $notifications_new = array();
        foreach ($notifications as $notification) {
            $notification_type = $notification['type'];
            $origin = $notification['origin_type'];
            $origin_id = $notification['origin_id'];
            $actor_id = $notification['actor_id'];



            if($origin == '' || !$origin_id || !$actor_id){
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'origin type or id not set');
                //$this->renderJSON($data);
                return $data;
            }

            $actor = User::model()->find("user_id=:user_id", array(":user_id"=>$actor_id));
            if(!$actor){
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'actor doesnt exist');
                //$this->renderJSON($data);
                return $data;
            }


            $notification['actor'] = model_to_array($actor);


            $notification['actor']['pictureFile'] = $actor->pictureFile;

            if($notification_type == 'invite'){

                $invite = Invite::model()->find('user_id=:user_id and origin_id=:origin_id and origin_type=:origin_type', array(':user_id'=>$user->user_id, ':origin_id'=>$notification['origin_id'], ':origin_type'=>$origin));

                if(!$invite){
                    $data = array('success'=>false,'error_id'=>3,'error_msg'=>'invalid invite');
                    //$this->renderJSON($data);
                    return;
                }

                $notification['invite_id'] = $invite->invite_id;
                $notification['invite_choice'] = intval($invite->choice);


                if($notification['origin_type'] == 'event'){
                    $event = Event::model()->find("event_id=:event_id", array(":event_id"=>$origin_id));
                    if(!$event){
                        $data = array('success'=>false,'error_id'=>2,'error_msg'=>'related thing doesnt exist');
                        //$this->renderJSON($data);
                        return $data;
                    }

                    $event = model_to_array($event);
                    $origin_event = $event['origin_type'];
                    $origin__event_id = $event['origin_id'];

                    if($origin != 'user'){
                        $sql = "SELECT " . $origin_event . '_name, color_id FROM `' . $origin_event . '`  WHERE ' . $origin_event . '_id = ' . $origin__event_id;
                        $command = Yii::app()->db->createCommand($sql);
                        $origin_data = $command->queryRow();
                        //echo json_encode($origin_data);
                        $event['origin_name'] = $origin_data[$origin_event . '_name'];
                        $event['origin_color_id'] = $origin_data['color_id'];
                        //array_push($events_data,$event);
                    }else{
                        $event['origin_name'] = null;
                        $event['origin_color_id'] = null;
                    }


                    $event_attending = EventUser::model()->find("user_id=:user_id and event_id=:event_id", array(":user_id"=>$user->user_id, ":event_id"=>$event['event_id']));
                    if($event_attending){
                        $event['is_attending'] = true;
                    }
                    else{
                        $event['is_attending'] = false;
                    }

                    $notification['origin'] = $event;
                }else if($notification['origin_type'] == 'class'){
                    $class = ClassModel::model()->find("event_id=:event_id", array(":event_id"=>$origin_id));
                    if(!$class){
                        $data = array('success'=>false,'error_id'=>2,'error_msg'=>'class doesnt exist');
                        return $data;
                    }

                    $notification['origin'] = model_to_array($class);
                    $notification['origin']['name'] = $class->class_name;
                }else if($notification['origin_type'] == 'club' || $notification['origin_type'] == 'group'){
                    $group = Group::model()->find("group_id=:group_id", array(":group_id"=>$origin_id));
                    if(!$group){
                        $data = array('success'=>false,'error_id'=>2,'error_msg'=>'group doesnt exist');
                        return $data;
                    }

                    $notification['origin'] = model_to_array($group);
                    $notification['origin']['name'] = $group->group_name;
                }
            }
            elseif($notification_type == 'follow'){
                $follow = User::model()->find("user_id=:user_id", array(":user_id"=>$origin_id));

                if(!$follow){
                    $data = array('success'=>false,'error_id'=>2,'error_msg'=>'related thing doesnt exist');
                    //$this->renderJSON($data);
                    return $data;
                }
                $notification['origin'] = get_model_associations($follow,array('department'=>array(),'school'=>array('university'),'groups'=>array(),'classes'=>array()));
            }
            elseif($notification_type == 'invite'){

            }
            elseif($notification_type == 'reply'){
                $reply = Reply::model()->find("reply_id=:reply_id", array(":reply_id"=>$origin_id));
                if(!$reply){
                    $data = array('success'=>false,'error_id'=>2,'error_msg'=>'related thing doesnt exist');
                    //$this->renderJSON($data);
                    return $data;
                }

                $post = Post::model()->find("post_id=:post_id", array(":post_id"=>$reply->post_id));
                $reply_thing=model_to_array($reply);
                $reply_thing['post']=$post;
                $notification['origin']= $reply_thing;
            }
            elseif($notification_type == 'like' || $notification_type == 'post'){
                $post = Post::model()->find("post_id=:post_id", array(":post_id"=>$origin_id));
                if(!$post){
                    $data = array('success'=>false,'error_id'=>2,'error_msg'=>'related thing doesnt exist');
                    //$this->renderJSON($data);
                    return $data;
                }

                $notification['origin'] = model_to_array($post);


                if($post->origin_type == 'class'){
                    $class = ClassModel::model()->find('class_id=:id', array(':id'=>$post->origin_id));
                    $notification['origin']['post_origin'] = model_to_array($class);
                    $notification['origin']['post_origin']['name'] = $class->class_name;
                }else if($post->origin_type == 'group' || $post->origin_type == 'club'){
                    $group = Group::model()->find('group_id=:id', array(':id'=>$post->origin_id));
                    $notification['origin']['post_origin'] = model_to_array($group);
                    $notification['origin']['post_origin']['name'] = $group->group_name;
                }else if($post->origin_type == 'department'){
                    $department = Department::model()->find('department_id=:id', array(':id'=>$post->origin_id));
                    $notification['origin']['post_origin'] = model_to_array($department);
                    $notification['origin']['post_origin']['name'] = $department->department_name;

                }else if($post->origin_type == 'school'){
                    $school = School::model()->find('school_id=:id', array(':id'=>$post->origin_id));
                    $notification['origin']['post_origin'] = model_to_array($school);
                    $notification['origin']['post_origin']['name'] = $school->school_name;
                }else{
                    $notification['origin']['post_origin'] = null;
                }


            }
            else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'database doesnt support this kind of notification');
                //$this->renderJSON($data);
                return $data;
            }
            array_push($notifications_new, $notification);
        }
        return $notifications_new;
    
    }

    function get_model_associations($model, array $attributes) {

        $row = array();

        foreach($model as $key => $value) {
            $row[$key] = $value;
        }

        $row = walk_model($model,$row,$attributes);

        return $row;
    }

    function models_to_array($models){
        $array = array();

        foreach($models as $model){
            array_push($array,model_to_array($model));
        }

        return $array;

    }

    function model_to_array($this_model){
        $row = array();
        foreach($this_model as $key => $value) {
            $row[$key] = $value;
        }
        return $row;
    }

       function walk_model($model, array $row,array $model_names){
        //array(schools => array(pictureFile))

        if(is_assoc($model_names)){
            foreach($model_names as $nested_model_name => $nested_attributes) {
                $name = trim($nested_model_name); //in case of spaces around commas

                $model_values = $model->{$name};

                //Check if the model association data is not null
                if($model_values){
                    if(is_array($model_values)){
                        for($i = 0; $i < count($model_values); ++$i){
                            $this_model = $model_values[$i];
                            $row[$name][$i] = array();
                            foreach($this_model as $key => $value) {
                                $row[$name][$i][$key] = $value;
                            }
                            $row[$name][$i] = walk_model($this_model,$row[$name][$i],$nested_attributes);
                        }
                    }else{
                        foreach($model_values as $key => $value) {
                            $row[$name][$key] = $value;
                        }
                        $row[$name] = walk_model($model_values,$row[$name],$nested_attributes);
                    }
                }else{
                    $relations = $model->relations();
                    $relation_type = $relations[$name][0];
                    if($relation_type == "CManyManyRelation" || $relation_type == "CHasManyRelation"){
                        $row[$name] = array();
                    }else{
                        $row[$name] = null;
                    }

                }
            }
        }else{
            foreach ($model_names as $attribute) {
                $name = trim($attribute); //in case of spaces around commas
                $model_data = $model->{$name};
                //Check if the model association data is not null
                if($model_data){
                    $row[$name] = array();
                    foreach($model_data as $key => $value) {
                        $row[$name][$key] = $value;
                    }
                }else{
                    $relations = $model->relations();
                    $relation_type = $relations[$name][0];
                    if($relation_type == "CManyManyRelation" || $relation_type == "CHasManyRelation"){
                        $row[$name] = array();
                    }else{
                        $row[$name] = null;
                    }
                }
            }
        }
        //var_dump($row);
        return $row;
    }

        function is_assoc($array) {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

function renderJSON($data)
    {
        header('Content-type: application/json');
        return CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }


?>