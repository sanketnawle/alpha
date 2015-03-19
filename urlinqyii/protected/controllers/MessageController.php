<?php
Yii::import('ext.runactions.components.ERunActions');
ERunActions::runBackground(true);


class MessageController extends Controller
{
	public function actionPollGroup()
	{
		$this->render('pollGroup');
	}

	public function actionPollUser()
	{
		$this->render('pollUser');
	}




    //GET
    //Loads recent messages
    public function actionLoad()
	{
		$user = $this->get_current_user($_GET);
        if(!$user){
            $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }


        $messages = Message::model()->findAllBySql('SELECT * FROM `message` WHERE user_id = ' . $user->user_id . ' OR target_type = "user" AND target_id = ' . $user->user_id . ' ORDER BY id');


        $return_data = array('success'=>true, 'messages'=>$messages, 'last_update'=>date('Y-m-d H:i:s'));
        $this->renderJSON($return_data);
        return;

	}



    //GET
    //gets the usres/classes/clubs this user sees in message panel
    public function actionLoadout()
	{
		$user = $this->get_current_user($_GET);
        if(!$user){
            $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }


        //Get recent incoming messages sent to this user
        $recent_messages = Message::model()->findAllBySql("SELECT *
                                                        FROM message
                                                        WHERE (target_type = 'custom' AND EXISTS (SELECT * FROM message_group_user WHERE user_id = " . $user->user_id . " AND message_group_id = message.target_id))
                                                        OR (target_type = 'user' AND target_id = " . $user->user_id . ")
                                                        GROUP BY
                                                            user_id, target_type, target_id
                                                        ORDER BY
                                                                id DESC
                                                        LIMIT 5");

        //OR (user_id = " . $user->user_id . ") for outgoing msgs

        include_once 'user/user.php';

        $recents = array();


        //Load related item to message
        for($x = 0; $x < count($recent_messages); $x++){
            $message = $recent_messages[$x];
            if($message->target_type == 'custom'){
                //Get the msg group
                $message_group = MessageGroup::model()->find('id=:id', array(':id'=>$message->target_id));
                if(!$message_group){
                    $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'msg group doesnt exist');
                    $this->renderJSON($return_data);
                    return;
                }

                $message_group = $this->model_to_array($message_group);
                $message_group['type'] = 'custom';


                array_push($recents, $message_group);

            }else if($message->target_type == 'user'){
                $other_user_id = $message->target_id;

                if($other_user_id == $user->user_id){
                    $other_user_id = $message->user_id;
                }

                $other_user = User::model()->find('user_id=:id', array(':id'=>$other_user_id));



                if(!$other_user){
                    $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'user doesnt exist');
                    $this->renderJSON($return_data);
                    return;
                }


                $is_online = is_online($other_user);

                $other_user = $this->get_model_associations($other_user,array('pictureFile'));


                $other_user['type'] = 'user';
                $other_user['id'] = $other_user['user_id'];
                $other_user['name'] = $other_user['firstname'] . ' ' . $other_user['lastname'];
                $other_user['is_online'] = $is_online;


                array_push($recents, $other_user);
            }else if($message->target_type == 'class'){
                $class = ClassModel::model()->find('class_id=:id', array(':id'=>$message->target_id));
                if(!$class){
                    $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'class doesnt exist');
                    $this->renderJSON($return_data);
                    return;
                }

                $class = $this->get_model_associations($class,array('pictureFile', 'coverFile'));
                $class['type'] = 'class';
                $class['id'] = $class['class_id'];
                $class['name'] = $class['class_name'];


                array_push($recents, $class);
            }else if($message->target_type == 'group'){
                $group = Group::model()->find('group_id=:id', array(':id'=>$message->target_id));
                if(!$group){
                    $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'group doesnt exist');
                    $this->renderJSON($return_data);
                    return;
                }

                $class = $this->get_model_associations($group,array('pictureFile', 'coverFile'));
                $group['type'] = 'group';
                $group['id'] = $group['group_id'];
                $group['name'] = $group['group_name'];


                array_push($recents, $group);
            }
        }


        //Get the users that this user has followed
        $users = $user->usersFollowed;

        for($i = 0; $i < count($users); $i++){
            $users[$i] = $this->get_model_associations($users[$i],array('pictureFile'));
            $users[$i]['name'] = $users[$i]['firstname'] . ' ' . $users[$i]['lastname'];
            $users[$i]['type'] = 'user';
            $users[$i]['id'] = $users[$i]['user_id'];
        }


        //Get this users classes
        $classes = $user->classes;

        for($i = 0; $i < count($classes); $i++){
            $classes[$i] = $this->get_model_associations($classes[$i],array('pictureFile', 'coverFile'));
            $classes[$i]['name'] = $classes[$i]['class_name'];
            $classes[$i]['type'] = 'class';
            $classes[$i]['id'] = $classes[$i]['class_id'];
        }


        $groups = $user->groups;


        for($i = 0; $i < count($groups); $i++){
            $groups[$i] = $this->get_model_associations($groups[$i],array('pictureFile', 'coverFile'));
            $groups[$i]['name'] = $groups[$i]['group_name'];
            $groups[$i]['type'] = 'class';
            $groups[$i]['id'] = $groups[$i]['class_id'];
        }


        array_merge($groups, $user->clubs);



        $return_data = array('success'=>true, 'recent'=>$recents, 'users'=>$users, 'classes'=>$classes, 'groups'=>$groups);
        $this->renderJSON($return_data);
        return;
	}



     //GET
    //Loads recent messages with a specfic user/group
    public function actionRecentChat() {

        if(!isset($_GET['target_type']) || !isset($_GET['target_id'])){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'data not set');
            $this->renderJSON($return_data);
            return;
        }

        $target_id = $_GET['target_id'];
        $target_type = $_GET['target_type'];


		$user = $this->get_current_user($_GET);
        if(!$user){
            $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }


        $messages = array();
        if($target_type == 'user'){
            $messages = Message::model()->findAllBySql('SELECT * FROM `message` WHERE (user_id = ' . $user->user_id . ' AND target_type = "user" AND target_id = ' . $target_id . ') OR (user_id = ' . $target_id . ' AND target_type = "user" AND target_id = ' . $user->user_id . ') ORDER BY id LIMIT 50');
        }elseif($target_type == 'custom'){

            $message_group = MessageGroup::model()->find('id=:id', array(':id'=>$target_id));
            if(!$message_group){
                $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'message group doesnt exist');
                $this->renderJSON($return_data);
                return;
            }

            //Make sure this user is a member of this group
            $message_group_user = MessageGroupUser::model()->find('user_id=:user_id and message_group_id=:message_group_id', array(':user_id'=>$user->user_id, ':message_group_id'=>$message_group->id));
            if(!$message_group_user){
                $return_data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'user is not a member of this group');
                $this->renderJSON($return_data);
                return;
            }


           // $messages = Message::model()->findAllBySql("SELECT * FROM `message` WHERE (target_type = 'group' AND target_id = '1') ORDER BY id LIMIT 50");

            $messages = Message::model()->findAllBySql('SELECT * FROM `message` WHERE (target_type = "' . $target_type . '" AND target_id = ' . $target_id . ') ORDER BY id LIMIT 50');
        }


        $return_data = array('success'=>true, 'messages'=>$messages, 'last_update'=>date('Y-m-d H:i:s'), 'target_type'=>$target_type);
        $this->renderJSON($return_data);
        return;

	}




    public function actionPoll()
    {


        if (ERunActions::runBackground()){

            //sleep(5);
            if(!isset($_GET['last_update'])){
                $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'last update not set');
                $this->renderJSON($return_data);
                return;
            }

            $user = $this->get_current_user($_GET);
            if(!$user){
                $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user is not logged in');
                $this->renderJSON($return_data);
                return;
            }

            $last_update = $_GET['last_update'];




            $limit = min(30, ini_get('max_execution_time'))/2;
            $start = time();

            try{

                for($i = 0; ($i == 0) || (time() - $start < $limit); $i++)
                {

                    sleep(1);

                    $messages = Message::model()->findAllBySql('SELECT * FROM `message` WHERE target_type = "user" AND target_id = ' . $user->user_id . ' AND sent_at > "' . $last_update . '" ORDER BY id');

                    if(count($messages) > 0 || (time() - $start >= $limit))
                    {
                        $return_data = array('success'=>true, 'messages'=>$messages, 'last_update'=>date('Y-m-d H:i:s'), 'max_execution_time'=>ini_get('max_execution_time'));
                        $this->renderJSON($return_data);
                        return;
                    }

                    //usleep(10000000);
                }
            }catch(Exception $e){
                $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'ERROR', 'ERRoR'=>$e->getMessage());
                $this->renderJSON($return_data);
                return;
            }




        }else{
            $return_data = array('success'=>'error running task in background');
            $this->renderJSON($return_data);
            return;
        }



    }

    //GET
    //last_update - optional date time stamp
    public function actionLoll()
	{
        $limit = min(30, ini_get('max_execution_time'))/2;
        $start = time();


        try{
            if(!isset($_GET['last_update'])){
                $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'last update not set');
                $this->renderJSON($return_data);
                return;
            }

            $user = $this->get_current_user($_GET);
            if(!$user){
                $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user is not logged in');
                $this->renderJSON($return_data);
                return;
            }




            $last_update = $_GET['last_update'];






            $messages = array();
            while(true){
                $messages = Message::model()->findAllBySql('SELECT * FROM `message` WHERE target_type = "user" AND target_id = ' . $user->user_id . ' AND sent_at > "' . $last_update . '" ORDER BY id');
                if($messages){
                    break;
                }else{
                    usleep($this->sleep * 1000);
                    #usleep(10000);
                }

            }



            $return_data = array('success'=>true, 'messages'=>$messages, 'last_update'=>date('Y-m-d H:i:s'));
            $this->renderJSON($return_data);
            return;
        }catch(Exception $e){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'ERROR', 'ERRoR'=>$e->getMessage());
            $this->renderJSON($return_data);
            return;
        }


	}

    public function actionSendToAll() {
        //Yii::app()->nodeSocket->registerClientScripts();
        $event = Yii::app()->nodeSocket->getFrameFactory()->createEventFrame();
        $event->setEventName('message');
        $event->setData(array('green', 'black'));
        $event->send();
    }

    public function actionSendToRoom() {
            //Yii::app()->nodeSocket->registerClientScripts();
            $event = Yii::app()->nodeSocket->getFrameFactory()->createEventFrame();
            $event->setEventName('test.event');
            $event->setRoom('testRoom');
            $event->setData(array('green', 'black'));
            $event->send();
    }




    public function actionSendMessage() {
		$event = Yii::app()->nodeSocket->createEventFrame();
		$event->setEventName('message');
		$event['data'] = array(
			1,
			array(
				'red',
				'black',
				'white'
			),
			new stdClass(),
			'simple string'
		);
		$event->send();


		$this->render('sendEvent');
	}
	public function actionSendRoomEvent() {
		$event = Yii::app()->nodeSocket->createEventFrame();
		$event->setRoom('example');
		$event->setEventName('example.room.event');
		$event['type_string'] = 'hello world';
		$event['type_array'] = array(1, 2, 3);
		$event['type_object'] = array('one' => 1, 'two' => 2);
		$event['type_bool'] = true;
		$event['type_integer'] = 11;
		$event->send();
		$this->render('sendRoomEvent');
	}
	public function actionEventListener() {
		Yii::app()->nodeSocket->registerClientScripts();
		$this->render('eventListener');
	}



    //Emits message to nodejs/socketio in the background
    public function actionSendFunction() {

        if(!isset($_POST['message_id'])){
            $data = array('success'=>false,'error_id'=>1);
            $this->renderJSON($data);
            return;
        }

        $message_id = $_POST['message_id'];

        //$user = $this->get_current_user($_POST);

        $message = Message::model()->find('id=:id', array(':id'=>$message_id));

        if(!$message){
            $data = array('success'=>false,'error_id'=>2, 'error_msg'=>'Msg doesnt exist');
            $this->renderJSON($data);
            return;
        }

//        //Make sure this user is the sender of this msg
//        if($message->user_id != $user->user_id){
//            $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'User cannot send this msg');
//            $this->renderJSON($data);
//            return;
//        }

        $origin = null;

        if($message->target_type == 'user'){
            $user = User::model()->find('user_id=:id', array(':id'=>$message->target_id));
            if(!$user){
                $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'user doesnt exist');
                $this->renderJSON($data);
                return;
            }

            $origin = $this->model_to_array($user);
            $origin['name']  = $user['firstname'] . ' ' . $user['lastname'];
            $origin['type'] = 'user';
            $origin['id'] = $user['user_id'];
        }elseif($message->target_type == 'group' || $message->target_type == 'club'){

            $group = Group::model()->find('group_id=:id', array(':id'=>$message->target_id));
            if(!$group){
                $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'group doesnt exist');
                $this->renderJSON($data);
                return;
            }

            $origin = $this->model_to_array($group);
            $origin['name']  = $group['group_name'];
            $origin['type'] = 'group';
            $origin['id'] = $group['group_id'];


        }elseif($message->target_type == 'class'){
            $class = ClassModel::model()->find('class_id=:id', array(':id'=>$message->target_id));
            if(!$class){
                $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'Class doesnt exist');
                $this->renderJSON($data);
                return;
            }

            $origin = $this->model_to_array($class);
            $origin['name']  = $class['class_name'];
            $origin['type'] = 'class';
            $origin['id'] = $class['class_id'];

        }elseif($message->target_type == 'custom'){
            $message_group = MessageGroup::model()->find('id=:id', array(':id'=>$message->target_id));
            if(!$message_group){
                $data = array('success'=>false,'error_id'=>3, 'error_msg'=>'Msg group doesnt exist');
                $this->renderJSON($data);
                return;
            }

            $origin = $this->model_to_array($message_group);
        }



        if (ERunActions::runBackground()) {

            $event = Yii::app()->nodeSocket->getFrameFactory()->createEventFrame();
            $event->setEventName($message->target_type . '_' . $message->target_id);
            //$event->setEventName($message->target_type . '_' . $message->target_id);

            $event->setData(array('origin'=>$origin,'user_id'=>$message->user_id,'target_type'=>$message->target_type,'target_id'=>$message->target_id,'text'=>$message->text));
            $event->send();

            $data = array('success'=>true,'error_id'=>'run');
            $this->renderJSON($data);
            return;
        }
        else {
            $data = array('success'=>false,'error_id'=>'error running in background');
            $this->renderJSON($data);
            return;
        }
    }




	public function actionSend() {
        if(!isset($_POST['text']) || !isset($_POST['target_id']) || !isset($_POST['target_type'])){
            $return_data = array('success'=>false, 'error_id'=>1, 'error_msg'=>'data is not set', 'post'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }

        $user = $this->get_current_user($_POST);
        if(!$user){
            $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'user is not logged in');
            $this->renderJSON($return_data);
            return;
        }

        //Who message is directed to
        //either user or a group of users
        //in a message_group
        $target_type = $_POST['target_type'];
        $target_id = $_POST['target_id'];
        $text = $_POST['text'];


        if(!$text || $text == ''){
            $return_data = array('success'=>false, 'error_id'=>2, 'error_msg'=>'text must not be empty');
            $this->renderJSON($return_data);
            return;
        }

        if($target_type == 'user'){
            //Verify target user exists
            $to_user = User::model()->find('user_id=:id', array(':id'=>$target_id));
            if(!$to_user){
                $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'target does not exist', 'post'=>$_POST);
                $this->renderJSON($return_data);
                return;
            }


            $message = new Message;
            $message->user_id = $user->user_id;
            $message->text = $text;
            $message->target_id = $target_id;
            $message->target_type = $target_type;

//            if($target_type == 'user'){
//                $to_user->subscribe($user);
//                $user->subscribe($to_user);
//
//            }
            Yii::app()->nodeSocket->registerClientScripts();
//            $frame = Yii::app()->nodeSocket->getFrameFactory()->createAuthenticationFrame();
//            $frame->setUserId($user->user_id);
//            $frame->send();



            if($message->save(false)){

//                $event = Yii::app()->nodeSocket->getFrameFactory()->createUserEventFrame();
//                $event->setUserId($user->user_id);
//                $event->setEventName('message');
//                $event->setData = array('msg'=>'asdasd');
//                $event->send();

                //Emit the message event to nodejs/socket.io asynchronously
                ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/message/sendFunction',$postData=array('message_id'=>$message->id),$contentType=null);


                $return_data = array('success'=>true, 'message'=>$message, 'last_update'=>date('Y-m-d H:i:s'));
                $this->renderJSON($return_data);
                return;
            }else{
                $return_data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'error saving message', 'post'=>$_POST);
                $this->renderJSON($return_data);
                return;
            }

        }else if($target_type == 'custom'){


            //Verify target message group exists
            $message_group = MessageGroup::model()->find('id=:id', array(':id'=>$target_id));
            if(!$message_group){
                $return_data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'msg group target does not exist', 'post'=>$_POST);
                $this->renderJSON($return_data);
                return;
            }


            //Make sure this user is apart of group
            $group_user = MessageGroupUser::model()->find('message_group_id=:id and user_id=:user_id', array(':id'=>$message_group->id, ':user_id'=>$user->user_id));

            if(!$group_user){
                $return_data = array('success'=>false, 'error_id'=>5, 'error_msg'=>'user not allowed to send msg to this group', 'post'=>$_POST);
                $this->renderJSON($return_data);
                return;
            }



            $message = new Message;
            $message->user_id = $user->user_id;
            $message->text = $text;
            $message->target_id = $target_id;
            $message->target_type = $target_type;

            if($message->save(false)){

                //Emit the message event to nodejs/socket.io asynchronously
                ERunActions::touchUrl(Yii::app()->getBaseUrl(true) . '/message/sendFunction',$postData=array('message_id'=>$message->id),$contentType=null);


                $return_data = array('success'=>true, 'message'=>$message, 'last_update'=>date('Y-m-d H:i:s'));
                $this->renderJSON($return_data);
                return;
            }else{
                $return_data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'error saving message', 'post'=>$_POST);
                $this->renderJSON($return_data);
                return;
            }


        }else{
            $return_data = array('success'=>false, 'error_id'=>3, 'error_msg'=>'target type not supported', 'post'=>$_POST);
            $this->renderJSON($return_data);
            return;
        }





	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}