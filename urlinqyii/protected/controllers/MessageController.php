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
            $frame = Yii::app()->nodeSocket->getFrameFactory()->createAuthenticationFrame();
            $frame->setUserId($user->user_id);
            $frame->send();



            if($message->save(false)){

//                $event = Yii::app()->nodeSocket->getFrameFactory()->createUserEventFrame();
//                $event->setUserId($user->user_id);
//                $event->setEventName('message');
//                $event->setData = array('msg'=>'asdasd');
//                $event->send();

                $event = Yii::app()->nodeSocket->getFrameFactory()->createEventFrame();
                $event->setEventName('message');
                $event->setData(array('msg'=>$message->text));
                $event->send();


                $return_data = array('success'=>true, 'message'=>$message, 'last_update'=>date('Y-m-d H:i:s'));
                $this->renderJSON($return_data);
                return;
            }else{
                $return_data = array('success'=>false, 'error_id'=>4, 'error_msg'=>'error saving message', 'post'=>$_POST);
                $this->renderJSON($return_data);
                return;
            }

        }else if($target_type == 'group'){

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