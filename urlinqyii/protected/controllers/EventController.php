<?php

class EventController extends Controller
{
    function stt($obj) {
        return strtotime($obj);
    }

    public function actionGetEvents(){
        if(!isset($_GET['date'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'date is not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user();
//        $date = '2014-11-12';
        $date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        //$events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>7));
        //$events = $user->get_all_events();
//        $events = Event::model()->findAllBySql('SELECT *
//                                                FROM `event`
//                                                LEFT OUTER JOIN `event_user`
//                                                ON event.event_id = event_user.event_id
//                                                WHERE event_user.user_id = 7 OR event.user_id = 7');

        //Get the events that this user is an event_user of
        $events_attending = Yii::app()->db->createCommand('SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = 7 AND start_date = "' . $date . '"')->queryAll();
        //Get the events that this
        $events = Yii::app()->db->createCommand('SELECT * FROM `event` WHERE event.user_id = 7 AND start_date = "' . $date . '"')->queryAll();

        $data = array('success'=>true,'events'=>array_merge($events,$events_attending));

        $this->renderJSON($data);
        return;


    }



    public function actionGetMonthEvents(){
        $user = $this->get_current_user();
//        $date = '2014-11-12';
        $date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        //$events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>7));
        //$events = $user->get_all_events();
//        $events = Event::model()->findAllBySql('SELECT *
//                                                FROM `event`
//                                                LEFT OUTER JOIN `event_user`
//                                                ON event.event_id = event_user.event_id
//                                                WHERE event_user.user_id = 7 OR event.user_id = 7');

        //Get the events that this user is an event_user of
        $events_attending = Yii::app()->db->createCommand('SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = 7 AND MONTH(`end_date`) = MONTH("' . $date . '")')->queryAll();
        //Get the events that this
        $events = Yii::app()->db->createCommand('SELECT * FROM `event` WHERE event.user_id = 7 AND MONTH(`end_date`) = MONTH("' . $date . '")')->queryAll();

        $data = array('success'=>true,'events'=>array_merge($events,$events_attending));

        $this->renderJSON($data);
        return;

    }




    public function actionGetWeekEvents(){
        $user = $this->get_current_user();
//        $date = '2014-11-12';
        $date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        //$events = Event::model()->findAll('start_date<=:date and end_date>=:date and user_id=:user_id',array(':date'=>$date,':user_id'=>7));
        //$events = $user->get_all_events();
//        $events = Event::model()->findAllBySql('SELECT *
//                                                FROM `event`
//                                                LEFT OUTER JOIN `event_user`
//                                                ON event.event_id = event_user.event_id
//                                                WHERE event_user.user_id = 7 OR event.user_id = 7');

        //Get the events that this user is an event_user of
        $events_attending = Yii::app()->db->createCommand('SELECT * FROM `event` JOIN `event_user` ON (event.event_id = event_user.event_id) WHERE event_user.user_id = ' . $user->user_id . ' AND WEEK(`end_date`) = WEEK("' . $date . '")')->queryAll();
        //Get the events that this
        $events = Yii::app()->db->createCommand('SELECT * FROM `event` WHERE event.user_id = ' . $user->user_id . ' AND WEEK(`end_date`) = WEEK("' . $date . '")')->queryAll();

        $data = array('success'=>true,'events'=>array_merge($events,$events_attending));

        $this->renderJSON($data);
        return;

    }


    public function actionAttendees(){
        //$user = $this->get_current_user();
        $event_id = $_GET['id'];
        //$date = $_GET['date'];
        //user_id=:user_id AND  //':user_id'=>1,
        $event = Event::model()->find('event_id=:event_id',array('event_id'=>$event_id));

        //$attendees = $event->attendees;


        //$data = array('success'=>true,'attendees'=>$attendees);

        $data = array('success'=>true,'attendees'=>$event->attendees);

        $this->renderJSON($data);
        return;

    }



    public function actionGetPlannerEvents(){
        //$user_id = $_GET['user_id'];
        $user = $this->get_current_user();
//        $user = User::model()->findBySql('SELECT * FROM `user` WHERE user_id=.'$user_id');

//        $events = Event::model()->findAll('user_id=:user_id',array(':user_id'=>$user->user_id));


//        $sql_str = '';
//        if (strpos($filter, 'Week') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND yearweek(`start_date`) = yearweek(curdate())";
//        }elseif(strpos($filter, 'Month') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND MONTH(`start_date`) = MONTH(curdate())";
//        }elseif(strpos($filter, 'Semester') !== FALSE){
//            $sql_str = "SELECT * FROM group_event WHERE group_id = '$group_id' AND YEAR(`start_date`) = YEAR(curdate())";
//        }



        //get current datetime
//        $date = date("Y-m-d H:i:s", time());
//        $datetime = new DateTime($date);
//        $datetime->modify('-1 day');
//        $date = $datetime->format('Y-m-d H:i:s');
//        $date_key = $datetime->format('Y-m-d');

//        $event_count = 0;
//
//        //Get events that were due yesterday
//        $date = date("Y-m-d H:i:s", time());
//        $datetime = new DateTime($date);
//        $datetime->modify('-1 day');
//        $yesterdays_date = $datetime->format('Y-m-d');
//
//
//        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $yesterdays_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
//        $past_due_events = Event::model()->findAllBySql($sql);
//        $event_count += count($past_due_events);
//
//        //Get events that are due today
//
//        $datetime = new DateTime($date);
//        $todays_date = $datetime->format('Y-m-d');
//
//        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $todays_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
//        $todays_events = Event::model()->findAllBySql($sql);
//        $event_count += count($todays_events);
//
//
//        //Get events that are due tomorrow
//
//        $datetime = new DateTime($date);
//        $datetime->modify('+1 day');
//        $tomorrows_date = $datetime->format('Y-m-d');
//
//        $sql = "SELECT * FROM event WHERE user_id = '" . $user->user_id ."' AND end_date = '" . $tomorrows_date . "'"; // AND YEAR(`start_date`) = YEAR(curdate())
//        $tomorrows_events = Event::model()->findAllBySql($sql);
//        $event_count += count($tomorrows_events);
//
//        $club = Group::model()->find('group_id=:group_id',array(':group_id'=>1));
//        $data = array('success'=>true,'past_due_events'=>$past_due_events,'todays_events'=>$todays_events,'tomorrows_events'=>$tomorrows_events,'event_count'=>$event_count);
//        //$data = array('success'=>true,'event'=>$this->get_model_associations($club,array('pictureFile')));
//
//
//        //Show 7 days after tomorrow
//
//        $this->renderJSON($data);
//        return;














        $event_count = 0;

        //Get events that were due yesterday
        $date = date("Y-m-d H:i:s", time());
        $datetime = new DateTime($date);
        $datetime->modify('-1 day');
        $start_date= $datetime->format('Y-m-d');
        $datetime->modify('+4 day');
        $end_date= $datetime->format('Y-m-d');

        $events = Event::model()->findAll('end_date>=:start_date and end_date<=:end_date and user_id=:user_id and complete=:complete',array(':start_date'=>$start_date,':end_date'=>$end_date,':user_id'=>$user->user_id, ':complete'=>0));


        $data = array('success'=>true,'events'=>$events);

        $this->renderJSON($data);
        return;











        //Or get all events from yesterday till tomorrow and have front end sort it



    }


    public function actionDelete(){
        if(!$this->authenticated()){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'Not authenticated');
            $this->renderJSON($data);
            return;
        }

        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        $user = $this->get_current_user();

        $event_id = $_POST['event_id'];
        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));

        if(!$event){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }
        //Check if the current user is either the creator
        //Of this event or he is attending it and associated through group_user table
        if($user->user_id == $event->user_id){
            if($event->delete()){
                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>6,'error_msg'=>'Error destroying event');
                $this->renderJSON($data);
                return;
            }
        }elseif($event_user = $event->user_is_attending($user->user_id)){
            if($event_user->delete()){
                $data = array('success'=>true);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>6,'error_msg'=>'Error destroying event_user association');
                $this->renderJSON($data);
                return;
            }

        }else{
            $data = array('success'=>false,'error_id'=>5,'error_msg'=>'User not authorized to touch this event.');
            $this->renderJSON($data);
            return;
        }




    }



    public function actionGetSuggestedEvents(){
        $events = Event::model()->findAll(array('limit'=>15) );

        $data = array('success'=>true,'events'=>$events);
        $this->renderJSON($data);
        return;
    }

    //Error ids
    // 1 - All data not set
    // 2 - error creating todo
	public function actionCreateTodo()
	{

        if(!isset($_POST['todo_name']) || !isset($_POST['todo_date']) || !isset($_POST['todo_time']) || !isset($_POST['origin']) || !isset($_POST['origin_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }



        try {



            $user = $this->get_current_user();

            $todo_name = $_POST['todo_name'];
            $todo_date = $_POST['todo_date'];
            $todo_time = $_POST['todo_time'];
            $todo_origin = $_POST['origin'];
            $todo_origin_id = $_POST['origin_id'];

            $event = new Event;
            $event->title = $todo_name;
            $event->event_type = 'todo';
            $event->user_id = $user->user_id;

            $event->origin_type = $todo_origin;
            $event->origin_id = $todo_origin_id;
            $event->end_date = $todo_date;
            $event->end_time = $todo_time;
            $event->all_day = false;
            $event->save(false);

            if($event){
                $data = array('success'=>true,'event'=>$event);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating todo');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }
	}



    //Error ids
    // 1 - All data not set
    // 2 - error creating todo
    public function actionCreate()
    {
//        $data = array('success'=>true);
//        $this->renderJSON($_POST);
//        return;

//                event_name: event_name,
//                origin_type: event_origin_type,
//                origin_id: event_origin_id,
//                event_type: event_category,
//                title: event_name,
//                description: event_description,
//                start_time: event_start_time,
//                end_time: event_end_time,
//                start_date: event_start_date,
//                end_date: event_end_date,
//                location: event_location,
//                event_todo: event_todo,
//                ll_day: event_all_day

        if(!isset($_POST['event']['event_type']) || !isset($_POST['event']['event_name']) || !isset($_POST['event']['event_todo']) || !isset($_POST['event']['origin_type']) || !isset($_POST['event']['origin_id']) || !isset($_POST['event']['title']) || !isset($_POST['event']['description'])
        || !isset($_POST['event']['start_time']) || !isset($_POST['event']['end_time']) || !isset($_POST['event']['start_date']) || !isset($_POST['event']['end_date']) || !isset($_POST['event']['location']) || !isset($_POST['event']['all_day'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        $event_data = $_POST['event'];


        try {


            $event = new Event;
            $event->title = $event_data['event_name'];
            $event->description = $event_data['description'];
            $event->event_type = $event_data['event_type'];
            $event->user_id = $this->get_current_user_id();
            $event->origin_type = $event_data['origin_type'];
            $event->origin_id = $event_data['origin_id'];
            $event->start_date = $event_data['start_date'];
            $event->end_date = $event_data['end_date'];
            $event->start_time = $event_data['start_time'];
            $event->end_time = $event_data['end_time'];
            $event->location = $event_data['location'];
            $event->all_day = $event_data['all_day'];

            $event->save(false);

            if($event){
                $data = array('success'=>true,'event'=>$event);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating event ');
                $this->renderJSON($data);
                return;
            }
        }catch(Exception $e){
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>$e->getMessage());
            $this->renderJSON($data);
            return;
        }
    }


    //Error ids
    // 1 - All data not set
    // 2 - error creating todo
    public function actionUpdate() {
//        $data = array('success'=>true);
//        $this->renderJSON($_POST);
//        return;

//        var post_data = {
//        event:{
//            event_name: 'Test event',
//                origin_type:' club',
//                origin_id: 1,
//                title: 'Test Event',
//                description: 'This is my test event description',
//                start_time: '10:10:10',
//                end_time: '11:11:11',
//                start_date: '2014-12-01',
//                end_date: '2014-12-01',
//                location: 'Manhattan'
//            }
//        };


        if(!isset($_POST['event']['event_id']) || !isset($_POST['event']['event_type']) || !isset($_POST['event']['event_name']) || !isset($_POST['event']['event_type']) || !isset($_POST['event']['origin_type']) || !isset($_POST['event']['origin_id']) || !isset($_POST['event']['title']) || !isset($_POST['event']['description'])
            || !isset($_POST['event']['start_time']) || !isset($_POST['event']['end_time']) || !isset($_POST['event']['start_date']) || !isset($_POST['event']['end_date']) || !isset($_POST['event']['location']) || !isset($_POST['event']['all_day'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'All data is not set');
            $this->renderJSON($data);
            return;
        }

        $event_data = $_POST['event'];
        $event_id = $event_data['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));


        if($event){
            $event->title = $event_data['event_name'];
            $event->description = $event_data['description'];
            $event->event_type = $event_data['event_type'];
            $event->user_id = $this->get_current_user_id();
            $event->origin_type = $event_data['origin_type'];
            $event->origin_id = $event_data['origin_id'];
            $event->start_date = $event_data['start_date'];
            $event->end_date = $event_data['end_date'];
            $event->start_time = $event_data['start_time'];
            $event->end_time = $event_data['end_time'];
            $event->location = $event_data['location'];
            $event->all_day = $event_data['all_day'];



            if($event->save(false)){
                $data = array('success'=>true,'event'=>$event);
                $this->renderJSON($data);
                return;
            }else{
                $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Error creating event ');
                $this->renderJSON($data);
                return;
            }
        }else {
            $data = array('success'=>false,'error_id'=>3,'error_msg'=>'event doesnt exist');
            $this->renderJSON($data);
            return;
        }

    }



    public function actionCheck(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'id not set');
            $this->renderJSON($data);
            return;
        }



        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
        if($event){
            $event->complete = true;
            $event->save(false);

            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
            return;
        }
    }

    public function actionUncheck(){
        if(!isset($_POST['event_id'])){
            $data = array('success'=>false,'error_id'=>1,'error_msg'=>'id not set');
            $this->renderJSON($data);
            return;
        }



        $event_id = $_POST['event_id'];

        $event = Event::model()->find('event_id=:id', array(':id'=>$event_id));
        if($event){
            $event->complete = false;
            $event->save(false);

            $data = array('success'=>true);
            $this->renderJSON($data);
            return;
        }else{
            $data = array('success'=>false,'error_id'=>2,'error_msg'=>'Event doesnt exist');
            $this->renderJSON($data);
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