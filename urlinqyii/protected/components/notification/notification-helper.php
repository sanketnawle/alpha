<?php


 function get_notifications_data($user, $notifications){


        $notifications_new = array();
        foreach ($notifications as $i=>$notification_model) {
            $notification = model_to_array($notification_model);
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



            $notification['actor'] = get_model_associations($actor,array('department'=>array(),'school'=>array('university'),'groups'=>array(),'classes'=>array()));


            $notification['actor']['pictureFile'] = $actor->pictureFile;

            if($notification_type == 'invite'){

                $invite = Invite::model()->find('user_id=:user_id and origin_id=:origin_id and origin_type=:origin_type', array(':user_id'=>$user->user_id, ':origin_id'=>$notification['origin_id'], ':origin_type'=>$origin));

                if(!$invite){
                    $notification_model->delete();
                    $data = array('success'=>false,'error_id'=>3,'error_msg'=>'invalid invite');
                    renderJSON($data);
                    return;
                }

                $notification['invite_id'] = $invite->invite_id;
                $notification['invite_choice'] = $invite->choice;


                if($notification['origin_type'] == 'event'){
                    $event = Event::model()->find("event_id=:event_id", array(":event_id"=>$origin_id));
                    if(!$event){
                        $notification_model->delete();
                        unset($notifications[$i]);
                        continue;
                    }

                    $event = model_to_array($event);
                    $origin_event = $event['origin_type'];
                    $origin__event_id = $event['origin_id'];

                    if($origin != 'user'){
                        try{
                            $sql = "SELECT " . $origin_event . '_name, color_id FROM `' . $origin_event . '`  WHERE ' . $origin_event . '_id = ' . $origin__event_id;
                            $command = Yii::app()->db->createCommand($sql);
                            $origin_data = $command->queryRow();
                            //echo json_encode($origin_data);
                            $event['origin_name'] = $origin_data[$origin_event . '_name'];
                            $event['origin_color_id'] = $origin_data['color_id'];
                            //array_push($events_data,$event);
                        }catch(Exception $e){
                            $event['origin_name'] = null;
                            $event['origin_color_id'] = null;
                        }
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
                    $notification_model->delete();
                    $class = ClassModel::model()->find("event_id=:event_id", array(":event_id"=>$origin_id));
                    if(!$class){
                        $notification_model->delete();
                        $data = array('success'=>false,'error_id'=>2,'error_msg'=>'class doesnt exist');
                        renderJSON($data);
                        return;
                    }

                    $notification['origin'] = model_to_array($class);
                    $notification['origin']['name'] = $class->class_name;

                    $class_user = ClassUser::model()->find('user_id=:user_id and class_id=:class_id', array(':user_id'=>$user->user_id, ':class_id'=>$notification['origin_id']));
                    if($class_user){
                        $notification['accepted'] = true;
                    }
                }else if($notification['origin_type'] == 'club' || $notification['origin_type'] == 'group'){
                    $group = Group::model()->find("group_id=:group_id", array(":group_id"=>$origin_id));
                    if(!$group){
                        $notification_model->delete();
                        unset($notifications[$i]);
                        continue;
                    }

                    $notification['origin'] = model_to_array($group);
                    $notification['origin']['name'] = $group->group_name;

                    $notification['accepted'] = false;

                    $group_user = GroupUser::model()->find('user_id=:user_id and group_id=:group_id', array(':user_id'=>$user->user_id, ':group_id'=>$notification['origin_id']));
                    if($group_user){
                        $notification['accepted'] = true;
                    }
                }
            }
            elseif($notification_type == 'follow'){
                $follow = User::model()->find("user_id=:user_id", array(":user_id"=>$origin_id));

                if(!$follow){
                    $notification_model->delete();
                    unset($notifications[$i]);
                    continue;
                }
                $notification['origin'] = get_model_associations($follow,array('department'=>array(),'school'=>array('university'),'groups'=>array(),'classes'=>array()));

                $following_back = false;

                $user_connection = UserConnection::model()->find('from_user_id=:from_user_id and to_user_id=:to_user_id', array(':from_user_id'=>$user->user_id, ':to_user_id'=>$follow->user_id));

                if($user_connection){
                    $following_back = true;
                }



                $notification['following_back'] = $following_back;
            }
            elseif($notification_type == 'reply'){
                $reply = Reply::model()->find("reply_id=:reply_id", array(":reply_id"=>$origin_id));
                if(!$reply){
                    $notification_model->delete();
                    unset($notifications[$i]);
                    continue;
                }

                $post = Post::model()->find("post_id=:post_id", array(":post_id"=>$reply->post_id));
                $reply = model_to_array($reply);
                $notification['origin'] = model_to_array($post);
                $notification['reply']= $reply;


                if($reply['anon'] == 1){
                    $notification['actor'] = null;
                }


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
            elseif($notification_type == 'like' || $notification_type == 'post'){
                $post = Post::model()->find("post_id=:post_id", array(":post_id"=>$origin_id));
                if(!$post){
                    $notification_model->delete();
                    unset($notifications[$i]);
                    continue;
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


                if($post->post_type == 'event'){
                    $post_event = PostEvent::model()->find('post_id=:post_id', array(':post_id'=>$post->post_id));
                    if($post_event){
                        $event = $post_event->event;
                        if($event){
                            $notification['event'] = model_to_array($event);

                            $notification['event']['attending'] = false;

                            //Check if this user is attending this event
                            if($notification['event']['user_id'] == $user->user_id){
                                $notification['event']['attending'] = true;
                            }else{
                                $event_user = EventUser::model()->find('event_id=:event_id and user_id=:user_id', array(':event_id'=>$notification['event']['event_id'], ':user_id'=>$user->user_id));
                                if($event_user){
                                    $notification['event']['attending'] = true;
                                }
                            }

                        }else{
                            unset($notifications[$i]);
                            continue;
                        }
                    }else{
                        unset($notifications[$i]);
                        continue;
                    }
                }


            }
            elseif($notification_type == 'event'){
                $event = Event::model()->find('event_id=:event_id',array(':event_id'=>$notification['origin_id']));

                if(!$event){
                    $notification_model->delete();

                    unset($notifications[$i]);
                    continue;

//                    $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event associated with notification doesnt exist. Notification was deleted', 'notification'=>$notification);
//                    $this->renderJSON($data);
//                    return;
                }

                $notification['origin'] = model_to_array($event);

                if($event->origin_type == 'class'){
                    $class = ClassModel::model()->find('class_id=:id', array(':id'=>$event->origin_id));
                    $notification['origin']['event_origin'] = model_to_array($class);
                    $notification['origin']['event_origin']['name'] = $class->class_name;
                }else if($event->origin_type == 'group' || $event->origin_type == 'club'){
                    $group = Group::model()->find('group_id=:id', array(':id'=>$event->origin_id));
                    $notification['origin']['event_origin'] = model_to_array($group);
                    $notification['origin']['event_origin']['name'] = $group->group_name;
                }else if($event->origin_type == 'department'){
                    $department = Department::model()->find('department_id=:id', array(':id'=>$event->origin_id));
                    $notification['origin']['event_origin'] = model_to_array($department);
                    $notification['origin']['event_origin']['name'] = $department->department_name;
                }else if($event->origin_type == 'school'){
                    $school = School::model()->find('school_id=:id', array(':id'=>$event->origin_id));
                    $notification['origin']['event_origin'] = model_to_array($school);
                    $notification['origin']['event_origin']['name'] = $school->school_name;
                }else{
                    $notification['origin']['event_origin'] = null;
                }
            }
            else{
                //This notification isnt supported, so just skip this
                unset($notifications[$i]);
                continue;

//                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'database doesnt support this kind of notification', 'notification'=>$notification);
//                //$this->renderJSON($data);
//                return $data;
            }
            array_push($notifications_new, $notification);
        }
//        $data = array('success'=>true,'notifications'=>$notifications_new);
//
//        if ($should_end_yii == 'false') {
//            return $data;
//        }
//       	renderJSON($data);
//        return;

     return array('success'=>true, 'notifications'=>$notifications_new);
    }



    function renderJSON($data)
    {
        header('Content-type: application/json');

        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }

       Yii::app()->end();
        
    }

    function is_assoc($array) {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

    function get_model_associations($model, array $attributes) {

        $row = array();

        foreach($model as $key => $value) {
            $row[$key] = $value;
        }

        $row = walk_model($model,$row,$attributes);

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


    function models_to_array($models){
        $array = array();

        foreach($models as $model){
            array_push($array, model_to_array($model));
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

?>